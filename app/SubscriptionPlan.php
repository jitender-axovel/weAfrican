<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'product_limit','service_limit','price'];

    public static $updatable = ['name' => "", 'product_limit' => "",'service_limit' => "",'price' => ""];

    public static $validater = array(
    	'name' => 'required|unique:subscription_plans|max:255',
    	);

}
