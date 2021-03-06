<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\BusinessEvent;
use Auth;
use DB;

class AdminBusinessEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $pageTitle = 'Business Event- Admin';
        $events = BusinessEvent::select('business_events.*', 'user_businesses.business_id', 'user_businesses.title as business_name')->leftJoin('user_businesses','business_events.user_id' , '=', 'user_businesses.user_id')->withCount('participations')->get();
        return view('admin.events.index', compact('pageTitle', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Respons
e     */
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
       
    }

    /**
     * Block the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        $event = BusinessEvent::find($id);
        $event->is_blocked = !$event->is_blocked;
        $event->save();

        if ($event->is_blocked) { 
            return back()->with('success', 'Business Event blocked successfully');
        } else {
            return back()->with('success', 'Business Event unblocked successfully');
        }   
    }

    public function destroy($id)
    {
        $event = BusinessEvent::findOrFail($id);

        if($event->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Business Event deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Business Event can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }
}