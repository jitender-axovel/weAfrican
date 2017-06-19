<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPortfolioImage extends Model
{
    protected $fillable = ['user_id', 'business_id', 'user_portfolio_id', 'title', 'description', 'image', 'featured_image'];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'user_portfolio_id' => "", 'title' => "", 'description' => "", 'image' => "", 'featured_image' => ""];
    
    public static $validater = array(
    	'title' => 'required|unique:user_portfolio_images|max:255',
    	'description' => 'required',
        'image' => 'required|image|mimes:jpg,png,jpeg',
    	);
}
