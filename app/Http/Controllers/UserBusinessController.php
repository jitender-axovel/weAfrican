<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\BussinessCategory;
use App\UserBusiness;
use App\CmsPage;
use App\User;
use App\CountryList;
use App\SecurityQuestion;
use App\BussinessSubcategory;
use Auth;
use Validator;
use App\Helper;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewRegisterBusiness;
use App\Mail\SendOtp;


class UserBusinessController extends Controller
{
    /**
     * Instantiate a new new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('index','show', 'edit', 'update', 'destroy');
        $this->user = new User();

    }

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
        $securityquestions = SecurityQuestion::where('is_blocked',0)->get();
        $term = CmsPage::where('slug', 'terms-and-conditions')->first();
        return view('business.register', compact('categories','pageTitle', 'term', 'securityquestions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $rules = array(
            'salutation' => 'required',
            'first_name' => 'required|max:255|string',
            'last_name' => 'required|max:255|string',
            'country_code' => 'required|numeric|min:0|max:99',
            'title' => 'required',
            'keywords' =>'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:5|max:255',
            'confirm_password' => 'required|min:5|max:255|same:password',
            'mobile_number' => 'required|numeric|unique:users',
            'pin_code' => 'regex:/\b\d{6}\b/',
            'country' => 'string',
            'state' => 'string',
            'city' => 'string',
            'business_logo' => 'image|mimes:jpg,png,jpeg',
            'bussiness_category_id' => 'required',
            'security_question_id' => 'required',
            'security_question_ans' => 'required|max:255|string',
            );
        if($input['bussiness_category_id']==1 || $input['bussiness_category_id']==2)
        {
            $rules['maritial_status'] = 'required';
            $rules['occupation'] = 'required|string';
            $rules['key_skills'] = 'required|string';
            $rules['academic'] = 'required';
            $input['is_update'] = 1;
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->messages();
            if ($messages->has('email'))
            {
                return back()->with('error', 'You are already registered with us , <a href="#">Please click here to Login</a>')->withInput();
            }else
            {
                return back()->withErrors($validator)
                         ->withInput();
            }
        }

        if(isset($input['is_agree_to_terms']))
            $input['is_agree_to_terms'] = 1;
        else 
            $input['is_agree_to_terms'] = 0;
        
        if($input['is_agree_to_terms'] == 1)
        { 
            if ($request->hasFile('business_logo') ){
                if ($request->file('business_logo')->isValid())
                {
                    $file = $key = md5(uniqid(rand(), true));
                    $ext = $request->file('business_logo')->
                        getClientOriginalExtension();
                    $image = $file.'.'.$ext; 

                    $fileName = $request->file('business_logo')->move(config('image.logo_image_path'), $image);

                    $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/small/'.$image;
                    shell_exec($command);

                    $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/medium/'.$image;
                    shell_exec($command);

                    $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/large/'.$image;
                    shell_exec($command);
                }
            }
            $user = array_intersect_key($request->input(), User::$updatable);
            $user['email'] = $input['email'];
            $user['user_role_id'] = 3;
            $user['password'] = bcrypt($input['password']);
            $user['otp'] = rand(1000,9999);
            $user = User::create($user);
            $user->save();

            $user->slug = Helper::slug($user->first_name, $user->id);
            
            $user->save();

            $business = array_intersect_key($input, UserBusiness::$updatable);

            $business['business_id']=substr($input['first_name'],0,3).rand(100,999);
            $business['user_id'] = $user->id;
            if(isset($fileName)){
                $business['business_logo'] = $image;
            }
            if($business['bussiness_subcategory_id']=="")
            {
                unset($business['bussiness_subcategory_id']);
            }
            $business = UserBusiness::create($business);
            $business->save();
            $value = $request->session()->get('key');
            if($business)
            {
                Session::put('mobile_number', $input['mobile_number']);
                Session::put('email', $input['email']);
                Session::put('otp', $user['otp']);
                Session::put('is_login', false);
                Mail::to('madhav@gmail.com')->send(new NewRegisterBusiness($user));
                Mail::to('madhav@gmail.com')->send(new SendOtp($user));
                if( count(Mail::failures()) > 0 ) {

                   return redirect('emailVerify')->with('warning', 'Mail Cannot be sent! Please try to resend the OTP!');

                   foreach(Mail::failures as $email_address) {
                       echo " - $email_address <br />";
                    }

                } else {
                    return redirect('emailVerify')->with('success', 'You have been successfully registered. OTP has been sent to '.$input['email'].'.Please enter the OTP!');
                }
                /*$res = json_decode($this->sendVerificationCode($input['country_code'],$input['mobile_number']));*/
                /*if($res->success==true)
                {
                    $mobile = "+".substr($res->message, strpos($res->message, "+") + 1);
                    $words = explode(" ", $mobile);
                    return redirect('otp')->with('success', 'You have been successfully registered. OTP has been sent to '.$words[0]." ".preg_replace( "/[^-, ]/", 'X', str_replace(substr($words[1], strrpos($words[1], '-') + 1),"",$words[1])).substr($words[1], strrpos($words[1], '-') + 1).'.Please enter the OTP!');
                }else
                {
                    return redirect('otp')->with('warning', $res->message.'! Please try to resend the OTP!');
                }*/
            }else{
                return back()->with('error', 'Business could not created successfully.Please try again'); 
            }    
        } else {
            return back()->with('error', 'Please select terms and conditions');
        }
    }

    public function otp()
    {
        Session::put('otp_verify', false);
        $pageTitle = "Email Verification";
        return view('business.otp', compact('pageTitle'));
    }

    public function checkOtp(Request $request)
    {
        $mobile_number = Session::get('mobile_number');
        $email = Session::get('email');
        $otp = Session::get('otp');
        $is_login = Session::get('is_login');
        $password = Session::get('password');
        $user = User::whereEmail($email)->first();
        /*$res = json_decode($this->verifyVerificationCode($user->country_code,$user->mobile_number,$request->input('otp')));*/
        /*if($res->success==true){*/
        if($request->input('otp')==$otp){
            $user->is_verified = 1;
            $user->save();
            Session::forget('mobile_number');Session::forget('email');Session::forget('otp');Session::forget('is_login');Session::forget('password');
            if($is_login)
            {
                if(Auth::attempt(['email' => $user->email,'password' => $password]))
                {
                    if (Auth::check()) {
                        return redirect()->intended('upload');
                    }else
                    {
                        return redirect('login')->with('error', 'Something goes wrong. Please try again!');
                    }
                }else
                {
                    return redirect('login')->with('error', 'Credential dos\'nt match!');
                }
            }else
            {
                return redirect('login')->with('success', 'Your Email is successfully verified. Please enter Email and Password to login!');
            }
        } else {
            return redirect('emailVerify')->with('error', 'OTP dos\'t match ! Please Enter the valid OTP');
        }
    }

    public function resendotp()
    {
        $mobile_number = Session::get('mobile_number');
        $email = Session::get('email');
        $user= User::whereEmail($email)->first();
        if ($user) {
            Session::put('otp', rand(1000,9999));
            $user->otp = Session::get('otp');
            $user->save();
            /*$res = json_decode($this->sendVerificationCode($user->country_code,$user->mobile_number));*/
            Mail::to('madhav@gmail.com')->send(new SendOtp($user));
            if( count(Mail::failures()) > 0 ) {

               return redirect('emailVerify')->with('warning', 'Mail Cannot be sent! Please try to resend the OTP!');

               foreach(Mail::failures as $email_address) {
                   echo " - $email_address <br />";
                }

            } else {
                return redirect('emailVerify')->with('success', 'New OTP has been send to your registerd email address. OTP has been sent to '.$email.'.Please enter the OTP!');
            }
            /*if($res->success==true)
            {
                $mobile = "+".substr($res->message, strpos($res->message, "+") + 1);
                $words = explode(" ", $mobile);
                return redirect('otp')->with('success', 'New OTP has been send to your registerd mobile number. OTP has been sent to '.$words[0]." ".preg_replace( "/[^-, ]/", 'X', str_replace(substr($words[1], strrpos($words[1], '-') + 1),"",$words[1])).substr($words[1], strrpos($words[1], '-') + 1).'');
            }else
            {
                return redirect('otp')->with('warning', $res->message.'! Please try to resend the OTP!');
            }*/
        } else {
            return redirect('login')->with('warning', 'Your login session has been expired, Please try to login again!');
        }
    }

    public function uploadForm()
    {
        $pageTitle = "Upload Document";
        return view('business.upload', compact('pageTitle'));
    }

    public function uploadDocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identity_proof' => 'mimes:jpeg,bmp,png,doc,docx,pdf',
            'business_proof' => 'mimes:jpeg,bmp,png,doc,docx,pdf',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }
                 
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

        return redirect('register-business/'.Auth::id())->with('success', 'Document Uploaded successfully');
    }

    /**
     * Send the Verification Code to the Registerd Mobile Number
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendVerificationCode($country_code,$mobile_number)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.authy.com/protected/json/phones/verification/start?via=sms&country_code=".$country_code."&phone_number=".$mobile_number."&locale=en",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "x-authy-api-key: SKunwdncmh5Xq5o2a6LweCDe7f7zKvbh",
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return $response;
        }
    }

    /**
     * Verify the OTP 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verifyVerificationCode($country_code,$mobile_number,$verification_code)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.authy.com/protected/json/phones/verification/check?country_code=".$country_code."&phone_number=".$mobile_number."&verification_code=".$verification_code,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "x-authy-api-key: SKunwdncmh5Xq5o2a6LweCDe7f7zKvbh"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return $response;
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
        $pageTitle = "Bussiness -Edit";
        $business = UserBusiness::find($id);
        $categories = BussinessCategory::where('is_blocked',0)->get();
        $subcategories = BussinessSubcategory::where('category_id',$business->bussiness_category_id)->get();
        return view('business.edit',compact('pageTitle','business','categories','subcategories'));
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
        $validator = Validator::make($request->all(), [
            'salutation' => 'required',
            'first_name' => 'required|max:255|string',
            'last_name' => 'required|max:255|string',
            'title' => 'required',
            'keywords' =>'required',
            'address' => 'string',
            'pin_code' => 'regex:/\b\d{6}\b/|integer',
            'country' => 'string',
            'state' => 'string',
            'city' => 'string',
            'about_us' => 'string',
            'working_hours' => 'string',
            'business_logo' => 'image|mimes:jpg,png,jpeg',
            'banner' => 'image|mimes:jpg,png,jpeg',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }

        $input = $request->input();
        if ($request->hasFile('business_logo') ){
            if ($request->file('business_logo')->isValid())
            {
                $file = $key = md5(uniqid(rand(), true));
                $ext = $request->file('business_logo')->
                    getClientOriginalExtension();
                $image = $file.'.'.$ext; 

                $fileName = $request->file('business_logo')->move(config('image.logo_image_path'), $image);

                $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/small/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/large/'.$image;
                shell_exec($command);
            }
        }
        if ($request->hasFile('banner') ){
            if ($request->file('banner')->isValid())
            {
                $bannerfile = $key = md5(uniqid(rand(), true));
                $bannerExt = $request->file('banner')->
                    getClientOriginalExtension();
                $bannerImage = $bannerfile.'.'.$bannerExt; 

                $bannerFileName = $request->file('banner')->move(config('image.banner_image_path').'business/', $bannerImage);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'business/'.$bannerImage.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.banner_image_path').'business/thumbnails/small/'.$bannerImage;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'business/'.$bannerImage.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.banner_image_path').'business/thumbnails/medium/'.$bannerImage;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'business/'.$bannerImage.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.banner_image_path').'business/thumbnails/large/'.$bannerImage;
                shell_exec($command);
            }
        }

        $business_input = array_intersect_key($input, UserBusiness::$updatable);
        $user_id = UserBusiness::where('id',$id)->first()->user_id;
        $user_input = array_intersect_key($input, User::$updatable);

        if(isset($fileName)) {
            $business_input['business_logo'] =  $image;
            $business = UserBusiness::where('id',$id)->update($business_input);
            $user = User::where('id',$user_id)->update($user_input);
        } else if(isset($bannerFileName)){
            $business_input['banner'] =  $bannerImage;
            $business = UserBusiness::where('id',$id)->update($business_input);
            $user = User::where('id',$user_id)->update($user_input);
        } else if((isset($fileName)) && (isset($bannerFileName))){
            $business_input['business_logo'] =  $image;
            $business_input['banner'] =  $bannerImage;
            $business = UserBusiness::where('id',$id)->update($business_input);
            $user = User::where('id',$user_id)->update($user_input);
        } else {
            $business = UserBusiness::where('id',$id)->update($business_input);
            $user = User::where('id',$user_id)->update($user_input);
        }

        return redirect('register-business/'.$id)->with('success', 'User Business updated successfully');
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
     * Show the form for Updating a User Mobile Number.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeMobile()
    {
        $pageTitle = "Change Mobile Number";
        $categories = BussinessCategory::where('is_blocked',0)->get();
        $term = CmsPage::where('slug', 'terms-and-conditions')->first();
        return view('business.change', compact('categories','pageTitle', 'term'));
    }

    /**
     * Update Mobile number
     *
     * @return \Illuminate\Http\Response
     */
    public function updateMobile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|numeric',
            'password' => 'required|min:5|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }
        $input = $request->input();
        $mobile_number = Session::get('mobile_number');
        $is_login = Session::get('is_login');
        $password = Session::get('password');
        if($password!=$input['password'])
        {
            return back()->with('error.password', 'Password dosn\'t match. Please enter a valid password to continue !');
        }else
        {
            $user = User::whereMobileNumber($mobile_number)->first();
            $user->mobile_number = $input['mobile_number'];
            $user->save();
            $res = json_decode($this->sendVerificationCode($user->country_code,$input['mobile_number']));
            if($res->success==true)
            {
                Session::put('mobile_number',$input['mobile_number']);
                $mobile = "+".substr($res->message, strpos($res->message, "+") + 1);
                $words = explode(" ", $mobile);
                return redirect('otp')->with('success', 'You have been successfully registered. OTP has been sent to '.$words[0]." ".preg_replace( "/[^-, ]/", 'X', str_replace(substr($words[1], strrpos($words[1], '-') + 1),"",$words[1])).substr($words[1], strrpos($words[1], '-') + 1).'.Please enter the OTP!');
            }else
            {
                return redirect('otp')->with('warning', $res->message.'! Please try to resend the OTP!');
            }
        }
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