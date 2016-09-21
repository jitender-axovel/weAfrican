<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\SubscriptionPlan;
use App\Helper;
use Validator;

class AdminSubscriptionPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        $page = 'Subscription Plan- Admin';
        $subscriptions = SubscriptionPlan::orderBy('id','DESC')->get();
        return view('admin.subscriptions.index', compact('page', 'subscriptions'));
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
        $page = "Edit Subscription Plan - Admin";
        $subscription = SubscriptionPlan::find($id);
        return view('admin.subscriptions.edit',compact('subscription','page'));
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
        $validator = Validator::make($request->all(), SubscriptionPlan::$validater 
        );

        if ($validator->fails()) {
            return redirect('admin/subscription/plan/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        $input = $request->input();

        $input = array_intersect_key($input, SubscriptionPlan::$updatable);
        $subscriptions = SubscriptionPlan::where('id',$id)->update($input);
    
        if($subscriptions > 0 ){
            
            return redirect('admin/subscription/plan')->with('success', 'Subscription Updated successfully');
        } else {

            return back()->with('error', 'Subscription could not be updated. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function getBlocked($id)
    {
        $subscription=SubscriptionPlan::find($id);
       
        if($subscription->is_blocked == 0){ 
            $subscription=SubscriptionPlan::where('id', $id)->update(['is_blocked' => '1']);
            return redirect('admin/subscription/plan')->with('success', 'Subscription Plan activated successfully');

        } else if($subscription->is_blocked == 1){ 
            $subscription=SubscriptionPlan::where('id', $id)->update(['is_blocked' => '0']);
            return redirect('admin/subscription/plan')->with('success', 'Subscription Plan deactivated successfully');
        }   
    }
}
