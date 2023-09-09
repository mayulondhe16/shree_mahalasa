<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Location;
use  App\Models\City;
use Validator;
use Session;

class LocationController extends Controller
{
    public function __construct(Location $Location)
    {
        $data               = [];
        $this->title        = "Location";
        $this->url_slug     = "location";
        $this->folder_path  = "admin/location/";
    }
    public function index(Request $request)
    {
        $contactdetails = Location::orderBy('id','desc')->get();

        $data['data']      = $contactdetails;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }
    public function add()
    {
        $data['city'] = City::orderBy('id','desc')->groupBy('city_name')->get();

        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'link'         => 'required',
            'title' => 'required',
            'city_id' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $contactdetails = new Location();
        $contactdetails->title = $request->title;
        $contactdetails->shop_name = $request->shop_name;
        $contactdetails->city_id = $request->city_id;
        $contactdetails->mobile_no1 = $request->mobile_no1;
        $contactdetails->mobile_no2 = $request->mobile_no2;
        $contactdetails->address = $request->address;
        $contactdetails->link = $request->link;
        $status = $contactdetails->save();
        $last_id = $contactdetails->id;

        // $path = Config::get('DocumentConstant.CATEGORY_ADD');
        // if ($request->hasFile('image')) {

        //     if ($contactdetails->image) {
        //         $delete_file_eng= storage_path(Config::get('DocumentConstant.MAIN_CATEGORY_DELETE') . $contactdetails->image);
        //         if(file_exists($delete_file_eng)){
        //             unlink($delete_file_eng);
        //         }

        //     }

        //     $fileName = $last_id.".". $request->image->extension();
        //     uploadImage($request, 'image', $path, $fileName);
           
        //     $contactdetails = Location::find($last_id);
        //     $contactdetails->image = $fileName;
        //     $status = $contactdetails->save();
        // }
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_location');
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
        $data1     = Location::find($id);
        $data['city'] = City::orderBy('id','desc')->groupBy('city_name')->get();
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $title = $request->title;
        $city_id = $request->city_id;
        
        $arr_data               = [];
        $contactdetails = Location::find($id);
        $existingRecord = Location::orderBy('id','DESC')->first();
        $contactdetails->title = $request->title;
        $contactdetails->shop_name = $request->shop_name;
        $contactdetails->city_id = $request->city_id;
        $contactdetails->mobile_no1 = $request->mobile_no1;
        $contactdetails->mobile_no2 = $request->mobile_no2;
        $contactdetails->address = $request->address;
        $contactdetails->link = $request->link;
        $status = $contactdetails->update();        
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_location');
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
        $certificate = Location::find($id);
        $certificate->delete();
        return \Redirect::to('manage_location');
    }

    public function view($id)
    {
        $id = base64_decode($id);
        $arr_data = [];
        $data['city'] = City::orderBy('id','desc')->groupBy('city_name')->get();

        $data1     = Location::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

   
}