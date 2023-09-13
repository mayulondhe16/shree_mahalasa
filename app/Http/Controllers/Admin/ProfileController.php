<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use  App\Models\User;
use Validator;
use Session;
use Sentinel;


class ProfileController extends Controller
{
    public function __construct(User $User)
    {
        $data               = [];
        $this->title        = "Profile";
        $this->url_slug     = "profile";
        $this->folder_path  = "admin/profile/";
    }
    public function index(Request $request)
    {
        $user = Sentinel::check();

        $data['data']      = $user;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
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
            'shade_name' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $Profile = new User();
        $arr_data               = [];
        $Profile->shade_name = $request->shade_name;
        $status = $Profile->save();
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_shade');
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
        $data1     = User::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $user = Sentinel::check();

      
        $request->validate([
            'oldpassword' => 'required',
            'new_password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6'
          ]);
          if(Hash::check($request->oldpassword , $user->password)) {
              if(!Hash::check($request->new_password , $user->password)) {
                 $user = User::find($user->id);
                 $user->update([
                     'password' => bcrypt($request->new_password)
                 ]);
                 Session::flash('success', 'Success! Password updated successfully.');
                 return \Redirect::to('manage_profile');
              }
              Session::flash('success','New password can not be the old password!');
              return \Redirect::to('manage_profile');
          }
          Session::flash('success','Old password does not matched!');
          return \Redirect::to('manage_profile');
      }
        // if (!empty($status))
        // {
        //     Session::flash('success', 'Success! Record updated successfully.');
        //     return \Redirect::to('manage_shade');
        // }
        // else
        // {
        //     Session::flash('error', "Error! Oop's something went wrong.");
        //     return \Redirect::back();
        // }

    public function delete($id)
    {
        $id = base64_decode($id);
        $all_data=[];
        $certificate = User::find($id);
        $certificate->delete();
        Session::flash('error', 'Record deleted successfully.');
        return \Redirect::to('manage_shade');
    }

    public function view($id)
    {
        $id = base64_decode($id);
        $arr_data = [];
        $data1     = User::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

   
}