<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class UserBusiness extends Model
{

    protected $fillable = ['user_id', 'bussiness_category_id', 'title' ,'keywords', 'about_us', 'address', 'city', 'state', 'country', 'pin_code', 'mobile_number', 'secondary_phone_number', 'email', 'website', 'working_hours' , 'is_agree_to_terms', 'identity_proof' , 'business_proof' , 'business_logo'];

    public static $updatable = ['user_id' => "", 'bussiness_category_id' => "", 
    'title' => "", 'keywords' => "", 'about_us' => "", 'address' => "", 'city' => "", 'state' => "", 'country' => "", 'pin_code' => "", 'mobile_number' => "", 'secondary_phone_number' => "", 'email' => "", 'website' => "", 'working_hours' => "", 'is_agree_to_terms' => "" ,'identity_proof' => "" ,'business_proof' => "", 'business_logo' => ""];

    public function category()
    {
        return $this->belongsTo('App\BussinessCategory','bussiness_category_id');
    }

    public function apiGetBusinessesByCategory($input)
    {
        return $this->where('bussiness_category_id', $input['categoryId'])->where('is_blocked', 0)->get();
    }

    public function apiPostUserBusiness($input)
    {
		$validator = Validator::make($input, [
		    'userId' => 'required',
		    'categoryId' => 'required',
		    'title' => 'required',
		    'keywords' =>'required',
		    'email' => 'required|email|max:255|unique:user_businesses',
		    'pinCode' => 'numeric',
		    'country' => 'string',
		    'state' => 'string',
		    'city' => 'string',
		    'businessLogo' => 'image|mimes:jpg,png,jpeg',
		    'aboutUs' => 'string',
		    'address' => 'string',
		    'secondaryPhoneNumber' => 'numeric',
		    'website' => 'string',
		    'workingHours' => 'string',
		    'mobileNumber' => 'required'
		]);

        if ($validator->fails()) {
            return response()->json(['status' => 'exception','response' => 'All fields are required']);   
        }

        $input = $request->input();
       
            if ($request->hasFile('businessLogo') ){
                if ($request->file('businessLogo')->isValid())
                {
                    $file = $key = md5(uniqid(rand(), true));
                    $ext = $request->file('businessLogo')->
                        getClientOriginalExtension();
                    $image = $file.'.'.$ext;  

                    $fileName = $request->file('businessLogo')->move(config('image.logo_image_path'), $image);

                    $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.logo_small_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/small/'.$image;
                    shell_exec($command);
                }
            }
            $user = array_intersect_key($request->input(), User::$updatable);
            $user['user_role_id'] = 3;

            $user = User::create($user);
            $user->save();

            $business = array_intersect_key($input, UserBusiness::$updatable);

            $business['user_id'] = $user->id;
            $business['bussiness_category_id'] = $input['categoryId'];
            $business['pin_code'] = $input['pinCode'];
            $business['mobile_number'] = $input['mobileNumber'];
            $business['about_us'] = $input['aboutUs'];
            $business['secondary_phone_number'] = $input['secondaryPhoneNumber'];
            $business['working_hours'] = $input['workingHours'];
          
            if(isset($fileName)){
                $business['business_logo'] = $image;
            }
           
            $business = UserBusiness::create($business);

            if($business->save()){
                return response()->json(['status' => 'success','response' => $business]);
            } else {
                return response()->json(['status' => 'failure','response' => 'System Error:User could not be created .Please try later.']);
            }  
    }
}