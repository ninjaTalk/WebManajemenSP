@extends('layouts/master')
@section('title', 'Beranda')
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel" style="background-color: white; padding: 10px 0 10px 10px" >
                    <div class="panel-body" style="background-color: #5fb95f;padding-left: 0; padding-top: 0;padding-bottom: 0;">
                        <div class="col-md-1" style="margin-right: 10px; background-color: white">
                            <img src="{{asset('admin/assets/img/bayar.png')}}"
                                  width="80" height="80" alt="Icon_transaksi" >
                        </div>
                        <div class="col-md-6 mr-3 float-right" style="color: white">
                            <h3>
                                <strong>Data Transaksi</strong>
                            </h3>
                            <h5 style="margin-top: -5px;margin-left: 10px">
                                Halaman ini menampilkan data transaksi berdasarkan tanggal
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="panel">
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
                    <div class="panel-body">
                        <form  action="/selective" method="get">
                            <div class="form-group form-inline col-md-8" style="padding-left: 0" >
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
                        <div class="card-body">
                            <ul class="list-group pagination col-md-12">
                                <table id="example" style="margin-top: -20px"
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
                                        <th></th>
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
                                            @if($datas->debit == 0)
                                                <th></th>
                                            @else
                                                <th>Rp.{{number_format($datas->debit, 0, "", ",")}}</th>
                                            @endif
                                            @if($datas->debt == 0)
                                                <th></th>
                                            @else
                                                <th>Rp.{{number_format($datas->debt, 0, "", ",")}}</th>
                                            @endif
                                            @if($datas->transactionType == "Pinjaman")
                                                <th></th>
                                            @else
                                                <th>
                                                    <a class="btn w-auto btn-primary" href="{{route('transaction.edit', $datas->id)}}">Edit</a>
                                                </th>
                                            @endif
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

