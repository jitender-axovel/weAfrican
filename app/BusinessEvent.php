<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\UserBusiness;
use Validator;
use DB;

class BusinessEvent extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'business_id', 'event_category_id', 'name', 'keywords', 'slug', 'description', 'organizer_name', 'address', 'start_date_time', 'end_date_time', 'banner', 'city', 'state', 'country', 'pin_code', 'latitude', 'longitude', 'start_date', 'end_date' ];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'event_category_id' => "", 'name' => "" , 'keywords' => "", 'slug' => "", 'description' => "", 'organizer_name' => "", 'address' => "", 'start_date_time' => "", 'end_date_time' => "", 'banner' => "", 'city' => "", 'state' => "", 'country' => "", 'pin_code' => "", 'latitude' => "", 'longitude' => "", 'start_date' => "", 'end_date' => ""];

    public static $validater = array(
        'event_category_id' => 'required',
        'name' => 'required|max:255',
    	'keywords' => 'required|max:255',
        'description' => 'required',
    	'organizer_name' => 'required',
    	'address' => 'required',
        'start_date_time' => 'required',
        'end_date_time' => 'required',
        'city' => 'required',
        'address' => 'required',
        'banner' => 'required|image|mimes:jpg,png,jpeg',
    	);

    public static $updateValidater = array(
        'event_category_id' => 'required',
    	'name' => 'required|max:255',
        'keywords' => 'required|max:255',
        'description' => 'required',
        'organizer_name' => 'required',
        'address' => 'required',
        'start_date_time' => 'required',
        'end_date_time' => 'required',
        'city' => 'required',
        'address' => 'required',
        'banner' => 'image|mimes:jpg,png,jpeg',
    	);

    public function category()
    {
        return $this->belongsTo('App\EventCategory','event_category_id');
    }

    public function participations()
    {
        return $this->hasMany('App\EventParticipant','event_id');
    }

    public function business()
    {
        return $this->hasOne('App\UserBusiness','id');
    }

    public function apiGetBusinessEvents($input)
    {

        if(isset($input['latitude']) && isset($input['longitude']) && isset($input['radius']))
        { 
            $events = DB::select("SELECT * , p.distance_unit * DEGREES( ACOS( COS( RADIANS( p.latpoint ) ) * COS( RADIANS(z.latitude ) ) * COS( RADIANS( p.longpoint ) - RADIANS( z.longitude ) ) + SIN( RADIANS( p.latpoint ) ) * SIN( RADIANS( z.latitude ) ) ) ) AS distance_in_km FROM business_events AS z JOIN (SELECT ".$input['latitude']." AS latpoint, ".$input['longitude']." AS longpoint, ".$input['radius']." AS radius, 111.045 AS distance_unit) AS p ON 1 =1 WHERE z.latitude BETWEEN p.latpoint - ( p.radius / p.distance_unit ) AND p.latpoint + ( p.radius / p.distance_unit ) AND z.longitude BETWEEN p.longpoint - ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND p.longpoint + ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND z.state = '".$input['state']."' AND z.event_category_id = ".$input['eventCategoryId']." AND z.is_blocked = 0 AND z.user_id != ".$input['userId']." ORDER BY distance_in_km DESC LIMIT ".$input['index'].", ".$input['limit']." ");
        } else {
            $events = $this->whereEventCategoryId($input['eventCategoryId'])->whereCountry($input['country'])->whereState($input['state'])->whereIsBlocked(0)->whereNotIn('user_id',[$input['userId']])->skip($input['index'])->limit($input['limit'])->get();
        }

        return $events;
    }

    public function apiGetUserBusinessEvents($input)
    {
        $events = $this->where('user_id',$input['userId'])->where('is_blocked',0)->get();
        return $events;
    }

    public function apiPostUserEvent($input)
    {
       $validator = Validator::make($input, [
            'userId' => 'required',
            'businessId' => 'required',
            'eventCategoryId' => 'required',
            'name' => 'required',
            'keywords' => 'required',
            'description' => 'required',
            'organizerName' => 'required',
            'address' => 'required',
            'startDateTime' => 'required',
            'endDateTime' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            ]);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        if(isset($input['eventId'])){

            if(isset($input['eventBanner']) && !empty($input['eventBanner']))
            {
                $data = $input['eventBanner'];

                $img = str_replace('data:image/jpeg;base64,', '', $data);
                $img = str_replace(' ', '+', $img);

                $data = base64_decode($img);

                $fileName = md5(uniqid(rand(), true));

                $image = $fileName.'.'.'png';

                $file = config('image.banner_image_path').'event/'.$image;

                $success = file_put_contents($file, $data);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.banner_image_path').'event/thumbnails/small/'.$image;
                shell_exec($command); 

                $command = 'ffmpeg -i '.config('image.banner_image_path').'/event/'.$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.product_image_path').'event/thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.product_image_path').'event/thumbnails/large/'.$image;
                shell_exec($command);
            }

            $input['user_id'] = $input['userId'];
            $input['business_id'] = $input['businessId'];   
            $input['event_category_id'] = $input['eventCategoryId'];
            $input['organizer_name'] = $input['organizerName'];
            $input['pin_code'] = $input['pincode'];
            $input['start_date'] = $input['startDateTime'];
            $input['end_date'] = $input['endDateTime'];

            if(isset($image)) {
                $input['banner'] =  $image;
            } 
            
            $event = array_intersect_key($input, BusinessEvent::$updatable);
           
            $event = BusinessEvent::where('id', $input['eventId'])->update($event);

            if($event)
                return response()->json(['status' => 'success','response' => "Event updated successfully."]);
            else
                return response()->json(['status' => 'failure','response' => "Event could not updated successfully.Please try again."]);
        }else{

            if(isset($input['eventBanner']) && !empty($input['eventBanner']))
            {
                $data = $input['eventBanner'];

                $img = str_replace('data:image/jpeg;base64,', '', $data);
                $img = str_replace(' ', '+', $img);

                $data = base64_decode($img);

                $fileName = md5(uniqid(rand(), true));

                $image = $fileName.'.'.'png';

                $file = config('image.banner_image_path').'event/'.$image;

                $success = file_put_contents($file, $data);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.banner_image_path').'event/thumbnails/small/'.$image;
                shell_exec($command); 

                $command = 'ffmpeg -i '.config('image.banner_image_path').'/event/'.$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.product_image_path').'event/thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.product_image_path').'event/thumbnails/large/'.$image;
                shell_exec($command);
            }

            $event = array_intersect_key($input, BusinessEvent::$updatable);
            $event['user_id'] = $input['userId'];
            $event['business_id'] = $input['businessId'];
            $event['event_category_id'] = $input['eventCategoryId'];
            $event['organizer_name'] = $input['organizerName'];
            $event['pin_code'] = $input['pincode'];

            $event['start_date'] = $input['startDateTime'];
            $event['end_date'] = $input['endDateTime'];

            if(isset($image)) {
                $event['banner'] =  $image;
            } 
            
            $event = BusinessEvent::create($event);
            $event->save();

            $event->slug = Helper::slug($event->name, $event->id);

            if($event->save())
                return response()->json(['status' => 'success','response' => $event]);
            else 
                return response()->json(['status' => 'failure','response' => 'System Error:Event could not be created .Please try later.']);
        }
    }

    public function apiPostEventAttendingUsers($input)
    {
        $check = DB::table('event_participants')->where('user_id',$input['userId'])->where('event_id',$input['eventId'])->first();

        if($check)
        {
            DB::table('event_participants')->where('user_id',$input['userId'])->where('event_id',$input['eventId'])->delete();
            return response()->json(['status' => 'success','response' => 0]);

        } else{
            $event = DB::table('event_participants')->insert(['user_id' => $input['userId'], 'event_id' => $input['eventId'] ]);
            return response()->json(['status' => 'success','response' => 1]);
        }
    }
}