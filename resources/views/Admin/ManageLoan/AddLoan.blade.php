@extends('layouts/master')
@section('title', 'Tambah Pinjaman')

@section('content')
    <div class="main">
        <div style="width: auto; background-color: #00b488; padding: 10px 5px 5px 5px;">
            <h1 style="margin-bottom: 30px !important;margin-left: 20px !important; color: white;">
                <strong>
                    Tambah Pinjaman
                </strong>
            </h1>
        </div>
        <div class="main-content" >
            <div class="container-fluid" >
                <div class="panel">
                    <div class="panel-body" style=" padding: 30px 25px 25px 40px ">
                        <form method="post" action="{{Route('loan.store')}}">
                            @csrf
                            <div class="form-group form-inline" style="margin-bottom: 20px !important;">
                                <label> Pilih Nasabah </label>
                                <label for="idUser"></label><select class="form-control" name="idNasabah" id="idUser" >
                                    @foreach($data as $datas)
                                        <option value="{{$datas->idNasabah}}"> {{$datas->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="margin-bottom: 20px !important;">
                                <label>Jumlah Pinjaman</label>
                                <input type="text" class="form-control
                                        @error('saldoPinjaman') is-invalid @enderror" autofocus
                                       placeholder="Masukkan jumlah pinjaman" name="saldoPinjaman">
                                @error('saldoPinjaman')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group form-inline" style="margin-bottom: 20px !important;">
                                <label>Jenis Bunga</label>
                                <select class="form-control" name="loanType" id="idUser" >
                                    <option value="MENETAP"> Menetap</option>
                                    <option value="MENURUN"> Menurun</option>
                                </select>
                            </div>
                            <div class="form-group" style="margin-bottom: 30px !important;">
                                <label>Tanggal Pinjaman</label>
                                <input type="date" class="form-control fitler-input @error('tglPinjam')
                                    is-invalid @enderror" name="tglPinjam">
                                @error('tglPinjam')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group" style="margin-bottom: 30px !important;">
                                <label>Jaminan</label>
                                <input type="text" class="form-control @error('jaminan')
                                    is-invalid @enderror" placeholder="Masukkan janinan nasabah"
                                       name="jaminan">
                                @error('jaminan')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
