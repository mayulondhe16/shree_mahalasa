<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Category;
use  App\Models\MainCategory;
use  App\Models\Aboutus;
use  App\Models\Quicklinks;
use  App\Models\Socialmedialinks;
use  App\Models\Brands;
use  App\Models\ContactDetails;
use  App\Models\Newsletter;
use  App\Models\Product;
use  App\Models\Logo;
use  App\Models\City;
use  App\Models\Shops;
use  App\Models\Location;
use  App\Models\Banner;
use  App\Models\Contactform;
use  App\Models\Menu;
use  App\Models\Size;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;
use Session;
use Config;


class ApiController extends Controller
{
    public function __construct()
    {
     
    }

    public function get_maincategory(Request $request)
    {
        try {
            $category = MainCategory::get();
            
            foreach ($category as $value) {
                $value->image =  Config::get('DocumentConstant.MAIN_CATEGORY_VIEW').$value['image'];
            }
            return $this->responseApi($category, 'All category data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_products(Request $request)
    {
        try {
            $products = Product::get();
            
            foreach ($products as $value) {
                $value->image =  Config::get('DocumentConstant.PRODUCT_VIEW').$value['image'];
            }
            return $this->responseApi($products, 'All products data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_trending_products(Request $request)
    {
        try {
            $products = Product::where('topTrending','1')->get();
            
            foreach ($products as $value) {
                $value->image =  Config::get('DocumentConstant.PRODUCT_VIEW').$value['image'];
            }
            return $this->responseApi($products, 'All products data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_logo(Request $request)
    {
        try {
            $logo = Logo::get();
            
            foreach ($logo as $value) {
                $value->image =  Config::get('DocumentConstant.LOGO_VIEW').$value['image'];
            }
            return $this->responseApi($logo, 'Data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_banner(Request $request,$id)
    {
        try {
            $logo = Banner::where('category_id',$id)->get();
            
            foreach ($logo as $value) {
                $value->image =  Config::get('DocumentConstant.BANNER_VIEW').$value['image'];
            }
            return $this->responseApi($logo, 'Data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_city(Request $request)
    {
        try {
            $city = City::get();
            return $this->responseApi($city, 'Data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }
    public function get_menu(Request $request)
    {
        try {
            $menu = Menu::get();
            return $this->responseApi($menu, 'Data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }
    public function get_size(Request $request)
    {
        try {
            $size = Size::get();
            return $this->responseApi($size, 'Data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_location(Request $request,$id)
    {
        try {
            $location = Location::where('city_id',$id)->get();
            foreach ($location as $value) {
                $city = City::where('id',$value->city_id)->first();
                $value->city = $city['city_name'];
            }
            return $this->responseApi($location, 'Data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_location_details(Request $request,$id)
    {
        try {
            $location = Location::where('id',$id)->get();
            return $this->responseApi($location, 'Data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }


    public function get_counts(Request $request)
    {
        try {
            $products = Product::count();
            $shops = Shops::count();
            $brands = Brands::count();
            return response()->json(['Total_shops'=>$shops,'Total_products'=>$products,'total_brands'=>$brands,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);

        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_topseller_products(Request $request)
    {
        try {
            $products = Product::where('topSelling','1')->get();
            
            foreach ($products as $value) {
                $value->image =  Config::get('DocumentConstant.PRODUCT_VIEW').$value['image'];
            }
            return $this->responseApi($products, 'All products data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_subcategory(Request $request,$id)
    {
        try {
            $category = Category::where('main_category',$id)->get();
            
            foreach ($category as $value) {
                $value->image =  Config::get('DocumentConstant.CATEGORY_VIEW').$value['image'];
            }
            return $this->responseApi($category, 'All category data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_aboutus(Request $request)
    {
        try {
            $about = Aboutus::get();
            foreach ($about as $value) {
                $value->image =  Config::get('DocumentConstant.ABOUTUS_VIEW').$value['image'];
            }
            return $this->responseApi($about, 'All category data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_quick_links(Request $request)
    {
        try {
            $links = Quicklinks::get();
            return $this->responseApi($links, 'All category data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_socialmedia_links(Request $request)
    {
        try {
            $links = Socialmedialinks::get();
            foreach ($links as $value) {
                $value->image =  Config::get('DocumentConstant.SOCIALMEDIAICON_VIEW').$value['image'];
            }
            return $this->responseApi($links, 'All category data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_brands(Request $request)
    {
        try {
            $brands = Brands::get();
            foreach ($brands as $value) {
                $value->image =  Config::get('DocumentConstant.BRAND_VIEW').$value['image'];
            }
            return $this->responseApi($brands, 'All category data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_company_details(Request $request)
    {
        try {
            $details = ContactDetails::get();
            // foreach ($details as $value) {
            //     $value->image =  Config::get('DocumentConstant.BRAND_VIEW').$value['image'];
            // }
            return $this->responseApi($details, 'All category data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function get_main_category(Request $request)
    {
        try {
            $category = Category::get();
            // foreach ($category as $value) {
            //     $value->image =  Config::get('DocumentConstant.BRAND_VIEW').$value['image'];
            // }
            return $this->responseApi($category, 'All category data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

    public function add_newsletter(Request $request)
    {
        try {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $newsletter = new Newsletter();
        $newsletter->email = $request->email;
        $status = $newsletter->save();
        return $this->responseApi([], 'All data get successfully', 'scuccess',200);

        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
    }

    public function add_contactform(Request $request)
    {
        try {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $contactform = new Contactform();
        $contactform->full_name = $request->full_name;
        $contactform->email = $request->email;
        $contactform->mobile_no = $request->mobile_no;
        $contactform->gender = $request->gender;
        $contactform->message = $request->email;
        $status = $contactform->save();
        return $this->responseApi([], 'All data get successfully', 'scuccess',200);

        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
    }

   
}