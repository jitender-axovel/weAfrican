<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserBusiness;
use App\BusinessLike;
use App\BusinessFollower;

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
        $user_id1 = BusinessLike::whereBusinessId($businessId)->pluck('user_id');
        $user_id2 = BusinessFollower::whereBusinessId($businessId)->pluck('user_id');
        $user_id = $user_id1->merge($user_id2)->unique()->toArray();
        $fcm_tokens = FcmUser::whereIn('user_id', $user_id)->pluck('fcm_reg_id')->toArray();
        //dd($fcm_tokens);
        $res = $this->sendPushNotificationToFCM($fcm_tokens,array("m" => $notification->message));
        //dd($res);
    }

    public function sendPushNotificationToFCM($registation_ids, $message) {
        //Google cloud messaging GCM-API url
        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => $registation_ids,
            'data' => $message,
        );

        if (!defined('FIREBASE_API_KEY')) {
            define("FIREBASE_API_KEY", "AAAAL_uNtq4:APA91bGp3ruskX7LbIlIFvHuo0-wy4Ku31RpQKIJA80eqPuckaHyOIgB0TUunhjN4p9qKWSBq59mewGcXhUSdt54FuDXvQ4M5M-W_naLdxBCK2nArpTGq_U4H8ThmEaFk-9rFuDUQckzj61DkJoKc8XP0Y4-crk5lg");       
        }

        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}