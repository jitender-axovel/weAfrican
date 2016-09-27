<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\BussinessCategory;
use App\UserBusiness;
use Auth;
use Validator;

class UserBusinessController extends Controller
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
        $pageTitle = "Register Business";
        $categories = BussinessCategory::where('is_blocked',0)->get();
        return view('business.create', compact('categories','pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'keywords' =>'required',
            'about_us' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pin_code' => 'required|numeric|min:6',
            'email' => 'required',
            'secondary_phone_number' => 'required|numeric|min:10',
            'working_hours' => 'required',
            'phone_number' => 'required|numeric|min:10'
        ]);

        if ($validator->fails()) {
            return redirect('register-business/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $input = $request->input();
             
        if(isset($input['is_agree_to_terms']))
            $input['is_agree_to_terms'] = 1;
        else 
            $input['is_agree_to_terms'] = 0;

        if($input['is_agree_to_terms'] == 1)
        { 

            $input = array_intersect_key($input, UserBusiness::$updatable);

            $input['user_id'] = Auth::id();
            $input['title'] = $input['title'];
            $input['bussiness_category_id'] = $input['bussiness_category_id'];
            $input['keywords'] = $input['keywords'];
            $input['about_us'] = $input['about_us'];
            $input['address'] = $input['address'];
            $input['city'] = $input['city'];
            $input['email'] = $input['email'];
            $input['pin_code'] = $input['pin_code'];
            $input['phone_number'] = $input['phone_number'];
            $input['secondary_phone_number'] = $input['secondary_phone_number'];
            $input['working_hours'] = $input['working_hours'];
            


            $business = UserBusiness::create($input);
            $business->save();

            return redirect('register-business/create')->with('success', 'New Business created successfully');
        } else {
            return redirect('register-business/create')->with('error', 'Please select terms and conditions');
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
        //
    }
}
