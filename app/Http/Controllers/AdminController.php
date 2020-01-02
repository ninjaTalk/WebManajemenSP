<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Customer;
use App\Employee;
use App\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use mysql_xdevapi\Exception;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::all()->where("isAdmin", "=", "1");
        //dd($data);
        return view('Admin.ManageUser.ManageAdmin.ShowAdmin', ['data'=>$data]);
    }
    public function showSearch(){
        return view('Admin.search');
    }
    public function fitlerSearch(Request $request){

        $this->validate($request, [
            'keyword' => 'required|min:1|max:20'
        ]);
        $checkBioEmployee = DB::table('employees')->where('idPegawai','like', $request->keyword)->get();
        $checkBioCustomers = Customer::join('employees', 'employees.idPegawai', '=', 'customers.idPegawai')
            ->where('customers.idNasabah','like', $request->keyword)
            ->select('employees.name as namePegawai', 'customers.name', 'customers.noKtp',
                'customers.gender', 'customers.alamat', 'customers.idNasabah', 'customers.kodeCollector')->get();
        $checkSavings = Customer::join('savings','savings.kodeTabungan', '=', 'customers.kodeTabungan')
            ->join('employees', 'employees.idPegawai', '=', 'customers.idPegawai')
            ->where('savings.kodeTabungan','like',  $request->keyword)
            ->select('employees.name as namePegawai', 'customers.name', 'customers.noKtp',
                'savings.kodeTabungan', 'savings.saldo', 'savings.tglLastInput')->get();
        $checkLoans = Loan::where('ppNomor','like',  $request->keyword)->get();

        if (count($checkBioEmployee) >=1){
//            dd($checkBioEmployee);
            $checkIsAdmin = $checkBioEmployee->first();
            if ($checkIsAdmin->isAdmin == '1'){
                return view('Admin.ManageUser.ManageAdmin.ShowAdmin', ['data'=>$checkBioEmployee]);
            }else{
                return view('Admin.ManageUser.ManageEmployee.ShowEmployee', ['data'=>$checkBioEmployee]);
            }
        }else if (count($checkBioCustomers)>=1){
//            dd($checkBioCustomers);
            return view("Admin.ManageUser.ManageCustomer.ShowCustomer", ['data'=>$checkBioCustomers]);
        }else if (count($checkSavings)>=1){
            return view('Admin.ManageSaving.homeSaving', ['data'=>$checkSavings]);
        }else if (count($checkLoans)>=1){
            return view('Admin.ManageLoan.homeLoan', ['data'=>$checkLoans]);
        }else{
            Session::flash('error', 'Data tidak ditemukan');
            return redirect()->intended('/search');
        }


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
                    'password' => 'required|min:8',
                    'radioGender' => 'required',
                ]
            );
            $hashPass = Hash::make($request->input('password'));
            try {
                Employee::create([
                    'name' => $request->name,
                    'isAdmin' => '1',
                    'password' => $hashPass,
                    'gender' => $request->radioGender,
                ]);
                Session::flash('success', 'Penambahan data berhasil');
                return redirect()->intended('/admins');
            }catch (\Exception $e){
                Session::flash('error', $e);
                return redirect()->intended('/admins')->withInput();
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
