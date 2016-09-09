<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class BussinessCategory extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'slug', 'description', 'image'];

    public static $updatable = ['title' => "", 'slug' => "", 'description' => "", 'image' => ""];

    public static $validater = array(
    	'title' => 'required|unique:bussiness_categories|max:255',
    	'description' => 'required',
    	'category_image' => 'required',
    	);

    public static $updateValidater = array(
    	'title' => 'required',
    	'description' => 'required',
    	);

    public function apiGetCategory()
    {
    	$category = BussinessCategory::where('is_blocked',0)->get();
    	return $category;
    }

}
