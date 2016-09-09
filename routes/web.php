<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'admin'], function() {
		Route::get('login', 'AdminController@login');
		Route::post('login', 'AdminController@postLogin');
		Route::group(['middleware' => ['admin']], function () {
			Route::get('dashboard', 'AdminController@index');
			Route::get('user/blocked/{id}','AdminUsersController@getBlocked');
			Route::resource('users', 'AdminUsersController');
			Route::get('bussiness/category/block/{id}', 'AdminBussinessCategoriesController@getBlocked');
			Route::resource('bussiness/category', 'AdminBussinessCategoriesController');
			Route::get('subscription/plan/block/{id}','AdminSubscriptionPlansController@getBlocked');
			Route::resource('subscription/plan', 'AdminSubscriptionPlansController');
			Route::get('advertisement/plan/activated/{id}','AdminAdvertisementPlansController@isActivated');
			Route::resource('advertisement/plan', 'AdminAdvertisementPlansController');
			Route::get('banner/activated/{id}','AdminBannersController@isActivated');
			Route::resource('banner', 'AdminBannersController');
		});	
});
