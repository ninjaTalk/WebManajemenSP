@extends('layouts/master')
@section('title', 'Data Anggoata')

@section('content')

    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-body">
                        <a href="/RTransaction" class="btn btn-info">Laporan Transaction</a>
                        <a href="/RSavings" class="btn btn-info">Laporan Simpanan</a>
                        <a href="/RLoans" class="btn btn-info">Laporan Pinjaman</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="jquery-3.4.1.min.js"></script>
@endsection
