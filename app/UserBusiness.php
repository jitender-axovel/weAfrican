<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Validator;
use Auth;
use DB;

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
        //dd($input);
        $distance_unit = 111.045;
        $radius = 50.0;
        $latpoint = $input['latitude'];
        $lngpoint = $input['longitude'];
        $st = $input['state'];
        $catId = $input['categoryId'];
            $business = UserBusiness::select(DB::raw("*, 
                ($distance_unit
                 * DEGREES(ACOS(COS(RADIANS($latpoint))
                 * COS(RADIANS('latitude'))
                 * COS(RADIANS($lngpoint) - RADIANS('longitude'))
                 + SIN(RADIANS($latpoint))
                 * SIN(RADIANS('latitude')))) 
            
       ) AS distance")
    )
    ->whereBetween('latitude',array('$latpoint  - ($radius /$distance_unit)','latpoint  + (radius /distance_unit)'))
    ->whereBetween('longitude',array('$lngpoint - ($radius / ($distance_unit * COS(RADIANS($latpoint))))','$lngpoint + ($radius / ($distance_unit * COS(RADIANS($latpoint)))))'))
    ->where('bussiness_category_id', '=', $catId)
    ->where('state', '=',  $st)
    ->orderBy("distance")
    ->skip($input['index'])
    ->take($input['limit'])
    ->setBindings([$latpoint, $lngpoint, $distance_unit,  $radius, $catId, $st])
    ->get();
    return $business;
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
                'pinCode' => 'required|max:10',
                'country' => 'string',
                'state' => 'string',
                'city' => 'string',
                'aboutUs' => 'string',
                'address' => 'string',
                'website' => 'string',
                'secondaryPhoneNumber' => 'numeric',
                'workingHours' => 'required|string',
                'mobileNumber' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
        ]);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        if(!$user){
            
            $check =User::where('id',$input['userId'])->update(['user_role_id' => 3]);
            $user = User::where('id',$input['userId'])->first();
            $business = array_intersect_key($input, UserBusiness::$updatable);

            $business['user_id'] = $input['userId'];
            $business['business_id']= substr($user->full_name,0,3).rand(0,999);
            $business['bussiness_category_id'] = $input['categoryId'];
            $business['pin_code'] = $input['pinCode'];
            $business['mobile_number'] = $input['mobileNumber'];
            $business['working_hours'] = $input['workingHours'];
            $business['is_agree_to_terms'] = 1;
            $business['about_us'] = $input['aboutUs'];
            $business['secondary_phone_number'] = $input['secondaryPhoneNumber'];

            dd(Storage::move(config('image.api_image_path').'eb5158b9b3bc3b16b9c74fa7c3d8ab42.jpeg', config('image.banner_image_path').'home/eb5158b9b3bc3b16b9c74fa7c3d8ab42.jpeg'));

            $command = 'ffmpeg -i '.config('image.api_image_path').'eb5158b9b3bc3b16b9c74fa7c3d8ab42.jpeg'.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.banner_image_path').'home/thumbnails/small/'.'eb5158b9b3bc3b16b9c74fa7c3d8ab42.jpeg';
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.api_image_path').'eb5158b9b3bc3b16b9c74fa7c3d8ab42.jpeg'.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.banner_image_path').'home/thumbnails/medium/'.'eb5158b9b3bc3b16b9c74fa7c3d8ab42.jpeg';
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.api_image_path').'eb5158b9b3bc3b16b9c74fa7c3d8ab42.jpeg'.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.banner_image_path').'home/thumbnails/large/'.'eb5158b9b3bc3b16b9c74fa7c3d8ab42.jpeg';
            shell_exec($command);

            if(isset($input['businessLogo'])) 
                $business['business_logo'] =  $input['businessLogo'];

            if(isset($input['businessBanner'])) 
                $business['banner'] =  $input['businessBanner'];
           
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
            $input['working_hours'] = $input['workingHours'];
            $input['about_us'] = $input['aboutUs'];
            $input['secondary_phone_number'] = $input['secondaryPhoneNumber'];

            $old = str_replace("\\","/",public_path()).'/uploads/images/logo/'.$input['businessLogo'];
            $new = str_replace("\\","/",public_path()).'/uploads/images/documents/'.$input['businessLogo'];
           $move = File::move($old, $new);
           dd($move);
            dd(Storage::move($old ,$new));
    
            if(isset($input['businessLogo'])) 
                $input['business_logo'] =  $input['businessLogo'];
           
            if(isset($input['businessBanner'])) 
                $input['banner'] =  $input['businessBanner'];
          

            $business = array_intersect_key($input, UserBusiness::$updatable);

            $userbusiness = $this->where('user_id',$input['user_id'])->update($business);
          
            if($userbusiness)

                return response()->json(['status' => 'success','response' => "Business updated successfully."]);
            else
                return response()->json(['status' => 'success','response' => "Business can not updated successfully."]);
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

    public function apiGetBusinessCities($countryName)
    {
        $cities = $this->where('country', $countryName)->where('is_blocked', 0)->pluck('city');
        return $cities;
    }
}