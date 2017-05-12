<<<<<<< HEAD
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
        //dd($user_id);
        $user_id = BusinessFollower::select('business_followers.user_id')->join('business_likes.user_id', 'business_likes.business_id', '=', 'business_followers.business_id')->get();
        //return view('admin.app-feedback.index', compact('pageTitle', 'feedbacks'));
        //$user_id2 = BusinessLike::where('business_id =',$businessId)->get();
    }
}
=======
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
        //$user_id = BusinessFollower::where('business_id =',$businessId)->get();
    }
}
>>>>>>> 8c39c53ea005b053df66154f2fe2a9daa6de81c2
