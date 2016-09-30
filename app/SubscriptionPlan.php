<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['coverage','price'];

    public static $updatable = ['coverage','price' => ""];

    public static $validater = array(
    	'price' => 'required',   
    	);

    public static $updateValidater = array(
    	'price' => 'required',   
    	);

    public function apiGetSubscriptionPlans()
    {
        $plans = SubscriptionPlan::where('is_blocked',0)->orderBy('id','asc')->get();
        return $plans;
    }

}
