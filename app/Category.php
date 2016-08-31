<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'slug'];

    public static $updatable = ['title' => "", 'slug' => "",'created_at' => ""];

    public static $validater = array(
    	'title' => 'required|unique:categories|max:255',
    	);

}
