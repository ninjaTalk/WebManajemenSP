@extends('layouts.master')
@section('title', 'Data Simpanan')
@section('content')

    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-body" style="background-color: #5fb95f;padding-left: 0; padding-top: 0;padding-bottom: 0">
                        <div class="col-md-1" style="margin-right: 10px; background-color: white">
                            <img  src="{{asset('admin/assets/img/tabungan.png')}}"
                                  width="80" height="80" alt="Icon_Tabungan" >
                        </div>
                        <div class="col-md-6 mr-3 float-right" style="color: white">
                            <h3>
                                <strong>Data Simpanan</strong>
                            </h3>
                            <h5 style="margin-top: -5px;margin-left: 10px">
                                Halaman ini menampilkan data simpanan / tabungan nasabah
                            </h5>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="card-body">
                            <ul class="list-group pagination col-md-12">
                                <table id="coba"
                                       class="table table-striped table-bordered mt-0 text-center">
                                    <thead>
                                    <tr>
                                        <th>Kode Tabungan</th>
                                        <th>Nomor KTP</th>
                                        <th>Name</th>
                                        <th>Saldo</th>
                                        <th>Tabungan Terakhir</th>
                                        <th>Nama Collector</th>
                                        <th>Created At</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $datas)
                                        <tr>
                                            <th>{{$datas->kodeTabungan}}</th>
                                            <th>{{$datas->noKtp}}</th>
                                            <th>{{$datas->name}}</th>
                                            <th>Rp. {{number_format($datas->saldo, 0, "", ",")}}</th>
                                            <th>{{$datas->tglLastInput}}</th>
                                            <th>{{$datas->namePegawai}}</th>
                                            <th>{{$datas->created_at}}</th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$data->Links()}}
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
