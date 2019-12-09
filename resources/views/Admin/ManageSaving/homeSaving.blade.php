@extends('layouts.master')
@section('title', 'Data Anggoata')
@section('content')

    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading">
                        <h3> Data Simpanan</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card-body">
                            <ul class="list-group pagination col-md-10">
                                <table id="coba"
                                       class="table table-striped table-bordered">
                                    <thead class="col-mid-8">
                                    <tr>
                                        <th>Kode Tabungan</th>
                                        <th>Nomor KTP</th>
                                        <th>Name</th>
                                        <th>Saldo</th>
                                        <th>Tabungan Terakhir</th>
                                        <th>Nama Collector</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $datas)
                                        <tr>
                                            <th>{{$datas->kodeTabungan}}</th>
                                            <th>{{$datas->noKtp}}</th>
                                            <th>{{$datas->name}}</th>
                                            <th>Rp. {{$datas->saldo}}</th>
                                            <th>{{$datas->tglLastInput}}</th>
                                            <th>{{$datas->namePegawai}}</th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="jquery-3.4.1.min.js"></script>
@endsection
