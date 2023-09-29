<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Api\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('welcome');
Route::get('get_maincategory', [ApiController::class, 'get_maincategory']);
Route::get('get_products/{id}', [ApiController::class, 'get_products']);
Route::get('get_products_details/{id}', [ApiController::class, 'get_products_details']);
Route::get('get_trending_products', [ApiController::class, 'get_trending_products']);
Route::get('get_topseller_products', [ApiController::class, 'get_topseller_products']);
Route::get('get_logo', [ApiController::class, 'get_logo']);

Route::get('get_subcategory/{id}', [ApiController::class, 'get_subcategory']);
Route::get('get_aboutus', [ApiController::class, 'get_aboutus']);
Route::get('get_quick_links', [ApiController::class, 'get_quick_links']);
Route::get('get_socialmedia_links', [ApiController::class, 'get_socialmedia_links']);
Route::get('get_brands', [ApiController::class, 'get_brands']);
Route::get('get_company_details', [ApiController::class, 'get_company_details']);
Route::post('add_newsletter', [ApiController::class, 'add_newsletter']);
Route::get('get_city', [ApiController::class, 'get_city']);
Route::get('get_counts', [ApiController::class, 'get_counts']);
Route::get('get_location/{id}', [ApiController::class, 'get_location']);
Route::get('get_location_details/{id}', [ApiController::class, 'get_location_details']);
Route::get('get_banner/{id}', [ApiController::class, 'get_banner']);
Route::post('add_contactform', [ApiController::class, 'add_contactform']);
Route::get('get_menu', [ApiController::class, 'get_menu']);
Route::get('get_size', [ApiController::class, 'get_size']);
Route::get('get_home_banner', [ApiController::class, 'get_home_banner']);
Route::get('get_top_brands', [ApiController::class, 'get_top_brands']);
Route::get('get_brand_details/{id}', [ApiController::class, 'get_brand_details']);




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});


