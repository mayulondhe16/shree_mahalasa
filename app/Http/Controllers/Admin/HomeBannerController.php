<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\HomeBanner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;
use Session;
use Config;

class HomeBannerController extends Controller
{
    public function __construct(HomeBanner $HomeBanner)
    {
        $data               = [];
        $this->title        = "HomeBanner";
        $this->url_slug     = "homebanner";
        $this->folder_path  = "admin/newbanner/";
    }
    public function index(Request $request)
    {
        $brands = HomeBanner::orderBy('id','DESC')->get();

        $data['data']      = $brands;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }
    public function add()
    {
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
        $brands = HomeBanner::orderBy('id','DESC')->get();
        if(isset($brand->id)){
            $last_id = $brands->id;
        }else{
            $last_id = '1';
        }
        $path = Config::get('DocumentConstant.HOME_BANNER_ADD');

        if ($request->hasFile('image')) {
            $fileName = $last_id.".". $request->image->extension();
            uploadImage($request, 'image', $path, $fileName);
           
            $brand = New HomeBanner();
            $brand->image = $fileName;
            $brand->background_color_left = $request->background_color_left;
            $brand->background_color_right = $request->background_color_right;
            $brand->save();
        }
        if (!empty($brand))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_homebanner');
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
        $data1     = HomeBanner::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $brands = HomeBanner::find($id);
        $path = Config::get('DocumentConstant.HOME_BANNER_ADD');
        if ($request->hasFile('image'))
        {
            if ($brands->image)
            {
                $delete_file_eng= storage_path(Config::get('DocumentConstant.HOME_BANNER_DELETE') . $brands->image);
                if(file_exists($delete_file_eng))
                {
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
            $brands->image = $fileName;

        }
        $brands->background_color_left = $request->background_color_left;
        $brands->background_color_right = $request->background_color_right;
        $status = $brands->save();
        if (!empty($brands))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_homebanner');
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
            $brands = HomeBanner::find($id);
            if ($brands) {
                if (file_exists(storage_path(Config::get('DocumentConstant.HOME_BANNER_DELETE') . $brands->image))) {
                    unlink(storage_path(Config::get('DocumentConstant.HOME_BANNER_DELETE') . $brands->image));
                }
               
                $brands->delete();           
                    Session::flash('error', 'Record deleted successfully.');
                    return \Redirect::to('manage_homebanner');
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
        $data1     = HomeBanner::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

   
}