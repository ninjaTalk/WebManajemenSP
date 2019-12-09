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
                                <h1>Edit Nasabah</h1>
                                <form method="post" action="/customer/{{$datas->idNasabah}}">
                                    @csrf
                                    @method('patch')
                                    <div class="form-group">
                                        <label>ID Nasabah</label>
                                        <input type="text" class="form-control"value="{{$datas->idNasabah}}" disabled >
                                    </div>
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control
                                        @error('name') is-invalid @enderror" autofocus value="{{$datas->name}}"
                                               placeholder="Masukkan nama pegawai" name="name">
                                        @error('name')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Nomor KTP</label>
                                        <input type="text" class="form-control @error('noKtp')
                                            is-invalid @enderror" name="noKtp" value="{{$datas->noKtp}}">
                                        @error('noKtp')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <div></div>
                                        <input type="hidden" id="lGender" value="{{$datas->gender}}">
                                        <label class="radio-inline">
                                            <input type="radio" id="radio01" value="Laki - Laki"
                                                   name="radioGender">Laki - Laki
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" id="radio02" value="Perempuan"
                                                   name="radioGender">Perempuan
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control @error('alamat')
                                            is-invalid @enderror" name="alamat" value="{{$datas->alamat}}" >
                                        @error('alamat')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>password</label>
                                        <input type="text" class="form-control @error('password') is-invalid @enderror"
                                               name="password" placeholder="Masukkan password" value="{{$datas->password}}">
                                        @error('password')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>QR Code</label>
                                        <input type="text" class="form-control" name="alamat"
                                               value="{{$datas->qrcode}}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Kode Collector</label>
                                        <input type="text" class="form-control @error('kodeCollector')
                                            is-invalid @enderror" name="kodeCollector" value="{{$datas->kodeCollector}}" disabled >
                                        @error('kodeCollector')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Kode Tabungan</label>
                                        <input type="text" class="form-control" name="alamat"
                                               value="{{$datas->kodeTabungan}}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>PP Nomor</label>
                                        <input type="text" class="form-control" name="alamat"
                                               value="{{$datas->ppNomor}}" disabled>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Perbaharui Data</button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--   // <input value="{{$data->name}}">--}}
    <script type="text/javascript">
        $(document).ready(function () {
            getGender();
            //alert("Settings page was loaded");
        });
        function getGender(){
            var gender = document.getElementById("lGender").value;
            //document.getElementById('radio02').checked = true;
            if (gender =="Perempuan"){
                document.getElementById("radio01").checked = false;
                document.getElementById("radio02").checked = true;
            }else if (gender == "Laki - Laki"){
                document.getElementById("radio01").checked = true;
                document.getElementById("radio02").checked = false;
            }
        }
    </script>
@endsection
