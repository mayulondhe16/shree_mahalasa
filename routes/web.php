<?php
/** @var \Laravel\Lumen\Routing\Router $router */
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ShadeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AboutusController;
use App\Http\Controllers\Admin\ContactDetailsController;
use App\Http\Controllers\Admin\QuicklinksController;
use App\Http\Controllers\Admin\SocialmedialinksController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\MainCategoryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\ProfileController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('dashboard');
// });
// 
// Route::get('/', 									'Admin\AuthController@login');
Route::get('/', [AuthController::class, 'login']);
Route::post('/login_process', [AuthController::class, 'login_process']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'admin'], function () 
{
    Route::get('/dashbord',		 					[AuthController::class, 'dashbord']);
    Route::get('/manage_brands',		 			[BrandController::class, 'index']);
	Route::get('/add_brand',		 				[BrandController::class, 'add']);
	Route::post('/store_brand',		 				[BrandController::class, 'store']);
	Route::get('/view_brand/{id}',	 				[BrandController::class, 'view']);
	Route::get('/edit_brand/{id}',		 			[BrandController::class, 'edit']);
	Route::post('/update_brand/{id}',		 		[BrandController::class, 'update']);
	Route::get('/delete_brand/{id}',		 		[BrandController::class, 'delete']);
	Route::get('/change_brand_status/{id}',	 	    [BrandController::class, 'change_brand_status']);

	Route::get('/manage_logo',		 			[LogoController::class, 'index']);
	Route::get('/add_logo',		 				[LogoController::class, 'add']);
	Route::post('/store_logo',		 				[LogoController::class, 'store']);
	Route::get('/edit_logo/{id}',		 			[LogoController::class, 'edit']);
	Route::post('/update_logo/{id}',		 		[LogoController::class, 'update']);

	Route::get('/manage_city',		 			    [CityController::class, 'index']);
	Route::get('/add_city',		 					[CityController::class, 'add']);
	Route::post('/store_city',		 				[CityController::class, 'store']);
	Route::get('/view_city/{id}',	 				[CityController::class, 'view']);
	Route::get('/edit_city/{id}',		 			[CityController::class, 'edit']);
	Route::post('/update_city/{id}',		 		[CityController::class, 'update']);
	Route::get('/delete_city/{id}',		 			[CityController::class, 'delete']);

	Route::get('/manage_shade',		 			    [ShadeController::class, 'index']);
	Route::get('/add_shade',		 				[ShadeController::class, 'add']);
	Route::post('/store_shade',		 				[ShadeController::class, 'store']);
	Route::get('/view_shade/{id}',	 				[ShadeController::class, 'view']);
	Route::get('/edit_shade/{id}',		 			[ShadeController::class, 'edit']);
	Route::post('/update_shade/{id}',		 		[ShadeController::class, 'update']);
	Route::get('/delete_shade/{id}',		 		[ShadeController::class, 'delete']);

	Route::get('/manage_category',		 			[CategoryController::class, 'index']);
	Route::get('/add_category',		 				[CategoryController::class, 'add']);
	Route::post('/store_category',		 			[CategoryController::class, 'store']);
	Route::get('/view_category/{id}',	 			[CategoryController::class, 'view']);
	Route::get('/edit_category/{id}',		 		[CategoryController::class, 'edit']);
	Route::post('/update_category/{id}',		 	[CategoryController::class, 'update']);
	Route::get('/delete_category/{id}',		 		[CategoryController::class, 'delete']);

	Route::get('/manage_aboutus',		 			[AboutusController::class, 'index']);
	Route::get('/add_aboutus',		 				[AboutusController::class, 'add']);
	Route::post('/store_aboutus',		 			[AboutusController::class, 'store']);
	Route::get('/view_aboutus/{id}',	 			[AboutusController::class, 'view']);
	Route::get('/edit_aboutus/{id}',		 		[AboutusController::class, 'edit']);
	Route::post('/update_aboutus/{id}',		 		[AboutusController::class, 'update']);
	Route::get('/delete_aboutus/{id}',		 		[AboutusController::class, 'delete']);

	Route::get('/manage_contactdetails',		 			[ContactDetailsController::class, 'index']);
	Route::get('/add_contactdetails',		 				[ContactDetailsController::class, 'add']);
	Route::post('/store_contactdetails',		 			[ContactDetailsController::class, 'store']);
	Route::get('/view_contactdetails/{id}',	 				[ContactDetailsController::class, 'view']);
	Route::get('/edit_contactdetails/{id}',		 			[ContactDetailsController::class, 'edit']);
	Route::post('/update_contactdetails/{id}',		 		[ContactDetailsController::class, 'update']);
	Route::get('/delete_contactdetails/{id}',		 		[ContactDetailsController::class, 'delete']);

	Route::get('/manage_quicklinks',		 			[QuicklinksController::class, 'index']);
	Route::get('/add_quicklinks',		 				[QuicklinksController::class, 'add']);
	Route::post('/store_quicklinks',		 			[QuicklinksController::class, 'store']);
	Route::get('/view_quicklinks/{id}',	 				[QuicklinksController::class, 'view']);
	Route::get('/edit_quicklinks/{id}',		 			[QuicklinksController::class, 'edit']);
	Route::post('/update_quicklinks/{id}',		 		[QuicklinksController::class, 'update']);
	Route::get('/delete_quicklinks/{id}',		 		[QuicklinksController::class, 'delete']);

	Route::get('/manage_socialmedialinks',		 			[SocialmedialinksController::class, 'index']);
	Route::get('/add_socialmedialinks',		 				[SocialmedialinksController::class, 'add']);
	Route::post('/store_socialmedialinks',		 			[SocialmedialinksController::class, 'store']);
	Route::get('/view_socialmedialinks/{id}',	 			[SocialmedialinksController::class, 'view']);
	Route::get('/edit_socialmedialinks/{id}',		 		[SocialmedialinksController::class, 'edit']);
	Route::post('/update_socialmedialinks/{id}',		 	[SocialmedialinksController::class, 'update']);
	Route::get('/delete_socialmedialinks/{id}',		 		[SocialmedialinksController::class, 'delete']);

	Route::get('/manage_newsletter',		 			[NewsletterController::class, 'index']);
	Route::get('/manage_contactus',		 			[NewsletterController::class, 'manage_contactus']);
	Route::get('/delete_contactus/{id}',		 			[NewsletterController::class, 'delete_contactus']);


	Route::get('/manage_products',		 			[ProductsController::class, 'index']);
	Route::get('/add_products',		 				[ProductsController::class, 'add']);
	Route::post('/store_products',		 			[ProductsController::class, 'store']);
	Route::get('/view_products/{id}',	 			[ProductsController::class, 'view']);
	Route::get('/edit_products/{id}',		 		[ProductsController::class, 'edit']);
	Route::post('/update_products/{id}',		 	[ProductsController::class, 'update']);
	Route::get('/delete_products/{id}',		 		[ProductsController::class, 'delete']);
	Route::get('/delete_product_image/{id}',		[ProductsController::class, 'delete_product_image']);
	Route::get('/manage_top_selling',		 		[ProductsController::class, 'manage_top_selling']);
	Route::get('/change_topselling_status/{id}',	[ProductsController::class, 'change_topselling_status']);
	Route::get('/change_toptrending_status/{id}',	[ProductsController::class, 'change_toptrending_status']);
	Route::get('/change_general_status/{id}',	 	[ProductsController::class, 'change_general_status']);

	Route::get('/manage_shops',		 			[ShopController::class, 'index']);
	Route::get('/add_shops',		 				[ShopController::class, 'add']);
	Route::post('/store_shops',		 			[ShopController::class, 'store']);
	Route::get('/view_shops/{id}',	 			[ShopController::class, 'view']);
	Route::get('/edit_shops/{id}',		 		[ShopController::class, 'edit']);
	Route::post('/update_shops/{id}',		 	[ShopController::class, 'update']);
	Route::get('/delete_shops/{id}',		 		[ShopController::class, 'delete']);
	Route::get('/delete_shop_image/{id}',		[ShopController::class, 'delete_shop_image']);

	Route::get('/manage_main_category',		 			[MainCategoryController::class, 'index']);
	Route::get('/add_main_category',		 				[MainCategoryController::class, 'add']);
	Route::post('/store_main_category',		 			[MainCategoryController::class, 'store']);
	Route::get('/view_main_category/{id}',	 			[MainCategoryController::class, 'view']);
	Route::get('/edit_main_category/{id}',		 		[MainCategoryController::class, 'edit']);
	Route::post('/update_main_category/{id}',		 	[MainCategoryController::class, 'update']);
	Route::get('/delete_main_category/{id}',		 		[MainCategoryController::class, 'delete']);

	Route::get('/manage_location',		 			[LocationController::class, 'index']);
	Route::get('/add_location',		 				[LocationController::class, 'add']);
	Route::post('/store_location',		 			[LocationController::class, 'store']);
	Route::get('/view_location/{id}',	 			[LocationController::class, 'view']);
	Route::get('/edit_location/{id}',		 		[LocationController::class, 'edit']);
	Route::post('/update_location/{id}',		 	[LocationController::class, 'update']);
	Route::get('/delete_location/{id}',		 		[LocationController::class, 'delete']);

	Route::get('/manage_banner',		 			[BannerController::class, 'index']);
	Route::get('/add_banner',		 				[BannerController::class, 'add']);
	Route::post('/store_banner',		 			[BannerController::class, 'store']);
	Route::get('/view_banner/{id}',	 			[BannerController::class, 'view']);
	Route::get('/edit_banner/{id}',		 		[BannerController::class, 'edit']);
	Route::post('/update_banner/{id}',		 	[BannerController::class, 'update']);
	Route::get('/delete_banner/{id}',		 		[BannerController::class, 'delete']);

	Route::get('/manage_homebanner',		 			[HomeBannerController::class, 'index']);
	Route::get('/add_homebanner',		 				[HomeBannerController::class, 'add']);
	Route::post('/store_homebanner',		 			[HomeBannerController::class, 'store']);
	Route::get('/view_homebanner/{id}',	 			[HomeBannerController::class, 'view']);
	Route::get('/edit_homebanner/{id}',		 		[HomeBannerController::class, 'edit']);
	Route::post('/update_homebanner/{id}',		 	[HomeBannerController::class, 'update']);
	Route::get('/delete_homebanner/{id}',		 		[HomeBannerController::class, 'delete']);

	Route::get('/manage_menu',		 			[MenuController::class, 'index']);
	Route::get('/add_menu',		 				[MenuController::class, 'add']);
	Route::post('/store_menu',		 			[MenuController::class, 'store']);
	Route::get('/view_menu/{id}',	 			[MenuController::class, 'view']);
	Route::get('/edit_menu/{id}',		 		[MenuController::class, 'edit']);
	Route::post('/update_menu/{id}',		 	[MenuController::class, 'update']);
	Route::get('/delete_menu/{id}',		 		[MenuController::class, 'delete']);

	Route::get('/manage_size',		 			[SizeController::class, 'index']);
	Route::get('/add_size',		 				[SizeController::class, 'add']);
	Route::post('/store_size',		 			[SizeController::class, 'store']);
	Route::get('/view_size/{id}',	 			[SizeController::class, 'view']);
	Route::get('/edit_size/{id}',		 		[SizeController::class, 'edit']);
	Route::post('/update_size/{id}',		 	[SizeController::class, 'update']);
	Route::get('/delete_size/{id}',		 		[SizeController::class, 'delete']);

	Route::get('/manage_profile',		 			[ProfileController::class, 'index']);
	Route::get('/add_profile',		 				[ProfileController::class, 'add']);
	Route::post('/store_profile',		 			[ProfileController::class, 'store']);
	Route::get('/view_profile/{id}',	 			[ProfileController::class, 'view']);
	Route::get('/edit_profile/{id}',		 		[ProfileController::class, 'edit']);
	Route::post('/update_profile/{id}',		 	[ProfileController::class, 'update']);
	Route::get('/delete_profile/{id}',		 		[ProfileController::class, 'delete']);
	Route::post('/getsubcategory',		 				[ProductsController::class, 'getsubcategory']);

	
});

