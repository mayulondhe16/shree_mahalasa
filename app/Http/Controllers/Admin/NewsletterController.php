<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Newsletter;
use  App\Models\Contactform;

use Validator;
use Session;

class NewsletterController extends Controller
{
    public function __construct(Newsletter $Newsletter)
    {
        $data               = [];
        $this->title        = "Newsletter";
        $this->url_slug     = "newsletter";
        $this->folder_path  = "admin/newsletter/";
    }
    public function index(Request $request)
    {
        $newsletter = Newsletter::get();

        $data['data']      = $newsletter;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }

    public function manage_contactus(Request $request)
    {
        $newsletter = Contactform::get();

        $data['data']      = $newsletter;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'manage_contactus',$data);
    }

    
    // public function add()
    // {
    //     $data['page_name'] = "Add";
    //     $data['title']     = $this->title;
    //     $data['url_slug']  = $this->url_slug;
    //     return view($this->folder_path.'add',$data);
    // }
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         // 'link'         => 'required',
    //         'link' => 'required',
    //     ]);

    //     if ($validator->fails()) 
    //     {
    //         return $validator->errors()->all();
    //     }
    //     $quicklinks = new Quicklinks();
    //     $quicklinks->link = $request->link;
    //     $status = $quicklinks->save();
    //     if (!empty($status))
    //     {
    //         Session::flash('success', 'Success! Record added successfully.');
    //         return \Redirect::to('manage_quicklinks');
    //     }
    //     else
    //     {
    //         Session::flash('error', "Error! Oop's something went wrong.");
    //         return \Redirect::back();
    //     }
    // }

    // public function edit($id)
    // {
    //     $id = base64_decode($id);
    //     $arr_data = [];
    //     $data1     = Quicklinks::find($id);
    //     $data['data']      = $data1;
    //     $data['page_name'] = "Edit";
    //     $data['url_slug']  = $this->url_slug;
    //     $data['title']     = $this->title;
    //     return view($this->folder_path.'edit',$data);
    // }

    // public function update(Request $request, $id)
    // {
    //     $link = $request->link;
    //     $address = $request->address;
        
    //     $arr_data               = [];
    //     $quicklinks = Quicklinks::find($id);
    //     $existingRecord = Quicklinks::orderBy('id','DESC')->first();
    //     $quicklinks->link = $request->link;
    //     $status = $quicklinks->update();        
    //     if (!empty($status))
    //     {
    //         Session::flash('success', 'Success! Record updated successfully.');
    //         return \Redirect::to('manage_quicklinks');
    //     }
    //     else
    //     {
    //         Session::flash('error', "Error! Oop's something went wrong.");
    //         return \Redirect::back();
    //     }
    // }

    public function delete_contactus($id)
    {
        $id = base64_decode($id);
        $all_data=[];
        $certificate = Contactform::find($id);
        $certificate->delete();
        return \Redirect::to('manage_contactus');
    }

    // public function view($id)
    // {
    //     $id = base64_decode($id);
    //     $arr_data = [];
    //     $data1     = Quicklinks::find($id);
    //     $data['data']      = $data1;
    //     $data['page_name'] = "View";
    //     $data['url_slug']  = $this->url_slug;
    //     $data['title']     = $this->title;
    //     return view($this->folder_path.'view',$data);
    // }

   
}