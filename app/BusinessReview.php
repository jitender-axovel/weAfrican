<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessReview extends Model
{
	
    protected $fillable = ['user_id', 'business_id', 'review'];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'review' => ""];

    public function apiGetBusinessReview($businessId)
    {
    	$reviews = $this->where('business_id', $businessId)->where('is_blocked', 0)->get();
    	return $reviews;
    }
}