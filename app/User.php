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
        'full_name', 'country_code', 'mobile_number', 'password', 'user_role_id', 'slug', 'otp', 'image'];

    /**
    * The attributes that are updatable.
    *
    * @var array
    */
    public static $updatable = [
        'full_name' => "", 'password' => "", 'slug' => "", 'otp' => "" , 'country_code' => "" , 'user_role_id' => "" , 'mobile_number' => "", 'image' => ""];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
    'password', 'remember_token',];

    public static $downloadable = ['full_name' => '', 'mobile_number' => "", 'country_code' => ''];

    public function role()
    {
        return $this->belongsTo('App\UserRole', 'user_role_id');
    }

    public function apiLogin(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return json_encode(['status' =>'error','response'=> 'Input parameters are missing']);  
        }

        $user = $this->where('mobile_number', $request->input('mobileNumber'))->whereIn('user_role_id',[3,4])->first();

        if (!$user){

            $validator = Validator::make($request->input(), [
                'fullName' => 'required',
                'mobileNumber' => 'required|numeric|unique:users,mobile_number',
                'countryCode' => 'required',
            ]);

            if($validator->fails()){
                if(count($validator->errors()) <= 1){
                        return response()->json(['status' => 'exception','response' => $validator->errors()]);   
                } else{
                    return response()->json(['status' => 'exception','response' => 'All fields are required']);   
                }
            }
           
            $user['full_name'] = $request->input('fullName');
            $user['mobile_number'] = $request->input('mobileNumber');
            $user['country_code'] = $request->input('countryCode');
            $user['password'] = bcrypt($request->input('mobileNumber'));
            $user['user_role_id'] = 4;

            $user = array_intersect_key($user, User::$updatable);

            $user = $this->create($user);

            $user['slug'] = Helper::slug($user->full_name, $user->id);

            if($user->save()){
                return response()->json(['status' => 'success','response' => $user]);
            } else {
                return response()->json(['status' => 'failure','response' => 'System Error:User could not be created .Please try later.']);
            }
        } else{

            $user->update(['full_name' => $request->input('fullName'), 'slug' => Helper::slug($request->input('fullName'),$user->id)]);

            if ($user->is_blocked) {
                // Authentication passed...
                return response()->json(['status' => 'exception','response' => 'Your account is blocked by admin.']);
                
            } else if (Auth::attempt(['mobile_number' => $user->mobile_number, 'password' => $user->mobile_number, 'is_blocked' => 0])) {

                $checkBusiness = UserBusiness::whereUserId($user->id)->first();
                
                $response = Auth::user();

                if ($checkBusiness)
                    $response['businessId'] = $checkBusiness->id;
                
;                return response()->json(['status' => 'success','response' => $response]);
            }
            else{
                return response()->json(['status' => 'failure', 'response' => 'Can not login using this mobile number!!!']);
            }
        }
    }

    public function apiCheckOtp($input)
    {
        $check = $this->where('mobile_number', $input['mobileNumber'])->first();
        if($check)
        { 
            $otp = $this->where('mobile_number', $input['mobileNumber'])->where('otp', $input['otp'])->first();
            if($otp)
                return 1;
            else
                return 2;
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
            $response['imageName'] = $image;
          
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

}