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
        $data = Transaction::join('customers','transactions.idNasabah',
            '=', 'customers.idNasabah')
            ->join('employees', 'transactions.idPegawai', '=', 'employees.idPegawai')
            ->select('transactions.id', 'transactions.debit', 'transactions.debt',
                'transactions.transactionType','transactions.kodeTabungan', 'transactions.ppNomor',
                'customers.name as nameCus', 'transactions.tglInput', 'customers.kodeCollector',
                'employees.name', 'transactions.description')
            ->where('customers.kodeCollector', 'A')
            ->where('transactions.tglInput', $currentDate )->get();
        $dataCollector = Employee::all()->where('kodeCollector', '!=', null || "")
            ->sortBy('kodeCollector', SORT_ASC);
        $capsule =[
            'data' =>$data,
            'date' =>$currentDate,
            'collect' =>$dataCollector,
            'selected' => 'A',
            //'edit'=>$editTransaction
        ];
        //return $currentDate;
        return view('Admin.ReportView.ReportTransaction', compact('capsule'));
    }
    public function printTransaction(Request $request){
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
            ->where('transactions.tglInput', $get )->get();
       // dd($data);
        $profile = Koperasi_profile::find(1);
        $capsule =[
            'data' =>$data,
            'date' =>$get,
            'profile' => $profile,
            'Collector' =>$kodeCollect
        ];
        $pdf = PDF::loadview('Admin.ReportView.TransactionViewReport', ['data'=>$capsule])->setPaper('a4', 'landscape');
        return $pdf->download("laporan-Transaksi/$get/$kodeCollect.pdf");
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
            ->join('log_activities', 'transactions.kodeTransaksi', 'like', 'log_activities.kodeTransaksi', 'left outer')
            ->select('transactions.id', 'transactions.debit', 'transactions.debt',
                'transactions.transactionType','transactions.kodeTabungan', 'transactions.ppNomor',
                'customers.name as nameCus', 'transactions.tglInput', 'customers.kodeCollector', 'employees.name', 'transactions.description')
            ->where('customers.kodeCollector', '=', $request->kodeCollector)
            ->where('transactions.tglInput', $date )
            ->orderBy('transactions.updated_at', 'DESC')
            ->orderBy('transactions.tglInput', 'DESC')
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
            'collect' => $dataCollector,
            'selected' => $request->kodeCollector,
        ];
        return view('Admin.ReportView.ReportTransaction', compact('capsule'));
    }
    public function indexSaving(){
        $data = Saving::join('customers',
            'savings.kodeTabungan', '=', 'customers.kodeTabungan')
            ->where('customers.kodeCollector', '=', 'A')->get();
        $dataCollector = Employee::all()->where('kodeCollector', '!=', null || "")
            ->sortBy('kodeCollector', SORT_ASC);
        //dd($data);
        $capsule = [
            'data' => $data,
            'collect' =>$dataCollector,
            'selected' => "A"
        ];
        //return $capsule;
        return view('Admin.ReportView.ReportSavings', compact('capsule'));
    }
    public function fitlerCollect(Request $request){
        $codeCollect = $request->kodeCollector;
        $data = Saving::join('customers',
            'savings.kodeTabungan', '=', 'customers.kodeTabungan')
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
        return $pdf->stream();
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
            ->where('loans.ppNomor', '=',$request->ppNomor)->get();
        //dd($data);
        $dataCustomers = Loan::join('customers', 'loans.idNasabah', '=', 'customers.idNasabah')
            ->where('loans.ppNomor', '=',$request->ppNomor)->first();
        $dataSaldo = Loan::all()->where('ppNomor', '=',$request->ppNomor)->first();
        $day = substr($dataSaldo->tglPinjam, 8);
        $deleteYear = substr($dataSaldo->tglPinjam, 5);
        $mouth = substr($deleteYear, 0, 2);
        $year = substr($dataSaldo->tglPinjam, 0, 4);
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
        ];
        //dd($capsule);
        $pdf = PDF::loadView('Admin.ReportView.LoanViewReport', compact('capsule'));
        return $pdf->download("laporan-pinjaman $dataCustomers->name $dataSaldo->tglPinjam.pdf");
        //return view('Admin.ReportView.LoanViewReport', compact('capsule'));
    }

}
