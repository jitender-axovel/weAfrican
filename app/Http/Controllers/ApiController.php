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
use App\BusinessFollower;
use App\BusinessNotification;
use App\UserConversation;
use App\CmsPage;
use App\EventCategory;
use Validator;
use DB;

class ApiController extends Controller
{
    /**
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->user = new User();
        $this->category = new BussinessCategory();
        $this->eventCategory = new EventCategory();
        $this->subscriptionPlan = new SubscriptionPlan();
        $this->businessProduct = new BusinessProduct();
        $this->businessEvent = new BusinessEvent();
        $this->userBusiness = new UserBusiness();
        $this->businessService = new BusinessService();
        $this->businessReviews = new BusinessReview();
        $this->userConversation = new UserConversation();
        $this->cmsPages = new CmsPage();
    }

    /**
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
     * Function: Get Business category.
     * Url: api/get/bussiness-categories
     * Request type: Get
     *
     * @param  Void
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventCategories()
    {
        $response = $this->eventCategory->apiGetEventCategory();
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any  event category ']);
    }

    /**
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
        $validator = Validator::make($input, [
                'userId' => 'required',
                'categoryId' => 'required',
                'state' => 'required',
                'index' => 'required',
                'limit' => 'required',
        ]);

       if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = $this->userBusiness->apiGetBusinessesByCategory($input);
        if(count($response))
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Business.']);
    }

    /**
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
     * Function: create and update User Event Details.
     * Url: api/post/user/event
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserEvent(Request $request)
    {   
        $input = $request->input();
        $response = $this->businessEvent->apiPostUserEvent($input);
        return $response;
    }

    /**
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

        $check = DB::table('business_likes')->where('user_id',$input['userId'])->where('business_id',$input['businessId'])->pluck('id')->first();

        if ($check)
        {
            if (isset($input['like']))
            {
                DB::table('business_likes')->where('id',$check)->update(['is_like' => $input['like']]);
                return response()->json(['status' => 'success','response' => 1]);

            } else {

                DB::table('business_likes')->where('id',$check)->update(['is_dislike' => $input['dislike']]);
                return response()->json(['status' => 'success','response' => 1]);
            }

        } else {

            if (isset($input['like']))
            {
                DB::table('business_likes')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'], 'is_like' => $input['like']]);
                return response()->json(['status' => 'success','response' => 1]);

            } else {

                DB::table('business_likes')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'], 'is_dislike' => $input['dislike']]);
                return response()->json(['status' => 'success','response' => 1]);
            }
        }
        return response()->json(['status' => 'failure','response' => 'System Error:Please try again.']);
    }

    /**
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
     
        $check = DB::table('business_ratings')->where('user_id', $input['userId'])->where('business_id', $input['businessId'])->pluck('id')->first();

        if ($check)
        {   
            DB::table('business_ratings')->where('id', $check)->update(['rating' => $input['rating'] ]); 
            return response()->json(['status' => 'success','response' => 'Business rating Updated successfully']);

        } else {

            DB::table('business_ratings')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'], 'rating' => $input['rating']]);
            return response()->json(['status' => 'success','response' => 'Business rating saved successfully']);
       }
    }

    /**
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

        $validator = Validator::make($input, [
            'userId' => 'required',
            'businessId' => 'required',
            'review' => 'required',
        ]);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = DB::table('business_reviews')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'], 'review' => $input['review']]);

        if($response)
            return response()->json(['status' => 'success','response' => 'Review Posted']);
         else
            return response()->json(['status' => 'success','response' => 'Unable to post review.Please try again.']);
    }

    /**
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

        $check = DB::table('business_followers')->where('user_id', $input['userId'])->where('business_id', $input['businessId'])->pluck('id')->first();

        if($check)
        {   
            DB::table('business_followers')->where('id', $check)->delete();
            return response()->json(['status' => 'success','response' => 0]);

        } else {

            DB::table('business_followers')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId']]);
            return response()->json(['status' => 'success','response' => 1]);
       }
    }

    /**
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
     * Function: delete Service.
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
     * Function: search events by lat,long/country,state.
     * Url: api/get/user/business-events
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessEvents(Request $request)
    {  
        $input = $request->input();
        $validator = Validator::make($input, [
                'userId' => 'required',
                'state' => 'required',
                'index' => 'required',
                'limit' => 'required',
        ]);

       if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = $this->businessEvent->apiGetBusinessEvents($input);
        
        if(count($response))
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Event.']);
    }

    /**
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

        if ($input['fcmRegId'] == DB::table('fcm_users')->where('user_id', $input['userId'])->pluck('fcm_reg_id')->first()) {
            return response()->json(['status' => 'success','response' =>'Fcm registration id updated successfully.']);
        }

        $check = DB::table('fcm_users')->where('user_id', $input['userId'])->pluck('user_id')->first();
        
        if ($check){
            $response = DB::table('fcm_users')->where('user_id', $input['userId'])->update(['fcm_reg_id' => $input['fcmRegId']]);

            if ($response)
                return response()->json(['status' => 'success','response' =>'Fcm registration id updated successfully.']);
            else
                return response()->json(['status' => 'failure','response' =>'System Error:Unable to update Fcm registration id for this user.']);

        } else {
            $response = DB::table('fcm_users')->insert(['user_id' => $input['userId'], 'user_role_id' => $input['roleId'], 'fcm_reg_id' => $input['fcmRegId']]);

            if($response)
                return response()->json(['status' => 'success','response' =>' Fcm registration id for this user save successfully.']);
            else
                return response()->json(['status' => 'failure','response' =>'System Error:Unable to save Fcm registration id for this user.']);
        }
    }

    /**
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
     * Function: Upload document(identity & business proof)
     * Url: api/post/upload/documents
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUploadDocuments(Request $request)
    {  
        $input = $request->input();
        $response = $this->userBusiness->apiPostUploadDocuments($input);
        return $response;
    }

    /**
     * Function: get all business reviews by business id
     * Url: api/get/business/reviews/{businessId}
     * Request type: Post
     *
     * @param   \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessReviews(Request $request)
    {  
        $input = $request->input();
        $response = $this->businessReviews->apiGetBusinessReview($input);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any review.']);
    }

    /**
     * Function: get business user details by business id
     * Url: api/get/user/business/details
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserBusinessDetails(Request $request)
    {  
        $input = $request->input();
        $response = $this->userBusiness->apiGetUserBusinessDetails($input);
        if($response != NULL)
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any business details.']);
    }
    /**
     * Function: get business states according to countryName
     * Url: api/get/business/states
     *
     * @param  \Illuminate\Http\Request  $request
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

    /**
     * Function: get search business by using search term
     * Url: api/get/searchBusinesses
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearchBusinesses(Request $request)
    {  
       
         $validator = Validator::make($request->all(), UserBusiness::$searchValidator );

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $input = $request->input();

        $businessIds = UserBusiness::where('title', 'LIKE', '%'.$input['term'].'%')->orWhere('keywords', 'LIKE', '%'.$input['term'].'%')->pluck('id');

        $response = UserBusiness::whereIn('id', $businessIds)->whereState($input['state'])->whereCountry($input['country'])->where('user_id', '!=',$input['userId'])->skip($input['index'])->take($input['limit'])->get();

        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not found any Business']);
    }

     /**
     * Function: get search events by using search term
     * Url: api/get/searchEvents
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearchEvents(Request $request)
    {  
        
        $validator = Validator::make($request->all(), UserBusiness::$searchValidator );

        if ($validator->fails())
        {
            if (count($validator->errors()) <= 1){
                return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $input = $request->input();

        $businessIds = BusinessEvent::whereState($input['state'])->whereCountry($input['country'])->where('user_id', '!=',$input['userId'])->pluck('id');

        $response = BusinessEvent::whereIn('business_id',$businessIds)->where('name', 'LIKE', '%'.$input['term'].'%')->orWhere('keywords', 'LIKE', '%'.$input['term'].'%')->skip($input['index'])->take($input['limit'])->get();

        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not found any events']);
    }

    /**
     * Function: get cms pages
     * Url: api/get/cmsPages
     * Request type: Get
     *
     * @param  void
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCmsPages()
    {  
        $response = $this->cmsPages->apiGetCmsPages();
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not found any cms pages']);
    }
    /**
     * Function: blocked/unblocked Notifications
     * Url: api/block/notification
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function blockNotification(Request $request)
    {
        $input = $request->input();
        $user = User::find($input['userId']);
        $user->is_notify = !$user->is_notify;
        $user->save();

        if ($user->is_notify) {
            return response()->json(['status' => 'success','response' => 'User unblocked notification successfully']);
            
        } else {
            return response()->json(['status' => 'success','response' => 'User blocked notification successfully']);
        }
    }
    /**
     * Function: get app notification
     * Url: api/get/app/notification
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAppNotification(Request $request)
    {
        $input = $request->input();
        $businessIds = BusinessFollower::whereUserId($input['userId'])->pluck('business_id');
        if($businessIds)
        {
            $notifications = BusinessNotification::whereIn('business_id',$businessIds)->skip($input['index'])->take($input['limit'])->get();
            return response()->json(['status' => 'success','response' => $notifications]);
        } else {
            return response()->json(['status' => 'success','response' => 'There is no notification.']);
        }
    }
    /**
     * Function:save user conversation/message
     * Url: api/post/user/message
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserMessage(Request $request)
    {
        $input = $request->input();
        $response = $this->userConversation->apiPostUserMessage($input);

        if ($response != NULL && $response->count())
        {
            return response()->json(['status' => 'success','response' => $response]);
        } else {
            return response()->json(['status' => 'exception','response' => 'False']);
        }
    }
    /**
     * Function:get single user conversation/message
     * Url: api/get/user/message
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserMessage(Request $request)
    {
        $input = $request->input();
        $response = $this->userConversation->apiGetUserMessage($input);

        if ($response != NULL && $response->count())
        {
            return response()->json(['status' => 'success','response' => $response]);
        } else {
            return response()->json(['status' => 'exception','response' => 'could not find any message']);
        }
    }
    /**
     * Function:get single user conversation/message
     * Url: api/get/user/all/messages
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserAllMessages(Request $request)
    {
        $input = $request->input();
        $response = $this->userConversation->apiGetUserAllMessages($input);

        if ($response != NULL && $response->count())
        {
            return response()->json(['status' => 'success','response' => $response]);
        } else {
            return response()->json(['status' => 'exception','response' => 'could not find any message']);
        }
    }

    /**
     * Function:to upload business banner
     * Url: api/upload/business/banner
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadBusinessBanner(Request $request)
    {
        $input = $request->input();
        $response = $this->userBusiness->apiUploadBusinessBanner($input);
        return $response;
    }

    /**
     * Function: save user basic details
     * Url: api/post/user/details
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function postUserDetails(Request $request)
    {
        $response = $this->user->apiPostUserDetails($request);
        return $response;
    }

    /**
     * Function: get user basic details
     * Url: api/get/user/details
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getUserDetails(Request $request)
    {
        $response = $this->user->apiGetUserDetails($request);
        if($response)
        {
            return response()->json(['status' => 'success','response' => $response]);
        } else {
            return response()->json(['status' => 'exception','response' => 'could not find user details.']);
        }
    }

     /**
     * Function: get all chat users of login user 
     * Url: api/get/chat/users
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChatUsers(Request $request)
    {
        $input = $request->input();

        $response = $this->userConversation->apiGetChatUsers($input);
        if ($response)
            return response()->json(['status' => 'success', 'response' => $response]);
        else
            return response()->json(['status' => 'exception', 'response' => 'Could not find any chat user.']);
    }

      /**
     * Function: to get previous messages 
     * Url: api/get/previous/messages
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPreviousMessages(Request $request)
    {
        $input = $request->input();

        $response = $this->userConversation->apiGetPreviousMessages($input);
        
        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success', 'response' => $response]);
        else
            return response()->json(['status' => 'exception', 'response' => 'Could not find any messages.']);
    }
}