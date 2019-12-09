<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Employee;
use App\Loan;
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
        $data = DB::table('transactions')->join('customers','transactions.idNasabah',
            '=', 'customers.idNasabah')
            ->where('transactions.tglInput','=', $currentDate)->get();
        //return json_decode($data);
        $capsule =[
            'data' =>$data,
            'date' =>$currentDate
        ];
        //return $currentDate;
        return view('Admin.ReportView.ReportTransaction', compact('capsule'));
    }
    public function printTransaction(Request $request){
        $get = $request->clone;
       // return $get;
        $data = DB::table('transactions')->join('customers','transactions.idNasabah',
            '=', 'customers.idNasabah')->where('tglInput', $get )->get();
        //return view('Admin.ReportView.TransactionViewReport', compact('data'));
//        $pdf = PDF::loadView('Admin.ReportView.TransactionViewReport', compact('data'));
//        return  $pdf->download('laporan-nasabah.pdf');
        $capsule =[
            'data' =>$data,
            'date' =>$get
        ];
        //return view('Admin.ReportView.TransactionViewReport', ['data'=>$capsule]);
        $pdf = PDF::loadview('Admin.ReportView.TransactionViewReport', ['data'=>$capsule]);
        return $pdf->stream();

    }
    public function menuShow(){
        return view('Admin.ReportView.MenuReport');
    }
    public function getSelectiveDate(Request $request){
        $date = $request->tanggal;
        $data = DB::table('transactions')->join('customers','transactions.idNasabah',
            '=', 'customers.idNasabah')->where('tglInput', $date )->get();
//        dd($data);
        $capsule =[
            'data' =>$data,
            'date' =>$date
        ];
        return view('Admin.ReportView.ReportTransaction', compact('capsule'));
    }
    public function indexSaving(){
        $data = DB::table('savings')->join('customers',
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
        $data = DB::table('savings')->join('customers',
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
        $data = DB::table('savings')->join('customers',
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

        $data = DB::table('loans')
            ->where('status', '=', 'LUNAS')->get();
        return view('Admin.ReportView.ReportLoans', compact('data'));
    }
    public function printLoan(Request $request){
        $array = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI',
            'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER',
            'NOVEMBER', 'DESEMBER'];
        $data = DB::table('loans')
            ->join('transactions', 'loans.ppNomor', '=', 'transactions.ppNomor')
            ->where('loans.ppNomor', '=',$request->ppNomor)->get();

        $dataCustomers = DB::table('loans')
            ->join('customers', 'loans.ppNomor', '=', 'customers.ppNomor')
            ->where('loans.ppNomor', '=',$request->ppNomor)->first();
        $dataSaldo = Loan::all()->where('ppNomor', '=',$request->ppNomor)->first();
        $day = substr($dataSaldo->tglPinjam, 8);
        $deleteYear = substr($dataSaldo->tglPinjam, 5);
        $mouth = substr($deleteYear, 0, 2);
        $year = substr($dataSaldo->tglPinjam, 0, 4);
        //return $day;
        $conMounth = $this->convertMouth($mouth);
        $capsule = [
            'data' =>$data,
            'user' =>$dataCustomers,
            'day' =>  $day,
            'mouth' =>$conMounth,
            'year' => $year,
            'dataLoans' => $dataSaldo,
        ];
        $pdf = PDF::loadView('Admin.ReportView.LoanViewReport', compact('capsule'));
        return $pdf->download("laporan-pinjaman $dataCustomers->name $dataSaldo->tglPinjam.pdf");
        //return view('Admin.ReportView.LoanViewReport', compact('capsule'));
    }

}
