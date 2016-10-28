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
use App\BusinessService;
use App\BusinessReview;
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
        $this->businessService = new BusinessService();
        $this->businessReviews = new BusinessReview();
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
     * @param  Void
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
     * @param  Void
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
     * Url: api/get/user/business-products
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserBusinessProducts(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->businessProduct->apiGetUserBusinessProducts($input);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Product.']);
    }

    /**
     * Author:Divya
     * Function: Get Business Events of user.
     * Url: api/get/user/business-events
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserBusinessEvents(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->businessEvent->apiGetUserBusinessEvents($input);
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
     * Function: Post event participants
     * Url: api/post/event/participants
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEventParticipants(Request $request)
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
                DB::table('business_likes')->where('id',$check)->update(['is_like' => $input['like'], 'is_dislike' => 0 ]);
                return response()->json(['status' => 'success','response' => 'User updated like status for business']);

            } else {
                DB::table('business_likes')->where('id',$check)->update(['is_like' => 0, 'is_dislike' => $input['dislike'] ]);
                return response()->json(['status' => 'success','response' => 'User updated dislike status for business']);
            }
        } else{
            if(isset($input['like'])!= NULL){
                DB::table('business_likes')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'], 'is_like' => $input['like'], 'is_dislike' => 0 ]);
                return response()->json(['status' => 'success','response' => 'User like business']);
            } else {
                DB::table('business_likes')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'], 'is_like' => 0, 'is_dislike' => $input['dislike'] ]);
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

    /**
     * Author:Divya
     * Function: Post business followers
     * Url: api/post/business/followers
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessFollowers(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }
        $check = DB::table('business_followers')->where('user_id', $input['userId'])->where('business_id', $input['businessId'])->pluck('id')->first();
        if($check)
        {   
            DB::table('business_followers')->where('id', $check)->delete();
            return response()->json(['status' => 'success','response' => 'User unfollow this business successfully']);

        } else {

            DB::table('business_followers')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId']]);
            return response()->json(['status' => 'success','response' => 'User follow this business successfully']);
       }
    }

    /**
     * Author:Divya
     * Function: Post business favourites
     * Url: api/post/business/favourites
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessFavourites(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }
        $check = DB::table('business_favourites')->where('user_id', $input['userId'])->where('business_id', $input['businessId'])->pluck('id')->first();
        if($check)
        {   
            DB::table('business_favourites')->where('id', $check)->delete();
            return response()->json(['status' => 'success','response' => 'User remove this business from favourite list.']);

        } else {

            DB::table('business_favourites')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId']]);
            return response()->json(['status' => 'success','response' => 'User add this business in favourite list']);
       }
    }

    /**
     * Author:Divya
     * Function: Get services of Business user.
     * Url: api/get/business-services
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessServices(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->businessService->apiGetBusinessServices($input);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Service.']);
    }

    /**
     * Author:Divya
     * Function: create and update service Details of business user.
     * Url: api/post/user/service
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserService(Request $request)
    {   
        $response = $this->businessService->apiPostUserService($request);
        return $response;
    }

    /**
     * Author:Divya
     * Function: delete product.
     * Url: api/post/user/delete/service
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteService(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $service = BusinessService::where('user_id',$input['userId'])->where('id',$input['serviceId'])->first();

        if($service && $service->delete()){
            return response()->json(['status' => 'success', 'response' => 'Service deleted successfully.']);
        } else {
            return response()->json(['status' => 'exception', 'response' => 'Service could not be deleted.Please try again.']);
        }
    }

    /**
     * Author:Divya
     * Function: Check Otp.
     * Url: api/check/otp
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkOtp(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->user->apiCheckOtp($input);
        
        if($response == 1)
        {
            return response()->json(['status' => 'success', 'response' => 'Otp Verified']);
        } else if($response == 2) {
            return response()->json(['status' => 'exception', 'response' => 'Incorrect Otp']);
        }else{
            return response()->json(['status' => 'exception', 'response' => 'Mobile Number does not exist.']);
        }
    }

    /**
     * Author:Divya
     * Function: Get all events details.
     * Url: api/post/user/business-events
     * Request type: Get
     *
     * @param  Void
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessEvents()
    {  
        $response = $this->businessEvent->apiGetBusinessEvents();
        
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Event.']);
    }

    /**
     * Author:Divya
     * Function: Save user fcm registration Ids.
     * Url: api/post/fcm/id
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFcmId(Request $request)
    {  
        $input = $request->input();
        if($input == NULL){
            return response()->json(['status' => 'exception','response' =>'Input parameters are missing.']);
        }
        
        $response = DB::table('fcm_users')->where('user_id', $input['userId'])->where('fcm_reg_id', $input['fcmRegId'])->first();
        
        if($response){
            return response()->json(['status' => 'success','response' =>'This Fcm registration id for this user already exist in database.']);
        }
        else{
            $response = DB::table('fcm_users')->insert(['user_id' => $input['userId'], 'fcm_reg_id' => $input['fcmRegId']]);
            if($response)
                return response()->json(['status' => 'success','response' =>' Fcm registration id for this user save successfully.']);
            else
                return response()->json(['status' => 'failure','response' =>'System Error:Unable to save Fcm registration id for this user.']);
        }
    }

    /**
     * Author:Divya
     * Function: Post app feedback.
     * Url: api/post/app/feedback
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAppFeedBack(Request $request)
    {  
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'success','response' => 'Input parmeters are missing.']);
        }

        $user = DB::table('app_feedbacks')->where('user_id', $input['userId'])->first();
        if($user){
            return response()->json(['status' => 'success','response' => 'This user already gave feedback']);
        }
        else {
            $feedback = DB::table('app_feedbacks')->insert(['user_id' => $input['userId'], 'feedback' => $input['feedback']]);
            if($feedback)
                return response()->json(['status' => 'success','response' => 'User feedback save successfully']);
            else
                return response()->json(['status' => 'failure','response' => 'System Error:Unable to save feedback.Please try again.']);
        }
    }

    /**
     * Author:Divya
     * Function: Upload document(identity & business proof)
     * Url: api/post/upload/documents
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUploadDocuments(Request $request)
    {  
        $response = $this->userBusiness->apiPostUploadDocuments($request);
        return $response;
    }

    /**
     * Author:Divya
     * Function: get all business reviews by business id
     * Url: api/get/business/reviews/{businessId}
     * Request type: Post
     *
     * @param  int $businessId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessReviews($businessId)
    {  
        $response = $this->businessReviews->apiGetBusinessReview($businessId);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any review.']);
    }

     /**
     * Author:Divya
     * Function: get business details of user by business id
     * Url: api/get/user/business/details/{businessId}
     * Request type: Post
     *
     * @param  int $businessId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserBusinessDetails($businessId)
    {  
        $response = $this->userBusiness->apiGetUserBusinessDetails($businessId);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any business details.']);
    }
    /**
     * Author:Divya
     * Function: get business states according to countryName
     * Url: api/get/business/states/{countryName}
     * Request type: Post
     *
     * @param  string $countryName
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessStates(Request $request)
    {  
        $input = $request->input();
        $response = $this->userBusiness->apiGetBusinessStates($input);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not found any state']);
    }
}