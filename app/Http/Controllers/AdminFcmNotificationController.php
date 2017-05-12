<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\FcmUser;
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
		/*for($i=0; $i < $userCount; $i++)
	    {	
			array_push($registation_ids, $sendUsers[$i]);			  
	    } */
		// JSON Msg to be transmitted to selected Users
		$message = array("m" => $respJson);  
        if($input['type'] == 1){
            $ids = FcmUser::select('fcm_reg_id')->where('user_role_id', 3)->get();
        
        } else if($input['type'] == 2){
            $ids = FcmUser::select('fcm_reg_id')->where('user_role_id', 4)->get();
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