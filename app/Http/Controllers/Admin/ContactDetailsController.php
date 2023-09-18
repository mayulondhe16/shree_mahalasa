<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\ContactDetails;
use Validator;
use Session;

class ContactDetailsController extends Controller
{
    public function __construct(ContactDetails $ContactDetails)
    {
        $data               = [];
        $this->title        = "Contact Details";
        $this->url_slug     = "contactdetails";
        $this->folder_path  = "admin/contactdetails/";
    }
    public function index(Request $request)
    {
        $contactdetails = ContactDetails::get();

        $data['data']      = $contactdetails;
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
            'phone_no' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = ContactDetails::where(['email'=>$request->input('email')])->count();

        if($is_exist)
        {
            Session::flash('error', "Contact Details already exist!");
            return \Redirect::back();
        }
        $contactdetails = new ContactDetails();
        $contactdetails->phone_no = $request->phone_no;
        $contactdetails->email = $request->email;
        $contactdetails->address = $request->address;
        $status = $contactdetails->save();
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_contactdetails');
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
        $data1     = ContactDetails::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $is_exist = ContactDetails::where('id','<>',$id)->where(['email'=>$request->input('email')])->count();

        if($is_exist)
        {
            Session::flash('error', "Contact details already exist!");
            return \Redirect::back();
        }

        $phone_no = $request->phone_no;
        $address = $request->address;
        
        $arr_data               = [];
        $contactdetails = ContactDetails::find($id);
        $existingRecord = ContactDetails::orderBy('id','DESC')->first();
        $contactdetails->phone_no = $request->phone_no;
        $contactdetails->email = $request->email;
        $contactdetails->address = $request->address;
        $status = $contactdetails->update();        
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_contactdetails');
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
        $certificate = ContactDetails::find($id);
        $certificate->delete();
        return \Redirect::to('manage_contactdetails');
    }

    public function view($id)
    {
        $id = base64_decode($id);
        $arr_data = [];
        $data1     = ContactDetails::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

   
}