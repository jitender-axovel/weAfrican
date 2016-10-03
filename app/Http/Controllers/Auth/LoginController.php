<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use Auth;

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

    use AuthenticatesUsers;

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

    public function username()
    {    
        return 'mobile_number';
    }

    public function postLogin(Request $request)
    {
        dd($request->input());
        $this->validate($request, [
            'full_name' => 'required', 'mobile_number' => 'required',
        ]);

        if ($this->auth->validate(['full_name' => $request->full_name, 'mobile_number' => $request->mobile_number, 'is_blocked' => 0])) {
            return redirect($this->loginPath())
                ->withInput()
                ->withErrors('Your account is Inactive or not verified');
        }
        $credentials  = array('full_name' => $request->full_name, 'mobile_number' => $request->mobile_number);
        if ($this->auth->attempt($credentials, $request->has('remember'))){
                return redirect()->intended($this->redirectPath());
        }
        return redirect($this->loginPath())
            ->withInput()
            ->withErrors([
                'full_name' => 'Incorrect name or mobile no',
            ]);
    }
}