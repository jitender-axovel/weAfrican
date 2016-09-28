<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\UserBusiness;
use App\BussinessCategory;

class AdminUserBusinessesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - User Business';
        $businesses = UserBusiness::get();
        return view('admin.business.index', compact('pageTitle', 'businesses'));
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
        $pageTitle = "Admin - Edit User Bussiness Category";
        $business = UserBusiness::find($id);
        $categories = BussinessCategory::where('is_blocked',0)->get();
        return view('admin.business.edit',compact('pageTitle','business', 'categories'));
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

        $input = $request->input();

        $input = array_intersect_key($input, UserBusiness::$updatable);

        $category = UserBusiness::where('id',$id)->update($input);
            
        return redirect('admin/business')->with('success', 'User Business updated successfully');
        
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

    public function block($id)
    {
        $business = UserBusiness::find($id);
        $business->is_blocked = !$business->is_blocked;
        $business->save();

        if ($business->is_blocked) {
            return redirect('admin/business')->with('success', 'User Bussiness has been blocked successfully');
        } else {
            return redirect('admin/business')->with('success', 'User Bussiness has been unblocked');
        }
    }
}
