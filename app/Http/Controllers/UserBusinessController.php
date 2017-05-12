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
use Auth;
use Validator;
use App\Helper;
use Illuminate\Support\Facades\Hash;
//use session;
use Session;

class UserBusinessController extends Controller
{
    /**
     * Instantiate a new new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('index', 'show', 'edit', 'update', 'destroy');
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
        $pageTitle  = "Register Business";
        $categories = BussinessCategory::where('is_blocked', 0)->get();
        $term       = CmsPage::where('slug', 'terms-and-conditions')->first();
        return view('business.register', compact('categories', 'pageTitle', 'term'));
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
            'full_name' => 'required|max:255|string',
            'country_code' => 'required|numeric|min:0|max:99',
            'title' => 'required',
            'keywords' =>'required',
            'email' => 'required|email|max:255|unique:user_businesses',
            'user_name' => 'required|max:255|unique:users',
            'mobile_number' => 'required|numeric|unique:users',
            'pin_code' => 'regex:/\b\d{6}\b/',
            'country' => 'string',
            'state' => 'string',
            'city' => 'string',
            'business_logo' => 'image|mimes:jpg,png,jpeg',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }

        $input = $request->input();

        if (isset($input['is_agree_to_terms'])) {
            $input['is_agree_to_terms'] = 1;
        } else {
            $input['is_agree_to_terms'] = 0;
        }
 
        if ($input['is_agree_to_terms'] == 1) {
            if ($request->hasFile('business_logo')) {
                if ($request->file('business_logo')->isValid()) {
                    $file  = $key = md5(uniqid(rand(), true));
                    $ext   = $request->file('business_logo')->
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
            $user                 = array_intersect_key($request->input(), User::$updatable);
            $user['user_role_id'] = 3;
            $user['password']     = bcrypt($input['mobile_number']);
            $user['otp']          = rand(1000, 9999);
            
            $user = User::create($user);
            $user->save();

            $user->slug = Helper::slug($user->full_name, $user->id);
            $user->save();
            

            $business                = array_intersect_key($input, UserBusiness::$updatable);
            $business['business_id'] =substr($input['full_name'], 0, 3).rand(100, 999);
            $business['user_id']     = $user->id;
            if (isset($fileName)) {
                $business['business_logo'] = $image;
            }
           
            $business = UserBusiness::create($business);
            $business->save();
            $value = $request->session()->get('key');
            if ($business) {
                return redirect('login')->with('success', 'You have been successfully registered. Please enter username and password to login!');
            } else {
                return back()->with('error', 'Business could not created successfully.Please try again');
            }
        } else {
            return back()->with('error', 'Please select terms and conditions');
        }
    }

    public function otp()
    {
        Session::put('otp_verify', false);
        $pageTitle = "Otp";
        return view('business.otp', compact('pageTitle'));
    }


    public function resendotp()
    {
        $user_name = Session::get('username');
        $password  = Session::get('password');
        $user      = User::whereUserName($user_name)->first();
        if ($user && Hash::check($password, $user->password)) {
            $user->otp = rand(1000, 9999);
            $user->save();
            Session::put('otp', $user->otp);
            //Send OTP SMS to the registered mobile number
            return redirect('otp')->with('success', 'New OTP has been send to your registerd mobile number');
        } else {
            return redirect('login')->with('warning', 'Your login session has been expired, Please try to login again!');
        }
    }
    public function checkOtp(Request $request)
    {
        $user_name = Session::get('username');
        $password  = Session::get('password');
        if (Session::get('otp')==$request->input('otp')) {
            if (Auth::attempt(['user_name' => $user_name,'password' => $password])) {
                if (Auth::check()) {
                    return redirect()->intended('upload');
                } else {
                    return redirect()->intended('logout');
                }
                //dd(Session::get('username'));
            } else {
                return redirect()->intended('logout');
            }
        } else {
            return redirect('otp')->with('error', 'Please Enter the valid OTP');
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
                 
        if ($request->file('identity_proof')->isValid() && $request->file('business_proof')->isValid()) {
            $indentityFile = $key = md5(uniqid(rand(), true));
            $ext           = $request->file('identity_proof')->
                getClientOriginalExtension();
            $image         = $indentityFile.'.'.$ext;
            
            $businessFile  = $key = md5(uniqid(rand(), true));
            $businessExt   = $request->file('business_proof')->getClientOriginalExtension();
            $businessImage = $businessFile.'.'.$businessExt;

            $indentityFileName = $request->file('identity_proof')->move(config('image.document_path'), $image);
            $BusinessFileName  = $request->file('business_proof')->move(config('image.document_path'), $businessImage);
        } else {
            return back()->with('Error', 'Identity Proof and Bussiness Proof is not uploaded. Please try again');
        }

        $input = $request->input();
   
        $input = array_intersect_key($input, UserBusiness::$updatable);

        $input['identity_proof'] = $image;
        $input['business_proof'] = $businessImage;
           
        $business = UserBusiness::where('user_id', Auth::id())->update($input);

        return redirect('register-business/'.Auth::id())->with('success', 'Document Uploaded successfully');
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
        $business  = UserBusiness::where('user_id', Auth::id())->first();
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
        $pageTitle  = "Bussiness -Edit";
        $business   = UserBusiness::find($id);
        $categories = BussinessCategory::where('is_blocked', 0)->get();
        return view('business.edit', compact('pageTitle', 'business', 'categories'));
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
            'title' => 'required',
            'email' => 'required|email|max:255',
            'keywords' =>'required',
            'address' => 'string',
            'pin_code' => 'regex:/\b\d{6}\b/|integer',
            'country' => 'string',
            'state' => 'string',
            'city' => 'string',
            'secondary_phone_number' => 'numeric',
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
        if ($request->hasFile('business_logo')) {
            if ($request->file('business_logo')->isValid()) {
                $file  = $key = md5(uniqid(rand(), true));
                $ext   = $request->file('business_logo')->
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
        if ($request->hasFile('banner')) {
            if ($request->file('banner')->isValid()) {
                $bannerfile  = $key = md5(uniqid(rand(), true));
                $bannerExt   = $request->file('banner')->
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

        $input = array_intersect_key($input, UserBusiness::$updatable);

        if (isset($fileName)) {
            $input['business_logo'] =  $image;
            $user                   = UserBusiness::where('id', $id)->update($input);
        } elseif (isset($bannerFileName)) {
            $input['banner'] =  $bannerImage;
            $user            = UserBusiness::where('id', $id)->update($input);
        } elseif ((isset($fileName)) && (isset($bannerFileName))) {
            $input['business_logo'] =  $image;
            $input['banner']        =  $bannerImage;
            $user                   = UserBusiness::where('id', $id)->update($input);
        } else {
            $user = UserBusiness::where('id', $id)->update($input);
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
}
