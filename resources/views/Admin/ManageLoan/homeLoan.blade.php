@extends('layouts.master')
@section('title', 'Data Anggoata')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading">
                        <h3><strong>Data Pinjaman</strong></h3>
                        <h5 style="margin-top: -5px;margin-left: 10px">Menampilkan Data Pinjaman Nasabah yang sedang BERJALAN ataupun LUNAS</h5>
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
                                       class="table table-striped table-bordered" style="font-size: 14px;">
                                    <thead class="col-mid-8" >
                                    <tr >
                                        <th >PP Nomor</th>
                                        <th>Name</th>
                                        <th>No KTP</th>
                                        <th class="col-md-1">Tanggal Pinjam</th>
                                        <th>Saldo</th>
                                        <th>Pokok Pinjaman</th>
                                        <th>Jenis Bunga</th>
{{--                                        <th class="col-md-1">Persentase Bunga</th>--}}
                                        <th class="col-md-1">Jumlah Angsuran</th>
                                        <th>Jaminan</th>
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
{{--                                            <th>--}}
{{--                                                @if($datas->bunga == 0.02)--}}
{{--                                                    2%--}}
{{--                                                @else--}}
{{--                                                    3%--}}
{{--                                                @endif--}}
{{--                                            </th>--}}
                                            <th>{{$datas->jmlAngsur}} Kali</th>
                                            <th>{{$datas->jaminan}}</th>
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
{{--                                @if(count($data)>=6)--}}
{{--                                    {{$data->Links()}}--}}
{{--                                @endif--}}
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
