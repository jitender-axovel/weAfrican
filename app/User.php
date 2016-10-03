<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Http\Request;

use Auth;
use Validator;
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
        'full_name', 'country_code', 'mobile_number', 'password', 'user_role_id', 'slug', 'otp'
    ];

    /**
    * The attributes that are updatable.
    *
    * @var array
    */
    public static $updatable = [
        'full_name' => "", 'password' => "", 'slug' => "", 'otp' => "" , 'country_code' => "" , 'user_role_id' => "" , 'mobile_number' => ""
    ];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
    'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\UserRole', 'user_role_id');
    }

    public function apiLogin(Request $request)
    {
        $user = $this->where('mobile_number', $request->input('mobileNumber'))->first();

        if (!$user){

            $validator = Validator::make($request->input(), [
                'fullName' => 'required',
                'mobileNumber' => 'required|numeric|unique:users,mobile_number',
                'countryCode' => 'required',
            ]);

            if ($validator->fails()) {
               return json_encode(['status' =>'error','response'=>$validator->errors()->all()]);  
            }
           
            $user['full_name'] = $request->input('fullName');
            $user['mobile_number'] = $request->input('mobileNumber');
            $user['country_code'] = $request->input('countryCode');
            $user['user_role_id'] = 4;

            $user = array_intersect_key($user, User::$updatable);

            $user = $this->create($user);

            $user['slug'] = Helper::slug($user->full_name, $user->id);

            if($user->save()){
                return response()->json(['status' => 'success','response' => ($user)]);
            } else {
                return response()->json(['status' => 'failure','response' => 'System Error:User could not be created .Please try later.']);
            }
        } else{

            $user = $this->whereFullName($request->input('fullName'))->where('mobile_number', $request->input('mobileNumber'))->first();

            if($user){
                return response()->json(['status' => 'success','response' => $user]);
            } else {
                return response()->json(['status' => 'exception','response' => 'Invalid Credentials']);
            }
        }
    }
}