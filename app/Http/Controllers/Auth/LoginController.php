<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Koperasi_profile;
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
        $data = Koperasi_profile::where('id', "=", 1)->first();
        //dd($data->name);
        return view('auth.login', ['url'=>'admin', 'data'=>$data]);
    }
    public function adminLogin(Request $request){
        //dd(Auth::check());
        $this->validate($request, [
            'idPegawai' => 'required',
            'password' => 'required'
        ]);
       // $password = Hash::make($request->input('12345678'));

            if (Auth::guard('admin')->attempt(['idPegawai' =>$request->input('idPegawai'),
                'password'=>$request->input('password'), 'isAdmin'=>'1'])){
                // if successful, then redirect to their intended location
                $data = Koperasi_profile::find($request->koperasiID);
                \session()->regenerate();
                Session::put([
                    'name'=>Auth::user()->name,
                    'idPegawai'=>$request->idPegawai,
                    'koperasiName'=>$data->name,
                   ]);
                Session::flash('success', 'Anda telah berhasil login ke sistem');
                return redirect()->intended('/transaction');
            }
            Session::flash('error', 'Login gagal, mohon mengulangi proses login kembali');
            return redirect()->intended('/')->withInput();

    }
    public function logout()
    {

        Auth::guard('admin')->logout();
        return redirect()->intended('/');
    }
}
