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
        'full_name', 'country_code', 'phone_number', 'password', 'user_role_id', 'slug', 'otp'
    ];

    /**
    * The attributes that are updatable.
    *
    * @var array
    */
    public static $updatable = [
        'full_name' => "", 'password' => "", 'slug' => "", 'otp' => "" , 'country_code' => "" , 'user_role_id' => "" , 'phone_number' => ""
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

    public function apiRegister($input)
    {
        $validator = Validator::make($input, [
            'full_name' => 'required',
            'mobile_no' => 'numeric|required|unique:users',
            'password' => 'required|min:6',
            ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'exception','response' => $validator->errors()->all()]);

        }

        $input['full_name']=ucfirst($input['full_name']);
        $input['mobile_no']=ucfirst($input['mobile_no']);
        $input['password']=bcrypt($input['password']);
        $input['user_role_id']= 4;

        $user = User::create($input);

        $user['slug'] = Helper::slug($input['full_name'], $user->id);

        if($user->save()){
            return response()->json(['status' => 'success','response' => array($user)]);
        } else {
            return response()->json(['status' => 'failure','response' => 'System Error:User could not be created .Please try later.']);
        }
    }

    public function apiLogin($input)
    {
        if (Auth::attempt(['mobile_no' => $input['mobile_no'], 'password' => $input['password'],'is_blocked' => 0])) {
            return response()->json(['status' => 'success','response' => Auth::user()]);
        }
        else {
            return response()->json(['status' => 'exception','response' => 'Your account is Inactive or not verified']);
        }

    }
}