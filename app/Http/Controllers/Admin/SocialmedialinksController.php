<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Socialmedialinks;
use Validator;
use Session;
use Config;

class SocialmedialinksController extends Controller
{
    public function __construct(Socialmedialinks $Socialmedialinks)
    {
        $data               = [];
        $this->title        = "Social Media Links";
        $this->url_slug     = "socialmedialinks";
        $this->folder_path  = "admin/socialmedialinks/";
    }
    public function index(Request $request)
    {
        $socialmedialinks = Socialmedialinks::orderBy('id','DESC')->get();

        $data['data']      = $socialmedialinks;
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
            'link' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = Socialmedialinks::where(['link'=>$request->input('link')])->count();

        if($is_exist)
        {
            Session::flash('error', "This Link already exist!");
            return \Redirect::back();
        }
        $socialmedialinks = new Socialmedialinks();
        $socialmedialinks->link = $request->link;
        $socialmedialinks->title = $request->title;
        $status = $socialmedialinks->save();
        $last_id = $socialmedialinks->id;
        $path = Config::get('DocumentConstant.SOCIALMEDIAICON_ADD');

        if ($request->hasFile('image')) {

            if ($socialmedialinks->image) {
                $delete_file_eng= storage_path(Config::get('DocumentConstant.SOCIALMEDIAICON_DELETE') . $socialmedialinks->image);
                if(file_exists($delete_file_eng)){
                    unlink($delete_file_eng);
                }

            }

            $fileName = $last_id.".". $request->image->extension();
            uploadImage($request, 'image', $path, $fileName);
        }
           
            $socialmedialinks = Socialmedialinks::find($last_id);
            $socialmedialinks->image = $fileName;
            $socialmedialinks->save();
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_socialmedialinks');
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
        $data1     = Socialmedialinks::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $is_exist = Socialmedialinks::where('id','<>',$id)->where(['link'=>$request->input('link')])->count();

        if($is_exist)
        {
            Session::flash('error', "This link already exist!");
            return \Redirect::back();
        }
        $link = $request->link;
        $address = $request->address;
        $arr_data               = [];
        $socialmedialinks = Socialmedialinks::find($id);
        $path = Config::get('DocumentConstant.SOCIALMEDIAICON_ADD');
        if ($request->hasFile('image'))
        {
           
            if ($socialmedialinks->image)
            {
                $delete_file_eng= storage_path(Config::get('DocumentConstant.SOCIALMEDIAICON_DELETE') . $socialmedialinks->image);
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
            $fileName = $randomString."_updated.". $request->image->extension();
            uploadImage($request, 'image', $path, $fileName);
            $socialmedialinks->image = $fileName;

        }
        
        $existingRecord = Socialmedialinks::orderBy('id','DESC')->first();
        $socialmedialinks->link = $request->link;
        $socialmedialinks->title = $request->title;
        $status = $socialmedialinks->update();     
        // dd($status);   
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_socialmedialinks');
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
        $certificate = Socialmedialinks::find($id);
        $certificate->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::to('manage_socialmedialinks');
    }

    public function view($id)
    {
        $id = base64_decode($id);
        $arr_data = [];
        $data1     = Socialmedialinks::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

   
}