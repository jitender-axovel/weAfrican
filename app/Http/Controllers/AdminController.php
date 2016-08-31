<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
	public function index() {
        return view('admin.dashboard');
    }

    public function login(){ 
    	if(Auth::check() && (Auth::user()->user_role_id == 1)) {
            return redirect('admin/dashboard');
        }
        elseif(Auth::check()) {
            return redirect('/');
        }
        
    	return view('admin.login');
    }

    public function postLogin(Request $request)
    { 
    	if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'user_role_id' => 1])) {
            // Authentication passed...
            return redirect()->intended('admin/dashboard');
        } else {
            $errors = new MessageBag(['email' => ['These credentials do not match our records.']]);
            return back()->withErrors($errors)->withInput(Input::except('password'));
        }
    }

    public function logout()
    {
    
    }
}
