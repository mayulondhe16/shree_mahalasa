<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Brands;
use  App\Models\Shade;
use  App\Models\City;

use Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin/login');
    }

    public function login_process(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'email'     => 'required',
                'password'  => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $user = \Sentinel::authenticate($credentials);
        
       
        if (!empty($user))
        {
            \Sentinel::login($user);
            return redirect('dashbord');
           
        }
        else
        {
           //\Sentinel::logout();
            Session::flash('error', 'Error! Incorrect username or password.');
            return \Redirect::back();
        }
    }

    public function dashbord(Request $request)
    {
        $data  = [];
        $data['title'] = 'Dashboard';
        $data['brands'] = Brands::count();
        $data['location'] = Location::count();
        $data['products'] = Product::count();
        $data['top_seller'] = Product::where('topSelling','1')->count();
        $data['trndy'] = Product::where('topTrending','1')->count();
        $data['city'] = City::count();
        return view('admin/dashboard',$data);
    }
    public function privacy_policy(Request $request)
    {
        $data  = [];
        return view('front/privacy_policy',$data);
    }
    public function terms_condition(Request $request)
    {
        $data  = [];
        return view('front/terms_condition',$data);
    }

    public function forget_password()
    {
        return view('admin/forget_password');
    }

    public function forget_password_process(Request $request)
    {
        if(!empty($request->input('email')))
        {
            $user = \DB::table('users')->where(['email'=>$request->input('email')])->count();

            if($user)
            {

                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randstring = '';
                for ($i = 0; $i < 8; $i++) {
                    $randstring.= $characters[rand(0, strlen($characters))];
                }
                
                \DB::table('users')->where(['email'=>$request->input('email')])->update(['password'=>bcrypt($randstring)]);
                $mail = new PHPMailer(true); 
                try {
                    //dd("Hello1");
                    //$mail->isSMTP(); 
                    $mail->CharSet    = "utf-8"; 
                    $mail->SMTPAuth   = true;  
                    $mail->SMTPSecure = env('SMTPSECURE');
                    $mail->Host       = env('HOST');
                    $mail->Port       = env('PORT');
                    $mail->Username   = env('USERNAME');
                    //$mail->Password   = env('PASSWORD');
                    $mail->setFrom('testmail@hohtechlabs.com', "HealthCare");
                    $mail->Subject = "Forget Password";
                    $mail->MsgHTML("Your system generated password is ".$randstring."");
                    $mail->addAddress($request->input('email'), "Admin");
                    $mail->send();
                } 
                catch (phpmailerException $e) 
                {
                    dd($e);
                    Session::flash('error', $e);
                } 
                catch (Exception $e) 
                {
                    dd($e);
                    Session::flash('error', $e);
                }
                Session::flash('success', 'Success! Please check your email for temporary password. Please login again.');
                return redirect('/login');
            }
            else
            {
                Session::flash('error', 'Error! Invalid email.');
                return \Redirect::back();
            }
        }
    }



    public function change_password()
    {
        return view('admin/change_password');
    }

    public function change_password_process(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'oldpassword'     => 'required',
                'new_password'    => 'required',
                'confi_password'  => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $data = \Sentinel::check();
        $credentials = [
            'email'    => $data->email,
            'password' => $request->input('oldpassword'),
        ];

        $user = \Sentinel::authenticate($credentials);

        if (!empty($user))
        {
            \DB::table('users')->where(['email'=>$data->email])->update(['password'=>bcrypt($request->input('new_password'))]);
            Session::flash('success', 'Success! Password changed successfully.');
            return \Redirect::back();
        }
        else
        {
            Session::flash('error', 'Error! Old password is wrong.');
            return \Redirect::back();
        }
    } 

    public function logout() 
    {
        \Sentinel::logout();
        Session::flash('success', 'You have successfully logged out!');
        return redirect('/');
    }
    public function feed_description(Request $request,$feed_id)
    {


        $arr_data = \DB::table('user_feed')->select('description')->where(['id'=>$feed_id])->first();
        // dd($arr_data);
        $data['data']      = $arr_data;
        return view('front/feed_description',$data);
    }
}
