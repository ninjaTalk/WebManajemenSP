@extends('layouts/master')
@section('title', 'Data Transaksi')
@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading">
                        <h3>Data Pinjaman</h3>
                    </div>
                    <div class="panel-body">
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
                                                <th>{{$datas->saldoPinjaman}}</th>
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
    </div>
    <script src="jquery-3.4.1.min.js"></script>
@endsection

