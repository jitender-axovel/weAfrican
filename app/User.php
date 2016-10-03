<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function apiLogin($input)
    {      
        $matchThese = ['full_name' => $input['fullName'] , 'mobile_number' => $input['mobileNumber'] ];
        $user = User::where($matchThese)->first();

        if (!$user){

            $validator = Validator::make($input, [
                'fullName' => 'required',
                'mobileNumber' => 'required|numeric|unique:users',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
           
            $user = array_intersect_key($input, User::$updatable);
            $user['full_name'] = $input['fullName'];
            $user['mobile_number'] = $input['mobileNumber'];
            $user['country_code'] = 91;
            $user['user_role_id'] = 4;

            $user = User::create($user);

            $user['slug'] = Helper::slug($input['fullName'], $user->id);

            if($user->save()){
                return response()->json(['status' => 'success','response' => array($user)]);
            } else {
                return response()->json(['status' => 'failure','response' => 'System Error:User could not be created .Please try later.']);
            }
        } else{
                return response()->json(['status' => 'success','response' => $user]);
        }
    }
}