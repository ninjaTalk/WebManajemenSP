<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Employee;
use App\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('customers') ->join('employees', 'employees.idPegawai', '=', 'customers.idPegawai')
            ->select('employees.name as namePegawai', 'customers.name', 'customers.noKtp',
                'customers.gender', 'customers.alamat', 'customers.idNasabah', 'customers.kodeCollector')->paginate(6);
        return view("Admin.ManageUser.ManageCustomer.ShowCustomer", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Employee::all()->where("isUser", "=", "0");
        return view('Admin.ManageUser.ManageCustomer.AddCustomer', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|max:50',
                'noKtp' => 'required|unique:customers|min:16',
                'alamat' => 'required|max:50',
                'password' => 'required|min:8|max:8',
            ]);
            $data = Customer::all()->where('idPegawai',
                '=', "$request->idPegawai");
            $users = DB::table('employees')->where('idPegawai', $request->idPegawai)->first();
            //$tempKodeCollect = ;
            // dd($users);
            //$countDataonTable = Employee::count();
            $lastUser = DB::table('customers')->orderBy('created_at', 'desc')->first();
            $lastID = $lastUser->idNasabah;
            $incrementID = $lastID + 1;
            //dd($incrementID);
            //dd($request->idPegawai, $users->kodeCollector);
            $kodeTabungan = "$incrementID" . "$users->kodeCollector";

            Customer::create([
                'name' => $request->name,
                'noKtp' => $request->noKtp,
                'gender' => $request->radioGender,
                'alamat' => $request->alamat,
                'password' => $request->password,
                'idPegawai' => $request->idPegawai,
                'kodeCollector' => $users->kodeCollector,
                'kodeTabungan' => "$kodeTabungan",
                'ppNomor' => "-",
            ]);
            Saving::create([
                'kodeTabungan' => $kodeTabungan,
                'name' => $request->name,
            ]);
            $this->makeQR($incrementID, $request->noKtp);
            move_uploaded_file("qr_$incrementID.png", "QR_Image");
            Session::flash('success', 'Penambahan data berhasil');
        }catch (\Exception $e){
            Session::flash('error', 'Penambahan Data GAGAL karena Nomer KTP sudah pernah tersimpan di dabatase');
        }
        return redirect()->intended('/customer');
    }
    public function makeQR($id, $noKtp){
        $file = public_path("\QR_Image\qr_$id.png");
        return \QRCode::text($noKtp)->setOutfile($file)-> png();

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($customer)
    {
        $user = DB::table('customers')->where('idNasabah', $customer)->get();
        return view('Admin.ManageUser.ManageCustomer.EditCustomer', ['data'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $customer)
    {

            $this->validate($request, [
                'name' => 'required|max:50',
                'alamat' => 'required|max:50',
                'password' => 'required|min:8|max:8',
                'noKtp' => [Rule::unique('customers', 'noKtp')
                    ->ignore($customer, 'idNasabah'), 'required']
            ]);
            $dataUser = DB::table('customers')->where('idNasabah', $customer);
            try{
                $dataUser->update([
                    'name' => $request->name,
                    'gender' => $request->radioGender,
                    'alamat' => $request->alamat,
                    'password' => $request->password,
                    'noKtp' => $request->noKtp
                ]);
                Session::flash('success', 'Perubahan data berhasil');
            }catch (\Exception $e){
                Session::flash('error', 'Nomer KTP tidak bisa didaftarkan karena sudah pernah tersimpan di dabatase');
            }
        return redirect()->intended('/customer');
    }

    public function destroy($customer)
    {
        //dd($customer);
        try {
            Session::flash('success', 'Penghapusan data berhasil');
            DB::delete("DELETE FROM customers WHERE idNasabah = '$customer'");
        }catch (\Exception $e){
            Session::flash('success', $e);
        }
        return redirect()->intended('/customer');
    }
}
