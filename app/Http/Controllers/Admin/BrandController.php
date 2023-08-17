<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Brands;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;
use Session;
use Config;

class BrandController extends Controller
{
    public function __construct(Brands $Brands)
    {
        $data               = [];
        $this->title        = "Brand";
        $this->url_slug     = "brand";
        $this->folder_path  = "admin/brands/";
    }
    public function index(Request $request)
    {
        $brands = Brands::orderBy('id','DESC')->get();

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
        $brands = new Brands();
        $brands->title = $request->title;
        $brands->description = $request->description;
        $return_data = $brands->save();
        $last_id = $brands->id;
        $path = Config::get('DocumentConstant.BRAND_ADD');

        if ($request->hasFile('image')) {

            if ($brands->image) {
                $delete_file_eng= storage_path(Config::get('DocumentConstant.BRAND_DELETE') . $brands->image);
                if(file_exists($delete_file_eng)){
                    unlink($delete_file_eng);
                }

            }

            $fileName = $last_id.".". $request->image->extension();
            uploadImage($request, 'image', $path, $fileName);
           
            $brand = Brands::find($last_id);
            $brand->image = $fileName;
            $brand->save();
        }
        if (!empty($brand))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_brands');
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
        $data1     = Brands::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $brands = Brands::find($id);
        $path = Config::get('DocumentConstant.BRAND_ADD');
        if ($request->hasFile('image'))
        {
            if ($brands->image)
            {
                $delete_file_eng= storage_path(Config::get('DocumentConstant.BRAND_DELETE') . $brands->image);
                if(file_exists($delete_file_eng))
                {
                    unlink($delete_file_eng);
                }

            }

            $fileName = $id.".". $request->image->extension();
            uploadImage($request, 'image', $path, $fileName);
        }
        $brands->title = $request->title;
        $brands->description = $request->description;
        $brands->image = $fileName;
        $status = $brands->save();
        if (!empty($brands))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_brands');
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
            $brands = Brands::find($id);
            if ($brands) {
                if (file_exists(storage_path(Config::get('DocumentConstant.BRAND_DELETE') . $brands->image))) {
                    unlink(storage_path(Config::get('DocumentConstant.BRAND_DELETE') . $brands->image));
                }
               
                $brands->delete();           
                    Session::flash('error', 'Record deleted successfully.');
                    return \Redirect::to('manage_brands');
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
        $data1     = Brands::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

    public function change_brand_status($id)
    {
        // dd($id);
        $data =  \DB::table('brands')->where(['id'=>$id])->first();
        //dd($data->is_active);
        if($data->top_seller=='1')
        {
            $category = \DB::table('brands')->where(['id'=>$id])->update(['top_seller'=>'0']);
            Session::flash('success', 'Success! Record deactivated successfully.');
            
        }
        else
        {
            $category = \DB::table('brands')->where(['id'=>$id])->update(['top_seller'=>'1']);
            Session::flash('success', 'Success! Record activated successfully.');
        }
        return \Redirect::back();
    }
   
}