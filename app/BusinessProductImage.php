<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class BusinessProductImage extends Model
{
    protected $fillable = ['user_id', 'business_id', 'business_product_id', 'image', 'featured_image'];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'business_product_id' => "", 'image' => "", 'featured_image' => ""];
    public static $validater = array(
        'image' => 'required|image|mimes:jpg,png,jpeg',
    	);
}
