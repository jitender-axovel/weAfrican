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
	Route::get('get/bussiness-categories', 'ApiController@getCategories');
	Route::get('get/subscription-plans', 'ApiController@getSubscriptionPlans');
	Route::post('get/business-products', 'ApiController@getBusinessProducts');
	Route::get('get/business-events', 'ApiController@getBusinessEvents');
	Route::get('get/category/businesses', 'ApiController@getBusinessesByCategory');
	Route::post('post/user/business', 'ApiController@postUserBusiness');
});