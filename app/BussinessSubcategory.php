<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BussinessSubcategory extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['category_id', 'title', 'slug', 'description', 'image'];

    public static $updatable = ['category_id' => '', 'title' => "", 'slug' => "", 'description' => "", 'image' => ""];

    public static $validater = array(
    	'title' => 'required|unique:bussiness_subcategories|max:255',
    	'description' => 'required',
    	'category_image' => 'required',
    	'category_id' => 'required',
    	);

    public static $updateValidater = array(
    	'title' => 'required',
    	'description' => 'required',
    	'category_id' => 'required',
    	);

    public function category()
    {
        return $this->belongsTo('App\BussinessCategory')->withTrashed();
    }
}
