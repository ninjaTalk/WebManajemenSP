@extends('layouts/master')
@section('title', 'Tambah Pinjaman')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="main">
                    <div class="main-content">
                        <div class="container-fluid">
                            <h1>Tambah Nasabah</h1>
                            <form method="post" action="{{Route('loan.store')}}">
                                @csrf
                                <div class="form-group form-inline">
                                    <label> Pilih Nasabah </label>
                                    <select class="form-control" name="idNasabah" id="idUser" >
                                        @foreach($data as $datas)
                                            <option value="{{$datas->idNasabah}}"> {{$datas->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Pinjaman</label>
                                    <input type="text" class="form-control
                                        @error('saldoPinjaman') is-invalid @enderror" autofocus
                                           placeholder="Masukkan jumlah pinjaman" name="saldoPinjaman">
                                    @error('saldoPinjaman')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group form-inline">
                                    <label>Jenis Bunga</label>
                                    <select class="form-control" name="loanType" id="idUser" >
                                            <option value="MENETAP"> Menetap</option>
                                            <option value="MENURUN"> Menurun</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pinjaman</label>
                                    <input type="date" class="form-control fitler-input @error('tglPinjam')
                                        is-invalid @enderror" name="tglPinjam">
                                    @error('tglPinjam')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
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
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
@endsection
