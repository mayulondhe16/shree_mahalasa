<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Product;
use  App\Models\Brands;
use  App\Models\Category;
use  App\Models\MainCategory;

use App\Models\ProductImages;

use Validator;
use Session;
use Config;

class ProductsController extends Controller
{
    public function __construct(Product $Product)
    {
        $data               = [];
        $this->title        = "Product";
        $this->url_slug     = "products";
        $this->folder_path  = "admin/product/";
    }
    public function index(Request $request)
    {
        $Product = Product::orderBy('id','DESC')->get();

        $data['data']      = $Product;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }
    public function add()
    {
        $data['category'] = Category::orderBy('title','desc')->groupBy('title')->get();
        $data['main_category'] = MainCategory::orderBy('title','desc')->groupBy('title')->get();
        $data['brand'] = Brands::orderBy('title','desc')->groupBy('title')->get();
        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = Product::where(['name'=>$request->input('name')])->count();

        if($is_exist)
        {
            Session::flash('error', "Product already exist!");
            return \Redirect::back();
        }
        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->main_category = $request->main_category;
        $product->brand_id = $request->brand_id;
        $product->description = $request->description;
        $product->save();
        $last_id = $product->id;
        $path = Config::get('DocumentConstant.PRODUCTTHUMB_ADD');
        $image = $request->file('image');
        if ($request->hasFile('image')) {
          
            if ($product->image){
                $delete_file_eng= storage_path(Config::get('DocumentConstant.PRODUCTTHUMB_DELETE') . $product->thumbnail_image);
                if(file_exists($delete_file_eng)){
                    unlink($delete_file_eng);
                }

            }

            $fileName = $last_id.".". $request->image->extension();
            uploadImage($request, 'image', $path, $fileName);
                $shop = Product::find($last_id);
                $shop->thumbnail_image = $fileName;
                $shop->save();
            
           
        }
       
        if(!empty($product))
        {
           
            $images = $request->file('images');
            if($images)
            {
               
                foreach ($images as $key => $image)
                {
                    $producId = $product->id;
                    $product_images =  new ProductImages();
                    $last_id = $product_images->id?$product_images->id:'1';
                    $path = Config::get('DocumentConstant.PRODUCT_ADD');

                  
                        $fileName = $producId."_".$key.".". $image->extension();
                        uploadMultiImage($image, 'image', $path, $fileName);
                       
                        $product_images = new ProductImages();
                       
                        $product_images->product_id =$producId;
                        $product_images->image = $fileName;
                        $status = $product_images->save();                 
                }
            }
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_products');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function edit($id)
    {
        $id = base64_decode($id);
        $arr_data = [];
        $data['category'] = Category::orderBy('title','desc')->groupBy('title')->get();
        $data['main_category'] = MainCategory::orderBy('title','desc')->groupBy('title')->get();
        $data['brand'] = Brands::orderBy('title','desc')->groupBy('title')->get();
        $data1     = Product::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            // 'image' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = Product::where('id','<>',$id)->where(['name'=>$request->input('name')])->count();

        if($is_exist)
        {
            Session::flash('error', "Product already exist!");
            return \Redirect::back();
        }
        $product = Product::find($id);;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->main_category = $request->main_category;
        $product->brand_id = $request->brand_id;
        $product->description = $request->description;
        $last_id = $product->id;
        $path = Config::get('DocumentConstant.PRODUCTTHUMB_ADD');

        $status = $product->update();
        if (!empty($status))
        {
            if ($request->hasFile('image')) {
          
                if ($product->image){
                    $delete_file_eng= storage_path(Config::get('DocumentConstant.PRODUCTTHUMB_DELETE') . $product->thumbnail_image);
                    if(file_exists($delete_file_eng)){
                        unlink($delete_file_eng);
                    }
    
                }
    
                $fileName = $last_id.".". $request->image->extension();
                uploadImage($request, 'image', $path, $fileName);
                    $shop = Product::find($last_id);
                    $shop->thumbnail_image = $fileName;
                    $shop->save();
                
               
            }
            $images = $request->file('images');
            $temp = [];
            if ($images)
            {
                $product_images = ProductImages::where('product_id','=',$product->id)->get();
                foreach ($images as $key => $image)
                {
               
                    $producId = $product->id;
                    $product_images =  new ProductImages();
                    $last_id = $product_images->id?$product_images->id:'1';
                    $path = Config::get('DocumentConstant.PRODUCT_ADD');
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $randomString = '';
                
                    for ($i = 0; $i < 10; $i++) {
                        $index = rand(0, strlen($characters) - 1);
                        $randomString .= $characters[$index];
                    }
                        $fileName = $randomString.".". $image->extension();
                        uploadMultiImage($image, 'image', $path, $fileName);
                       
                        $product_images = new ProductImages();
                       
                        $product_images->product_id =$producId;
                        $product_images->image = $fileName;
                        $status = $product_images->save();                 
                }
            }
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_products');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    public function delete($id)
    {
        $id = base64_decode($id);
        try {
            $product_images = ProductImages::where('product_id','=',$id)->get();
          
            if ($product_images)
            {
                foreach($product_images as $images)
                {
                    $prd_img = ProductImages::find($images->id);
                    if (file_exists(storage_path(Config::get('DocumentConstant.PRODUCT_DELETE') . $images->image)))
                    {
                        unlink(storage_path(Config::get('DocumentConstant.PRODUCT_DELETE') . $images->image));
                    }
               
                $prd_img->delete();    
                }
                $product = Product::find($id);
                $product->delete();
                Session::flash('error', 'Record deleted successfully.');
                return \Redirect::to('manage_products');
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return $e;
        }
       
    }

    public function delete_product_image($id)
    {
        // dd($id);
        try {
            $product_images = ProductImages::find($id);
            if ($product_images)
            {
                if (file_exists(storage_path(Config::get('DocumentConstant.PRODUCT_DELETE') . $product_images->image)))
                {
                    unlink(storage_path(Config::get('DocumentConstant.PRODUCT_DELETE') . $product_images->image));
                }
               
                $product_images->delete();           
                    Session::flash('error', 'Record deleted successfully.');
                    return \Redirect::to('manage_products');
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function view($id)
    {
        $id = base64_decode($id);
        $arr_data = [];
        $data1     = Product::find($id);
        $product_images = ProductImages::where('product_id','=',$id);
        $data['data']      = $data1;
        $data['images']      = $product_images;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

    public function manage_top_selling(Request $request)
    {
        $Product = Product::orderBy('id','DESC')->get();

        $data['data']      = $Product;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Top Products';
        return view($this->folder_path.'manage_top_selling',$data);
    }

    public function change_topselling_status($id)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date("Y-m-d H:i:s",time());
        $data =  \DB::table('products')->where(['id'=>$id])->first();
        if($data->topSelling=='1')
        {
            $category = \DB::table('products')->where(['id'=>$id])->update(['topSelling'=>'0','topSelling_updated'=>$date]);
            Session::flash('success', 'Success! Record deactivated successfully.');
            
        }
        else
        {
            $category = \DB::table('products')->where(['id'=>$id])->update(['topSelling'=>'1']);
            Session::flash('success', 'Success! Record activated successfully.');
        }
        return \Redirect::back();
    }

    public function change_toptrending_status($id)
    {
        // dd($id);
        date_default_timezone_set('Asia/Kolkata');
        $date = date("Y-m-d H:i:s",time());
        $data =  \DB::table('products')->where(['id'=>$id])->first();
        //dd($data->is_active);
        if($data->topTrending=='1')
        {
            $category = \DB::table('products')->where(['id'=>$id])->update(['topTrending'=>'0','topTrending_updated'=>$date]);
            Session::flash('success', 'Success! Record deactivated successfully.');
            
        }
        else
        {
            $category = \DB::table('products')->where(['id'=>$id])->update(['topTrending'=>'1']);
            Session::flash('success', 'Success! Record activated successfully.');
        }
        return \Redirect::back();
    }

    public function change_general_status($id)
    {
        // dd($id);
        $data =  \DB::table('products')->where(['id'=>$id])->first();
        //dd($data->is_active);
        if($data->general=='1')
        {
            $category = \DB::table('products')->where(['id'=>$id])->update(['general'=>'0']);
            Session::flash('success', 'Success! Record deactivated successfully.');
            
        }
        else
        {
            $category = \DB::table('products')->where(['id'=>$id])->update(['general'=>'1']);
            Session::flash('success', 'Success! Record activated successfully.');
        }
        return \Redirect::back();
    }

    public function getsubcategory()
    {
        $maincategory = $_POST['id'];
        if ($maincategory != null) {
                $cat = \DB::table('category')
                                ->select('id','title')
                                ->where(['main_category'=>$maincategory])
                                ->orderBy('title','ASC')
                                ->groupBy('title')
                                ->get();
                if (count($cat) > 0) {
                        echo "'<option>Select Subcategory</option>'";
                    foreach ($cat as $cat_details) {
                        echo "<option value='" . $cat_details->id . "'>" . $cat_details->title . "</option>";
                    }
                } else {
                    echo "'<option>-</option>'";
                }
        }
    }
}