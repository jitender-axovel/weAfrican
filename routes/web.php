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
Route::group(['middleware' => ['before']], function(){
	Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);

	Auth::routes();

	Route::get('logout', 'Auth\LoginController@logout');

	Route::get('cms/{slug}', ['uses' => 'CmsController@index', 'as' => 'cms']);

	Route::resource('register-business', 'UserBusinessController');

	Route::get('otp', 'UserBusinessController@otp');
	Route::post('check-otp', 'UserBusinessController@checkOtp');

	Route::group(['middleware' => ['auth']], function() {
		
		Route::get('upload', 'UserBusinessController@uploadForm');
		Route::post('upload-document', 'UserBusinessController@uploadDocument');
		Route::resource('business-product', 'BusinessProductsController');
		Route::resource('business-event', 'BusinessEventsController');
		Route::resource('subscription-plans', 'SubscriptionPlansController');
		Route::resource('business-service', 'BusinessServicesController');
		Route::resource('event/participants/download-csv/{id}', 'BusinessEventsController@exportToCsv');
	});
});

Route::group(['prefix' => 'admin'], function() {
	Route::get('login', 'AdminController@login');
	Route::post('login', 'AdminController@postLogin');
	Route::group(['middleware' => ['admin']], function () {
		Route::get('dashboard', 'AdminController@index');
		Route::get('user/blocked/{id}','AdminUsersController@block');
		Route::resource('users', 'AdminUsersController');
		Route::get('business/block/{id}','AdminUserBusinessesController@block');
		Route::resource('business', 'AdminUserBusinessesController');
		Route::get('bussiness/category/block/{id}', 'AdminBussinessCategoriesController@block');
		Route::resource('bussiness/category', 'AdminBussinessCategoriesController');
		Route::get('event/block/{id}', 'AdminBusinessEventsController@block');
		Route::resource('event', 'AdminBusinessEventsController');
		Route::get('business/identity/proof/validate/{id}','AdminUserBusinessesController@identityProofVerfied');
		Route::get('business/proof/validate/{id}','AdminUserBusinessesController@businessProofVerfied');
		Route::get('subscription/plan/block/{id}','AdminSubscriptionPlansController@block');
		Route::resource('subscription/plan', 'AdminSubscriptionPlansController');
		Route::get('product/block/{id}','AdminBusinessProductsController@block');
		Route::resource('product', 'AdminBusinessProductsController');
		Route::get('service/block/{id}','AdminBusinessServicesController@block');
		Route::resource('service', 'AdminBusinessServicesController');
		Route::get('banner/block/{id}','AdminBusinessBannersController@block');
		Route::resource('banner', 'AdminBusinessBannersController');
		Route::resource('cms', 'AdminCmsPagesController');
		Route::resource('fcm-notification', 'AdminFcmNotificationController');
		Route::post('send/notification', 'AdminFcmNotificationController@sendNotification');
		Route::resource('app-feedback', 'AdminAppFeedbackController');
		Route::get('app-feedback/block/{id}','AdminAppFeedbackController@block');
		Route::resource('reviews', 'AdminBusinessReviewsController');
		Route::get('reviews/block/{id}','AdminBusinessReviewsController@block');
	});
});
