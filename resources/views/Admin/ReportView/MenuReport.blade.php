@extends('layouts/master')
@section('title', 'Menu Laporan')

@section('content')
    <style> #menuReport
        {
            height:150px;
            margin-right:50px;
            font-size: 24px;
            /*background-color:white ;*/
            /*border-color: #3c3c3c;*/
            color: white;
        }
    </style>
    <div class="main ">
        <div class="main-content" >
            <div class="container-fluid">
                <a id="menuReport" href="/RTransaction" class="btn btn-warning col-md-3 mr-3">
                    <div style="padding-top: 50px;">
                        <strong>Laporan Transaksi</strong>
                        <i class="lnr lnr-text-align-justify"></i>
                    </div>
                </a>
                <a id="menuReport" style="color: white"  href="/RSavings" class="btn btn-info col-md-3 mr-3">
                    <div style="padding-top: 50px;">
                        <strong>Laporan Simpanan</strong>
                        <i class="lnr lnr-chart-bars"></i>
                    </div>
                </a>
                <a id="menuReport"  href="/RLoans" class="btn btn-success col-md-3 mr-3">
                    <div style="padding-top: 50px;">
                        <strong>Laporan Pinjaman</strong>
                        <i class="lnr lnr-book"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
    </div>
    <script src="jquery-3.4.1.min.js"></script>
@endsection
