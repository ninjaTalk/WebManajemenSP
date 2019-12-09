@extends('layouts/master')
@section('title', 'Data Anggoata')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="main">
                    <div class="main-content">
                        <div class="container-fluid">
                                <h1>Tambah Pegawai</h1>
                                <form method="post" action="{{Route('employee.store')}}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control
                                        @error('name') is-invalid @enderror" autofocus
                                               placeholder="Masukkan nama admin" name="name">
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
                                        <label>password</label>
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
    </div>
@endsection
