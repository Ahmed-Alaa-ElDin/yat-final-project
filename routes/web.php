<?php

use Illuminate\Support\Facades\Route;


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
// AUTH::routes(['verify'=>true]);

Route::middleware('auth')->group(function (){

    Route::get('/', 'DashboardController@startApp')->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', 'ProfileController@index')->name('profile.show');
    Route::patch('/profile/img', 'ProfileController@update')->name('profile.update');
    Route::post('/profile/img', 'ProfileController@upload_photo')->name('profile.photo.upload');
    Route::delete('/profile/img', 'ProfileController@delete_photo')->name('profile.photo.delete');

    // User Routes
    Route::get('/new_user','UserController@new_user')->name('user.form')->middleware('verified');
    Route::post('/new_user','UserController@create')->name('user.create');
    Route::get('/all_users','UserController@view_users')->name('users.view');
    Route::get('/get_user','UserController@view_user')->name('user.view');
    Route::get('/edit_user/{id?}','UserController@edit_user')->name('user.edit')->middleware('verified');
    Route::post('/edit_user','UserController@save_edit_user')->name('user.edit.save');
    Route::patch('/edit_user','UserController@delete_photo')->name('user.photo.delete');
    Route::delete('/edit_user','UserController@delete_user')->name('user.delete')->middleware('verified');
    
    // Category Routes
    Route::get('/new_category','CategoryController@new_category')->name('category.form')->middleware('verified');
    Route::post('/new_category','CategoryController@create')->name('category.create');
    Route::get('/categories','CategoryController@view_categories')->name('categories.view');
    Route::get('/categories/{id?}','CategoryController@edit_category')->name('category.edit')->middleware('verified');
    Route::post('/categories','CategoryController@save_edit_category')->name('category.edit.save');
    Route::delete('/categories','CategoryController@delete_category')->name('category.delete')->middleware('verified');

    // Products Routes
    Route::get('/new_product','ProductController@new_product')->name('product.form')->middleware('verified');
    Route::post('/new_product','ProductController@create')->name('product.create');
    Route::get('/get_product','ProductController@view_product')->name('product.view');
    Route::get('/products','ProductController@view_products')->name('products.view');
    Route::get('/products/{id?}','ProductController@edit_product')->name('product.edit')->middleware('verified');
    Route::post('/products','ProductController@save_edit_product')->name('product.edit.save');
    Route::delete('/products','ProductController@delete_product')->name('product.delete')->middleware('verified');

    // Countries Routes
    Route::get('/new_country','CountryController@new_country')->name('country.form')->middleware('verified');
    Route::post('/new_country','CountryController@create')->name('country.create');
    Route::get('/countries','CountryController@view_countries')->name('countries.view');
    Route::get('/countries/{id?}','CountryController@edit_country')->name('country.edit')->middleware('verified');
    Route::post('/countries','CountryController@save_edit_country')->name('country.edit.save');
    Route::delete('/countries','CountryController@delete_country')->name('country.delete')->middleware('verified');

    // Cities Routes
    Route::get('/new_city','CityController@new_city')->name('city.form')->middleware('verified');
    Route::post('/new_city','CityController@create')->name('city.create');
    Route::get('/cities','CityController@view_cities')->name('cities.view');
    Route::get('/cities/{id?}','CityController@edit_city')->name('city.edit')->middleware('verified');
    Route::post('/cities','CityController@save_edit_city')->name('city.edit.save');
    Route::delete('/cities','CityController@delete_city')->name('city.delete')->middleware('verified');

    // States Routes
    Route::get('/new_state','StateController@new_state')->name('state.form')->middleware('verified');
    Route::post('/new_state','StateController@create')->name('state.create');
    Route::get('/states','StateController@view_states')->name('states.view');
    Route::get('/states/{id?}','StateController@edit_state')->name('state.edit')->middleware('verified');
    Route::post('/states','StateController@save_edit_state')->name('state.edit.save');
    Route::delete('/states','StateController@delete_state')->name('state.delete')->middleware('verified');

    // Orders Routes
    Route::get('/new_order','OrderController@new_order')->name('order.form')->middleware('verified');
    Route::get('/get_user_address','OrderController@get_address')->name('address.get');
    Route::get('/get_country_cities','OrderController@get_cities')->name('city.get');
    Route::get('/get_city_states','OrderController@get_states')->name('state.get');
    Route::post('/add_items','OrderController@save_address_order')->name('address.create');
    Route::post('/create_item','OrderController@save_item')->name('item.create');
    Route::delete('/create_item','OrderController@delete_item')->name('item.delete');
    Route::delete('/delete_order','OrderController@delete_order')->name('order.delete');
    Route::patch('/save_order','OrderController@save_order')->name('order.save');
    Route::get('/orders','OrderController@view_orders')->name('orders.view');
    Route::get('/get_order','OrderController@view_order')->name('order.view');
    Route::delete('/delete_one_order','OrderController@delete_one_order')->name('order.view.delete')->middleware('verified');

    // Statistics Routes
    Route::get('/stats','StatController@go_to_stat')->name('stats.get');
});

require __DIR__.'/auth.php';
