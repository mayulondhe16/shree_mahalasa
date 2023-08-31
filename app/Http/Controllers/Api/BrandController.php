<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Models\Brands;
use Validator;
use Session;
use Config;

class BrandController extends Controller
{
    public function __construct(Brands $Brands)
    {

    }
    public function allBrands(Request $request)
    {
        
        try {
            $brands = Brands::orderBy('id','DESC')->get();
            
            foreach ($brands as $value) {
                $value->image =  Config::get('DocumentConstant.BRAND_VIEW').$value['image'];
            }
            return $this->responseApi($brands, 'All brand data get successfully', 'scuccess',200);
        } catch (\Exception $e) {
           return $this->responseApi(array(), $e->getMessage(), 'error',500);
        }
       
    }
   
}