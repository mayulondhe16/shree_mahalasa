<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\City;
use Validator;
use Session;

class CityController extends Controller
{
    public function __construct(City $City)
    {
        $data               = [];
        $this->title        = "City";
        $this->url_slug     = "city";
        $this->folder_path  = "admin/city/";
    }
    public function index(Request $request)
    {
        $city = City::orderBy('id','DESC')->get();

        $data['data']      = $city;
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
            'city_name' => 'required',
            'state_name' => 'required',
            'country_name' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = City::where(['city_name'=>$request->input('city_name')])->count();

        if($is_exist)
        {
            Session::flash('error', "City already exist!");
            return \Redirect::back();
        }
        $city = new City();
        $arr_data               = [];
        $city->city_name = $request->city_name;
        $city->state_name = $request->state_name;
        $city->country_name = $request->country_name;
        $status = $city->save();
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_city');
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
        $data1     = City::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $is_exist = City::where('id','<>',$id)->where(['city_name'=>$request->input('city_name')])->count();

        if($is_exist)
        {
            Session::flash('error', "City already exist!");
            return \Redirect::back();
        }

        $arr_data               = [];
        $city = City::find($id);
        $existingRecord = City::orderBy('id','DESC')->first();
        $city->city_name = $request->city_name;
        $city->state_name = $request->state_name;
        $city->country_name = $request->country_name;      
        $status = $city->update();   
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_city');
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
        $certificate = City::find($id);
        $certificate->delete();
        Session::flash('error', 'Record deleted successfully.');
        return \Redirect::to('manage_city');
    }

    public function view($id)
    {
        $id = base64_decode($id);
        $arr_data = [];
        $data1     = City::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

   
}