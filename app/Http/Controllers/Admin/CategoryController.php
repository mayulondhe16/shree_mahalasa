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
use Config;

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
            'image' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $category = new Category();
        $category->title = $request->title;
        $category->description = $request->description;
        $status = $category->save();
        $last_id = $category->id;
        $path = Config::get('DocumentConstant.CATEGORY_ADD');
        if ($request->hasFile('image')) {

            if ($category->image) {
                $delete_file_eng= storage_path(Config::get('DocumentConstant.MAIN_CATEGORY_DELETE') . $category->image);
                if(file_exists($delete_file_eng)){
                    unlink($delete_file_eng);
                }

            }

            $fileName = $last_id.".". $request->image->extension();
            uploadImage($request, 'image', $path, $fileName);
           
            $category = Category::find($last_id);
            $category->image = $fileName;
            $status = $category->save();
        }
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
        $category = Category::find($id); 

        $path = Config::get('DocumentConstant.CATEGORY_ADD');
        if ($request->hasFile('image'))
        {
            if ($category->image)
            {
                $delete_file_eng= storage_path(Config::get('DocumentConstant.CATEGORY_DELETE') . $category->image);
                if(file_exists($delete_file_eng))
                {
                    unlink($delete_file_eng);
                }

            }

            $fileName = $id.".". $request->image->extension();
            uploadImage($request, 'image', $path, $fileName);
            $category->title = $request->title;
            $category->description = $request->description;
            $category->image = $fileName;
            $status = $category->save();
        } 
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
        try {
            $category = Category::find($id);
            if ($category) {
                if (file_exists(storage_path(Config::get('DocumentConstant.CATEGORY_DELETE') . $category->image))) {
                    unlink(storage_path(Config::get('DocumentConstant.CATEGORY_DELETE') . $category->image));
                }
               
                $category->delete();           
                    Session::flash('error', 'Record deleted successfully.');
                    return \Redirect::to('manage_category');
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
        $data1     = Category::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

   
}