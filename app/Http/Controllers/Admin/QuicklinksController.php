<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Quicklinks;
use Validator;
use Session;

class QuicklinksController extends Controller
{
    public function __construct(Quicklinks $Quicklinks)
    {
        $data               = [];
        $this->title        = "Quick Links";
        $this->url_slug     = "quicklinks";
        $this->folder_path  = "admin/quicklinks/";
    }
    public function index(Request $request)
    {
        $quicklinks = Quicklinks::orderBy('id','DESC')->get();

        $data['data']      = $quicklinks;
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
        $quicklinks = new Quicklinks();
        $quicklinks->link = $request->link;
        $quicklinks->title = $request->title;
        $status = $quicklinks->save();
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_quicklinks');
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
        $data1     = Quicklinks::find($id);
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
        $quicklinks = Quicklinks::find($id);
        $existingRecord = Quicklinks::orderBy('id','DESC')->first();
        $quicklinks->link = $request->link;
        $quicklinks->title = $request->title;
        $status = $quicklinks->update();        
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_quicklinks');
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
        $certificate = Quicklinks::find($id);
        $certificate->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::to('manage_quicklinks');
    }

    public function view($id)
    {
        $id = base64_decode($id);
        $arr_data = [];
        $data1     = Quicklinks::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

   
}