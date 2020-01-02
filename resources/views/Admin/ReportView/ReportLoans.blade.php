@extends('layouts/master')
@section('title', 'Laporan Pinjaman')
@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-body" style="background-color: #00b488;padding-left: 0; padding-top: 0;padding-bottom: 0;">
                        <div class="col-md-1" style="margin-right: 10px; background-color: white">
                            <img src="{{asset('admin/assets/img/loan.png')}}"
                                 width="95" height="90" alt="Icon_pinjaman" >
                        </div>
                        <div class="col-md-6 mr-3 float-right" style="color: white">
                            <h3>
                                <strong>Laporan Pinjaman</strong>
                            </h3>
                            <p>Menampilkan data pinajaman nasabah yang telah <strong>LUNAS</strong></p>
                        </div>
                    </div>
                    <hr style="margin: 10px 0 0 0"/>
                    <div class="panel-body">
                            <div class="card-body">
                                <ul class="list-group pagination col-md-12">
                                    <table id="example"
                                           class="table table-striped table-bordered responsive">
                                        <thead class="col-mid-8">
                                        <tr>
                                            <th>PP Nomor</th>
                                            <th>Tanggal Pinjaman</th>
                                            <th>Nama Nasabah</th>
                                            <th>Saldo Pinjaman</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $datas)
                                            <tr>
                                                <th>{{$datas->ppNomor}}</th>
                                                <th>{{$datas->tglPinjam}}</th>
                                                <th>{{$datas->name}}</th>
                                                <th>Rp.{{number_format($datas->saldoPinjaman, 0, "", ",")}}</th>
                                                <th>{{$datas->status}}</th>
                                                <th>
                                                    <form action="/PLoan" method="get">
                                                        <input type="hidden" id="cloneDate" name="ppNomor" value="{{$datas->ppNomor}}">
                                                        <input type="submit" class="btn btn-danger" value="CETAK">
                                                    </form>
                                                </th>
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
    <script src="jquery-3.4.1.min.js"></script>
@endsection

