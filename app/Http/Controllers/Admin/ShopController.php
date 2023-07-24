<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Shops;
use  App\Models\City;
use  App\Models\ShopImages;
use Validator;
use Session;

class ShopController extends Controller
{
    public function __construct(Shops $Shops)
    {
        $data               = [];
        $this->title        = "Shops";
        $this->url_slug     = "shops";
        $this->folder_path  = "admin/shops/";
    }
    public function index(Request $request)
    {
        $shops = Shops::get();

        $data['data']      = $shops;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }
    public function add()
    {
        $data['city'] = City::orderBy('city_name','desc')->groupBy('city_name')->get();
        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thumbnail_image' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $shops = new Shops();
        $shopImages = new ShopImages();
        $arr_data               = [];
        if(isset($_FILES["thumbnail_image"]["name"]) && !empty($_FILES["thumbnail_image"]["name"]))
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
    
            $file_name                         = $_FILES["thumbnail_image"]["name"];
            $file_tmp                          = $_FILES["thumbnail_image"]["tmp_name"];
            $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
            $random_file_name                  = $randomString.'.'.$ext;
            $latest_image                   = '/shop_thumbnail_images/'.$random_file_name;
            if(move_uploaded_file($file_tmp,str_replace('\\', '/',public_path()).$latest_image))
            {
                $shops->thumbnail_image = $latest_image;
            }
        }   
        $shops->name =  $request->name;
        $shops->address =  $request->address;
        $shops->lat =  $request->lat;
        $shops->long =  $request->long;
        $shops->city =  $request->city;
        $shops->description =  $request->description;
        $shopstatus = $shops->save();

        $temp = [];
        for ($i=0; $i <count($_FILES['images']['name']); $i++) 
        { 
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i_ = 0; $i_ < 20; $i_++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            $file_name                         = $_FILES["images"]["name"][$i];
            $file_tmp                          = $_FILES["images"]["tmp_name"][$i];
            $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);

            $random_file_name                  = $randomString.'.'.$ext;
            $latest_image                      = '/shop_images/'.$random_file_name;
            $filename                          = basename($file_name,$ext);
            $newFileName                       = $filename.time().".".$ext; 
          
            if(move_uploaded_file($file_tmp,str_replace('\\', '/',public_path()).$latest_image))
            array_push($temp, $random_file_name);  
               
                $shopImages->shop_id = $shops->id;
                $shopImages->images = $latest_image;
                $status = $shopImages->save();
        }


        if (!empty($status))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_shops');
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
        $data1     = Shops::find($id);
        $data['city'] = City::orderBy('city_name','desc')->groupBy('city_name')->get();
        $data['shop_images'] = ShopImages::where('shop_id',$id)->get();
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'thumbnail_image' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $shops = Shops::find($id);
        $shopImages = new ShopImages();
        $arr_data               = [];
        if(isset($_FILES["thumbnail_image"]["name"]) && !empty($_FILES["thumbnail_image"]["name"]))
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
    
            $file_name                         = $_FILES["thumbnail_image"]["name"];
            $file_tmp                          = $_FILES["thumbnail_image"]["tmp_name"];
            $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
            $random_file_name                  = $randomString.'.'.$ext;
            $latest_image                   = '/shop_thumbnail_images/'.$random_file_name;
            if(move_uploaded_file($file_tmp,str_replace('\\', '/',public_path()).$latest_image))
            {
                $shops->thumbnail_image = $latest_image;
            }
        }   
        $shops->name =  $request->name;
        $shops->address =  $request->address;
        $shops->lat =  $request->lat;
        $shops->long =  $request->long;
        $shops->city =  $request->city;
        $shops->description =  $request->description;
        $shopstatus = $shops->update();

        // $temp = [];
        // for ($i=0; $i <count($_FILES['images']['name']); $i++) 
        // { 
        //     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        //     $charactersLength = strlen($characters);
        //     $randomString = '';
        //     for ($i_ = 0; $i_ < 20; $i_++) {
        //         $randomString .= $characters[rand(0, $charactersLength - 1)];
        //     }

        //     $file_name                         = $_FILES["images"]["name"][$i];
        //     $file_tmp                          = $_FILES["images"]["tmp_name"][$i];
        //     $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);

        //     $random_file_name                  = $randomString.'.'.$ext;
        //     $latest_image                      = '/shop_images/'.$random_file_name;
        //     $filename                          = basename($file_name,$ext);
        //     $newFileName                       = $filename.time().".".$ext; 
          
        //     if(move_uploaded_file($file_tmp,str_replace('\\', '/',public_path()).$latest_image))
        //     array_push($temp, $random_file_name);  
               
        //         $shopImages->shop_id = $shops->id;
        //         $shopImages->images = $latest_image;
        //         $status = $shopImages->save();
        // }

     
        if (!empty($shopstatus))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_shops');
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
        $all_data=[];
        $certificate = Shops::find($id);
        $certificate->delete();
        $img = ShopImages::find($id);
        $img->delete();
        return \Redirect::to('manage_shops');
    }

    public function view($id)
    {
        $id = base64_decode($id);
        $arr_data = [];
        $data1     = Shops::find($id);
        $data['city'] = City::orderBy('city_name','desc')->groupBy('city_name')->get();
        $data['shop_images'] = ShopImages::where('shop_id',$id)->get();
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

   
}