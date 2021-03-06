<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => ['api']], function (){ 
	Route::post('get/user/business-products', 'ApiController@getUserBusinessProducts');
	Route::post('get/user/business-events', 'ApiController@getUserBusinessEvents');
	Route::post('get/category/businesses', 'ApiController@getBusinessesByCategory');
	Route::post('post/user/business', 'ApiController@postUserBusiness');
	Route::post('post/user/event', 'ApiController@postUserEvent');
	Route::post('post/user/delete/product', 'ApiController@postDeleteProduct');
	Route::post('post/user/delete/event', 'ApiController@postDeleteEvent');
	Route::post('post/event/participants', 'ApiController@postEventParticipants');
	Route::post('post/business/express/{like}', 'ApiController@postBusinessLikes');
	Route::post('post/business/rating', 'ApiController@postBusinessRating');
	Route::post('post/business/reviews', 'ApiController@postBusinessReviews');
	Route::post('post/business/followers', 'ApiController@postBusinessFollowers');
	Route::post('post/business/favourites', 'ApiController@postBusinessFavourites');
	Route::post('get/business-services', 'ApiController@getBusinessServices');
	Route::post('post/user/service', 'ApiController@postUserService');
	Route::post('post/user/delete/service', 'ApiController@postDeleteService');
	Route::post('get/business-events' ,'ApiController@getBusinessEvents');
	Route::post('post/fcm/id' ,'ApiController@postFcmId');
	Route::post('post/app/feedback' ,'ApiController@postAppFeedback');
	Route::post('post/upload/documents' ,'ApiController@postUploadDocuments');
	Route::post('get/business/reviews' ,'ApiController@getBusinessReviews');
	Route::post('get/user/business/details' ,'ApiController@getUserBusinessDetails');	
	Route::post('get/searchBusinesses' ,'ApiController@getSearchBusinesses');
	Route::post('get/searchEvents' ,'ApiController@getSearchEvents');
	Route::post('block/notification' ,'ApiController@blockNotification');
	Route::post('get/app/notification' ,'ApiController@getAppNotification');
	Route::post('post/user/message' ,'ApiController@postUserMessage');
	Route::post('get/user/message' ,'ApiController@getUserMessage');
	Route::post('get/user/all/messages' ,'ApiController@getUserAllMessages');
	Route::post('upload/business/banner', 'ApiController@uploadBusinessBanner');
	Route::post('post/user/details', 'ApiController@postUserDetails');
	Route::post('get/user/details', 'ApiController@getUserDetails');
	Route::post('get/chat/users' , 'ApiController@getChatUsers');
	Route::post('get/previous/messages', 'ApiController@getPreviousMessages');
	Route::post('get/user/business/status', 'ApiController@getUserBusinessStatus');
	Route::post('get/user/attending/event/status', 'ApiController@getUserEventAttendingStatus');

	//New Apis
	Route::post('signup', 'ApiController@signup');
	Route::post('check/otp' ,'ApiController@checkOtp');
	Route::post('resend/otp' ,'ApiController@resendOtp');
	Route::post('get/user/portfolio', 'ApiController@getUserPortfolio');
	Route::post('post/user/portfolio', 'ApiController@postUserBusinessPortfolio');
	Route::post('get/user/portfolioDetails', 'ApiController@getUserPortfolioImages');
	Route::post('post/user/portfolioDetails', 'ApiController@postUserPortfolioDetail');
	Route::post('remove/user/portfolioDetails', 'ApiController@removeUserPortfolioDetail');
	Route::post('post/business/productImage', 'ApiController@postBusinessProductImage');
	Route::get('get/business/securityQuestion', 'ApiController@getSecurityQuestion');
	Route::get('get/business/eventSeatingPlans', 'ApiController@getEventSeatingPlans');
	Route::post('remove/product/image', 'ApiController@removeBusinessProductImage');

	//Updated Apis
	Route::post('login', 'ApiController@login');
	Route::post('post/user/product', 'ApiController@postUserProduct');

	//Get request api
	Route::get('get/business-categories', 'ApiController@getCategories');
	Route::get('get/business-subCategories/{id}', 'ApiController@getSubCategories');
	Route::get('get/currency/{countryName}', 'ApiController@getCurrency');
	Route::get('get/subscription-plans', 'ApiController@getSubscriptionPlans');
	Route::get('get/business/states' ,'ApiController@getBusinessStates');
	Route::get('get/cmsPages/{slug}' ,'ApiController@getCmsPages');
	Route::get('get/event-categories', 'ApiController@getEventCategories');

});