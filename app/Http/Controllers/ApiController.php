<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\User;
use App\BussinessCategory;
use App\SubscriptionPlan;
use App\BusinessProduct;
use App\BusinessEvent;
use App\UserBusiness;
use Validator;
use DB;

class ApiController extends Controller
{
    /**
     * Author:Divya
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->user = new User();
        $this->category = new BussinessCategory();
        $this->subscriptionPlan = new SubscriptionPlan();
        $this->businessProduct = new BusinessProduct();
        $this->businessEvent = new BusinessEvent();
        $this->userBusiness = new UserBusiness();

    }

    /**
     * Author:Divya
     * Function: Register User/Login User.
     * Url: api/login
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $response = $this->user->apiLogin($request);
        return $response;
    }

    /**
     * Author:Divya
     * Function: Get Business category.
     * Url: api/get/bussiness-categories
     * Request type: Get
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories()
    {
        $response = $this->category->apiGetCategory();
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any category ']);
    }

    /**
     * Author:Divya
     * Function: Get all Subscription plans.
     * Url: api/get/subscription-plans
     * Request type: Get
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubscriptionPlans()
    {
        $response = $this->subscriptionPlan->apiGetSubscriptionPlans();
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Subscription Plan ']);
    }

    /**
     * Author:Divya
     * Function: Get Business Products of user.
     * Url: api/get/business-products
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessProducts(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->businessProduct->apiGetBusinessProducts($input);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Product.']);
    }

    /**
     * Author:Divya
     * Function: Get Business Events of user.
     * Url: api/get/business-events
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessEvents(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->businessEvent->apiGetBusinessEvents($input);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Event.']);
    }

    /**
     * Author:Divya
     * Function: Get Businesses according to category Id.
     * Url: api/get/category/businesses
     * Request type: Get
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessesByCategory(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->userBusiness ->apiGetBusinessesByCategory($input);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Business.']);
    }

    /**
     * Author:Divya
     * Function: create and update User Business Details.
     * Url: api/post/user/business
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserBusiness(Request $request)
    {   
        $response = $this->userBusiness->apiPostUserBusiness($request);
        return $response;
    }

    /**
     * Author:Divya
     * Function: create and update User Product Details.
     * Url: api/post/user/product
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserProduct(Request $request)
    {   
        $response = $this->businessProduct->apiPostUserProduct($request);
        return $response;
    }

    /**
     * Author:Divya
     * Function: create and update User Event Details.
     * Url: api/post/user/event
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserEvent(Request $request)
    {   
        $response = $this->businessEvent->apiPostUserEvent($request);
        return $response;
    }

    /**
     * Author:Divya
     * Function: delete product.
     * Url: api/post/user/delete/product
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteProduct(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $product = BusinessProduct::where('user_id',$input['userId'])->where('id',$input['productId'])->first();

        if($product && $product->delete()){
            return response()->json(['status' => 'success', 'response' => 'Product deleted successfully.']);
        } else {
            return response()->json(['status' => 'exception', 'response' => 'Product could not be deleted.Please try again.']);
        }
    }

    /**
     * Author:Divya
     * Function: delete event.
     * Url: api/post/user/delete/event
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteEvent(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $event = BusinessEvent::where('user_id',$input['userId'])->where('id',$input['eventId'])->first();

        if($event && $event->delete()){
            return response()->json(['status' => 'success', 'response' => 'Event deleted successfully.']);
        } else {
            return response()->json(['status' => 'exception', 'response' => 'Event could not be deleted.Please try again.']);
        }
    }

    /**
     * Author:Divya
     * Function: Post event attending users
     * Url: api/post/event/attending/users
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEventAttendingUsers(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->businessEvent->apiPostEventAttendingUsers($input);
        return $response;
    }

    /**
     * Author:Divya
     * Function: Post business like and dislikes
     * Url: api/post/business/likes
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessLikes(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $check = DB::table('business_likes')->where('user_id',$input['userId'])->where('business_id',$input['businessId'])->pluck('id')->first();
        if($check)
        {
            if(isset($input['like'])!= NULL){
                DB::table('business_likes')->where('id',$check)->update(['likes' => $input['like'], 'dislikes' => 0 ]);
                return response()->json(['status' => 'success','response' => 'User updated like status for business']);

            } else {
                DB::table('business_likes')->where('id',$check)->update(['likes' => 0, 'dislikes' => $input['dislike'] ]);
                return response()->json(['status' => 'success','response' => 'User updated dislike status for business']);
            }
        } else{
            if(isset($input['like'])!= NULL){
                DB::table('business_likes')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'], 'likes' => $input['like'], 'dislikes' => 0 ]);
                return response()->json(['status' => 'success','response' => 'User like business']);
            } else {
                DB::table('business_likes')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'], 'likes' => 0, 'dislikes' => $input['dislike'] ]);
                return response()->json(['status' => 'success','response' => 'User dislike business']);
            }
        }
        return response()->json(['status' => 'failure','response' => 'System Error']);
    }

    /**
     * Author:Divya
     * Function: Post business rating
     * Url: api/post/business/rating
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessRating(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }
        $check = DB::table('business_ratings')->where('user_id', $input['userId'])->where('business_id', $input['businessId'])->pluck('id')->first();
        if($check)
        {   
            DB::table('business_ratings')->where('id', $check)->update(['rating' => $input['rating'] ]); 
            return response()->json(['status' => 'success','response' => 'Business rating Updated successfully']);

        } else {

            DB::table('business_ratings')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'], 'rating' => $input['rating']]);
            return response()->json(['status' => 'success','response' => 'Business rating saved successfully']);
       }
    }

    /**
     * Author:Divya
     * Function: Post business reviews
     * Url: api/post/business/reviews
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessReviews(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }
        $check = DB::table('business_reviews')->where('user_id', $input['userId'])->where('business_id', $input['businessId'])->pluck('id')->first();
        if($check)
        {   
            return response()->json(['status' => 'success','response' => 'User already reviewed on this business']);

        } else {

            DB::table('business_reviews')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'], 'review' => $input['review']]);
            return response()->json(['status' => 'success','response' => 'User review save successfully.']);
       }
    }
}