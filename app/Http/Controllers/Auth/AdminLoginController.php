<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class AdminLoginController extends Controller
{
    public function __construct(){
        $this->middleware('guest:admin')->except('logout');
    }
    public function showLoginForm(){
        return view('auth.admin-login');
    }
    public function login(Request $request){
        //validate form data
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
      
        //attemp to log the company in

        if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password],
            $request->filled('remember'))){
            //successfully logged in
            return redirect()->intended(route('admin.dashboard'));
        }else{
            return redirect()->back()
            ->withInput($request->only($request->email, 'remember'))
            ->withErrors([
                'email' => 'credentials do not match with our database.',
            ]);
        }
    }
    public function logout(Request $request)
    {
        auth('admin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        $request->session()->invalidate();
        return redirect('/admin/login');
    }
}
