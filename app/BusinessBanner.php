<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessBanner extends Model
{
    protected $fillable = ['user_id', 'subscription_plan_id', 'country', 'state', 'city','image', 'latitude', 'longitude'];

    public static $updatable = ['user_id' => "", 'subscription_plan_id' => "", 'country' => "", 'state' => "", 'city' => "", 'image' => "", 'latitude' => "", 'longitude' => ""];


    public function business()
    {
    	return $this->belongsTo('App\UserBusiness','user_id','user_id');
    }

    public function subscription()
    {
        return $this->belongsTo('App\SubscriptionPlan','subscription_plan_id','id');
    }
}
