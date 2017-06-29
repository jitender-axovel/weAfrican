<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessBanner;
use App\HomePageBanner;
use App\EventBanner;
use Auth;

class MyAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "My Account | WeAfrican";
        return view('my-account.index', compact('pageTitle'));
    }

    /**
     * Display a Business Banners List.
     *
     * @return \Illuminate\Http\Response
     */
    public function businessBanners()
    {
        $pageTitle = "Business Banners | WeAfrican";
        $businessBanners = BusinessBanner::where('user_id', Auth::id())->get();
        return view('my-account.business', compact('pageTitle','businessBanners'));
    }

    /**
     * Display a Sponsor Banners List.
     *
     * @return \Illuminate\Http\Response
     */
    public function sponsorBanners()
    {
        $pageTitle = "Sponsor Banners | WeAfrican";
        $homeBanners = HomePageBanner::where('user_id', Auth::id())->get();
        return view('my-account.sponsor', compact('pageTitle','homeBanners'));
    }

    /**
     * Display a Event Banners List.
     *
     * @return \Illuminate\Http\Response
     */
    public function eventBanners()
    {
        $pageTitle = "Event Banners | WeAfrican";
        $eventBanners = EventBanner::where('user_id', Auth::id())->get();
        return view('my-account.event', compact('pageTitle','eventBanners'));
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
}
