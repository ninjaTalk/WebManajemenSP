@extends('layouts/master')
@section('title', 'Data Anggoata')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="main">
                    <div class="main-content">
                        <div class="container-fluid">
                            @foreach($data as $datas)
                                <h2>Edit Transaksi</h2>
                                <form method="post" action="/transaction/{{$datas->id}}">
                                    @csrf
                                    @method('patch')
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Kode Transaksi</label>
                                            <input type="text" class="form-control" autofocus value="{{$datas->kodeTransaksi}}"
                                                   disabled placeholder="Masukkan nama pegawai" name="kodeTransaksi">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>ID Nasabah</label>
                                            <input type="text" class="form-control"value="{{$datas->idNasabah}}" disabled >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control"value="{{$datas->transactionType}}"
                                               name="transactionType" >
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control"value="{{$datas->kodeTabungan}}"
                                               name="kodeTabungan"  >
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control"value="{{$datas->ppNomor}}"
                                               name="ppNomor"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Input</label>
                                        <input type="text" class="form-control" autofocus value="{{$datas->tglInput}}"
                                               placeholder="Masukkan nama pegawai" name="tglInput" disabled>
                                    </div>
                                    @if($datas->debit!=null)
                                        <div class="form-group">
                                            <label>Debit</label>
                                            <input type="text" class="form-control @error('debit')
                                                is-invalid @enderror" name="debit" value="{{$datas->debit}}">
                                            @error('debit')
                                            <div class="alert alert-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label>Debt</label>
                                            <input type="text" class="form-control @error('debt')
                                                is-invalid @enderror" name="debt" value="{{$datas->debt}}">
                                            @error('debt')
                                            <div class="alert alert-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    @endif


                                    <button type="submit" class="btn btn-primary">Perbaharui Data</button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
