@extends('layouts/master')
@section('title', 'Tambah Pegawai')

@section('content')
    <div class="main">
        <div style="width: auto; background-color: #e4cb10; padding: 10px 5px 5px 5px;">
            <h1 style="margin-bottom: 30px !important;margin-left: 20px !important; ">
                <strong>
                    Tambah Pegawai
                </strong>
            </h1>
        </div>
        <div class="main-content" >
            <div class="container-fluid" >
                <div class="panel">
                    <div class="panel-body" style=" padding: 35px 25px 25px 40px;font-size: 16px ">
                        <form method="post" action="{{Route('employee.store')}}">
{{--                            <h3 style="margin-bottom: 20px;text-transform: uppercase"><strong>form tambah pegawai</strong></h3>--}}
                            @csrf
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control
                                        @error('name') is-invalid @enderror" autofocus
                                       placeholder="Masukkan nama admin" name="name" value="{{old('name')}}">
                                @error('name')
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
                                <label>Kode Collector</label>
                                <input type="text" class="form-control @error('kodeCollector')
                                    is-invalid @enderror" name="kodeCollector"
                                       placeholder="Masukkan kode Collector (A - Z)">
                                @error('kodeCollector')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                                       placeholder="Masukkan password">
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
