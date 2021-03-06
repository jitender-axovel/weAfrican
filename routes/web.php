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

	Route::get('event', 'SubscriptionPlanPagesController@event');
	Route::get('sponsor', 'SubscriptionPlanPagesController@sponsor');
	Route::get('banner', 'SubscriptionPlanPagesController@banner');
	Route::get('search', 'SubscriptionPlanPagesController@search');
	
	Route::get('{status}-page', function ($status) {
    	return view('errors.'.$status);
	});

	Route::resource('register-business', 'UserBusinessController');
	Route::get('resend-otp', 'UserBusinessController@resendotp');
	Route::get('otp', 'UserBusinessController@otp');
	Route::get('emailVerify', 'UserBusinessController@otp');
	Route::post('check-otp', 'UserBusinessController@checkOtp');
	Route::post('country-details', 'AjaxController@countryDetails');
	Route::post('country', 'AjaxController@countryList');
	Route::post('state', 'AjaxController@stateList');
	Route::post('city', 'AjaxController@cityList');
	Route::post('category', 'AjaxController@categoryList');
	Route::post('subcategory', 'AjaxController@subcategoryList');

	Route::group(['middleware' => ['auth']], function() {

		//Route::get('otp', 'UserBusinessController@otp');
		Route::get('upload', 'UserBusinessController@uploadForm');
		Route::post('upload-document', 'UserBusinessController@uploadDocument');
		Route::resource('business-product', 'BusinessProductsController');
		Route::post('send_message', 'BusinessFollowerListController@sendMessage');//Ajax function to send push Notification
		Route::resource('business-event', 'BusinessEventsController');
		Route::resource('business-follower', 'BusinessFollowerListController');
		Route::resource('business-service', 'BusinessServicesController');
		Route::post('event/participants/download-csv/{eventId}', 'BusinessEventsController@exportToCsv');
		Route::resource('banners', 'BannersController');
		Route::delete('home/banner/{id}', 'BannersController@deleteHomeBanner');
		Route::delete('business/banner/{id}', 'BannersController@deleteBusinessBanner');
		Route::delete('event/banner/{id}', 'BannersController@deleteEventBanner');
		Route::get('home/banner/block/{id}','BannersController@blockHomeBanner');
		Route::get('business/banner/block/{id}','BannersController@blockBusinessBanner');
		Route::get('event/banner/block/{id}','BannersController@blockEventBanner');
		Route::get('mobileVerify', 'UserBusinessController@verifyMobile');
		Route::get('verifyMobile', 'UserBusinessController@mobileOtp');
		Route::get('resend-mobile-otp', 'UserBusinessController@resendMobileOtp');
		Route::resource('change-mobile', 'UserBusinessController@changeMobile');
		Route::post('update-mobile', 'UserBusinessController@updateMobile');
		Route::post('check-mobile-otp', 'UserBusinessController@checkMobileOtp');
		Route::resource('portfolio', 'UserBusinessPortfolioController');
		Route::resource('my-account', 'MyAccountController');
		Route::resource('business-banner', 'MyAccountController@businessBanners');
		Route::resource('sponsor-banner', 'MyAccountController@sponsorBanners');
		Route::resource('event-banner', 'MyAccountController@eventBanners');
		Route::resource('subscription-plans', 'UserSubscriptionPlansController');
	});
});

Route::group(['prefix' => 'admin'], function() {
	Route::get('login', 'AdminController@login');
	Route::post('login', 'AdminController@postLogin');
	Route::group(['middleware' => ['admin']], function () {
		Route::get('dashboard', 'AdminController@index');
		Route::get('user/blocked/{id}','AdminUsersController@block');
		Route::resource('users', 'AdminUsersController');
		Route::get('getSearch', 'AdminUsersController@getSearch');
		Route::get('getCSV', 'AdminUsersController@exportToCsv');
		Route::get('business/block/{id}','AdminUserBusinessesController@block');
		Route::resource('business', 'AdminUserBusinessesController');
		Route::get('bussiness/category/block/{id}', 'AdminBussinessCategoriesController@block');
		Route::resource('bussiness/category', 'AdminBussinessCategoriesController');
		Route::get('bussiness/sub-category/block/{id}', 'AdminBussinessSubcategoriesController@block');
		Route::resource('bussiness/sub-category', 'AdminBussinessSubcategoriesController');
		Route::get('event/block/{id}', 'AdminBusinessEventsController@block');
		Route::resource('event', 'AdminBusinessEventsController');
		Route::get('business/identity/proof/validate/{id}','AdminUserBusinessesController@identityProofVerfied');
		Route::get('business/proof/validate/{id}','AdminUserBusinessesController@businessProofVerfied');
		Route::get('business/user/validate/{id}','AdminUserBusinessesController@businessUserVerify');
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
		Route::resource('seating-plan', 'AdminSeatingPlanController');
		Route::get('seating-plan/block/{id}', 'AdminSeatingPlanController@block');
		Route::resource('security-question', 'AdminSecurityQuestionsController');
		Route::get('security-question/block/{id}', 'AdminSecurityQuestionsController@block');
	});
});