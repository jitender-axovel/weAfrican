<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['name','city_id','image'];

    public static $updatable = ['name' => "", 'city_id' => "",'image' => ""];

    public static $validater = array(
    	'name' => 'required|unique:banners|max:255',
    	);

}
