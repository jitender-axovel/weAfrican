<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserBusiness;
use App\BussinessCategory;
use App\BussinessSubCategory;
use App\CountryList;

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
	    	$list = array();
	    	$list[0] = User::distinct('country')->pluck('id', 'country');
	    	if($user_role_id==3)
	    	{
	    		$list[1] = BussinessCategory::where('is_blocked', 0)->where('parent_id',0)->orderBy('id','asc')->pluck('id', 'title');
	    	}
	    	print_r(json_encode($list));
    	}
    	else
    	{
    		$list = User::distinct('country')->pluck('id', 'country');
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
    	$stateList = User::where('country',$country)->distinct('state')->pluck('state');
    	print_r(json_encode($stateList));

    }

    public function cityList(Request $request)
    {
    	$user_role_id = $request->input('user_role');
    	$country = $request->input('country');
    	$state = $request->input('state');
	    $cityList = User::where('country',$country)->where('state',$state)->distinct('city')->pluck('city');
    	print_r(json_encode($cityList));

    }

    public function subcategoryList(Request $request)
    {
    	$input = $request->input();
    	$subcategoryList = BussinessCategory::where('parent_id',$input['category'])->where('is_blocked', 0)->orderBy('id','asc')->pluck('title', 'id')->toArray();
    	print_r(json_encode($subcategoryList));
    }

    public function categoryList(Request $request)
    {
    	$input = $request->input();
    	$categoryList = BussinessCategory::where('is_blocked', 0)->orderBy('id','asc')->pluck('title', 'id');
    	print_r(json_encode($categoryList));
    }

    /**
     * Method to get country details from restcountries.eu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function countryDetails(Request $request)
    {
        $input = $request->input();
        $country = $input['country'];
        $details = CountryList::whereCountry($country)->first();
        if($details)
        {
            print_r(json_encode(array('country_code' => $details->country_calling_code, 'currency' => $details->country_currency_code)));
        }else
        {
            return "";
        }
    }
}
