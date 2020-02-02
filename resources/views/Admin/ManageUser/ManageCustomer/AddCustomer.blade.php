@extends('layouts/master')
@section('title', 'Tambah Nasabah')

@section('content')
    <div class="main">
        <div style="width: auto; background-color: #00b488; padding: 10px 5px 5px 5px;">
            <h1 style="margin-bottom: 30px !important;margin-left: 20px !important; color: white;text-transform: uppercase">
                <strong>
                    form Tambah Nasabah
                </strong>
            </h1>
        </div>
        <div class="main-content" >
            <div class="container-fluid" >
                <div class="panel">
                    <div class="panel-body" style=" padding: 35px 25px 25px 40px;font-size: 16px ">
                        <form method="post" action="{{Route('customer.store')}}">
                            @csrf
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control
                                        @error('name') is-invalid @enderror" autofocus
                                       placeholder="Masukkan nama nasabah" name="name">
                                @error('name')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nomor KTP</label>
                                <input type="number" class="form-control @error('noKtp')
                                    is-invalid @enderror" placeholder="Masukkan Nomor KTP Nasabah"
                                       name="noKtp">
                                @error('noKtp')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <div></div>
                                <label class="radio-inline">
                                    <input type="radio"  checked value="Laki - Laki"
                                           name="radioGender">Laki - Laki
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" value="Perempuan"
                                           name="radioGender">Perempuan
                                </label>
                            </div>
                            <div class="form-group">
                                <label> Pilih Colector </label>
                                <select class="form-control" name="idPegawai" id="idUser" >
                                    @foreach($data as $datas)
                                        <option value="{{$datas->idPegawai}}"> {{$datas->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control @error('alamat')
                                    is-invalid @enderror" placeholder="Masukkan alamat nasabah"
                                       name="alamat">
                                @error('alamat')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" placeholder="Masukkan password">
                                @error('password')
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

