<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\BussinessCategory;
use App\SubscriptionPlan;
use App\BusinessProduct;


class ApiController extends Controller
{
    public function __construct()
    {
    	$this->user = new User();
        $this->category = new BussinessCategory();
        $this->subscriptionPlan = new SubscriptionPlan();
        $this->businessProduct = new BusinessProduct();

    }

    public function login(Request $request)
    {
        $response = $this->user->apiLogin($request);
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
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Subscription Plan ']);
    }

    public function getBusinessProducts(Request $request)
    {   
        $input = $request->input();

        $response = $this->businessProduct->apiGetBusinessProducts($input);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Products.']);
    }
}