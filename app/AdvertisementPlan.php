<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertisementPlan extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'slug'];

    public static $updatable = ['name' => "", 'slug' => "",'created_at' => ""];

    public static $validater = array(
    	'name' => 'required|unique:categories|max:255',
    	);

}
