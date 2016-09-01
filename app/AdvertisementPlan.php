<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertisementPlan extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'city_id'];

    public static $updatable = ['name' => "", 'city_id' => "",'created_at' => ""];

    public static $validater = array(
    	'name' => 'required|unique:advertisement_plans|max:255',
    	);

}
