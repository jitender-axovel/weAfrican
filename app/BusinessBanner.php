<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessBanner extends Model
{
    protected $fillable = ['user_id', 'subscription_plan_id', 'country', 'state', 'city','image'];

    public static $updatable = ['country' => "", 'state' => "", 'city' => "", 'image' => ""];


    public function business()
    {
    	return $this->belongsTo('App\UserBusiness');
    }
}
