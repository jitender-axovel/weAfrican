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
        $notification->source      = $source;
        $notification->message     = $business->title." "."created new"." ".$source.".";
        $notification->save();
        $user_id = BusinessFollower::where('business_id', $businessId)->get();
        dd($user_id);
        $user_id = AppFeedback::select('app_feedbacks.*', 'users.full_name', 'users.mobile_number', 'users.country_code')->leftJoin('users', 'app_feedbacks.user_id', '=', 'users.id')->get();
        return view('admin.app-feedback.index', compact('pageTitle', 'feedbacks'));
        //$user_id2 = BusinessLike::where('business_id =',$businessId)->get();
    }
}
