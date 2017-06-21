<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BussinessCategory extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['parent_id','title', 'slug', 'description', 'image'];

    public static $updatable = ['parent_id' => "", 'title' => "", 'slug' => "", 'description' => "", 'image' => ""];

    public static $validater = array(
    	'title' => 'required|unique:bussiness_categories|max:20',
    	'description' => 'required',
    	'category_image' => 'required',
    	);

    public static $updateValidater = array(
    	'title' => 'required',
    	'description' => 'required',
    	);

    public function businesses()
    {
        return $this->hasMany('App\UserBusiness');
    }
    
    public function getBusinesses()
    {
        return $this->businesses()->where('is_blocked', 0)->orderBy('sort_order','asc')->get();
    }

    public function apiGetCategory()
    {
    	$categories = $this->where('is_blocked',0)->get();
       	return $categories;
    }

    public function apiGetSubCategory($id)
    {
        $subCategories = $this->where('is_blocked',0)->where('parent_id',$id)->get();
        return $subCategories;
    }

    public function parent()
    {
        return $this->belongsTo('App\BussinessCategory','parent_id','id');
    }
}