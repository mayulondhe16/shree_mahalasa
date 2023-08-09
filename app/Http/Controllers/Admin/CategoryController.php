<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;
use Session;

class CategoryController extends Controller
{
    public function __construct(Category $Category)
    {
        $data               = [];
        $this->title        = "Sub-Category";
        $this->url_slug     = "category";
        $this->folder_path  = "admin/category/";
    }
    public function index(Request $request)
    {
        $Category = Category::orderBy('id','DESC')->get();

        $data['data']      = $Category;
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
            // 'link'         => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $category = new Category();
        $arr_data               = [];
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
    
            $file_name                         = $_FILES["image"]["name"];
            $file_tmp                          = $_FILES["image"]["tmp_name"];
            $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
            $random_file_name                  = $randomString.'.'.$ext;
            $latest_image                   = '/category/'.$random_file_name;
            if(Storage::put('all_project_data'.$latest_image, File::get($request->image)))
            {
                $category->image = $latest_image;
            }
        }   


        $category->title = $request->title;
        $category->description = $request->description;
        $status = $category->save();
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_category');
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

    public function update(Request $request, $id)
    {
        $title = $request->title;
        $description = $request->description;
       
        $arr_data               = [];
        $category = Category::find($id);
        $existingRecord = Category::orderBy('id','DESC')->first();
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
      
            $file_name                         = $_FILES["image"]["name"];
            $file_tmp                          = $_FILES["image"]["tmp_name"];
            $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
            $random_file_name                  = $randomString.'.'.$ext;
            $latest_image                   = '/category/'.$random_file_name;

            if(Storage::put('all_project_data'.$latest_image, File::get($request->image)))
            {
                $category->image = $latest_image;
            }
           
            
        } 
        $category->title = $title;
        $category->description = $description;
        $status = $category->update();        
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_category');
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
        $certificate = Category::find($id);
        $certificate->delete();
        Session::flash('error', 'Record deleted successfully.');
        return \Redirect::to('manage_category');
    }

    public function view($id)
    {
        $id = base64_decode($id);
        $arr_data = [];
        $data1     = Category::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

   
}