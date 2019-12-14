<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }
    public function showAdminLoginForm(){
        return view('auth.login', ['url'=>'admin']);
    }
    public function adminLogin(Request $request){
        //dd(Auth::check());
        $this->validate($request, [
            'idPegawai' => 'required',
            'password' => 'required'
        ]);
        //dd($request->idPegawai, $request->password);
        $password = Hash::make($request->input('12345678'));
        //dd($password);
        //dd(Hash::check($request->input('pass')));
        //$password = $request->input('pass');
        //$coba = Hash::make('A8765432');
//        try {
            $user = User::find($request->idPegawai);
            if (Auth::guard('admin')->attempt(['idPegawai' =>$request->input('idPegawai'),
                'password'=>$request->input('password'), 'isAdmin'=>'1'])){
                // if successful, then redirect to their intended location
                \session()->regenerate();
                Session::put(['name'=>Auth::user()->name]);
                Session::flash('success', 'Anda telah berhasil login ke sistem');
                return redirect()->intended('/transaction');

//            if (Auth::attempt(['email' =>$request->input('idPegawai'), 'password'=>$request->input('password')])){
//                Session::flash('success', 'Anda telah berhasil login ke sistem');
//                return redirect('/transaction');
//            }
            }
            Session::flash('error', 'Login gagal, mohon mengulangi proses login kembali');
            return redirect()->intended('/')->withInput();

//        }catch (\Exception $e){
//            Session::flash('error', 'Login gagal, mohon mengulangi proses login kembali');
//            return redirect()->intended('/')->withInput();
//        }
    }
    public function logout()
    {

        Auth::guard('admin')->logout();
//        $request->session()->flush();
//        $request->session()->regenerate();
        return redirect()->intended('/');
    }
}
