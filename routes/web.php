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

Route::middleware('auth')->group(function (){

    Route::get('/', 'DashboardController@startApp')->name('dashboard');
    
    Route::get('/profile', 'ProfileController@index')->name('profile.show');
    Route::patch('/profile/img', 'ProfileController@update')->name('profile.update');
    Route::post('/profile/img', 'ProfileController@upload_photo')->name('profile.photo.upload');
    Route::delete('/profile/img', 'ProfileController@delete_photo')->name('profile.photo.delete');

    Route::get('/new_user','UserController@index')->name('user.form');
    Route::post('/new_user','UserController@create')->name('user.create');
    Route::get('/all_users','UserController@view_users')->name('users.view');
    Route::get('/get_user','UserController@view_user')->name('user.view');
    Route::get('/edit_user/{id?}','UserController@edit_user')->name('user.edit');
    Route::post('/edit_user','UserController@save_edit_user')->name('user.edit.save');
    Route::patch('/edit_user','UserController@delete_photo')->name('user.photo.delete');
    Route::delete('/edit_user','UserController@delete_user')->name('user.delete');
});

require __DIR__.'/auth.php';
