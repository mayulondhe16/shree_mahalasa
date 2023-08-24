<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;
use Session;
use Config;

class CategoryController extends Controller
{
    public function __construct()
    {
     
    }

    public function allCategory(Request $request)
    {
        try {
            $category = Category::get();
            
            foreach ($category as $value) {
                $value->image =  Config::get('DocumentConstant.CATEGORY_VIEW').$value['image'];
            }
            return $this->responseApi($category, 'All category data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }

   
}