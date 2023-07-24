<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Product;
use  App\Models\Brands;
use  App\Models\Category;
use App\Models\ProductImages;
use Validator;
use Session;

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
        $Product = Product::get();

        $data['data']      = $Product;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }
    public function add()
    {
        $data['category'] = Category::orderBy('title','desc')->groupBy('title')->get();
        $data['brand'] = Brands::orderBy('title','desc')->groupBy('title')->get();
        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'link'         => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->description = $request->description;
        $status = $product->save();
        if (!empty($status))
        {
            $product_images =  new ProductImages();
            $image = $_FILES["image"]["name"];
            // dd($_FILES['image']['name']);
            $temp = [];
            for ($i=0; $i <count($_FILES['image']['name']); $i++) 
            { 
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i_ = 0; $i_ < 20; $i_++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
    
                $file_name                         = $_FILES["image"]["name"][$i];
                $file_tmp                          = $_FILES["image"]["tmp_name"][$i];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
    
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/products/'.$random_file_name;
                $filename                          = basename($file_name,$ext);
                $newFileName                       = $filename.time().".".$ext; 
              
                if(move_uploaded_file($file_tmp,str_replace('\\', '/',public_path()).$latest_image))
                array_push($temp, $random_file_name);  
                    $product_images->product_id = $product->id;
                    $product_images->image = $latest_image;
                    $productstatus = $product_images->save();
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
        $data1     = Category::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }
    public function delete($id)
    {
        $id = base64_decode($id);
        $all_data=[];
        $product = Product::find($id);
        $product->delete();

        $product_images = ProductImages::where('product_id','=',$id);
        $product_images->delete();
        return \Redirect::to('manage_products');
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

   
}