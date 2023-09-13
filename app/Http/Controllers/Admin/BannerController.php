<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Banner;
use  App\Models\Brands;
use  App\Models\Category;
use  App\Models\MainCategory;

use App\Models\ProductImages;

use Validator;
use Session;
use Config;

class BannerController extends Controller
{
    public function __construct(Banner $Banner)
    {
        $data               = [];
        $this->title        = "Banner";
        $this->url_slug     = "banner";
        $this->folder_path  = "admin/banner/";
    }
    public function index(Request $request)
    {
        $Banner = Banner::orderBy('id','DESC')->get();

        $data['data']      = $Banner;
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
            'image' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $banner = new Banner();
        $banner->category_id = $request->main_category;
        $banner->background_color_left = $request->background_color_left;
        $banner->background_color_right = $request->background_color_right;
        $banner->save();
        if(!empty($banner))
        {
            $last_id = $banner->id;
            $path = Config::get('DocumentConstant.BANNER_ADD');
    
            if ($request->hasFile('image')) {
    
                if ($banner->image) {
                    $delete_file_eng= storage_path(Config::get('DocumentConstant.BANNER_DELETE') . $banner->image);
                    if(file_exists($delete_file_eng)){
                        unlink($delete_file_eng);
                    }
    
                }
    
                $fileName = $last_id.".". $request->image->extension();
                uploadImage($request, 'image', $path, $fileName);
               
                $banner = Banner::find($last_id);
                $banner->image = $fileName;
                $banner->save();
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_banner');
            }
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
        $data['main_category'] = MainCategory::orderBy('title','desc')->groupBy('title')->get();
        $data1     = Banner::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'main_category' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $banner = Banner::find($id);;
        $banner->category_id = $request->main_category;
        $banner->background_color_left = $request->background_color_left;
        $banner->background_color_right = $request->background_color_right;
        $status = $banner->update();
        // dd($status);
        if (!empty($status))
        {
            $last_id = $banner->id;
            $path = Config::get('DocumentConstant.BANNER_ADD');
    
            if ($request->hasFile('image')) {
    
                if ($banner->image) {
                    $delete_file_eng= storage_path(Config::get('DocumentConstant.BANNER_DELETE') . $banner->image);
                    if(file_exists($delete_file_eng)){
                        unlink($delete_file_eng);
                    }
    
                }
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randomString = '';
            
                for ($i = 0; $i < 10; $i++) {
                    $index = rand(0, strlen($characters) - 1);
                    $randomString .= $characters[$index];
                }
                $fileName = $randomString.".". $request->image->extension();
                uploadImage($request, 'image', $path, $fileName);
               
                $banner = Banner::find($last_id);
                $banner->image = $fileName;
                $banner->save();

           
            }
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_banner');
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
                $product = Banner::find($id);
                $product->delete();
                Session::flash('error', 'Record deleted successfully.');
                return \Redirect::to('manage_banner');
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
                    return \Redirect::to('manage_banner');
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
        $data['main_category'] = MainCategory::orderBy('title','desc')->groupBy('title')->get();
        $data1     = Banner::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

    public function manage_top_selling(Request $request)
    {
        $Banner = Banner::get();

        $data['data']      = $Banner;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Top Banner';
        return view($this->folder_path.'manage_top_selling',$data);
    }

    public function change_topselling_status($id)
    {
        $data =  \DB::table('products')->where(['id'=>$id])->first();
        if($data->topSelling=='1')
        {
            $category = \DB::table('products')->where(['id'=>$id])->update(['topSelling'=>'0']);
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
        $data =  \DB::table('products')->where(['id'=>$id])->first();
        //dd($data->is_active);
        if($data->topTrending=='1')
        {
            $category = \DB::table('products')->where(['id'=>$id])->update(['topTrending'=>'0']);
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
}