<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;

class BusinessProduct extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'slug', 'description', 'price', 'image'];

    public static $updatable = ['title' => "", 'slug' => "", 'description' => "", 'price' => "", 'image' => ""];

    public static $validater = array(
    	'title' => 'required|unique:business_products|max:255',
    	'description' => 'required',
    	'product_image' => 'required',
        'price' => 'required|integer',
        'product_image' => 'image|mimes:jpg,png,jpeg',
    	);

    public static $updateValidater = array(
    	'title' => 'required',
    	'description' => 'required',
        'price' => 'required|integer',
        'product_image' => 'image|mimes:jpg,png,jpeg',
    	);

    public function apiGetBusinessProducts($input)
    {
        $product = BusinessProduct::where('id',$input['userId'])->where('is_blocked',0)->get();
        return $product;
    }
}