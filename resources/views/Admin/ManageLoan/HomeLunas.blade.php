@extends('layouts.master')
@section('title', 'Data Pinjaman Lunas')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-body" style="background-color: #5fb95f;
                    padding: 0 0 0 0; margin-bottom: 10px;">
                        <div class="col-md-1" style="margin-right: 10px; background-color: white">
                            <img  src="{{asset('admin/assets/img/paid2.png')}}"
                                  width="80" height="80" alt="Icon_pinjaman" >
                        </div>
                        <div class="col-md-6 mr-3 float-right" style="color: white">
                            <h3>
                                <strong>Data Lunas</strong>
                            </h3>
                            <h5 style="margin-top: -5px;margin-left: 10px">
                                Halaman ini menampilkan data pinajaman nasabah yang telah lunas
                            </h5>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{session()->get('success')}}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-warning">
                                {{session()->get('error')}}
                            </div>
                        @endif
                            <a href="/loan/create" class="btn btn-primary">Tambah Pinjaman Baru</a>
                            <a href="#" class="btn btn-info">Pinjaman LUNAS</a>
                            <a href="/loan" class="btn btn-info">Pinjaman BERJALAN</a>
                         <div class="card-body">
                            <ul class="list-group pagination">
                                <table id="coba"
                                       class="table table-striped table-bordered">
                                    <thead class="col-mid-8">
                                    <tr>
                                        <th>PP Nomor</th>
                                        <th>Name</th>
                                        <th>No KTP</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Berakhir</th>
                                        <th>Jenis Bunga</th>
                                        <th>Jaminan</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $datas)
                                        <tr>
                                            <th>{{$datas->ppNomor}}</th>
                                            <th>{{$datas->name}}</th>
                                            <th>{{$datas->noKtp}}</th>
                                            <th>{{$datas->tglPinjam}}</th>
                                            <th>{{$datas->tglLastInput}}</th>
                                            <th>{{$datas->loanType}}</th>
                                            <th>{{$datas->jaminan}}</th>
                                            <th>{{$datas->status}}</th>
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
