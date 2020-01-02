<?php

namespace App\Http\Controllers;

use App\Loan;
use App\Log_activity;
use App\Saving;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $data = DB::table('transactions')
            ->join('customers','transactions.idNasabah',
            '=', 'customers.idNasabah')
            ->select('transactions.id', 'transactions.tglInput', 'transactions.kodeTabungan',
                'transactions.ppNomor', 'customers.name', 'transactions.transactionType',
                'transactions.debit', 'transactions.debt', 'transactions.kodeTransaksi')
            ->where('transactions.description' ,'=', null)
            ->orderByDesc('transactions.tglInput')
            ->paginate(6);
        return view('Admin.homeAdmin', compact('data'));
    }
    public function getSelectiveDate(Request $request){
        $date = $request->tanggal;
        $data = DB::table('transactions')->join('customers','transactions.idNasabah',
                '=', 'customers.idNasabah')->where('tglInput', $date )->paginate(6);
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
        $data = DB::table('transactions')->where('id','=', $transaction)->get();
        //dd($data);
        //$data = Transaction::find($transaction);
        return view('Admin.ManageTransaction.EditTransaction', compact('data'));
    }


    public function editTransaction($idNasabah, $tgl, $data){
        $kodeTransaksi = "$idNasabah/$tgl/$data/Edited";
        return $kodeTransaksi;
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
                $kodeTransaksi = $this->editTransaction($recordActivities->idNasabah, $request->getTgl, $request->kodeTabungan);
                try {
                    Transaction::create([
                        'kodeTransaksi' => $this->editTransaction($recordActivities->idNasabah, $request->getTgl, $request->kodeTabungan),
                        'tglInput' => $request->getTgl,
                        'idPegawai' => $id,
                        'idNasabah' => $recordActivities->idNasabah,
                        'kodeTabungan' => $request->kodeTabungan,
                        'transactionType' => 'Tabungan',
                        'description' => "Perubahan Karena : $request->description. Debit dari $recordActivities->debit menjadi $request->debit",
                        'debit' =>$recordActivities->debit,
                    ]);
                }catch (\Exception $e){
                    $setEdit = Transaction::where('kodeTransaksi', '=',$kodeTransaksi);
                    $setEdit->update([
                        'idPegawai' =>$id,
                        'description' => "Perubahan Karena : $request->description. Debit dari $recordActivities->debit menjadi $request->debit",
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
                'debt'=>'required',
                'description' =>'required|max:200'
            ]);
                $getRecord = Transaction::find($transaction);
                $getPPnomor = $getRecord->ppNomor;
                $getRecordLoan = Loan::where('ppNomor', '=', $getPPnomor)->first();
                //dd($check);
//                return $getRecordLoan->saldoPinjaman;,
                $plusSaldoPinjaman = $getRecordLoan->sisaSaldo + $getRecord->debt;
                $countDebt = $plusSaldoPinjaman - $request->debt;
                try {
                    Transaction::create([
                        'kodeTransaksi' => $this->editTransaction($getRecord->idNasabah, $request->getTgl, $request->ppNomor),
                        'idPegawai' => $id,
                        'tglInput' => $request->getTgl,
                        'idNasabah' => $getRecord->idNasabah,
                        'ppNomor' => $request->ppNomor,
                        'transactionType' => 'Pinjaman',
                        'description' => "Perubahan Karena : $request->description. Debt dari $getRecord->debt menjadi $request->debt",
                        'debt' => $getRecord->debt,
                        'sisaSaldo' => $countDebt
                    ]);
                }catch (\Exception $e){
                   $set = Transaction::where('kodeTransaksi', '=',$this->editTransaction($getRecord->idNasabah, $request->getTgl, $request->ppNomor));
                   $set->update([
                      'sisaSaldo' =>$countDebt,
                      'idPegawai' =>$id,
                      'description' => "Perubahan Karena : $request->description. Debit dari $getRecord->debt menjadi $request->debt",
                      'debt' => $getRecord->debt,
                   ]);
                }

                $getRecord->update([
                    'debt' => $request->debt,
                ]);
                $setLoan = DB::table('loans')->where('ppNomor', '=', "$request->ppNomor");
                if ($countDebt != 0){
                    $statusLoan = "BERJALAN";
                }else{
                    $statusLoan = "LUNAS";
                }
                $setLoan->update([
                    'status' =>$statusLoan,
                    'sisaSaldo' => $countDebt
                ]);
            Session::flash('success', 'Perubahan data berhasil');
        }
        Session::flash('success', 'Perubahan data s berhasil');
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
