<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\BusinessEvent;
use App\EventBanner;
use App\UserBusiness;
use App\User;
use App\Helper;
use Validator;
use Auth;
use DB;

class BusinessEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Business Event";
        $events = BusinessEvent::whereUserId(Auth::id())->withCount('participations')->get();
        return view('business-event.index', compact('pageTitle', 'events'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Business Event -create";
        $business = UserBusiness::where('user_id', Auth::id())->first();
        
        return view('business-event.create', compact('pageTitle', 'business'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), BusinessEvent::$validater );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $request->input();

        if ($request->hasFile('banner') ){
            if ($request->file('banner')->isValid())
            {
                $file = $key = md5(uniqid(rand(), true));
                $ext = $request->file('banner')->
                    getClientOriginalExtension();
                $image = $file.'.'.$ext; 
                
                $fileName = $request->file('banner')->move(config('image.banner_image_path').'event/', $image);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.banner_image_path').'event/thumbnails/small/'.$image;
                shell_exec($command); 

                $command = 'ffmpeg -i '.config('image.banner_image_path').'/event/'.$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.product_image_path').'event/thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.product_image_path').'event/thumbnails/large/'.$image;
                shell_exec($command);
            }
        }
        
        $event = array_intersect_key($request->input(), BusinessEvent::$updatable);
        $event['user_id'] = Auth::id();
        $event['start_date_time'] = date('Y-m-d H:i:s', strtotime($input['start_date_time']));
        $event['end_date_time'] = date('Y-m-d H:i:s', strtotime($input['end_date_time']));
        $event['banner'] = $image;
       
          
        $event = BusinessEvent::create($event);

        $event->save();
      
        $event->slug = Helper::slug($event->name, $event->id);
        $event->save();

        return redirect('business-event')->with('success', 'New Event created successfully');
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
        $pageTitle = "Business Product-Edit";
        $event = BusinessEvent::find($id);
        return view('business-event.edit',compact('pageTitle','event'));
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
        $validator = Validator::make($request->all(),BusinessEvent::$updateValidater);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $request->input();

        if ($request->hasFile('banner') ){
            if ($request->file('banner')->isValid())
            {
                $file = $key = md5(uniqid(rand(), true));
                $ext = $request->file('banner')->
                    getClientOriginalExtension();
                $image = $file.'.'.$ext; 
                
                $fileName = $request->file('banner')->move(config('image.banner_image_path').'event/', $image);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.banner_image_path').'event/thumbnails/small/'.$image;
                shell_exec($command); 
                
                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.banner_image_path').'event/thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.banner_image_path').'event/thumbnails/large/'.$image;
                shell_exec($command);
            }
        }

        $input = array_intersect_key($input, BusinessEvent::$updatable);
        $input['start_date_time'] = date('Y-m-d H:i:s', strtotime($input['start_date_time']));
        $input['end_date_time'] = date('Y-m-d H:i:s', strtotime($input['end_date_time']));

        if(isset($fileName)) {
            $input['banner'] =  $image;
            $event = BusinessEvent::where('id',$id)->update($input);
        } else {
            $event = BusinessEvent::where('id',$id)->update($input);
        }

        return redirect('business-event')->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = BusinessEvent::findOrFail($id);

        if($event->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Event deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Event can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }

    public function exportToCsv(Request $request, $eventId)
    {
        $input = $request->input();
        
        $index = $input['index'];
        $limit = $input['limit'];
        
        $input = array_intersect_key($input, User::$downloadable);

        if($limit == '') {
            $users = User::select($input)->leftJoin('event_participants', 'users.id', '=', 'event_participants.user_id')->where('event_participants.event_id',$eventId)->get()->toArray();

        } else {
            $users = User::select($input)->leftJoin('event_participants', 'users.id', '=', 'event_participants.user_id')->where('event_participants.event_id',$eventId)->skip($index)->take($limit)->get()->toArray();
        }

        $delimiter=";";

        $filename = "export".time().".csv";

        header('Content-Type: application/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        $f = fopen('php://output', 'w');
        fputcsv($f, $input, $delimiter);

        foreach ($users as $line) { 
            // generate csv lines from the inner arrays
            fputcsv($f, $line, $delimiter); 
        }
    }
}