<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Loan::all()->where('status', '=', 'BERJALAN');
        return view('Admin.ManageLoan.homeLoan', ['data'=>$data]);
    }
    public function indexLunas(){
        $data = Loan::all()->where('status', '=', 'LUNAS');
        return view('Admin.ManageLoan.HomeLunas', compact('data'));
    }

    public function create()
    {
        $data = Customer::all();
        return view('Admin.ManageLoan.AddLoan', compact('data'));
    }

    public function store(Request $request)
    {
        $Check = DB::table('customers')->where('idNasabah', $request->idNasabah)->first();
        //return $Check->ppNomor;
            if (($Check->ppNomor != "-")) {
                Session::flash('error', 'Nasabah ini masih memiliki pinjaman yang sedang BERJALAN');
                return redirect()->intended('/loan');
            }else{
                $this->validate($request, [
                    'idNasabah' => 'required',
                    'saldoPinjaman' => 'required',
                    'loanType' => 'required',
                    'tglPinjam' => 'required',
                    'jaminan' => 'required',
                ]);
                $deleteYears = substr($request->tglPinjam, 5);
                $getMouth = substr($deleteYears, 0, 2);
                $getYears = substr($request->tglPinjam, 0, 4);
                $ppNomor = $request->idNasabah . '/' . $this->convertMounth($getMouth) . '/' . $getYears . '/KCSC';
                $dataNasabah = DB::table('customers')
                    ->where('idNasabah', $request->idNasabah)->first();
                //return $dataNasabah->noKtp;
                $pokokPinjaman = $this->getPokokPinjaman($request->saldoPinjaman, 10);
                $bunga = $this->getBunga($request->loanType);
                try{
                    Loan::create([
                        'ppNomor' => $ppNomor,
                        'tglPinjam' => $request->tglPinjam,
                        'saldoPinjaman' => $request->saldoPinjaman,
                        'loanType' => $request->loanType,
                        'jaminan' => $request->jaminan,
                        'name' => $dataNasabah->name,
                        'noKtp' => $dataNasabah->noKtp,
                        'status' => "BERJALAN",
                        'idPegawai' => $dataNasabah->idPegawai,
                        'jmlAngsur' => 10,
                        'pokokPinjaman' =>$pokokPinjaman,
                        'bunga' => $bunga
                ]);
                    $updateCustomer = DB::table('customers')->where('idNasabah', $request->idNasabah);
                    $updateCustomer->update([
                        'ppNomor' =>$ppNomor
                    ]);
                    Session::flash('success', 'Penambahan pinjaman berhasil');
                    return redirect()->intended('/loan');
                }catch (\Exception $e){
                    Session::flash('error', "$e");
                    return redirect()->intended('/loan');
                }
            }
    }

    public function convertMounth($mount){
       $array = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
       $generatedMounth = $array[$mount-1];
       return $generatedMounth;
    }
    public function getPokokPinjaman($saldo, $jmlAngsuran){
        $pokokPinjaman = $saldo / $jmlAngsuran;
        return $pokokPinjaman;
    }
    public function getBunga( $typeLoan){
        if ($typeLoan == "MENURUN"){
            $bunga = 0.03;
            return $bunga;
        }else if($typeLoan == "MENETAP"){
            $bunga = 0.02;
            return $bunga;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy($loan)
    {
        $data = Loan::find($loan);
        $getPP = DB::table('loans')->where('id', '=',$loan)->first();
        //return $data;
        $dataUser = $getPP->ppNomor;
        $data->update([
            'ppNomor'=>'-'
        ]);
        $data->delete();
        $getUser = DB::table('customers')
            ->where('ppNomor', '=', $dataUser);
        $getUser->update([
            'ppNomor' => '-'
        ]);
        Session::flash('success', 'Penambahan pinjaman berhasil');
        return redirect()->intended('/loan');
    }
}
