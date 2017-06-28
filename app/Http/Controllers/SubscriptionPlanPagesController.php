<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubscriptionPlan;

class SubscriptionPlanPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a plans of Event Subscription Plan of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function event()
    {
        $pageTitle = "We African Event Subscription Plans";
        $flag = 1;
        $plans = SubscriptionPlan::where('title', 'like', '%Event%')->get();
        return view('subscription-plan-pages.event', compact('pageTitle', 'flag', 'plans'));
    }

    /**
     * Display a plans of Sponsor Subscription Plan of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sponsor()
    {
        $pageTitle = "We African Sponsor Subscription Plans";
        $flag = 1;
        $plans = SubscriptionPlan::where('title', 'like', '%Sponsor%')->get();
        return view('subscription-plan-pages.sponsor', compact('pageTitle', 'flag', 'plans'));
    }

    /**
     * Display a plans of Business Banner Subscription Plan of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function banner()
    {
        $pageTitle = "We African Business Subscription Plans";
        $flag = 1;
        $plans = SubscriptionPlan::where('title', 'like', '%Business%')->get();
        return view('subscription-plan-pages.business', compact('pageTitle', 'flag', 'plans'));
    }

    /**
     * Display a plans of Search Subscription Plan of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $pageTitle = "We African Search Subscription Plans";
        $flag = 1;
        $plans = SubscriptionPlan::where('title', 'like', '%Search%')->get();
        return view('subscription-plan-pages.search', compact('pageTitle', 'flag', 'plans'));
    }
}
