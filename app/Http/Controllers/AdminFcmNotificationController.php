<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\FcmUser;
use App\User;
use App\UserBusiness;
use DB;

class AdminFcmNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        $pageTitle = 'Notification- Admin';
        $fcmUsers = FcmUser::leftJoin('users','fcm_users.user_id' , '=' , 'users.id')->get();

        return view('admin.fcm-notifications.index', compact('pageTitle', 'fcmUsers'));
    }


    public function sendNotification(Request $request)
    {
    	$input = $request->input();
        
    	//$sendUsers = $input['sendmsg'];
	    $resp = "<tr id='header'><td>FCM Response [".date("h:i:sa")."]</td></tr>";
	    //$userCount = count($sendUsers);
		$msg = $input['message'];
		$respJson = '{"Message":"'.$msg.'"}';
		$registation_ids = array();
		// JSON Msg to be transmitted to selected Users
		$message = array("m" => $respJson);  
        $user_condition = array();
        $business_condition = array();
        if($input['country']!="")
        {
            $user_condition['country'] = $input['country'];
        }
        if($input['state']!="")
        {
            $user_condition['state'] = $input['state'];
        }
        if($input['city']!="")
        {
            $user_condition['city'] = $input['city'];
        }
        if($input['type'] == 3){
            if($input['category']!="")
            {
                $business_condition['bussiness_category_id'] = $input['category'];
            }
            if($input['subcategory']!="")
            {
                $business_condition['bussiness_subcategory_id'] = $input['subcategory'];
            }
            $user_ids = User::where($user_condition)->pluck('id');
            $user_id = UserBusiness::where($business_condition)->whereIn('user_id',$user_ids)->pluck('user_id');
            $ids = FcmUser::select('fcm_reg_id')->whereIn('user_id', $user_id)->where('user_role_id', 3)->get();
        
        } else if($input['type'] == 4){
            $user_ids = User::where($user_condition)->pluck('id');
            $user_id = UserBusiness::where($business_condition)->whereIn('user_id',$user_ids)->pluck('user_id');
            $ids = FcmUser::select('fcm_reg_id')->whereIn('user_id', $user_id)->where('user_role_id', 4)->get();
        }
        else{
            $ids = FcmUser::select('fcm_reg_id')->get();
        }
        foreach($ids as $key =>$id)
        {
            $registation_ids[] = $id->fcm_reg_id;
        }
        
		$pushsts = $this->sendPushNotificationToFCM($registation_ids, $message);
       
		$resp = $resp."<tr><td>".$pushsts."</td></tr>";
		echo "<table>".$resp."</table>";
    }

    public function sendPushNotificationToFCM($registation_ids, $message) {
		//Google cloud messaging GCM-API url
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $registation_ids,
            'data' => $message,
        );
        // echo  json_encode($fields);
		// Update your Google Cloud Messaging API Key
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       //
    }

   
}