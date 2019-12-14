@extends('layouts.master')
@section('title', 'Data Anggoata')
@section('content')

    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-body">
                        <h3><strong>Data Simpanan</strong></h3>
                        <h5 style="margin-top: -5px;margin-left: 10px">Menampilkan Data Simpanan seluruh Nasabah</h5>
                        <div class="card-body">
                            <ul class="list-group pagination col-md-10">
                                <table id="coba"
                                       class="table table-striped table-bordered mt-0">
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
                                @if(count($data)>6)
                                    {{$data->Links()}}
                                @endif
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
