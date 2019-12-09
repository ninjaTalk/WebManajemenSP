@extends('layouts/master')
@section('title', 'Data Anggoata')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="main">
                    <div class="main-content">
                        <div class="container-fluid">
                                <h1>Tambah Nasabah</h1>
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
                                        <input type="text" class="form-control @error('noKtp')
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
                                        <label>password</label>
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
    </div>
    <script type="text/javascript">
        getkodeCollector = function (val) {

        }

        </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
@endsection
