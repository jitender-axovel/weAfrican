<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserBusiness;
use App\BussinessCategory;
use App\BussinessSubCategory;

class AjaxController extends Controller
{

	/**
     * Display a Country and Category listing of the ron Admin FCM.
     *
     * @return \Illuminate\Http\Response
     */
    public function countryList(Request $request)
    {
    	$user_role_id = $request->input('user_role');
    	if($user_role_id!="")
    	{
	    	$user_ids = User::where('user_role_id',$user_role_id)->pluck('id');
	    	$list = array();
	    	$list[0] = UserBusiness::whereIn('user_id',$user_ids)->distinct('country')->pluck('id', 'country');
	    	if($user_role_id==3)
	    	{
	    		$list[1] = BussinessCategory::where('is_blocked', 0)->orderBy('id','asc')->pluck('id', 'title');
	    	}
	    	print_r(json_encode($list));
    	}
    	else
    	{
    		$list = UserBusiness::distinct('country')->pluck('id', 'country');
    		print_r(json_encode($list));
    	}
    }

    /**
     * Display a State List on the basis of User role type listing of the ron Admin FCM.
     *
     * @return \Illuminate\Http\Response
     */
    public function stateList(Request $request)
    {
    	$user_role_id = $request->input('user_role');
    	$country = $request->input('country');
    	if($user_role_id!=""){
	    	$user_ids = User::where('user_role_id',$user_role_id)->pluck('id');
	    	$stateList = UserBusiness::whereIn('user_id',$user_ids)->where('country',$country)->distinct('state')->pluck('state');
    	}else
    	{
    		$stateList = UserBusiness::where('country',$country)->distinct('state')->pluck('state');
    	}
    	print_r(json_encode($stateList));

    }

    public function cityList(Request $request)
    {
    	$user_role_id = $request->input('user_role');
    	$country = $request->input('country');
    	$state = $request->input('state');
    	if($user_role_id!=""){
	    	$user_ids = User::where('user_role_id',$user_role_id)->pluck('id');
	    	$cityList = UserBusiness::whereIn('user_id',$user_ids)->where('country',$country)->where('state',$state)->distinct('city')->pluck('city');
    	}else
    	{
    		$cityList = UserBusiness::where('country',$country)->where('state',$state)->distinct('city')->pluck('city');
    	}
    	print_r(json_encode($cityList));

    }

    public function subcategoryList(Request $request)
    {
    	$input = $request->input();
    	$subcategoryList = BussinessSubCategory::whereCategoryId($input['category'])->where('is_blocked', 0)->orderBy('id','asc')->pluck('title', 'id')->toArray();
    	print_r(json_encode($subcategoryList));
    }

    public function categoryList(Request $request)
    {
    	$input = $request->input();
    	$categoryList = BussinessCategory::where('is_blocked', 0)->orderBy('id','asc')->pluck('title', 'id');
    	print_r(json_encode($categoryList));
    }
}
