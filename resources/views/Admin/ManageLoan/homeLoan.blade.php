@extends('layouts.master')
@section('title', 'Data Anggoata')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading">
                        <h3>Data Pinjaman</h3>
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
                            <a href="/lunas" class="btn btn-info">Pinjaman LUNAS</a>
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
                                        <th>Saldo</th>
                                        <th>Pokok Pinjaman</th>
                                        <th>Jenis Bunga</th>
                                        <th>Jaminan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $datas)
                                        <tr>
                                            <th>{{$datas->ppNomor}}</th>
                                            <th>{{$datas->name}}</th>
                                            <th>{{$datas->noKtp}}</th>
                                            <th>{{$datas->tglPinjam}}</th>
                                            <th>Rp. {{$datas->saldoPinjaman}}</th>
                                            <th>Rp. {{$datas->pokokPinjaman}}</th>
                                            <th>{{$datas->loanType}}</th>
                                            <th>{{$datas->jaminan}}</th>
                                            <th>{{$datas->status}}</th>
                                            <th>
                                                <a class="btn btn-danger" href="#" onclick="
                                                    if (window.confirm('Apakah anda yakin ingin menghapus data ini ? ')){
                                                    $('#formDelete{{$datas->id}}').submit()
                                                    }
                                                    ">Hapus</a>
                                                <form action="{{route('loan.destroy', $datas->id)}}"
                                                      id="formDelete{{$datas->id}}" method="POST">
                                                    @method('delete')
                                                    @csrf
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
