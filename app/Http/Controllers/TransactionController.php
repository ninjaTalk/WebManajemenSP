<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Loan;
use App\Log_activity;
use App\Saving;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function Sodium\add;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Transaction::join('customers','transactions.idNasabah',
            '=', 'customers.idNasabah')
            ->select('transactions.id', 'transactions.tglInput', 'transactions.kodeTabungan',
                'transactions.ppNomor', 'customers.name', 'transactions.transactionType',
                'transactions.debit', 'transactions.debt', 'transactions.kodeTransaksi')
            ->where('transactions.description' ,'=', null)
            ->where('transactions.created_at' ,'=', null)
            ->orderByDesc('transactions.tglInput')
            ->paginate(6);
        return view('Admin.homeAdmin', compact('data'));
    }
    public function getSelectiveDate(Request $request){
        $date = $request->tanggal;
        $data = Transaction::join('customers','transactions.idNasabah',
            '=', 'customers.idNasabah')
            ->select('transactions.id', 'transactions.tglInput', 'transactions.kodeTabungan',
                'transactions.ppNomor', 'customers.name', 'transactions.transactionType',
                'transactions.debit', 'transactions.debt', 'transactions.kodeTransaksi')
            ->where('tglInput', $date )
            ->where('transactions.description' ,'=', null)
            ->orderByDesc('transactions.tglInput')
            ->paginate(6);
        //dd($data);
        return view('Admin.homeAdmin', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit($transaction)
    {
        $data = Transaction::where('id','=', $transaction)->get();
        //dd($data);
        //$data = Transaction::find($transaction);
        $datas = $data->first();
        if ($datas->transactionType == "Pinjaman") {
            $loanData = Loan::where('ppNomor', '=', $datas->ppNomor)->first();
            $getStatus = $loanData->status;
            return view('Admin.ManageTransaction.EditTransaction', ['data'=>$data, 'status'=>$getStatus]);
        }
        return view('Admin.ManageTransaction.EditTransaction', compact('data'));
    }


    public function editTKode($idNasabah, $tgl, $data){
        $kodeTransaksi = "$idNasabah/$tgl/$data/Edited";
        return $kodeTransaksi;
    }
    public function editTransaction($bunga, $jml,$sisaSaldo, $id, $tgl, $idNasabah, $ppNomor, $debt, $debtAkhir,  $description){

        try{
            Transaction::create([
                'kodeTransaksi' => $this->editTKode($idNasabah, $tgl, $ppNomor),
                'idPegawai' => $id,
                'tglInput' => $tgl,
                'idNasabah' => $idNasabah,
                'ppNomor' => $ppNomor,
                'transactionType' => 'Pinjaman',
                'description' => "Perubahan Karena : $description. Debt dari Rp. $debt menjadi Rp. $debtAkhir",
                'debt' => $debt,
                'bunga'=>$bunga,
                'jml'=>$jml,
                'sisaSaldo' => $sisaSaldo
            ]);
        }catch (\Exception $e){
            $set = Transaction::where('kodeTransaksi', '=',$this->editTKode($idNasabah, $tgl, $ppNomor));
            $set->update([
                'sisaSaldo' =>$sisaSaldo,
                'idPegawai' =>$id,
                'description' => "Perubahan Karena : $description. Rp. Debt dari $debt menjadi Rp. $debtAkhir",
                'debt' => $debt,
                'bunga'=>$bunga,
                'jml'=>$jml,
            ]);
        }
        return true;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $transaction)
    {
        $id = Session::get('idPegawai');
        //dd($request->getTgl);
        if ($request->transactionType == "Tabungan"){
            $this->validate($request, [
                'debit'=>'required',
                'description'=>'required|max:200']);
            //get saldo in saving
                $getSaldo = Saving::where('kodeTabungan', $request->kodeTabungan)->first();
                //get debit in transaction will be edit
                $recordActivities = Transaction::find($transaction);
                //save debit in var
                $nowDebit = $recordActivities->debit;
                //minus saldo so the number of saldo will become before enter or input savings
                $minusSaldo = $getSaldo->saldo - $nowDebit;
                //update transaction
                $kodeTransaksi = $this->editTKode($recordActivities->idNasabah, $request->getTgl, $request->kodeTabungan);
                try {
                    Transaction::create([
                        'kodeTransaksi' => $this->editTKode($recordActivities->idNasabah, $request->getTgl, $request->kodeTabungan),
                        'tglInput' => $request->getTgl,
                        'idPegawai' => $id,
                        'idNasabah' => $recordActivities->idNasabah,
                        'kodeTabungan' => $request->kodeTabungan,
                        'transactionType' => 'Tabungan',
                        'description' => "Perubahan Karena : $request->description. Debit dari Rp. $recordActivities->debit menjadi Rp. $request->debit",
                        'debit' =>$recordActivities->debit,
                    ]);
                }catch (\Exception $e){
                    $setEdit = Transaction::where('kodeTransaksi', '=',$kodeTransaksi);
                    $setEdit->update([
                        'idPegawai' =>$id,
                        'description' => "Perubahan Karena : $request->description. Debit dari Rp. $recordActivities->debit menjadi Rp. $request->debit",
                        'debit' => $recordActivities->debit,
                    ]);
                }
                $recordActivities->update([
                    'debit' => $request->debit,
                ]);
                $setSaving = DB::table('savings')->where('kodeTabungan',"=", $request->kodeTabungan);
                $countDebit = $minusSaldo + $request->debit;
                //dd($countDebit);
                $setSaving->update([
                    'saldo' => $countDebit
                ]);
            Session::flash('success', 'Perubahan data berhasil');
        }
        else if ($request->transactionType == "Pinjaman"){
            $this->validate($request, [
                'description' =>'required|max:200'
            ]);
            $data = Transaction::where('id','=', $transaction)->get();
            $datas = $data->first();
            $loanData = Loan::where('ppNomor', '=', $datas->ppNomor)->first();
            $getPokok = $loanData->pokokPinjaman;
            $getsisa = $loanData->sisaSaldo;
            $saldoBeforeEdit = $getsisa + $datas->debt;
            $getcount = Transaction::where('ppNomor','=', $datas->ppNomor)->where('description', '=', null)->get();

            if ($loanData->bunga == 0.02){
                $bunga = $loanData->saldoPinjaman * 0.02;
                $jml = $getPokok + $bunga;
                $manyPay = count($getcount);
                if ($manyPay == null || $manyPay == 0){
                    $sisaPay = 10;
                }else {
                    $sisaPay = 10 - ($manyPay - 1);
                }
                //dd($getcount);
                $lunasBunga = $sisaPay * $bunga;
                $lunasJml = $saldoBeforeEdit + $lunasBunga;
                //dd("menetap");
            }else{
               // dd("Menurun");
                $bunga = $saldoBeforeEdit * 0.03;
                $jml = $getPokok + $bunga;
                $lunasBunga = $bunga;
                $lunasJml = $saldoBeforeEdit + $bunga;
            }
            $sisaSaldoBiasa = $saldoBeforeEdit - $getPokok;
            $sisaLunas = $saldoBeforeEdit - $saldoBeforeEdit;
            if ($request->radioPay == "biasa"){
                $this->editTransaction(
                    $bunga,$jml,
                    $sisaSaldoBiasa,
                    $id,
                    $datas->tglInput,
                    $datas->idNasabah,
                    $datas->ppNomor,
                    $datas->debt,
                    $getPokok,
                    $request->description
                );
                $finaljml = $jml;
                $finalBunga = $bunga;
                $debt = $getPokok;
                $finalSaldo = $sisaSaldoBiasa;
            }else{
                $this->editTransaction(
                    $lunasBunga,
                    $lunasJml,
                    $sisaLunas,
                    $id,
                    $datas->tglInput,
                    $datas->idNasabah,
                    $datas->ppNomor,
                    $datas->debt,
                    $saldoBeforeEdit,
                    $request->description
                );
                $finaljml = $lunasJml;
                $finalBunga = $lunasBunga;
                $debt = $saldoBeforeEdit;
                $finalSaldo = $sisaLunas;
            }

                $setEdit = Transaction::find($transaction);
                $setEdit->update([
                    'debt' => $debt,
                    'bunga' => $finalBunga,
                    'jml' =>$finaljml,
                    'sisaSaldo'=>$finalSaldo
                ]);
                $setLoan = Loan::where('ppNomor', '=', "$request->ppNomor");
                $setCustomers = Customer::where('idNasabah', '=', $datas->idNasabah);
                if ($finalSaldo != 0){
                    $statusLoan = "BERJALAN";
                    $setCustomers->update([
                        'ppNomor'=>$loanData->ppNomor
                    ]);
                }else{
                    $statusLoan = "LUNAS";
                    $setCustomers->update([
                        'ppNomor'=>null
                    ]);
                }
                $setLoan->update([
                    'status' =>$statusLoan,
                    'sisaSaldo' => $finalSaldo
                ]);
            Session::flash('success', 'Perubahan data berhasil');
        }
        Session::flash('success', 'Perubahan data berhasil');
        return redirect()->intended('/home');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
