<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        //dd(Auth::user());
        //dd(\session()->get());
//        dd(Auth::guard('admin')->user());
        //dd(Session::get('name'));
        $data = DB::table('transactions')
            ->join('customers','transactions.idNasabah',
            '=', 'customers.idNasabah')
            ->select('transactions.id', 'transactions.tglInput', 'transactions.kodeTabungan',
                'transactions.ppNomor', 'customers.name', 'transactions.transactionType',
                'transactions.debit', 'transactions.debt', 'transactions.kodeTransaksi')
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $transaction)
    {
        //dd($request->transactionType);
        if ($request->transactionType == "Tabungan"){
            $this->validate($request, ['debit'=>'required']);
            //get saldo in saving
            try {
                $getSaldo = DB::table('savings')->where('kodeTabungan', $request->kodeTabungan)->first();
                //get debit in transaction will be edit
                $getNowDebit = DB::table('transactions')->where('id', '=', $transaction)->first();

                //save debit in var
                $nowDebit = $getNowDebit->debit;
                //minus saldo so the number of saldo will become before enter or input savings
                $minusSaldo = $getSaldo->saldo - $nowDebit;
                //update transaction
                $data = DB::table('transactions')->where('id', '=', $transaction);
                $data->update([
                    'debit' => $request->debit,
                ]);
                //dd($setSaving);
                $setSaving = DB::table('savings')->where('kodeTabungan', "$request->kodeTabungan");
                $countDebit = $minusSaldo + $request->debit;
                $setSaving->update([
                    'saldo' => $countDebit
                ]);
                Session::flash('success', 'Perubahan data berhasil');
            }catch (\Exception $e){
                Session::flash('error', $e);
            }
        }
        else if ($request->transactionType == "Pinjaman"){
            $this->validate($request, ['debt'=>'required']);
            //get soldo pinjaman
            try {
                $getSaldoPinjaman = DB::table('loans')->where('ppNomor', $request->ppNomor)->first();

                //get debt
                $getDebt = DB::table('transactions')->where('id', $request->id)->first();

                $minusSaldoPinjaman = $getSaldoPinjaman - $request->debt;
                $datas = DB::table('transactions')->where('id', '=', $transaction);
                $datas->update([
                    'debt' => $request->debt,
                ]);
                $setLoan = DB::table('loans')->where('ppNomor', '=', "$request->ppNomor");
                $countDebt = $minusSaldoPinjaman + $request->debt;
                $setLoan->update([
                    'saldoPinjaman' => $countDebt
                ]); Session::flash('success', 'Perubahan data berhasil');
            }catch (\Exception $e){
                Session::flash('error', $e);
            }

        }
        return redirect()->intended('/');

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
