<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Employee;
use App\Koperasi_profile;
use App\Loan;
use App\Log_activity;
use App\Saving;
use App\Transaction;
use Barryvdh\DomPDF\Facade as PDF;
//use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function indexTransaction(){
        $currentDate = date("Y-m-d");
        //return $currentDate;
        $dataCollector = Employee::all()->where('kodeCollector', '!=', null || "")
            ->sortBy('kodeCollector', SORT_ASC);
        $selected = $dataCollector->first();
        $data = Transaction::join('customers','transactions.idNasabah',
            '=', 'customers.idNasabah')
            ->join('employees', 'transactions.idPegawai', '=', 'employees.idPegawai')
            ->select('transactions.id', 'transactions.debit', 'transactions.debt',
                'transactions.transactionType','transactions.kodeTabungan', 'transactions.ppNomor',
                'customers.name as nameCus', 'transactions.tglInput', 'customers.kodeCollector',
                'employees.name', 'transactions.description')
            ->where('customers.kodeCollector', $selected)
            ->where('transactions.tglInput', $currentDate )->get();

        //dd($selected->kodeCollector);
        $capsule =[
            'data' =>$data,
            'date' =>$currentDate,
            'dateTarget'=>$currentDate,
            'collect' =>$dataCollector,
            'selected' => $selected->kodeCollector,
            //'edit'=>$editTransaction
        ];
        //return $currentDate;
        return view('Admin.ReportView.ReportTransaction', compact('capsule'));
    }
    public function printTransaction(Request $request){
       // dd($request->clone.",". $request->cloneTarget);
        $get = $request->clone;
        $kodeCollect = $request->cloneCollect;
        $data = Transaction::join('customers','transactions.idNasabah',
            '=', 'customers.idNasabah')
            ->join('employees', 'transactions.idPegawai', '=', 'employees.idPegawai')
            ->select('transactions.id', 'transactions.debit', 'transactions.debt',
                'transactions.transactionType','transactions.kodeTabungan', 'transactions.ppNomor',
                'customers.name as nameCus', 'transactions.tglInput', 'customers.kodeCollector',
                'employees.name', 'transactions.description')
            ->where('customers.kodeCollector', $kodeCollect)
            ->whereBetween('tglInput',[$get, $request->cloneTarget])
            ->get();
       // dd($data);
        $profile = Koperasi_profile::find(1);
        $capsule =[
            'data' =>$data,
            'date' =>$get,
            'dateTarget'=>$request->cloneTarget,
            'profile' => $profile,
            'Collector' =>$kodeCollect
        ];
        $pdf = PDF::loadview('Admin.ReportView.TransactionViewReport', ['data'=>$capsule])->setPaper('a4', 'landscape');
        return $pdf->download("laporan_Transaksi/$get/$kodeCollect.pdf");
        //return view('Admin.ReportView.TransactionViewReport', ['data'=>$capsule]);

    }
    public function menuShow(){
        return view('Admin.ReportView.MenuReport');
    }
    public function getSelectiveDate(Request $request){
        $date = $request->tanggal;
        //dd($request->kodeCollector, $date);
        $data = Transaction::join('customers','transactions.idNasabah',
            '=', 'customers.idNasabah')
            ->join('employees', 'transactions.idPegawai', '=', 'employees.idPegawai')
            ->select('transactions.id', 'transactions.debit', 'transactions.debt',
                'transactions.transactionType','transactions.kodeTabungan', 'transactions.ppNomor',
                'customers.name as nameCus', 'transactions.tglInput', 'customers.kodeCollector', 'employees.name', 'transactions.description')
            ->where('customers.kodeCollector', '=', $request->kodeCollector)
            ->whereBetween('tglInput',[$date, $request->tanggalTarget])
            ->orderBy('transactions.tglInput', 'DESC')
            ->orderBy('transactions.updated_at', 'DESC')
            ->orderBy('transactions.description', 'ASC')
            ->get();
        $dataCollector = Employee::all()->where('kodeCollector', '!=', null || "")
            ->sortBy('kodeCollector', SORT_ASC);
//        $editTransaction = Log_activity::join('employees', 'log_activities.idPegawai', '=', 'employees.idPegawai')
//            ->join('transactions', 'log_activities.kodeTransaksi', '=', 'transactions.kodeTransaksi')
//            ->select('log_activities.id', 'log_activities.description', 'log_activities.debit', 'log_activities.debt',
//                'employees.name', 'transactions.transactionType', 'transactions.ppNomor', 'transactions.kodeTabungan')
//            ->where('log_activities.created_at', '=', $date)->get();
//        dd($data);
        $capsule =[
            'data' =>$data,
            'date' =>$date,
            'dateTarget'=>$request->tanggalTarget,
            'collect' => $dataCollector,
            'selected' => $request->kodeCollector,
        ];
        return view('Admin.ReportView.ReportTransaction', compact('capsule'));
    }
    public function indexSaving(){
        $dataCollector = Employee::all()->where('kodeCollector', '!=', null || "")
            ->sortBy('kodeCollector', SORT_ASC);
        $selected = $dataCollector->first();
        //dd($selected->kodeCollector);
        $data = Saving::join('customers',
            'savings.kodeTabungan', '=', 'customers.kodeTabungan')
            ->where('customers.kodeCollector', '=', $selected->kodeCollector)->get();

        //dd($data);
        $capsule = [
            'data' => $data,
            'collect' =>$dataCollector,
            'selected' => $selected->kodeCOllector
        ];
        //return $capsule;
        return view('Admin.ReportView.ReportSavings', compact('capsule'));
    }
    public function fitlerCollect(Request $request){
        $codeCollect = $request->kodeCollector;
        $data = Saving::join('customers',
            'savings.kodeTabungan', '=', 'customers.kodeTabungan')
            ->where('customers.deleted_at', '=', null)
            ->where('customers.kodeCollector', '=', $codeCollect)->get();
        $dataCollector = Employee::all()->where('kodeCollector', '!=', null || "")
            ->sortBy('kodeCollector', SORT_ASC);
        $capsule = [
            'data' => $data,
            'collect' =>$dataCollector,
            'selected' => $codeCollect
        ];
        //return $capsule;
        return view('Admin.ReportView.ReportSavings', compact('capsule'));

    }
    public function printSavings(Request $request){
        $currentMouth = date("m");
        $convert = $this->convertMouth($currentMouth);
        $currentYears = date("Y");
        //return $convert;
        $codeCollect = $request->cloneCollect;
        //return $codeCollect;
        $data = Saving::join('customers',
            'savings.kodeTabungan', '=', 'customers.kodeTabungan')
            ->where('customers.kodeCollector', '=', $codeCollect)->get();
        $dataCollector = Employee::all()->where('kodeCollector', '=', $codeCollect )->first();
        $capsule = [
            'data' => $data,
            'collect' =>$dataCollector,
            'selected' => $codeCollect,
            'mouth' => $convert,
            'year' =>$currentYears
        ];
        //return $capsule;
        $pdf = PDF::loadview('Admin.ReportView.SavingViewReport', ['capsule'=>$capsule]);
        return $pdf->download("laporan_simapanan_KC - $codeCollect .pdf");
    }
    public function printSavingsNasabah(Request $request){
        $data = Saving::join('customers',
            'savings.kodeTabungan', '=', 'customers.kodeTabungan')->where('savings.kodeTabungan', '=', $request->kodeTabungan )->first();
        //dd($data);
        $dataTransaksi = Saving::join('transactions', 'savings.kodeTabungan','=', 'transactions.kodeTabungan')
            ->join('employees', 'transactions.idPegawai', '=', 'employees.idPegawai')
            ->where('savings.kodeTabungan', '=', $request->kodeTabungan)
            ->where('transactions.description', '=', null)->get();
        $capsule = [
            'user' => $data,
            'transaction' =>$dataTransaksi,
        ];
        //return $capsule;
        $pdf = PDF::loadview('Admin.ReportView.SavingNasabahViewReport', ['capsule'=>$capsule]);
        return $pdf->download("laporan_Tabungan_$request->kodeTabungan .pdf");
        //return view('Admin.ReportView.SavingNasabahViewReport', ['capsule'=>$capsule]);
    }
    public function convertMouth($value){
        $array = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI',
            'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER',
            'NOVEMBER', 'DESEMBER'];
        $generated = $array[$value-1];
        return $generated;
    }
    public function indexLoan(){

        $data = Loan::where('status', '=', 'LUNAS')->get();
        return view('Admin.ReportView.ReportLoans', compact('data'));
    }
    public function printLoan(Request $request){
        $data = Loan::join('transactions', 'loans.ppNomor', '=', 'transactions.ppNomor')
            ->select('loans.bunga as percent', 'transactions.debt', 'transactions.bunga', 'transactions.jml', 'loans.sisaSaldo')
            ->where('loans.ppNomor', '=',$request->ppNomor)
            ->where('transactions.created_at', '=',null)->get();
        //dd($data);
        $dataCustomers = Loan::join('customers', 'loans.idNasabah', '=', 'customers.idNasabah')
            ->where('loans.ppNomor', '=',$request->ppNomor)->first();
        $dataSaldo = Loan::all()->where('ppNomor', '=',$request->ppNomor)->first();
        $day = substr($dataSaldo->tglPinjam, 8);
        $deleteYear = substr($dataSaldo->tglPinjam, 5);
        $mouth = substr($deleteYear, 0, 2);
        $year = substr($dataSaldo->tglPinjam, 2, 2);
        //return $day;
        $conMounth = $this->convertMouth($mouth);
        $tmpPPnomor = $data->first()->ppNomor;
        $capsule = [
            'ppNomor' => $tmpPPnomor,
            'data' =>$data,
            'user' =>$dataCustomers,
            'day' =>  $day,
            'mouth' =>$conMounth,
            'year' => $year,
            'dataLoans' => $dataSaldo,
            'percent' => $data->first()->percent
        ];
        //dd($capsule);
        $pdf = PDF::loadView('Admin.ReportView.LoanViewReport', compact('capsule'));
        return $pdf->download("laporan_pinjaman $dataCustomers->name $dataSaldo->tglPinjam.pdf");
        //return view('Admin.ReportView.LoanViewReport', compact('capsule'));
    }

}
