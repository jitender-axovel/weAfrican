<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventBanner extends Model
{
    protected $fillable = ['user_id', 'subscription_plan_id', 'banner', ];

    public static $updatable = ['user_id' => "", 'subscription_plan_id' => "", 'banner' => "" ];

    public static $validater = array(
        'banner' => 'required|image|mimes:jpg,png,jpeg',
    	);
}
