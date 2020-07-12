<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Employee;
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
//            ->where('transactions.created_at' ,'=', null)
            ->orderByDesc('transactions.id')
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
            if ($loanData->bunga <0.03){
                $bunga = $loanData->saldoPinjaman * 0.02;
                $pokok = $loanData->pokokPinjaman;
                $result = $pokok + $bunga;
            }else{
                $getResult = $loanData->sisaSaldo + $datas->debt;
                $bunga = $getResult * 0.03;
                $pokok = $loanData->pokokPinjaman;
                $result = $pokok + $bunga;
            }
            //dd($pokok .", ".$bunga.",".$result);
            return view('Admin.ManageTransaction.EditTransaction', ['data'=>$data, 'status'=>$getStatus, "result" =>$result]);
        }
        return view('Admin.ManageTransaction.EditTransaction', compact('data'));
    }


    public function editTKode($kode, $tgl, $idPegawai){
        $getId = Transaction::all()->sortByDesc('id',SORT_DESC)->first();
        $updateID = $getId->id+1;
        $kodeTransaksi = "$kode/$tgl/$idPegawai/$updateID";
        //dd($kodeTransaksi);
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
                'description' => "Perubahan Karena : $description. Debt dari Rp. $debt menjadi Rp. $debtAkhir",
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
        $name = Session::get('name');
        //dd($request->getTgl);
        if ($request->transactionType == "Tabungan"){
            $this->validate($request, [
                'debit'=>'required|numeric',
                'description'=>'required|max:200']);
                //get saldo in saving
                $getSaldo = Saving::where('kodeTabungan', $request->kodeTabungan)->first();
                //get debit in transaction will be edit
                $recordActivities = Transaction::find($transaction);
                //save debit in var
                $nowDebit = $recordActivities->debit;
                //minus saldo so the number of saldo will become before enter or input savings
                $minusSaldo = $getSaldo->saldo - $nowDebit;
                $saldoTransaction = $minusSaldo + $request->debit;
                 $countDebit = $minusSaldo + $request->debit;
                 //update main transaction
                //get data admin

                //update transaction
                $kodeTransaksi = $this->editTKode($recordActivities->idNasabah, $request->getTgl, $request->kodeTabungan);
                try {
                    Transaction::create([
                        'kodeTransaksi' => $this->editTKode($recordActivities->kodeTabungan, $request->getTgl, $recordActivities->idPegawai),
                        'tglInput' => $request->getTgl,
                        'idPegawai' => $recordActivities->idPegawai,
                        'idNasabah' => $recordActivities->idNasabah,
                        'kodeTabungan' => $request->kodeTabungan,
                        'saldoTabungan' => $countDebit,
                        'transactionType' => 'Tabungan',
                        'debit' =>$request->debit,
                        'edited_by' =>$name
                    ]);
                }catch (\Exception $e){
                   // dd($countDebit);
//                    $setEdit = Transaction::where('kodeTransaksi', '=',$kodeTransaksi);
//                    $setEdit->update([
//                        'idPegawai' =>$id,
//                        'description' => "Perubahan Karena : $request->description. Debit dari Rp. $recordActivities->debit menjadi Rp. $request->debit",
//                        'debit' => $recordActivities->debit,
//                        'saldoTabungan' => $countDebit,
//                    ]);
                }
                $recordActivities->update([
                    //'debit' => $request->debit,
                    //'saldoTabungan' => $countDebit,
                    'description' => "Perubahan Karena : $request->description. Debit dari Rp. $recordActivities->debit menjadi Rp. $request->debit",
                ]);
                $setSaving = DB::table('savings')->where('kodeTabungan',"=", $request->kodeTabungan);

                //dd($countDebit);
                $setSaving->update([
                    'saldo' => $countDebit
                ]);
            Session::flash('success', 'Perubahan data berhasil');
        }
        else if ($request->transactionType == "Pinjaman"){
            $this->validate($request, [
                'description' =>'required|max:200',
                'debt => numeric'
            ]);
            $data = Transaction::where('id','=', $transaction)->get();
            $datas = $data->first();
            $loanData = Loan::where('ppNomor', '=', $datas->ppNomor)->first();
            $getPokok = $loanData->pokokPinjaman;
            $getsisa = $loanData->sisaSaldo;
            $saldoBeforeEdit = $getsisa + $datas->debt;
            $getcount = Transaction::where('ppNomor','=', $datas->ppNomor)->where('description', '=', null)->get();

            //calculate price
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

            //check payloan input
            if ($request->ModifiedPay!=null){
                $this->validate($request, ['ModifiedPay'=>'numeric']);
                $getPokok = $request->ModifiedPay - $bunga;
                $jml = $request->ModifiedPay;
                if ($getPokok <$bunga){
                    Session::flash('error', 'Nilai nomninal dibawah standar pembayaran');
                    return redirect()->intended('/home');
                }
            }
            //dd($getPokok . "," . $saldoBeforeEdit);
            $sisaSaldoBiasa = $saldoBeforeEdit - $getPokok;
            $sisaLunas = $saldoBeforeEdit - $saldoBeforeEdit;
            if ($request->radioPay == "biasa"){
                $check =  Customer::where('idNasabah', '=', $datas->idNasabah)->first();
                //dd($datas->ppNomor ." , ". $check->ppNomor);
                if ($datas->ppNomor != $check->ppNomor && $check->ppNomor != null){
                    Session::flash('error', 'Perubahan data lunas tidak bisa dilakukan, nasabah masih memiliki pinjaman yang sedang berjalan sekarang. Pastikan nasabah tidak memiliki pinjaman jika ingin mengubah data transaksi dari lunas menjadi berjalan');
                    return redirect()->intended('/home');
                }
                $finaljml = $jml;
                $finalBunga = $bunga;
                $debt = $getPokok;
                $finalSaldo = $sisaSaldoBiasa;
                Transaction::create([
                    'kodeTransaksi' => $this->editTKode($datas->ppNomor, $datas->tglInput, $datas->idPegawai),
                    'idPegawai' => $datas->idPegawai,
                    'tglInput' =>  $datas->tglInput,
                    'idNasabah' => $datas->idNasabah,
                    'ppNomor' =>  $datas->ppNomor,
                    'transactionType' => 'Pinjaman',
                    'debt' => $getPokok,
                    'bunga'=>$finalBunga,
                    'jml'=>$finaljml,
                    'sisaSaldo' => $finalSaldo,
                    'edited_by' =>$name
                ]);
            }else{
                $finaljml = $lunasJml;
                $finalBunga = $lunasBunga;
                $debt = $saldoBeforeEdit;
                $finalSaldo = $sisaLunas;
                Transaction::create([
                    'kodeTransaksi' => $this->editTKode($datas->ppNomor, $datas->tglInput, $datas->idPegawai),
                    'idPegawai' => $datas->idPegawai,
                    'tglInput' =>  $datas->tglInput,
                    'idNasabah' => $datas->idNasabah,
                    'ppNomor' =>  $datas->ppNomor,
                    'transactionType' => 'Pinjaman',
                    'debt' => $debt,
                    'bunga'=>$finalBunga,
                    'jml'=>$finaljml,
                    'sisaSaldo' => $finalSaldo,
                    'edited_by' =>$name
                ]);
            }

                $setEdit = Transaction::find($transaction);
                $setEdit->update([
//                    'debt' => $debt,
//                    'bunga' => $finalBunga,
//                    'jml' =>$finaljml,
//                    'sisaSaldo'=>$finalSaldo
                    'edited_by' =>$name,
                    'description' => "Perubahan Karena : $request->description. Debt dari Rp. $datas->debt menjadi Rp. $finaljml",
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
