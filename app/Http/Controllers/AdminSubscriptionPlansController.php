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
        $subscriptions = SubscriptionPlan::get();
        return view('admin.subscriptions.index', compact('page', 'subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = "Create Subscription Plan - Admin";
        return view('admin.subscriptions.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->input(), SubscriptionPlan::$validater 
        );

        if ($validator->fails()) {
            if($request->ajax()) {
                return json_encode($validator->errors()->all());
            } 
        }

        $input = $request->input();
  
            $input = array_intersect_key($input,SubscriptionPlan::$updatable);
            $subscription = new SubscriptionPlan();
            $subscription->name = $input['name'];
            $subscription->product_limit = $input['product_limit'];
            $subscription->service_limit = $input['service_limit'];
            $subscription->price = $input['price'];
            $subscription->save();

            if($request->ajax()) {
                return json_encode(['status' => 'success','url' => url('admin/subscription/plan')]);
            } else {
                return back();
            }
            
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscription = SubscriptionPlan::findOrFail($id);
        if($subscription->delete()){
            $response = array(
                'status' => 'success',
                'message' => ' Subscription Plan deleted  successfully',
            );
             return json_encode($response);
        } else {
            $response = array(
                'status' => 'error',
                'message' => ' Subscription
                Plan can not be deleted.Please try again',
            );
             return json_encode($response);

        }
    }

    public function isActivated($id)
    {
        $subscription=SubscriptionPlan::find($id);
       
        if($subscription->is_activated == 0){ 
            $subscription=SubscriptionPlan::where('id', $id)->update(['is_activated' => '1']);
            return redirect('admin/subscription/plan')->with('success', 'Subscription Plan activated successfully');

        } else if($subscription->is_activated == 1){ 
           $subscription=SubscriptionPlan::where('id', $id)->update(['is_activated' => '0']);
            return redirect('admin/subscription/plan')->with('success', 'Subscription Plan deactivated successfully');
        }   
    }
}
