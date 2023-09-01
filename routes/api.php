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

Route::get('get_maincategory', [ApiController::class, 'get_maincategory']);
Route::get('get_products', [ApiController::class, 'get_products']);
Route::get('get_trending_products', [ApiController::class, 'get_trending_products']);
Route::get('get_topseller_products', [ApiController::class, 'get_topseller_products']);
Route::get('get_logo', [ApiController::class, 'get_logo']);

Route::get('get_subcategory', [ApiController::class, 'get_subcategory']);
Route::get('get_aboutus', [ApiController::class, 'get_aboutus']);
Route::get('get_quick_links', [ApiController::class, 'get_quick_links']);
Route::get('get_socialmedia_links', [ApiController::class, 'get_socialmedia_links']);
Route::get('get_brands', [ApiController::class, 'get_brands']);
Route::get('get_company_details', [ApiController::class, 'get_company_details']);
Route::post('add_newsletter', [ApiController::class, 'add_newsletter']);
Route::get('get_city', [ApiController::class, 'get_city']);




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


