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
	Route::post('login', 'ApiController@login');
	Route::get('get/business-categories', 'ApiController@getCategories');
	Route::get('get/subscription-plans', 'ApiController@getSubscriptionPlans');
	Route::post('get/business-products', 'ApiController@getBusinessProducts');
	Route::post('get/business-events', 'ApiController@getBusinessEvents');
	Route::get('get/category/businesses', 'ApiController@getBusinessesByCategory');
	Route::post('post/user/business', 'ApiController@postUserBusiness');
	Route::post('post/user/product', 'ApiController@postUserProduct');
	Route::post('post/user/event', 'ApiController@postUserEvent');
	Route::post('post/user/delete/product', 'ApiController@postDeleteProduct');
	Route::post('post/user/delete/event', 'ApiController@postDeleteEvent');
	Route::post('post/event/attending/users', 'ApiController@postEventAttendingUsers');
	Route::post('post/business/likes', 'ApiController@postBusinessLikes');
	Route::post('post/business/rating', 'ApiController@postBusinessRating');
	Route::post('post/business/reviews', 'ApiController@postBusinessReviews');
	Route::post('post/business/followers', 'ApiController@postBusinessFollowers');
	Route::post('post/business/favourites', 'ApiController@postBusinessFavourites');
	Route::post('get/business-services', 'ApiController@getBusinessServices');
	Route::get('post/user/service', 'ApiController@postUserService');
	Route::get('post/user/delete/service', 'ApiController@postDeleteService');

});