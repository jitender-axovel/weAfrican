<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\BusinessBanner;
use Validator;

class AdminBusinessBannersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Banners- Admin';
        $banners = BusinessBanner::get();
        return view('admin.banners.index', compact('page', 'banners'));
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
        $pageTitle = "Edit Banner - Admin";
        $banner = BusinessBanner::find($id);
        return view('admin.banners.edit',compact('banner','pageTitle'));
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
        $banner = BusinessBanner::find($id);

        if (!$banner) {
            return back()->with('error', 'Sorry, the banner you requested does not exists');
        }

        $validator = Validator::make($request->input(), BusinessBanner::$validator);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = array_intersect_key($request->input(), BusinessBanner::$updatable);

        if ($banners->update($input)){
            return redirect('admin/banner')->with('success', 'Banner Updated successfully');
        } else {
            return back()->with('error', 'Banner could not be updated. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = BusinessBanner::findOrFail($id);
        if ($banner->delete()) {
            $response = array(
                'status' => 'success',
                'message' => ' Banner Plan deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Banner Plan can not be deleted.Please try again',
            );
        }
        return json_encode($response);
    }

    public function block($id)
    {
        $banner = BusinessBanner::find($id);
        $banner->is_blocked = !$banner->is_blocked;
        $banner->save();

        if ($banner->is_blocked == 1) {
            return redirect('admin/banner')->with('success', 'Banner unblocked successfully');
        } else if ($banner->is_activated == 1){
            return redirect('admin/banner')->with('success', ' Banner blocked successfully');
        }
    }
}