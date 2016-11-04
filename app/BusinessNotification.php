<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserBusiness;

class BusinessNotification extends Model
{
    protected $fillable = ['business_id', 'source', 'message'];

    public function saveNotification($businessId, $source)
    {
    	$business = UserBusiness::whereId($businessId)->first();

    	$notification = new BusinessNotification();

        $notification->business_id = $businessId;
        $notification->source = $source;
        $notification->message = $business->title." "."created new"." ".$source.".";
        $notification->save();
    }
}