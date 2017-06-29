<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\BusinessLike;
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
use App\EventParticipant;
use App\CmsPage;
use App\EventCategory;
use App\CountryList;
use App\UserPortfolio;
use App\UserPortfolioImage;
use App\SecurityQuestion;
use App\EventSeatingPlan;
use Validator;
use Image;
use File;
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
        $this->country = new CountryList();
        $this->portfolio = new UserPortfolio();
        $this->portfolioImage = new UserPortfolioImage();
        $this->securityQuestion = new SecurityQuestion();
        $this->eventSeatingPlan = new EventSeatingPlan();
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
     * Function: Register User.
     * Url: api/signup
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request)
    {
        $response = $this->user->apiSignup($request);
        return $response;
    }

    /**
     * Function: Get Business category.
     * Url: api/get/business-categories
     * Request type: Get
     *
     * @param  
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories()
    {    
        $categoryData = array();
        $response = $this->category->apiGetCategory();

        if ($response != NULL)
            return response()->json(['status' => 'success','response' => $response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any category ']);
    }

    /**
     * Function: Get Business sub category by id.
     * Url: api/get/business-subCategories
     * Request type: Get
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubCategories($id)
    {    
        $response = $this->category->apiGetSubCategory($id);

        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' => $response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any sub-category ']);
    }

    /**
     * Function: Get currency according to country Name.
     * Url: api/get/currency/{countryName}
     * Request type: Get
     *
     * @param  string $countryName
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrency($countryName)
    {    
        $response = $this->country->apiGetCurrency($countryName);

        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' => $response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any currency ']);
    }

    /**
     * Function: Get user portfolio details according to businessID.
     * Url: api/get/user/portfolio
     * Request type: Get
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserPortfolio(Request $request)
    {    
        $input = $request->input();
        $response = $this->portfolio->apiGetUserPortfolio($input);

        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' => $response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find user portfolio details']);
    }

    /**
     * Function: Get Event category.
     * Url: api/get/bussiness-categories
     * Request type: Get
     *
     * @param  Void
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventCategories()
    {
        $response = $this->eventCategory->apiGetEventCategory();
        if ($response != NULL && $response->count())
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
        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Subscription Plan ']);
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
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->businessEvent->apiGetUserBusinessEvents($input);
        if ($response != NULL && $response->count())
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

       if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = $this->userBusiness->apiGetBusinessesByCategory($input);
        if (count($response))
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
     * Function: create and update User Business Portfolio Details.
     * Url: api/post/user/portfolio
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserBusinessPortfolio(Request $request)
    {   
        $response = $this->portfolio->postUserBusinessPortfolio($request);
        return $response;
    }

    /**
     * Function: create and update User Business Details.
     * Url: api/get/user/portfolioDetails
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserPortfolioImages(Request $request)
    {   
        
        $input = $request->input();
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->portfolioImage->apiGetUserPortfolioImages($input);
        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Portfolio Images.']);
        return $response;
    }

    /**
     * Function: To remoce User portfolio Images and description
     * Url: api/remove/user/portfolioDetails
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeUserPortfolioDetail(Request $request)
    {   
        
        $input = $request->input();
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->portfolioImage->apiRemoveUserPortfolioImages($input);
        return $response;
    }

    /**
     * Function: create and update User Portfolio Details.
     * Url: api/post/user/portfolioDetails
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserPortfolioDetail(Request $request)
    {   
        $response = $this->portfolioImage->apiPostUserPortfolioDetail($request);
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
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $event = BusinessEvent::where('user_id',$input['userId'])->where('id',$input['eventId'])->first();

        if ($event && $event->delete())
            return response()->json(['status' => 'success', 'response' => 'Event deleted successfully.']);
        else
            return response()->json(['status' => 'exception', 'response' => 'Event could not be deleted.Please try again.']);

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
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->businessEvent->apiPostEventAttendingUsers($input);
        return $response;
    }

    /**
     * Function: Post business like 
     * Url: api/post/business/likes
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessLikes(Request $request, $status)
    {   
        $input = $request->input();

        $check = BusinessLike::where('user_id',$input['userId'])->where('business_id',$input['businessId'])->first();

        $response = ['is_like' => null, 'is_dislike' => null, 'result' => 0, 'Total_likes' => null, 'Total_dislikes' => null];

        if ($check) {
            if ($status == 'like') {

                $response['is_like'] = ($check->is_like) ? null: 1;
                ($check->is_dislike) ? ($response['result'] = 1) : '';

            } else {

                $response['is_dislike'] = ($check->is_dislike) ? null: 1;
                ($check->is_like) ? ($response['result'] = 1) : '';
                
            }

            if ($response['is_like'] == null && $response['is_dislike'] == null) {

                $check->delete();
                $response['Total_likes'] = BusinessLike::where('business_id', $input['businessId'])->count('is_like');
                $response['Total_dislikes'] = BusinessLike::where('business_id',$input['businessId'])->count('is_dislike');
                $response['result'] = 0;
                $response = array_except($response,['is_like', 'is_dislike']);

                return response()->json(['status' => 'success','response' => $response]);

            } elseif ($check->update(['is_like' => $response['is_like'], 'is_dislike' => $response['is_dislike']])) {

                $response['Total_likes'] = BusinessLike::where('business_id', $input['businessId'])->count('is_like');
                $response['Total_dislikes'] = BusinessLike::where('business_id',$input['businessId'])->count('is_dislike');
                $response = array_except($response,['is_like', 'is_dislike']);
                return response()->json(['status' => 'success','response' => $response]);
            }

        } else {

            ($status == 'like') ? ($response['is_like'] = 1) : ($response['is_dislike'] =1);
            $response['result'] = 1;

            if (BusinessLike::insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'] , 'is_like' => $response['is_like'], 'is_dislike' => $response['is_dislike']])) {
                $response['Total_likes'] = BusinessLike::where('business_id', $input['businessId'])->count('is_like');
                $response['Total_dislikes'] = BusinessLike::where('business_id',$input['businessId'])->count('is_dislike');
                $response = array_except($response,['is_like', 'is_dislike']);
                return response()->json(['status' => 'success','response' => $response]);
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
        $reviewCount = BusinessReview::whereBusinessId($input['businessId'])->count();

        if($response)
            return response()->json(['status' => 'success','response' => $reviewCount]);
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
            $response['count'] = BusinessFollower::whereBusinessId($input['businessId'])->count();
            $response['follower'] = 0;
            return response()->json(['status' => 'success','response' => $response]);

        } else {

            DB::table('business_followers')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId']]);
            $response['count'] = BusinessFollower::whereBusinessId($input['businessId'])->count();
            $response['follower'] = 1;
            return response()->json(['status' => 'success','response' => $response]);
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
            return response()->json(['status' => 'failure','response' => ['message' => 'All fields are required.']]);
        }

        $response = $this->user->apiCheckOtp($input);
        return $response;
    }

    /**
     * Function: Resend Otp.
     * Url: api/resend/otp
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendOtp(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'failure','response' => ['message' => 'All fields are required.']]);
        }

        $response = $this->user->apiResendOtp($input);
        
        if($response == 1)
        {
            return response()->json(['status' => 'success', 'response' => ['message' => 'New OTP has been send to the registerd email address']]);
        }else if($response == 2) {
            return response()->json(['status' => 'failure', 'response' => ['message' => 'Unable to generate new OTP. Please try again!']]);
        }else if($response == 3){
            return response()->json(['status' => 'failure', 'response' => ['message' => 'Mail Cannot be sent! Please try again!!']]);
        }else{
            return response()->json(['status' => 'failure', 'response' => ['message' => 'Email does not exist.']]);
        }
    }

    /**
     * Function: search events by lat,long/country,state.
     * Url: api/get/business-events
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

        if ($validator->fails()){
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
        $validator = Validator::make($request->all(), UserBusiness::$searchValidator);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $input = $request->input(); 

        if (isset($input['categoryId'])) {
           $ids = UserBusiness::whereBussinessCategoryId($input['categoryId'])->pluck('id');
           
            if ($ids->count()) {

                $businessIds = UserBusiness::whereIn('id', $ids)->whereState($input['state'])->whereCountry($input['country'])->where('user_id', '!=', $input['userId'])->pluck('id');
                
                $search1 = UserBusiness::WhereIn('id', $businessIds)->where('title', 'LIKE', '%'.$input['term'].'%')->pluck('id');
                $search2 = UserBusiness::whereIn('id', $businessIds)->Where('keywords', 'LIKE', '%'.$input['term'].'%')->pluck('id');
                $searchIds = $search1->merge($search2);

                $response = UserBusiness::whereIn('id', $searchIds)->skip($input['index'])->take($input['limit'])->orderBy('created_at', 'asc')->get();

            } else {
                $response = null;
            }
            
        } else {

            $businessIds = UserBusiness::where('title', 'LIKE', '%'.$input['term'].'%')->orWhere('keywords', 'LIKE', '%'.$input['term'].'%')->pluck('id');

            $response = UserBusiness::whereIn('id', $businessIds)->whereState($input['state'])->whereCountry($input['country'])->where('user_id', '!=',$input['userId'])->skip($input['index'])->take($input['limit'])->orderBy('created_at', 'asc')->get();
        }

        if ($response != null && $response->count())
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

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $input = $request->input();

        if (isset($input['categoryId'])) {
            $ids = BusinessEvent::whereEventCategoryId($input['categoryId'])->pluck('id');

            if ($ids->count()) {
                $eventIds = BusinessEvent::whereIn('id', $ids)->whereState($input['state'])->whereCountry($input['country'])->where('user_id', '!=',$input['userId'])->pluck('id');
                $search1 = BusinessEvent::whereIn('id',$eventIds)->where('name', 'LIKE', '%'.$input['term'].'%')->pluck('id');
                $search2 =BusinessEvent::whereIn('id', $eventIds)->where('keywords', 'LIKE', '%'.$input['term'].'%')->pluck('id');
                $searchIds = $search1->merge($search2);

                $response = BusinessEvent::select('business_events.*','users.mobile_number')->join('users', 'users.id', '=','business_events.user_id')->whereIn('business_events.id', $searchIds)->skip($input['index'])->take($input['limit'])->orderBy('created_at', 'asc')->get();    
                
            } else {
                $response = null;
            }

        } else {

            $eventIds = BusinessEvent::whereState($input['state'])->whereCountry($input['country'])->where('user_id', '!=',$input['userId'])->pluck('id');

            $response = BusinessEvent::select('business_events.*', 'users.mobile_number')->join('users', 'users.id', '=', 'business_events.id')->whereIn('business_events.id',$eventIds)->where('business_events.name', 'LIKE', '%'.$input['term'].'%')->orWhere('business_events.keywords', 'LIKE', '%'.$input['term'].'%')->skip($input['index'])->take($input['limit'])->orderBy('created_at', 'asc')->get();
        }

        if ($response != null && $response->count())
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
    public function getCmsPages($slug)
    {  
        $response = $this->cmsPages->apiGetCmsPages($slug);
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

    /**
     * Function: To get user like/dislike and following status on particular business
     * Url: api/get/user/business/status
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserBusinessStatus(Request $request)
    {
        $input = $request->input();
        $response['like'] = BusinessLike::whereUserId($input['userId'])->whereBusinessId($input['businessId'])->where('is_like', 1)->count();
        $response['dislike'] = BusinessLike::whereUserId($input['userId'])->whereBusinessId($input['businessId'])->where('is_dislike', 1)->count();
        $response['follower'] = BusinessFollower::whereUserId($input['userId'])->whereBusinessId($input['businessId'])->count();
        
        if ($response != NULL && count($response))
            return response()->json(['status' => 'success', 'response' => $response]);
        else
            return response()->json(['status' => 'exception', 'response' => 'Could not find any data for status.']);
    }

    /**
     * Function: To get attending event status of user on particular event 
     * Url: api/get/user/attending/event/status
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserEventAttendingStatus(Request $request)
    {
        $input = $request->input();
        $response = EventParticipant::whereUserId($input['userId'])->whereEventId($input['eventId'])->count();
        if ($response != NULL && count($response))
            return response()->json(['status' => 'success', 'response' => $response]);
        else
            return response()->json(['status' => 'exception', 'response' => 0]);
    }

    /**
     * Function: To save product image in a temp folder 
     * Url: api/post/business/productImage
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessProductImage(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'image' => 'required|string',
            'id' => 'sometimes|required|integer'
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }
        $data = $input['image'];

        $img = str_replace('data:image/jpeg;base64,', '', $data);
        $img = str_replace(' ', '+', $img);

        $data = base64_decode($img);

        $fileName = md5(uniqid(rand(), true));

        $image = $fileName.'.'.'png';

        $file = config('image.temp_image_path').$image;

        $success = file_put_contents($file, $data);

        if($success)
        {
            return response()->json(['status' => 'success','response' => asset(config('image.temp_image_url')).'/'.$image]);
        }else
        {
            return response()->json(['status' => 'failure','response' => 'System Error:Image cannot be saved .Please try later.']);
        }
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
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $product = BusinessProduct::where('user_id',$input['userId'])->where('id',$input['productId'])->first();

        if ($product && $product->delete()) {
            return response()->json(['status' => 'success', 'response' => 'Product deleted successfully.']);
        } else {
            return response()->json(['status' => 'exception', 'response' => 'Product could not be deleted.Please try again.']);
        }
    }

    /**
     * Function: delete product Image.
     * Url: api/remove/product/image
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeBusinessProductImage(Request $request)
    {   
        $input = $request->input();
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }
        if(isset($input['addedImage']) and !empty($input['addedImage']))
        {
            foreach (explode('|', $input['addedImage']) as $value) {
                Helper::removeImages(config('image.temp_image_path'),$value);
            }
        }elseif(isset($input['deleteImage']) and !empty($input['deleteImage']))
        {
            foreach (explode('|', $input['addedImage']) as $value) {
                Helper::removeImages(config('image.temp_image_path'),$value);
            }
        }
        return response()->json(['status' => 'success', 'response' => 'Product Images deleted successfully.']);
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
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->businessProduct->apiGetUserBusinessProducts($input);
        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Product.']);
    }

    /**
     * Function: Get Security Question list.
     * Url: api/get/business/securityQuestion
     * Request type: GET
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSecurityQuestion(Request $request)
    {
        $response = $this->securityQuestion->apiGetSecurityQuestions();
        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Security Questions.']);
    }

    /**
     * Function: Get Seating Plans List.
     * Url: api/get/business/eventSeatingPlans
     * Request type: GET
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventSeatingPlans(Request $request)
    {
        $response = $this->eventSeatingPlan->apiGetEventSeatingPlans();
        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Event Seating Plans.']);
    }
}
