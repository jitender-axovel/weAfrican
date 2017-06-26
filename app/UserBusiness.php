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
use Image;

class UserBusiness extends Model
{
    protected $fillable = ['user_id', 'business_id', 'bussiness_category_id', 'bussiness_subcategory_id', 'title' ,'keywords', 'about_us', 'website', 'working_hours' , 'is_agree_to_terms', 'identity_proof' , 'business_proof' , 'business_logo', 'banner', 'is_update'];

    public static $updatable = ['user_id' => "", 'business_id' => "" ,'bussiness_category_id' => "", 'bussiness_subcategory_id' => "", 'title' => "", 'keywords' => "", 'about_us' => "", 'website' => "", 'working_hours' => "", 'is_agree_to_terms' => "" ,'identity_proof' => "" ,'business_proof' => "", 'business_logo' => "", 'banner' => "", 'is_update' => ""];

    public static $searchValidator = array(
        'userId' => 'required',
        'state' => 'required',
        'country' => 'required',
        'index' => 'required',
        'limit' => 'required',
        'term' => 'required',
        'categoryId' => 'numeric',
    );

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo('App\BussinessCategory','bussiness_category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\BussinessSubcategory','bussiness_subcategory_id');
    }

    public function events()
    {
        return $this->hasMany('App\BusinessEvent','business_id');
    }

    public function products()
    {
        return $this->hasMany('App\BusinessProduct','business_id');
    }

    public function services()
    {
        return $this->hasMany('App\BusinessService','business_id');
    }
    
    public function likes()
    {
        return $this->hasMany('App\BusinessLike','business_id');
    }

    public function getLikes()
    {
        return $this->likes()->where('is_like', 1)->count();
    }

    public function getLikesList()
    {
        return $this->likes()->where('is_like', 1)->get();
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

    public function portfolio()
    {
        return $this->hasOne('App\UserPortfolio','business_id');
    }

    public function apiGetBusinessesByCategory($input)
    {
        if (isset($input['latitude']) && isset($input['longitude']) && isset($input['radius'])) {
            $business = DB::select("SELECT * , p.distance_unit * DEGREES( ACOS( COS( RADIANS( p.latpoint ) ) * COS( RADIANS(z.latitude ) ) * COS( RADIANS( p.longpoint ) - RADIANS( z.longitude ) ) + SIN( RADIANS( p.latpoint ) ) * SIN( RADIANS( z.latitude ) ) ) ) AS distance_in_km FROM user_businesses AS z JOIN (SELECT ".$input['latitude']." AS latpoint, ".$input['longitude']." AS longpoint, ".$input['radius']." AS radius, 111.045 AS distance_unit) AS p ON 1 =1 WHERE z.latitude BETWEEN p.latpoint - ( p.radius / p.distance_unit ) AND p.latpoint + ( p.radius / p.distance_unit ) AND z.longitude BETWEEN p.longpoint - ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND p.longpoint + ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND z.state = '".$input['state']."' AND z.bussiness_category_id = ".$input['categoryId']." AND z.is_blocked = 0 AND z.user_id != ".$input['userId']." ORDER BY distance_in_km ASC LIMIT ".$input['index'].", ".$input['limit']." ");
        } else {
            $business = $this->whereBussinessCategoryId($input['categoryId'])->whereCountry($input['country'])->whereState($input['state'])->whereIsBlocked(0)->whereNotIn('user_id',[$input['userId']])->skip($input['index'])->limit($input['limit'])->orderBy('created_at','asc')->get();
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
                    'subcategoryId' => 'sometimes|required',
                    'title' => 'required',
                    'keywords' =>'required',
                    'email' => 'required|email|max:255',
                    'pinCode' => 'required|max:10',
                    'country' => 'required|string',
                    'state' => 'required|string',
                    'city' => 'required|string',
                    'currency' => 'required|string',
                    'aboutUs' => 'string',
                    'address' => 'string',
                    'website' => 'string',
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

                    $img = Image::make($file);
                    
                    $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.logo_image_path').'/thumbnails/large/'.$image); 

                    $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.logo_image_path').'/thumbnails/medium/'.$image);
                            
                    $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.logo_image_path').'/thumbnails/small/'.$image);
                }
                
                $input['adderss'] = $input['address'];
                $input['pin_code'] = $input['pinCode'];
                $input['mobile_number'] = $input['mobileNumber'];
                $input['currency'] = $input['currency'];

                $user = array_intersect_key($input, User::$updatable);
                $user['user_role_id'] = 3;
                $check = User::where('id',$input['userId'])->update($user);
                $user = User::where('id',$input['userId'])->first();
                $business = array_intersect_key($input, UserBusiness::$updatable);

                $business['user_id'] = $input['userId'];
                $business['business_id']= substr($user->first_name,0,3).rand(0,999);
                $business['bussiness_category_id'] = $input['categoryId'];

                if(isset($input['subcategoryId']))
                {
                    $business['bussiness_subcategory_id'] = $input['subcategoryId'];
                }

                $business['pin_code'] = $input['pinCode'];
                $business['mobile_number'] = $input['mobileNumber'];
                $business['working_hours'] = $input['workingHours'];
                $business['is_agree_to_terms'] = 1;
                $business['about_us'] = isset($input['aboutUs']) ? $input['aboutUs'] : '';

                

                if (isset($image)) {
                    $business['business_logo'] = $image;
                }
                try{
                    $business = UserBusiness::create($business);
                    $business->save(); 

                }catch (\Illuminate\Database\QueryException $e) {
                    return response()->json(['status' => 'exception','response' => 'Query Exception occured. Plese Try again ']);
                }catch (PDOException $e) {
                    return response()->json(['status' => 'exception','response' => 'PDOException occur. Plese Try again ']);
                }catch(Exception $e)
                {
                    return response()->json(['status' => 'exception','response' => 'Exception occured. Plese Try again ']);
                }

                if ($business and $check) {
                    return response()->json(['status' => 'success','response' => $business]);
                }elseif(!$check){
                    return response()->json(['status' => 'failure','response' => "User can not updated successfully.Please try again"]);
                }else {
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

                    $img = Image::make($file);
                    
                    $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.logo_image_path').'/thumbnails/large/'.$image); 

                    $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.logo_image_path').'/thumbnails/medium/'.$image);
                            
                    $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.logo_image_path').'/thumbnails/small/'.$image);
                }

                $input['user_id'] = $input['userId'];
                $input['bussiness_category_id'] = $input['categoryId'];

                if(isset($input['subcategoryId']))
                {
                    $input['bussiness_subcategory_id'] = $input['subcategoryId'];
                }

                $input['pin_code'] = $input['pinCode'];
                $input['mobile_number'] = $input['mobileNumber'];
                $input['working_hours'] = $input['workingHours'];
                $input['about_us'] = $input['aboutUs'];
                $input['currency'] = $input['currency'];

                if (isset($image)) {
                    $input['business_logo'] = $image;
                }
                
                try{
                    $business = array_intersect_key($input, UserBusiness::$updatable);

                    $userbusiness = $this->where('user_id',$input['user_id'])->update($business);

                    $userDetail = array_intersect_key($input, User::$updatable);

                    $userDetail = User::whereId($input['user_id'])->update($userDetail);

                }catch (\Illuminate\Database\QueryException $e) {
                    return response()->json(['status' => 'exception','response' => 'Query Exception occured. Plese Try again ']);
                }catch (PDOException $e) {
                    return response()->json(['status' => 'exception','response' => 'PDOException occur. Plese Try again ']);
                }catch(Exception $e)
                {
                    return response()->json(['status' => 'exception','response' => 'Exception occured. Plese Try again ']);
                } 

                if ($userbusiness and $userDetail)
                    return response()->json(['status' => 'success','response' => "Business updated successfully."]);
                elseif(!$userDetail)
                    return response()->json(['status' => 'failure','response' => "User can not updated successfully.Please try again"]);
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
                
            $img = Image::make($file);
                    
            $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                 $constraint->aspectRatio();
            })->save(config('image.banner_image_path').'/thumbnails/large/'.$image); 

            $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                 $constraint->aspectRatio();
            })->save(config('image.banner_image_path').'/thumbnails/medium/'.$image);
                    
            $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                 $constraint->aspectRatio();
            })->save(config('image.banner_image_path').'/thumbnails/small/'.$image);
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
