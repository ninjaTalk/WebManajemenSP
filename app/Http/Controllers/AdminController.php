<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::all()->where("isUser", "=", "1");
        //dd($data);
        return view('Admin.ManageUser.ManageAdmin.ShowAdmin', ['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.ManageUser.ManageAdmin.AddAdmin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $this->validate($request, [
                    'name' => 'required|max:50',
                    'password' => 'required|max:8',
                    'radioGender' => 'required',
                ]
            );
            try {
                Employee::create([
                    'name' => $request->name,
                    'isUser' => "1",
                    'password' => $request->password,
                    'gender' => $request->radioGender,
                ]);
                Session::flash('success', 'Penambahan data berhasil');
                return redirect()->intended('/admins');
            }catch (\Exception $e){
                Session::flash('error', $e);
                return redirect()->intended('/admins');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit($admin)
    {
        $user = DB::table('employees')->where('idPegawai', $admin)->get();
        return view('Admin.ManageUser.ManageAdmin.EditAdmin', ['data'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $admin)
    {
        $this->validate($request, [
            'name'=> 'string|required|max:50',
            'radioGender' => 'required',
            'password' => 'string|required|max:8'
        ]);
        $data = DB::table('employees')->where("idPegawai", $admin);
        try {
            $data->update([
                'name' => $request->name,
                'password' => $request->password,
                'gender' => $request->radioGender,
            ]);
            return redirect()->intended('/admins');
        }catch (\Exception $e){
            Session::flash('error', $e);
            return redirect()->intended('/admins');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($admin)
    {
        try {
            Session::flash('success', 'Penghapusan data berhasil');
            DB::delete("DELETE FROM employees WHERE idPegawai = '$admin'");
        }catch (\Exception $e){
            Session::flash('success', $e);
        }
        return redirect()->intended('/admins');
    }
}
