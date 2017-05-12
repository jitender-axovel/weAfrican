<<<<<<< HEAD
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function login()
    {
        $pageTitle = 'Admin-login';

        if (Auth::check() && (Auth::user()->user_role_id == 1)) {
            return redirect('admin/dashboard');
        } elseif (Auth::check()) {
            return redirect('/');
        }
        
        return view('admin.login', compact('pageTitle'));
    }

    public function postLogin(Request $request)
    {
        if (Auth::attempt(['mobile_number' => $request->input('mobile_number'), 'password' => $request->input('password'), 'user_role_id' => 1])) {
            // Authentication passed...
            return redirect()->intended('admin/dashboard');
        } else {
            $errors = new MessageBag(['mobile_number' => ['These credentials do not match our records.']]);
            return back()->withErrors($errors)->withInput(Input::except('password'));
        }
    }

    public function logout()
    {
    }
}
=======
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
        $pageTitle = 'Admin-login';

    	if (Auth::check() && (Auth::user()->user_role_id == 1)) {
            return redirect('admin/dashboard');
        }
        elseif(Auth::check()) {
            return redirect('/');
        }
        
    	return view('admin.login', compact('pageTitle'));
    }

    public function postLogin(Request $request)
    {
    	if (Auth::attempt(['mobile_number' => $request->input('mobile_number'), 'password' => $request->input('password'), 'user_role_id' => 1])) {
            // Authentication passed...
            return redirect()->intended('admin/dashboard');
        } else {
            $errors = new MessageBag(['mobile_number' => ['These credentials do not match our records.']]);
            return back()->withErrors($errors)->withInput(Input::except('password'));
        }
    }

    public function logout()
    {

    }
}
>>>>>>> 8c39c53ea005b053df66154f2fe2a9daa6de81c2
