<<<<<<< HEAD
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
	Route::get('resend-otp', 'UserBusinessController@resendotp');
	Route::get('otp', 'UserBusinessController@otp');
	Route::post('check-otp', 'UserBusinessController@checkOtp');

	Route::group(['middleware' => ['auth']], function() {

		//Route::get('otp', 'UserBusinessController@otp');
		Route::get('upload', 'UserBusinessController@uploadForm');
		Route::post('upload-document', 'UserBusinessController@uploadDocument');
		Route::resource('business-product', 'BusinessProductsController');
		Route::resource('business-event', 'BusinessEventsController');
		Route::resource('subscription-plans', 'UserSubscriptionPlansController');
		Route::resource('business-service', 'BusinessServicesController');
		Route::post('event/participants/download-csv/{eventId}', 'BusinessEventsController@exportToCsv');
		Route::resource('banners', 'BannersController');
		Route::delete('home/banner/{id}', 'BannersController@deleteHomeBanner');
		Route::delete('business/banner/{id}', 'BannersController@deleteBusinessBanner');
		Route::delete('event/banner/{id}', 'BannersController@deleteEventBanner');
		Route::get('home/banner/block/{id}','BannersController@blockHomeBanner');
		Route::get('business/banner/block/{id}','BannersController@blockBusinessBanner');
		Route::get('event/banner/block/{id}','BannersController@blockEventBanner');
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
		Route::get('home/banner/block/{id}','AdminBannersController@blockHomeBanner');
		Route::get('business/banner/block/{id}','AdminBannersController@blockBusinessBanner');
		Route::get('event/banner/block/{id}','AdminBannersController@blockEventBanner');
		Route::resource('banner', 'AdminBannersController');
		Route::resource('cms', 'AdminCmsPagesController');
		Route::resource('fcm-notification', 'AdminFcmNotificationController');
		Route::post('send/notification', 'AdminFcmNotificationController@sendNotification');
		Route::resource('app-feedback', 'AdminAppFeedbackController');
		Route::get('app-feedback/block/{id}','AdminAppFeedbackController@block');
		Route::resource('reviews', 'AdminBusinessReviewsController');
		Route::get('reviews/block/{id}','AdminBusinessReviewsController@block');
		Route::resource('conversation', 'AdminUserConversationsController');
		Route::get('get/conversations/{senderId}/{receiverId}', 'AdminUserConversationsController@getConversations');
		Route::get('get/message/{senderId}', 'AdminUserConversationsController@getMessage');
		Route::delete('business/banner/{id}', 'AdminBusinessBannersController@deleteBusinessBanner');
		Route::delete('event/banner/{id}', 'AdminBannersController@deleteEventBanner');
		Route::get('category/event/block/{id}', 'AdminEventCategoriesController@block');

		Route::resource('category/event', 'AdminEventCategoriesController');
	});
=======
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
	Route::get('resend-otp', 'UserBusinessController@resendotp');
	Route::get('otp', 'UserBusinessController@otp');
	Route::post('check-otp', 'UserBusinessController@checkOtp');

	Route::group(['middleware' => ['auth']], function() {

		//Route::get('otp', 'UserBusinessController@otp');
		Route::get('upload', 'UserBusinessController@uploadForm');
		Route::post('upload-document', 'UserBusinessController@uploadDocument');
		Route::resource('business-product', 'BusinessProductsController');
		Route::resource('business-event', 'BusinessEventsController');
		Route::resource('subscription-plans', 'UserSubscriptionPlansController');
		Route::resource('business-service', 'BusinessServicesController');
		Route::post('event/participants/download-csv/{eventId}', 'BusinessEventsController@exportToCsv');
		Route::resource('banners', 'BannersController');
		Route::delete('home/banner/{id}', 'BannersController@deleteHomeBanner');
		Route::delete('business/banner/{id}', 'BannersController@deleteBusinessBanner');
		Route::delete('event/banner/{id}', 'BannersController@deleteEventBanner');
		Route::get('home/banner/block/{id}','BannersController@blockHomeBanner');
		Route::get('business/banner/block/{id}','BannersController@blockBusinessBanner');
		Route::get('event/banner/block/{id}','BannersController@blockEventBanner');
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
		Route::get('home/banner/block/{id}','AdminBannersController@blockHomeBanner');
		Route::get('business/banner/block/{id}','AdminBannersController@blockBusinessBanner');
		Route::get('event/banner/block/{id}','AdminBannersController@blockEventBanner');
		Route::resource('banner', 'AdminBannersController');
		Route::resource('cms', 'AdminCmsPagesController');
		Route::resource('fcm-notification', 'AdminFcmNotificationController');
		Route::post('send/notification', 'AdminFcmNotificationController@sendNotification');
		Route::resource('app-feedback', 'AdminAppFeedbackController');
		Route::get('app-feedback/block/{id}','AdminAppFeedbackController@block');
		Route::resource('reviews', 'AdminBusinessReviewsController');
		Route::get('reviews/block/{id}','AdminBusinessReviewsController@block');
		Route::resource('conversation', 'AdminUserConversationsController');
		Route::get('get/conversations/{senderId}/{receiverId}', 'AdminUserConversationsController@getConversations');
		Route::get('get/message/{senderId}', 'AdminUserConversationsController@getMessage');
		Route::delete('business/banner/{id}', 'AdminBusinessBannersController@deleteBusinessBanner');
		Route::delete('event/banner/{id}', 'AdminBannersController@deleteEventBanner');
		Route::get('category/event/block/{id}', 'AdminEventCategoriesController@block');

		Route::resource('category/event', 'AdminEventCategoriesController');
	});
>>>>>>> 8c39c53ea005b053df66154f2fe2a9daa6de81c2
});