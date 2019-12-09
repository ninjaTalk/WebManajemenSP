<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        return view('LoginForm.login');
    }
    public function postLogin(Request $request){
        $this->validate($request,[
           'id'=> 'required',
            'password'=>'required'
        ]);
        $details =$request->only('id', 'password');
        if (Auth::attempt($details)){
            return redirect()->intended('/');
        }if (\auth()->user())
        return Redirect::to('LoginForm.login')->withSuccess('Oppes! You have entered invalid credentials');
    }
    public function dashboard(){
        if (Auth::check()){
            return view('/');
        }
        return Redirect::to('LoginForm.login')->withSuccess('Oppes! You have entered invalid credentials');
    }
    public function logOut(){
        Session::flush();
        Auth::logout();
        return redirect('LoginForm.login');
    }
}
