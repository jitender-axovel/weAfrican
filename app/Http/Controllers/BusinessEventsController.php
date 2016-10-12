<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\BusinessEvent;
use Validator;
use App\Helper;
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
        $events = BusinessEvent::where('business_events.user_id',Auth::id())->select('business_events.*',DB::raw('count(event_users.user_id) AS attending'))->join('event_users','event_users.event_id', '=', 'business_events.id')->groupBy('event_users.event_id')->get();



        return view('business-event.index', compact('events','pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Business Event -create";
        return view('business-event.create', compact('pageTitle'));
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
        
        $event = array_intersect_key($request->input(), BusinessEvent::$updatable);
        $event['user_id'] = Auth::id();
          
        $event = BusinessEvent::create($event);

        $event->save();
      
        $event->slug = Helper::slug($event->title, $event->id);
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

        $input = array_intersect_key($input, BusinessEvent::$updatable);

        $product = BusinessEvent::where('id',$id)->update($input);

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
}