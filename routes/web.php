<?php

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
// Home
Route::get('/', 'ProductController@list');
Route::get('/brand/{brand}', 'ProductController@brand_list');
Route::get('/category/{category}', 'ProductController@category_list');
Route::get('/login', 'Auth\LoginController@home');
Route::get('/recover_password', 'UserController@recover_show');

// User
Route::get('/user/{id}', 'UserController@show');
Route::put('/user/{id}/edit_user', 'UserController@edit');
Route::get('/user/{id}/edit', 'UserController@show_edit');
Route::put('/edit_user', 'UserController@edit')->name('edit_user');
Route::get('/user/{id}/delete_user', 'UserController@delete_user');

// Addresses
Route::get('/user/{id}/addresses', 'UserController@show_addresses');

// Orders
Route::get('/user/{id}/past_orders', 'UserController@show_past_orders');
Route::get('/user/{id}/orders', 'UserController@show_current_orders');
Route::get('user/{id}/order/{id_order}', 'OrderController@show');
Route::patch('/api/order/{id}', 'OrderController@change_status');
Route::get('/reports', 'ReportController@list');
// Products
Route::post('/api/ban/{id}/{motive}/{id_review}','BanController@create_ban');
Route::put('/api/report/dismiss/{id_user}/{id_review}/{motive}','ReportController@dismiss');
Route::get('/product/add', 'ProductController@show_add');
Route::post('/product/add_product', 'ProductController@add');
Route::get('product/{id}', 'ProductController@show')->name('product');
Route::post('product/{id}', 'ReviewController@create_review')->name('create_review');
Route::get('product/{id}/edit', 'ProductController@show_edit');
Route::put('/product/{id}/edit_product', 'ProductController@edit');
Route::get('product/{id}/delete', 'ProductController@delete_product');

// Reviews
Route::post('report/review/{id}/{motive}', 'ReportController@create_report');
Route::post('api/report/review/{id}/{motive}', 'ReportController@create_report')->name('create_report');
Route::delete('api/review/{id}', 'ReviewController@remove');

Route::put('/product/{id}/edit_product', 'ProductController@edit');
Route::put('/product/{id}','ReviewController@edit_review')->name('edit_review');
Route::post('api/review/edit/{id}/{title}/{text}/{rating}','ReviewController@edit_review');
// Shopping Cart
Route::get('shopping_cart', 'ShoppingCartController@list');
Route::delete('api/product/{id}', 'ProductController@remove');
Route::post('api/product/{id}', 'ProductController@buy');

// Wish List
Route::get('/wishlist', 'WishListController@list');
Route::post('api/wishlist/product/{id}', 'ProductController@add_wishlist')->name('addwishlist');
Route::delete('api/wishlist/product/{id}', 'ProductController@remove_wishlist')->name('removewishlist');

// API
Route::get('/search', 'SearchController@search');

// Authentication
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');

// About us
Route::get('about', 'AboutController@show');

//Contact us
Route::get('faq', 'FAQController@show');

//Checkout
Route::get('checkout', 'CheckoutController@show');
Route::post('verify', 'CheckoutController@info');

//Management
Route::get('/create_user', 'ManagementController@show_create_user');
Route::get('/user_search', 'ManagementController@show_search_users');
Route::post('/user_search', 'ManagementController@show_search');
Route::post('/create_user', 'ManagementController@register');
Route::put('edit_profile_admin', 'ManagementController@edit_admin')->name('edit_profile_admin');

//Email
use App\Http\Controllers\TestController;
Route::post('/send-email', [TestController::class, 'sendEmail']);

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

