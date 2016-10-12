<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Validator;
use DB;

class BusinessEvent extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'name', 'title', 'slug', 'organizer_name', 'address', 'event_dt', ];

    public static $updatable = ['user_id' => "", 'name' => "" , 'title' => "", 'slug' => "", 'organizer_name' => "", 'address' => "", 'event_dt' => ""];

    public static $validater = array(
        'name' => 'required|max:255',
    	'title' => 'required|max:255',
    	'organizer_name' => 'required',
    	'address' => 'required',
        'event_dt' => 'required',
    	);

    public static $updateValidater = array(
    	'name' => 'required|max:255',
        'title' => 'required|max:255',
        'organizer_name' => 'required',
        'address' => 'required',
        'event_dt' => 'required',
    	);

    public function apiGetBusinessEvents($input)
    {
        $events = $this->where('id',$input['userId'])->where('is_blocked',0)->get();
        return $events;
    }

    public function apiPostUserEvent(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return json_encode(['status' =>'error','response'=> 'Input parameters are missing']); 
        }

        $event = $this->where('user_id',$input['userId'])->where('id', $input['eventId'])->first();

        if (!$event){

            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'title' => 'required|max:255',
                'organizerName' => 'required',
                'address' => 'required',
                'eventDateTime' => 'required',
                ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->all()]);   
            }

            $event = array_intersect_key($request->input(), BusinessEvent::$updatable);
            $event['user_id'] = $input['userId'];
            $event['organizer_name'] = $input['organizerName'];
            $event['event_dt'] = $input['eventDateTime'];
            $event = BusinessEvent::create($event);
            $event->save();

            $event->slug = Helper::slug($event->title, $event->id);

            if($event->save()){
                return response()->json(['status' => 'success','response' => $event]);
            } else {
                return response()->json(['status' => 'failure','response' => 'System Error:Product could not be created .Please try later.']);
            }
        } else {

            $validator = Validator::make($input, [
                'name' => 'required',
                'title' => 'required',
                'organizerName' => 'required',
                'address' => 'required',
                'eventDateTime' => 'required',
                ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->all()]);   
            }

            $input['user_id'] = $input['userId'];
            $input['id'] = $input['eventId'];
            $input['organizer_name'] = $input['organizerName'];
            $input['event_dt'] = $input['eventDateTime'];
            
            $event = array_intersect_key($input, BusinessEvent::$updatable);
           
            $event = BusinessEvent::where('id', $input['id'])->where('user_id', $input['user_id'])->update($event);

            return response()->json(['status' => 'success','response' => "Event updated successfully."]);
        }
    }

    public function apiPostEventAttendingUsers($input)
    {
        $check = DB::table('event_users')->where('user_id',$input['userId'])->where('event_id',$input['eventId'])->first();

        if($check)
        {
            DB::table('event_users')->where('user_id',$input['userId'])->where('event_id',$input['eventId'])->delete();
            return response()->json(['status' => 'success','response' => "User does not attending event."]);

        } else{
            $event = DB::table('event_users')->insert(['user_id' => $input['userId'], 'event_id' => $input['eventId'] ]);
            return response()->json(['status' => 'success','response' => "User attending event"]);
        }
    }
}