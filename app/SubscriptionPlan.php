<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['product_limit','service_limit','price'];

    public static $updatable = ['product_limit' => "",'service_limit' => "",'price' => ""];

    public static $validater = array(
    	'product_limit' => 'required',
    	'service_limit' => 'required',
    	'price' => 'required',   
    	);

    public static $updateValidater = array(
    	'product_limit' => 'required',
    	'service_limit' => 'required',
    	'price' => 'required',   
    	);

    public function apiGetSubscriptionPlans()
    {
        $plans = SubscriptionPlan::where('is_blocked',0)->orderBy('id','asc')->get();
        return $plans;
    }

}
