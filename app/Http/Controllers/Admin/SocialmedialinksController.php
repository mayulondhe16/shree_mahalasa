<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Socialmedialinks;
use Validator;
use Session;

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
        $socialmedialinks = Socialmedialinks::get();

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
        $socialmedialinks = new Socialmedialinks();
        $socialmedialinks->link = $request->link;
        $status = $socialmedialinks->save();
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
        $link = $request->link;
        $address = $request->address;
        
        $arr_data               = [];
        $socialmedialinks = Socialmedialinks::find($id);
        $existingRecord = Socialmedialinks::orderBy('id','DESC')->first();
        $socialmedialinks->link = $request->link;
        $status = $socialmedialinks->update();        
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