<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Auth;
use Session;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtp;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

   

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        //Session::put('username', $request->full_name);
        //Session::put('password', $request->password);
        $user = User::whereEmail($request->email)->first();
        if($user)
        {
            if ($user && Hash::check($request->password, $user->password)) {
                if($user->user_role_id==3)
                {
                    if($user->is_verified==1)
                    {
                        if(Auth::attempt(['email' => $request->email,'password' => $request->password]))
                        {
                            if (Auth::check()) {
                                return redirect()->intended('upload');
                            }else
                            {
                                return redirect('login')->with('error', 'Something goes wrong. Please try again!');
                            }
                        }else
                        {
                            return redirect()->back()->withErrors(['password' => 'Credential dos\'nt match!']);
                        }
                    }else
                    {
                        Session::put('is_login', true);
                        Session::put('mobile_number', $user->mobile_number);
                        Session::put('password', $request->password);
                        $user->otp = rand(1000,9999);
                        $user->save();
                        $res = json_decode(app('App\Http\Controllers\UserBusinessController')->sendVerificationCode($user->country_code,$user->mobile_number));
                        if($res->success==true)
                        {
                            $mobile = "+".substr($res->message, strpos($res->message, "+") + 1);
                            $words = explode(" ", $mobile);
                            return redirect('otp')->with('success', 'Please enter the OTP to verify your mobile number to proceed to logged in! OTP has been sent to '.$words[0]." ".preg_replace( "/[^-, ]/", 'X', str_replace(substr($words[1], strrpos($words[1], '-') + 1),"",$words[1])).substr($words[1], strrpos($words[1], '-') + 1).'');
                        }else
                        {
                            return redirect('login')->with('warning', $res->message.'! Please try again!');
                        }
                    }
                }else
                {
                    return redirect('login')->with('error', 'You are not authorized to access!');
                }
            }else
            {
                return redirect()->back()
            ->withErrors(['password' => 'Please enter a Valid Password']);
            }
        }else
        {
            return redirect()->back()
            ->withErrors(['email' => 'Email does not match']);
        }
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->intended('/');
    }
}