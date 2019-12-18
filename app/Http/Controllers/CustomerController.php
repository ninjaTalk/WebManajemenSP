<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Employee;
use App\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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

        $data = Customer::join('employees', 'employees.idPegawai', '=', 'customers.idPegawai')
//            ->where('customers.deleted_at','=', null)
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
        $data = Employee::all()->where("isAdmin", "=", "0");
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
//        try {
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
            $qr = "qr_$incrementID.png";
            //dd($qr);
            $kodeTabungan = "$users->kodeCollector"."$incrementID";
            Saving::create([
                'kodeTabungan' => $kodeTabungan,
            ]);
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
                'qrcode'=> $qr
            ]);
            $getID = DB::table('customers')->orderBy('created_at', 'desc')->first();
            $setID = DB::table('savings')->where('kodeTabungan', '=', $kodeTabungan);
            $this->makeQR($incrementID, $request->noKtp);
            move_uploaded_file("qr_$incrementID.png", "QR_Image");

            $setID->update([
                'idNasabah'=>$getID->idNasabah,
                ]);
            Session::flash('success', 'Penambahan data berhasil');
//        }catch (\Exception $e){
//            Session::flash('error', 'Penambahan Data GAGAL karena Nomer KTP sudah pernah tersimpan di dabatase');
//        }
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
        try {
            $dataUser =  DB::table('customers')->where('idNasabah', '=', $customer);
            $dataUser->update([
                'deleted_at'=> Carbon::now(),
                'noKtp' =>null
                ]);

            $userGet = $dataUser->first();
            //dd($userGet->qrcode);
            $QR_path = public_path("\QR_Image\qr_$userGet->idNasabah.png");
            if (File::exists($QR_path)){
                File::delete($QR_path);
            }
            $dataSaving = DB::table('savings')->where('kodeTabungan', '=', $userGet->kodeTabungan);
            $dataSaving->update(['deleted_at'=>Carbon::now()]);
            if (($userGet->ppNomor!=null)||($userGet->ppNomor!='-')){
                $dataLoan = DB::table('loans')->where('ppNomor', '=', $userGet->ppNomor);
                $dataLoan->update(['deleted_at'=>Carbon::now()]);
            }
           // $dataUser->delete();
            Session::flash('success', 'Penghapusan data berhasil');
        }catch (\Exception $e){
            Session::flash('success', $e);
        }
        return redirect()->intended('/customer');
    }
}
