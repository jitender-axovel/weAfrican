<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class UserBusiness extends Model
{

    protected $fillable = ['user_id', 'bussiness_category_id', 'title' ,'keywords', 'about_us', 'address', 'city', 'state', 'country', 'pin_code', 'mobile_number', 'secondary_phone_number', 'email', 'website', 'working_hours' , 'is_agree_to_terms', 'identity_proof' , 'business_proof' , 'business_logo'];

    public static $updatable = ['user_id' => "", 'bussiness_category_id' => "", 'title' => "", 'keywords' => "", 'about_us' => "", 'address' => "", 'city' => "", 'state' => "", 'country' => "", 'pin_code' => "", 'mobile_number' => "", 'secondary_phone_number' => "", 'email' => "", 'website' => "", 'working_hours' => "", 'is_agree_to_terms' => "" ,'identity_proof' => "" ,'business_proof' => "", 'business_logo' => ""];

    public function category()
    {
        return $this->belongsTo('App\BussinessCategory','bussiness_category_id');
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
                'businessLogo' => 'image|mimes:jpg,png,jpeg',
                'aboutUs' => 'string',
                'address' => 'string',
                'secondaryPhoneNumber' => 'numeric',
                'website' => 'string',
                'workingHours' => 'string',
                'mobileNumber' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'exception','response' => $validator->errors()->all()]);   
        }

        if(!$user){
           
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
            
            $user = User::where('id',$input['userId'])->update(['user_role_id' => 3]);

            $business = array_intersect_key($input, UserBusiness::$updatable);

            $business['user_id'] = $input['userId'];
            $business['bussiness_category_id'] = $input['categoryId'];
            $business['pin_code'] = $input['pinCode'];
            $business['mobile_number'] = $input['mobileNumber'];
            $business['about_us'] = $input['aboutUs'];
            $business['secondary_phone_number'] = $input['secondaryPhoneNumber'];
            $business['working_hours'] = $input['workingHours'];
            $business['is_agree_to_terms'] = $input['isAgreeToTerms'];
          
            if(isset($fileName)){
                $business['business_logo'] = $image;
            }
           
            $business = UserBusiness::create($business);

            if($business->save()){
                return response()->json(['status' => 'success','response' => $business]);
            } else {
                return response()->json(['status' => 'failure','response' => 'System Error:User could not be created .Please try later.']);
            }
        } else {

            if ($request->hasFile('businessLogo') ){
                if ($request->file('businessLogo')->isValid())
                {
                    $file = $key = md5(uniqid(rand(), true));
                    $ext = $request->file('businessLogo')->
                        getClientOriginalExtension();
                    $image = $file.'.'.$ext; 

                    $fileName = $request->file('businessLogo')->move(config('image.logo_image_path'), $image);

                    $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.media_small_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/small/'.$image;
                    shell_exec($command);
                }
            }

            $input['user_id'] = $input['userId'];
            $input['bussiness_category_id'] = $input['categoryId'];
            $input['pin_code'] = $input['pinCode'];
            $input['mobile_number'] = $input['mobileNumber'];
            $input['about_us'] = $input['aboutUs'];
            $input['secondary_phone_number'] = $input['secondaryPhoneNumber'];
            $input['working_hours'] = $input['workingHours'];

            $business = array_intersect_key($input, UserBusiness::$updatable);
            
            if(isset($fileName)) {
                $input['business_logo'] =  $image;
                $user = UserBusiness::where('user_id',$input['user_id'])->update($business);
            } else {
                
                $user = UserBusiness::where('user_id',$input['user_id'])->update($business);
            }

            return response()->json(['status' => 'success','response' => "Business updated successfully."]);
        }
    }
}