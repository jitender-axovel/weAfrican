<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\BussinessCategory;
use App\UserBusiness;
use App\CmsPage;
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
        $term = CmsPage::where('slug', 'terms-and-conditions')->first();
        return view('business.create', compact('categories','pageTitle', 'term'));
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

            return redirect('upload')->with('success', 'New Business created successfully');
            
        } else {
            return redirect('register-business/create')->with('error', 'Please select terms and conditions');
        }

    }

    public function uploadForm()
    {

        $pageTitle = "Upload Document";
        return view('business.upload', compact('pageTitle'));
    }

     public function uploadDocument(Request $request)
    {

        if($request->file('identity_proof')->isValid() && $request->file('business_proof')->isValid())
        {
            $indentityFile = $key = md5(uniqid(rand(), true));
            $ext = $request->file('identity_proof')->
                getClientOriginalExtension();
            $image = $indentityFile.'.'.$ext; 
            
            $businessFile = $key = md5(uniqid(rand(), true));
            $businessExt = $request->file('business_proof')->getClientOriginalExtension();
            $businessImage = $businessFile.'.'.$businessExt; 

            $indentityFileName = $request->file('identity_proof')->move(config('image.document_path'), $image);
            $BusinessFileName = $request->file('business_proof')->move(config('image.document_path'), $businessImage);
  
        } else {

            return back()->with('Error', 'Identity Proof and Bussiness Proof is not uploaded. Please try again');
        }

        $input = $request->input();
   
        $input = array_intersect_key($input, UserBusiness::$updatable);

        $input['identity_proof'] = $image; 
        $input['business_proof'] = $businessImage;
           
        $business = UserBusiness::where('user_id',Auth::id())->update($input);

        return back()->with('success', 'Document Uploaded successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = "Business Profile";
        $business = UserBusiness::where('user_id',Auth::id())->first();
        return view('business.profile', compact('business', 'pageTitle'));
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