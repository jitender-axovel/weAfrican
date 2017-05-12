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
        Session::put('username', $request->full_name);
        Session::put('password', $request->password);
        $user = User::whereMobileNumber($request->password)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $user->otp = rand(1000, 9999);
            $user->save();
            Session::put('otp', $user->otp);
            Mail::to('madhav@gmail.com')->send(new SendOtp($user));
            // Send OTP SMS To registered Mobile Number
            return view('business.otp', compact('pageTitle'));
        } else {
            return redirect()->back()
            ->withErrors(['password' => 'credentials does not match']);
        }
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->intended('/');
    }
}