<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Employee;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::where("isAdmin", "=", "0")->paginate(6);
        //dd($data);
        return view('Admin.ManageUser.ManageEmployee.ShowEmployee', ['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.ManageUser.ManageEmployee.AddEmployee');
    }
    public function changeCollector(Request $request){
        $dataUser = DB::table('customers')->where('kodeCollector', '=', $request->kodeCollector);
        $dataEmployee = DB::table('employees')->where('idPegawai', '=', $request->idPegawai)->first();
        $dataUser->update([
            'kodeCollector' =>$dataEmployee->kodeCollector,
            'idPegawai' =>$request->idPegawai
        ]);
        return redirect()->intended('/customer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            //dd(Employee::count());
            $this->validate($request, [
                    'name' => 'required|max:50',
                    'password' => 'required|max:8',
                    'radioGender' => 'required',
                    'kodeCollector' => 'required|unique:employees|max:1'
                ]
            );
            try {
                Employee::create([
                    'name' => $request->name,
                    'isAdmin' => "0",
                    'password' => $request->password,
                    'gender' => $request->radioGender,
                    'kodeCollector' => $request->kodeCollector
                ]);
                Session::flash('success', 'Penambahan data berhasil');
                return redirect()->intended('/employee');
            }catch (\Exception $e){
                Session::flash('error', $e);
                return redirect()->intended('/employee');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($employee)
    {
        //d($id->name);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($employee)
    {
        $user = DB::table('employees')->where('idPegawai', $employee)->get();
        return view('Admin.ManageUser.ManageEmployee.EditEmployee', ['data'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employee)
    {
        $this->validate($request, [
            'name'=> 'string|required|max:50',
            'radioGender' => 'required',
            'password' => 'string|required|min:8|max:8'
        ]);
        $data = DB::table('employees')->where("idPegawai", $employee);
        try {
            $data->update([
                'name' => $request->name,
                'isAdmin' => "0",
                'password' => $request->password,
                'gender' => $request->radioGender,
            ]);
            return redirect()->intended('/employee');
        }catch (\Exception $e){
            Session::flash('error', $e);
            return redirect()->intended('/employee');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($employee)
    {
        $dataEmplo = DB::table('employees')->where('idPegawai',  $employee)->first();
        //dd($data->kodeCollector);
//        try {
            $getCol = $dataEmplo->kodeCollector;
            Session::flash('success', 'Penghapusan data berhasil');
            DB::delete("DELETE FROM employees WHERE idPegawai = '$employee'");
            $data = Employee::all()->where("isAdmin", "=", "0");
            $capsule = [
                'data' =>$data,
                'user' =>$getCol
            ];
            return view('Admin.ManageUser.ManageEmployee.switchCollector', ['data'=>$capsule]);
//        }catch (\Exception $e){
//            Session::flash('error', $e);
//        }
        return redirect()->intended('/employee');
    }
}
