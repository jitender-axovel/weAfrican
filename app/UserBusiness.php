<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBusiness extends Model
{

    protected $fillable = ['user_id', 'bussiness_category_id', 'title' ,'keywords', 'about_us', 'address', 'city', 'state', 'country', 'pin_code', 'mobile_number', 'secondary_phone_number', 'email', 'website', 'working_hours' , 'is_agree_to_terms', 'identity_proof' , 'business_proof' , 'business_logo'];

    public static $updatable = ['user_id' => "", 'bussiness_category_id' => "", 
    'title' => "", 'keywords' => "", 'about_us' => "", 'address' => "", 'city' => "", 'state' => "", 'country' => "", 'pin_code' => "", 'mobile_number' => "", 'secondary_phone_number' => "", 'email' => "", 'website' => "", 'working_hours' => "", 'is_agree_to_terms' => "" ,'identity_proof' => "" ,'business_proof' => "", 'business_logo' => ""];

    public function category()
    {
        return $this->belongsTo('App\BussinessCategory','bussiness_category_id');
    }
}