<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\User;
use Validator;
use Auth;
use DB;

class UserBusiness extends Model
{

    protected $fillable = ['user_id', 'business_id', 'bussiness_category_id', 'title' ,'keywords', 'about_us', 'address', 'city', 'state', 'country', 'pin_code', 'mobile_number', 'secondary_phone_number', 'email', 'website', 'working_hours' , 'is_agree_to_terms', 'identity_proof' , 'business_proof' , 'business_logo', 'banner','latitude', 'longitude'];

    public static $updatable = ['user_id' => "", 'business_id' => "" ,'bussiness_category_id' => "", 'title' => "", 'keywords' => "", 'about_us' => "", 'address' => "", 'city' => "", 'state' => "", 'country' => "", 'pin_code' => "", 'mobile_number' => "", 'secondary_phone_number' => "", 'email' => "", 'website' => "", 'working_hours' => "", 'is_agree_to_terms' => "" ,'identity_proof' => "" ,'business_proof' => "", 'business_logo' => "", 'banner' => "", 'latitude' => "", 'longitude' => ""];

    public static $searchValidator = array(
        'userId' => 'required',
        'state' => 'required',
        'country' => 'required',
        'index' => 'required',
        'limit' => 'required',
        'term' => 'required',
        'categoryId' => 'numeric',
    );

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
        if (isset($input['latitude']) && isset($input['longitude']) && isset($input['radius'])) {
            $business = DB::select("SELECT * , p.distance_unit * DEGREES( ACOS( COS( RADIANS( p.latpoint ) ) * COS( RADIANS(z.latitude ) ) * COS( RADIANS( p.longpoint ) - RADIANS( z.longitude ) ) + SIN( RADIANS( p.latpoint ) ) * SIN( RADIANS( z.latitude ) ) ) ) AS distance_in_km FROM user_businesses AS z JOIN (SELECT ".$input['latitude']." AS latpoint, ".$input['longitude']." AS longpoint, ".$input['radius']." AS radius, 111.045 AS distance_unit) AS p ON 1 =1 WHERE z.latitude BETWEEN p.latpoint - ( p.radius / p.distance_unit ) AND p.latpoint + ( p.radius / p.distance_unit ) AND z.longitude BETWEEN p.longpoint - ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND p.longpoint + ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND z.state = '".$input['state']."' AND z.bussiness_category_id = ".$input['categoryId']." AND z.is_blocked = 0 AND z.user_id != ".$input['userId']." ORDER BY distance_in_km DESC LIMIT ".$input['index'].", ".$input['limit']." ");
        } else {
            $business = $this->whereBussinessCategoryId($input['categoryId'])->whereCountry($input['country'])->whereState($input['state'])->whereIsBlocked(0)->whereNotIn('user_id',[$input['userId']])->skip($input['index'])->limit($input['limit'])->get();
        }

        return $business;
    }

    public function apiPostUserBusiness(Request $request)
    {
        $input = $request->input();
        $check = User::where('id', $input['userId'])->whereNotIn('user_role_id', ['1,2'])->first();

        if ($check) {

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
                    'mobileNumber' => 'required|numeric',
                    'latitude' => 'required',
                    'longitude' => 'required',
            ]);

            if ($validator->fails()) {
                if (count($validator->errors()) <= 1) {
                        return response()->json(['status' => 'exception','response' => $validator->errors()]);   
                } else {
                    return response()->json(['status' => 'exception','response' => 'All fields are required']);   
                }
            }

            if (!$user) {

                if (isset($input['businessLogo']) && !empty($input['businessLogo'])) {

                    $data = $input['businessLogo'];

                    $img = str_replace('data:image/jpeg;base64,', '', $data);
                    $img = str_replace(' ', '+', $img);

                    $data = base64_decode($img);

                    $fileName = md5(uniqid(rand(), true));

                    $image = $fileName.'.'.'png';

                    $file = config('image.logo_image_path').$image;

                    $success = file_put_contents($file, $data);
                        
                    $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/small/'.$image;
                    shell_exec($command);

                    $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/medium/'.$image;
                    shell_exec($command);

                    $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/large/'.$image;
                    shell_exec($command);
                }
                
                $check = User::where('id',$input['userId'])->update(['user_role_id' => 3]);
                $user = User::where('id',$input['userId'])->first();
                $business = array_intersect_key($input, UserBusiness::$updatable);

                $business['user_id'] = $input['userId'];
                $business['business_id']= substr($user->full_name,0,3).rand(0,999);
                $business['bussiness_category_id'] = $input['categoryId'];
                $business['pin_code'] = $input['pinCode'];
                $business['mobile_number'] = $input['mobileNumber'];
                $business['working_hours'] = $input['workingHours'];
                $business['is_agree_to_terms'] = 1;
                $business['about_us'] = isset($input['aboutUs']) ? $input['aboutUs'] : '';
                $business['secondary_phone_number'] = isset($input['secondaryPhoneNumber']) ? $input['secondaryPhoneNumber'] : '';

                if (isset($image)) {
                    $business['business_logo'] = $image;
                }

                $business = UserBusiness::create($business);
                $business->save(); 
                if ($business) {
                    return response()->json(['status' => 'success','response' => $business]);
                } else {
                    return response()->json(['status' => 'failure','response' => 'System Error:User could not be created .Please try later.']);
                }

            } else {

                if (isset($input['businessLogo']) && !empty($input['businessLogo'])) {

                    $data = $input['businessLogo'];

                    $img = str_replace('data:image/jpeg;base64,', '', $data);
                    $img = str_replace(' ', '+', $img);

                    $data = base64_decode($img);

                    $fileName = md5(uniqid(rand(), true));

                    $image = $fileName.'.'.'png';

                    $file = config('image.logo_image_path').$image;

                    $success = file_put_contents($file, $data);
                        
                    $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/small/'.$image;
                    shell_exec($command);

                    $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/medium/'.$image;
                    shell_exec($command);

                    $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/large/'.$image;
                    shell_exec($command);
                }

                $input['user_id'] = $input['userId'];
                $input['bussiness_category_id'] = $input['categoryId'];
                $input['pin_code'] = $input['pinCode'];
                $input['mobile_number'] = $input['mobileNumber'];
                $input['working_hours'] = $input['workingHours'];
                $input['about_us'] = $input['aboutUs'];
                $input['secondary_phone_number'] = $input['secondaryPhoneNumber'];

                if (isset($image)) {
                    $input['business_logo'] = $image;
                }
        
                $business = array_intersect_key($input, UserBusiness::$updatable);

                $userbusiness = $this->where('user_id',$input['user_id'])->update($business);
              
                if ($userbusiness)
                    return response()->json(['status' => 'success','response' => "Business updated successfully."]);
                else
                    return response()->json(['status' => 'failure','response' => "Business can not updated successfully.Please try again"]);
            }
        } else {
            return response()->json(['status' => 'exception','response' => "User Does not exist."]);
        }
    }

    public function apiUploadBusinessBanner($input)
    {
        if (isset($input['banner']) && !empty($input['banner'])) {

            $data = $input['banner'];

            $img = str_replace('data:image/jpeg;base64,', '', $data);
            $img = str_replace(' ', '+', $img);

            $data = base64_decode($img);

            $fileName = md5(uniqid(rand(), true));

            $image = $fileName.'.'.'png';

            $file = config('image.banner_image_path').'business/'.$image;

            $success = file_put_contents($file, $data);
                
            $command = 'ffmpeg -i '.config('image.banner_image_path').'business/'.$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.banner_image_path').'business/thumbnails/small/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.banner_image_path').'business/'.$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.banner_image_path').'business/thumbnails/medium/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.banner_image_path').'business/'.$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.banner_image_path').'business/thumbnails/large/'.$image;
            shell_exec($command);
        }
          
        if ($this->where('id',$input['businessId'])->update(['banner' => $image]))
            return response()->json(['status' => 'success','response' => "Business Banner uploaded successfully."]);
        else
            return response()->json(['status' => 'success','response' => "Business banner can not uploaded successfully."]);
    }

    public function apiPostUploadDocuments($input)
    {
        $input = $request->input();
        $data = $input['business_proof'];
        $data1 = $input['identity_proof'];

        $data = base64_decode($data); 
        $data1 = base64_decode($data1); 
        $im = imagecreatefromstring($data); 
        $im1 = imagecreatefromstring($data1); 

        if ($im !== false && $im1 !== false) {
            $file = md5(uniqid(rand(), true));
            $image = $file.'.'.'png';
            imagepng($im, config('image.document_path').$image);
            $input['business_proof'] =  $image; 
            $file1 = md5(uniqid(rand(), true));
            $image1 = $file1.'.'.'png';
            imagepng($im1, config('image.document_path').$image1);
            $input['identity_proof'] =  $image1; 
            imagedestroy($im); 
            imagedestroy($im1); 

        } else { 
            return response()->json(['status' => 'failure','response' => "An error occurred.Could not save image"]);
        }
            
        $business = array_intersect_key($input, UserBusiness::$updatable);

        $userbusiness = $this->where('id',$input['business_id'])->update($business);
      
        if ($userbusiness)
            return response()->json(['status' => 'success','response' => "Business Banner uploaded successfully."]);
        else
            return response()->json(['status' => 'success','response' => "Business banner can not uploaded successfully."]);
    }

    public function apiGetUserBusinessDetails($input)
    {
        $businessData = array();
        $business = $this->where('id', $input['businessId'])->where('is_blocked', 0)->first();
        $businessData['businessDetails'] = $business;
        $businessData['favourites'] = $business->getFavourites();
        $businessData['likes'] = $business->getLikes();
        $businessData['dislikes'] = $business->getDislikes();
        $businessData['rating'] = $business->getRatings();
        $businessData['reviews'] = $business->getReviews();
        $businessData['followers'] = $business->getFollowers();
       
        return $businessData;
    }

    public function apiGetBusinessStates($input)
    {
        $states = $this->where('country', $input['countryName'])->distinct()->pluck('state');
        return $states;
    }
}
