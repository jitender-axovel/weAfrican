<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessBanner extends Model
{
    protected $fillable = ['user_business_id', 'title', 'description', 'city', 'url', 'is_blocked'];

    public static $updatable = ['title' => "", 'description' => "", 'city' => "", 'url' => "", 'is_blocked' => ""];

    public $validator = array(
    	'title' => 'required|max:255',
    	'description' => 'max:1000',
    	'city' => 'required|max:255',
    	'url' => 'required|max:255',
	);

    public function business()
    {
    	return $this->belongsTo('App\UserBusiness');
    }
}
