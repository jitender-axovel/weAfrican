<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\BussinessCategory;
use App\SubscriptionPlan;


class ApiController extends Controller
{
    public function __construct()
    {
    	$this->user = new User();
        $this->category = new BussinessCategory();
        $this->subscriptionPlan = new SubscriptionPlan();

    }
    
    public function register(Request $request)
    {
    	$input = $request->input();
    	$response = $this->user->apiRegister($input);
   		return $response;
    }

    public function login(Request $request)
    {
        $input = $request->input();
        $response = $this->user->apiLogin($input);
        return $response;
    }

    public function getCategories()
    {
        $response = $this->category->apiGetCategory();
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any category ']);
    }

    public function getSubscriptionPlans()
    {
        $response = $this->subscriptionPlan->apiGetSubscriptionPlans();
        if($response != NULL)
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Subscription Plan ']);
    }

}
