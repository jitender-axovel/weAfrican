<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;
use Auth;

class UserBusiness extends Model
{

    protected $fillable = ['user_id', 'business_id', 'bussiness_category_id', 'title' ,'keywords', 'about_us', 'address', 'city', 'state', 'country', 'pin_code', 'mobile_number', 'secondary_phone_number', 'email', 'website', 'working_hours' , 'is_agree_to_terms', 'identity_proof' , 'business_proof' , 'business_logo', 'banner','latitude', 'longitude'];

    public static $updatable = ['user_id' => "", 'business_id' => "" ,'bussiness_category_id' => "", 'title' => "", 'keywords' => "", 'about_us' => "", 'address' => "", 'city' => "", 'state' => "", 'country' => "", 'pin_code' => "", 'mobile_number' => "", 'secondary_phone_number' => "", 'email' => "", 'website' => "", 'working_hours' => "", 'is_agree_to_terms' => "" ,'identity_proof' => "" ,'business_proof' => "", 'business_logo' => "", 'banner' => "", 'latitude' => "", 'longitude' => ""];

    public function category()
    {
        return $this->belongsTo('App\BussinessCategory','bussiness_category_id');
    }

    public function likes()
    {
        return $this->hasMany('App\BusinessLike','business_id');
    }

    public function getLikes()
    {
        return $this->likes()->where('is_like', 1)->count();
    }

    public function getDislikes()
    {
        return $this->likes()->where('is_dislike', 1)->count();
    }

    public function followers()
    {
        return $this->hasMany('App\BusinessFollower','business_id');
    }

    public function getFollowers()
    {
        return $this->followers()->count();
    }

    public function ratings()
    {
        return $this->hasMany('App\BusinessRating','business_id');
    }

    public function getRatings()
    {
        return $this->ratings()->avg('rating');
    }

    public function favourites()
    {
        return $this->hasMany('App\BusinessFavourite','business_id');
    }

    public function getFavourites()
    {
        return $this->favourites()->count();
    }

    public function reviews()
    {
        return $this->hasMany('App\BusinessReview','business_id');
    }

    public function getReviews()
    {
        return $this->reviews()->count();
    }

    public function apiGetBusinessesByCategory($input)
    {
        return $this->where('bussiness_category_id', $input['categoryId'])->where('is_blocked', 0)->get();
    }

    public function apiPostUserBusiness(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
             return json_encode(['status' =>'exception','response'=> 'Input parameters are missing']);  
        }

        $user = $this->where('user_id',$input['userId'])->first();

        $validator = Validator::make($input, [
                'userId' => 'required',
                'categoryId' => 'required',
                'title' => 'required',
                'keywords' =>'required',
                'email' => 'required|email|max:255',
                'pinCode' => 'numeric',
                'country' => 'string',
                'state' => 'string',
                'city' => 'string',
                'aboutUs' => 'string',
                'address' => 'string',
                'secondaryPhoneNumber' => 'numeric',
                'website' => 'string',
                'workingHours' => 'string',
                'mobileNumber' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'exception','response' => $validator->errors()->all()]);   
        }

        if(!$user){
            
            User::where('id',$input['userId'])->update(['user_role_id' => 3]);
            $user = User::where('id',$input['userId'])->first();
            $business = array_intersect_key($input, UserBusiness::$updatable);

            $business['user_id'] = $input['userId'];
            $business['business_id']=substr($user->full_name,0,3).rand(0,999);
            $business['bussiness_category_id'] = $input['categoryId'];
            $business['pin_code'] = $input['pinCode'];
            $business['mobile_number'] = $input['mobileNumber'];
            $business['about_us'] = $input['aboutUs'];
            $business['secondary_phone_number'] = $input['secondaryPhoneNumber'];
            $business['working_hours'] = $input['workingHours'];
            $business['is_agree_to_terms'] = 1;
            if(isset($input['businessLogo']))
                $business['business_logo'] = $input['businessLogo'];
    
            if(isset($input['banner']))
                $business['banner'] = $input['banner'];
            
            $business = UserBusiness::create($business);
            $business->save(); 
            if($business){
                return response()->json(['status' => 'success','response' => $business]);
            } else {
                return response()->json(['status' => 'failure','response' => 'System Error:User could not be created .Please try later.']);
            }
        } else {

            $input['user_id'] = $input['userId'];
            $input['bussiness_category_id'] = $input['categoryId'];
            $input['pin_code'] = $input['pinCode'];
            $input['mobile_number'] = $input['mobileNumber'];
            $input['about_us'] = $input['aboutUs'];
            $input['secondary_phone_number'] = $input['secondaryPhoneNumber'];
            $input['working_hours'] = $input['workingHours'];

            if(isset($input['businessLogo'])) {
                $input['business_logo'] =  $input['businessLogo'];
            } 
            if(isset($input['businessBanner'])) {
                $input['banner'] =  $input['businessBanner'];
            }

            $business = array_intersect_key($input, UserBusiness::$updatable);
           
            UserBusiness::where('user_id',$input['user_id'])->update($business);

            return response()->json(['status' => 'success','response' => "Business updated successfully."]);
        }
    }

    public function apiPostUploadDocuments(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'success','response' => 'Input parmeters are missing.']);
        }

        $check = $this->where('id',$input['businessId'])->first();
        if($check){
            $input['business_proof'] = $input['businessProof'];
            $input['identity_proof'] = $input['identityProof'];

            $this->where('id',$input['businessId'])->update(['identity_proof' => $input['identityProof'], 'business_proof' => $input['businessProof']]);

            return response()->json(['status' => 'success','response' => "Documents uploaded successfully."]);
        }else {
            return response()->json(['status' => 'exception','response' => "Documents does not uploaded  successfully."]);
        }
    }

    public function apiGetUserBusinessDetails($businessId)
    {
        $business = $this->where('id', $businessId)->where('is_blocked', 0)->first();
        return $business;
    }
}