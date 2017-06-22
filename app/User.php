<?php
namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\UserBusiness;
use App\Helper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewRegisterBusiness;
use App\Mail\SendOtp;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'salutation','first_name','middle_name','last_name', 'gender', 'country_code', 'mobile_number', 'email', 'password', 'user_role_id', 'slug', 'otp', 'image', 'address', 'city', 'state', 'country', 'pin_code', 'currency', 'security_question_id', 'security_question_ans', 'latitude', 'longitude'];

    /**
    * The attributes that are updatable.
    *
    * @var array
    */
    public static $updatable = [
        'salutation' => "",'first_name' => "",'middle_name' => "",'last_name' => "", 'gender'=>"", 'password' => "", 'slug' => "", 'email' => "", 'otp' => "" , 'country_code' => "" , 'user_role_id' => "" , 'mobile_number' => "", 'image' => "", 'address' => "", 'city' => "", 'state' => "", 'country' => "", 'pin_code' => "", 'currency' => "", 'security_question_id' => "", 'security_question_ans' => "", 'latitude' => "", 'longitude' => ""];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
    'password', 'remember_token',];

    public static $downloadable = ['first_name' => '', 'middle_name' => '', 'last_name' => '', 'mobile_number' => "", 'country_code' => ''];

    public function role()
    {
        return $this->belongsTo('App\UserRole', 'user_role_id');
    }

    public function apiLogin(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return json_encode(['status' => 'exception', 'response' => 'All fields are required']);  
        }else
        {
            foreach ($input as $key => $value) {
                if($value==NULL or $value=="")
                {
                    return json_encode(['status' => 'exception', 'response' => ucwords($key).' is mandetory']);
                }
            }
        }

        $user = $this->where('email', $request->input('email'))->whereIn('user_role_id',[3,4])->first();

        if (!$user){
            return response()->json(['status' => 'failure', 'response' => 'Email id not found. Please register to login!!']);
        }else{
            if ($user->is_blocked) {
                // Authentication passed...
                return response()->json(['status' => 'exception', 'response' => 'Your account is blocked by admin.']);
                
            }else if($user && Hash::check($request->input('password'), $user->password))
            {
                if(!$user->is_verified){
                    $user->otp = rand(1000,9999);
                    if($user->save())
                    {
                        Mail::to('madhav@gmail.com')->send(new SendOtp($user));
                        if( count(Mail::failures()) > 0 ) {
                            return response()->json(['status' => 'failure', 'response' => "Mail Cannot be sent! Please try again!!"]);
                        }else
                        {
                            return response()->json(['status' => 'exception', 'response' => "Email is not verified OTP has been send to your email. Please verify OTP to proceed!."]);
                        }
                    }else
                    {
                        return response()->json(['status' => 'failure', 'response' => 'System Error:OTP not generated .Please try later.']);
                    }
                }elseif (Auth::attempt(['email' => $user->email, 'password' => $request->input('password'), 'is_blocked' => 0])) {
                   
                   $checkBusiness = UserBusiness::whereUserId($user->id)->first();

                   $response = Auth::user();

                    if ($checkBusiness)
                        $response['businessId'] = $checkBusiness->id;

                    return response()->json(['status' => 'success', 'response' => $response]);

                }else{
                    return response()->json(['status' => 'failure', 'response' => 'Can not login. Please try again later!!!']);
                }
            }else if(!Hash::check($request->input('password'), $user->password))
            {
                return response()->json(['status' => 'exception', 'response' => 'Please enter a valid password!']);
            }
            else{
                return response()->json(['status' => 'failure', 'response' => 'Can not login. Please try again later!!!']);
            }
        }
    }

    public function apiSignup(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return json_encode(['status' =>'exception', 'response' => 'All fields are required']);  
        }else
        {
            foreach ($input as $key => $value) {
                if($value==NULL or $value=="")
                {
                    return json_encode(['status' =>'exception', 'response' => ucwords($key).' is mandetory']);
                }
            }
        }

        $user = $this->where('email', $request->input('email'))->whereIn('user_role_id',[3,4])->first();
        
        if (!$user){
            $name = explode(' ', $input['name']);
            if(count($name)>1 and count($name)==2)
            {
                $input['first_name'] = $name[0];
                $input['last_name'] = $name[1];
            }elseif(count($name)>1 and count($name)==3)
            {
                $input['first_name'] = $name[0];
                $input['middle_name'] = $name[1];
                $input['last_name'] = $name[2];
            }elseif(count($name)>1 and count($name)>3)
            {
                $input['first_name'] = $name[0];
                $input['middle_name'] = $name[1];
                $input['last_name'] = $name[2].' '.$name[3];
            }else
            {
                $input['first_name'] = $input['name'];
            }
            $validator = Validator::make($input, [
                'first_name' => 'required',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required',
            ]);
            
            if($validator->fails()){
                if(count($validator->errors()) <= 1){
                        return response()->json(['status' => 'exception', 'response' => $validator->errors()]);   
                } else{
                    return response()->json(['status' => 'exception', 'response' =>  'All fields are required']);   
                }
            }
            
            $user['first_name'] = $input['first_name'];
            if(isset($input['middle_name']))
            {
                $user['middle_name'] = $input['middle_name'];
            }
            if(isset($input['last_name']))
            {
                $user['last_name'] = $input['last_name'];
            }
            $user['email'] = $request->input('email');
            /*$user['country_code'] = $request->input('countryCode');*/
            $user['password'] = bcrypt($request->input('password'));
            $user['user_role_id'] = 4;
            $user['otp'] = rand(1000,9999);
            
            $user = array_intersect_key($user, User::$updatable);

            $user = $this->create($user);

            $user['slug'] = Helper::slug($user->first_name, $user->id);

            if($user->save()){
                Mail::to('madhav@gmail.com')->send(new NewRegisterBusiness($user));
                Mail::to('madhav@gmail.com')->send(new SendOtp($user));
                if( count(Mail::failures()) > 0 ) {
                    return response()->json(['status' => 'failure', 'response' => 'Mail Cannot be sent! Please try again!!']);
                }else
                {
                    return response()->json(['status' => 'success','response' =>  'You have been successfully registered. OTP has been send to your email. Please verify OTP to login']);
                }
            } else {
                return response()->json(['status' => 'failure', 'response' => 'System Error:User could not be created .Please try later.']);
            }
        } else{
            return response()->json(['status' => 'exception', 'response' => 'Email is already registered. Please sign-in to continue!!']);
        }
    }

    public function apiCheckOtp($input)
    {
        if($input == NULL)
        {
            return json_encode(['status' => 'exception', 'response' => 'All fields are required']);  
        }else
        {
            foreach ($input as $key => $value) {
                if($value==NULL or $value=="")
                {
                    return json_encode(['status' => 'exception', 'response' => ucwords($key).' is mandetory']);
                }
            }
        }
        $check = $this->where('email', $input['email'])->first();
        if($check)
        { 
            $otp = $this->where('email', $input['email'])->where('otp', $input['otp'])->first();

            if($otp)
            {
                $otp->is_verified = 1;
                $otp->save();

                $checkBusiness = UserBusiness::whereUserId($otp->id)->first();
                
                if ($checkBusiness)
                    $otp['businessId'] = $checkBusiness->id;
                
                return response()->json(['status' => 'success', 'response' => $otp]);
            }else
            {
                return response()->json(['status' => 'exception', 'response' => 'Incorrect Otp. Please enter the correct OTP!!']);
            }
        }else {
            return response()->json(['status' => 'failure', 'response' => 'Email does not exist.']);
        }
    }

    public function apiResendOtp($input)
    {
        /*$input = $request->input();*/
        if($input == NULL)
        {
            return json_encode(['status' => 'exception', 'response' => 'All fields are required']);  
        }else
        {
            foreach ($input as $key => $value) {
                if($value==NULL or $value=="")
                {
                    return json_encode(['status' => 'exception','response' => ucwords($key).' is mandetory']);
                }
            }
        }

        $check = $this->where('email', $input['email'])->first();
        if($check)
        { 
            $check->otp = rand(1000,9999);
            if($check->save()){
                Mail::to('madhav@gmail.com')->send(new SendOtp($check));
                if( count(Mail::failures()) > 0 ) {
                    return 3;
                }else{
                    return 1;
                }
            }
            else
            {
                return 2;
            }
        }else {
            return 0;
        }
    }

    public function apiPostUserDetails(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
                'userId' => 'required',
                'fullName' => 'string',
        ]);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $user = $this->where('id',$input['userId'])->first();

        if($user){

            if(isset($input['image']) && !empty($input['image']))
            {
                $data = $input['image'];

                $img = str_replace('data:image/jpeg;base64,', '', $data);
                $img = str_replace(' ', '+', $img);

                $data = base64_decode($img);

                $fileName = md5(uniqid(rand(), true));

                $image = $fileName.'.'.'png';

                $file = config('image.user_image_path').$image;

                $success = file_put_contents($file, $data);
                    
                $command = 'ffmpeg -i '.config('image.user_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.user_image_path').'thumbnails/small/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.user_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.user_image_path').'thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.user_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.user_image_path').'thumbnails/large/'.$image;
                shell_exec($command);
            }
            
            $user = array_intersect_key($input, User::$updatable);

            $user['slug'] = Helper::slug($input['fullName'], $input['userId']);

            $user['full_name'] = $input['fullName'];
            
            if(isset($image))
                $user['image'] = $image;

            $user = $this->where('id',$input['userId'])->update($user);

            $response = array();

            $response['response'] = "User details updated successfully.";
            $response['imageName'] = (isset($image)) ? $image :'';
          
            if($user)
                return response()->json(['status' => 'success','response' => $response]);
            else
                return response()->json(['status' => 'failure','response' => "System error:User can not updated successfully.Please try again."]);
        }else{
            return response()->json(['status' => 'exception','response' => "User not found!!"]);
        }
    }

    public function apiGetUserDetails(Request $request)
    {
        $input = $request->input();
        $user = $this->where('id',$input['userId'])->first();
        return $user;
    }

    public function business()
    {
        return $this->hasOne('App\UserBusiness');
    }

}