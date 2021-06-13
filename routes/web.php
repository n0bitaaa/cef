<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/','Auth\LoginController@showLoginForm')->name('login');

Route::post('/','Auth\LoginController@login');

Route::group(['middleware' => 'auth'],function(){

    Route::get('/home','FrontendController@index')->name('frontend.index');

    Route::get('/receipt','FrontendController@receipt')->name('frontend.receipt');

});

Route::group(['prefix'=>'admin'],function(){
    Route::get('/login','Auth\LoginController@showLogin')->name('showLogin');

    Route::post('/login','Auth\LoginController@postLogin')->name('postLogin');

    Route::get('/register','Auth\RegisterController@showRegister')->name('showRegister');

    Route::post('/register','Auth\RegisterController@postRegister')->name('postRegister');

    Route::post('/logout','Auth\LoginController@logout')->name('Logout');
});

Route::group(['prefix'=>'admin','middleware'=>'auth:admin'],function(){
    Route::resource('/admins','AdminController')->only(['index','update','destroy']);

    Route::resource('/users','UserController')->except(['show','edit']);

    Route::resource('/products','ProductController')->except(['show','edit']);

    Route::resource('/orders','OrderController')->except(['show','edit']);

    Route::get('/orders/complete/{id?}','OrderController@orderComplete')->name('orderComplete');

    Route::post('/getnewCode','AdminController@newCode')->name('newCode');

    Route::get('/notifications','NotificationController@index')->name('noti_index');

    Route::get('/readOne/{id?}','NotificationController@readOne')->name('readOne');

    Route::get('/readAll','NotificationController@readAll')->name('readAll');

    Route::get('/deleteAll','NotificationController@deleteAll')->name('deleteAll');

    Route::post('/admins/search','AdminController@search')->name('admins.search');

    Route::post('/users/search','UserController@search')->name('users.search');

    Route::post('/products/search','ProductController@search')->name('products.search');

    Route::post('/orders/search','OrderController@search')->name('orders.search');
});