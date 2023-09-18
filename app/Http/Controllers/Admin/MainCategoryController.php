<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\MainCategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;
use Session;
use Config;

class MainCategoryController extends Controller
{
    public function __construct(MainCategory $MainCategory)
    {
        $data               = [];
        $this->title        = "Main-Category";
        $this->url_slug     = "main_category";
        $this->folder_path  = "admin/main_category/";
    }
    public function index(Request $request)
    {
        $mainCategory = MainCategory::orderBy('id','DESC')->get();

        $data['data']      = $mainCategory;
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

        $is_exist = MainCategory::where(['title'=>$request->input('title')])->count();

        if($is_exist)
        {
            Session::flash('error', "Main Category already exist!");
            return \Redirect::back();
        }
        $mainCategory = new MainCategory();
        $mainCategory->title = $request->title;
        // $mainCategory->description = $request->description;
        $status = $mainCategory->save();
        $last_id = $mainCategory->id;
        $path = Config::get('DocumentConstant.MAIN_CATEGORY_ADD');
        if ($request->hasFile('image')) {

            if ($mainCategory->image) {
                $delete_file_eng= storage_path(Config::get('DocumentConstant.MAIN_CATEGORY_DELETE') . $mainCategory->image);
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
           
            $mainCategory = MainCategory::find($last_id);
            $mainCategory->image = $fileName;
            $mainCategory->save();
        }
        if (!empty($mainCategory))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_main_category');
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
        $data1     = MainCategory::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {    
        $is_exist = MainCategory::where('id','<>',$id)->where(['title'=>$request->input('title')])->count();

        if($is_exist)
        {
            Session::flash('error', "Main Category already exist!");
            return \Redirect::back();
        }

       
        $mainCategory = MainCategory::find($id);       
      
        $path = Config::get('DocumentConstant.MAIN_CATEGORY_ADD');
        if ($request->hasFile('image'))
        {
            if ($mainCategory->image)
            {
                $delete_file_eng= storage_path(Config::get('DocumentConstant.MAIN_CATEGORY_DELETE') . $mainCategory->image);
                if(file_exists($delete_file_eng))
                {
                    unlink($delete_file_eng);
                }

            }

            $fileName = $id.".". $request->image->extension();
            uploadImage($request, 'image', $path, $fileName);
            $mainCategory->image = $fileName;
           
        }
        $mainCategory->title = $request->title;
        // $mainCategory->description = $request->description;
        $status = $mainCategory->save();
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_main_category');
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
            $main_category = MainCategory::find($id);
            if ($main_category) {
                if (file_exists(storage_path(Config::get('DocumentConstant.MAIN_CATEGORY_DELETE') . $main_category->image))) {
                    unlink(storage_path(Config::get('DocumentConstant.MAIN_CATEGORY_DELETE') . $main_category->image));
                }
               
                $main_category->delete();           
                    Session::flash('error', 'Record deleted successfully.');
                    return \Redirect::to('manage_main_category');
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
        $data1     = MainCategory::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

   
}