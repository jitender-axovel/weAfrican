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

Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);

Auth::routes();

Route::get('cms/{slug}', ['uses' => 'CmsController@index', 'as' => 'cms']);

Route::group(['prefix' => 'admin'], function() {
	Route::get('login', 'AdminController@login');
	Route::post('login', 'AdminController@postLogin');
	Route::group(['middleware' => ['admin']], function () {
		Route::get('dashboard', 'AdminController@index');
		Route::get('user/blocked/{id}','AdminUsersController@block');
		Route::resource('users', 'AdminUsersController');
		Route::get('bussiness/category/block/{id}', 'AdminBussinessCategoriesController@block');
		Route::resource('bussiness/category', 'AdminBussinessCategoriesController');
		Route::get('subscription/plan/block/{id}','AdminSubscriptionPlansController@block');
		Route::resource('subscription/plan', 'AdminSubscriptionPlansController');
		Route::get('banner/block/{id}','AdminBusinessBannersController@block');
		Route::resource('banner', 'AdminBusinessBannersController');
		Route::resource('cms', 'AdminCmsPagesController');
	});
});
