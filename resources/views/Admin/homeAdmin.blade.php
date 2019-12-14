@extends('layouts/master')
@section('title', 'Data Transaksi')
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading">
                       <h3>Data Transaksi</h3>
                        <form action="/selective" method="get">
                            <div class="form-group form-inline col-md-8" >
                                <input id="myDate" type="date" name="tanggal" class="form-control fitler-input"
                                       value="{{ old('tanggal') }}">
                                <span class="input-group-prepend ml-1">
                                <input  type="submit" value="CARI" class="btn btn-primary">
                         </span>
                                <span class="ml-2 float-right">
                             <a href="/" class="btn btn-primary">RESET</a>
                         </span>
                            </div>
                        </form>
                    </div>
                    <div class="panel-body">
                        <div class="panel-body">
                            @if(session()->has('success'))
                                <div class="alert alert-success m-0 p-2">
                                    {{session()->get('success')}}
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-warning m-0 p-2">
                                    {{session()->get('error')}}
                                </div>
                            @endif
                        <div class="card-body">
                            <ul class="list-group pagination col-md-12">
                                <table id="example"
                                       class="table table-striped table-bordered responsive">
                                    <thead class="col-mid-8">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal Input</th>
                                        <th>Kode Tabungan</th>
                                        <th>PP Nomor</th>
{{--                                        <th class="col-md-1">ID Nasabah</th>--}}
                                        <th>Nama Nasabah</th>
                                        <th>Jenis Transaksi</th>
                                        <th>Debit</th>
                                        <th>Debt</th>
                                        <th >View</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $datas)
                                        <tr>
                                            <th>{{$datas->id}}</th>
                                            <th>{{$datas->tglInput}}</th>
                                            <th>{{$datas->kodeTabungan}}</th>
                                            <th>{{$datas->ppNomor}}</th>
                                            <th>{{$datas->name}}</th>
                                            <th>{{$datas->transactionType}}</th>
                                            <th>Rp.{{$datas->debit}}</th>
                                            <th>Rp.{{$datas->debt}}</th>
                                            <th>
                                                <a class="btn btn-primary" href="{{route('transaction.edit', $datas->id)}}">Edit</a>
                                                <a class="btn btn-danger" href="#" onclick="
                                                    if (window.confirm('Apakah anda yakin ingin menghapus data ini ? ')){
                                                    $('#formDelete{{$datas->kodeTransaksi}}').submit()
                                                    }
                                                    ">delete</a>
                                                <form action="{{route('transaction.destroy', $datas->kodeTransaksi)}}"
                                                      id="formDelete{{$datas->kodeTransaksi}}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                </form>
                                            </th>
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
    <script type="text/javascript">


    </script>
    <script src="jquery-3.4.1.min.js"></script>
@endsection

