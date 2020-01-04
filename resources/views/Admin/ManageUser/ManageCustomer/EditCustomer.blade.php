@extends('layouts/master')
@section('title', 'Edit Nasabah')

@section('content')
    <div class="main">
        <div style="width: auto; background-color: #00b488; padding: 10px 5px 5px 5px;">
            <h1 style="margin-bottom: 30px !important;margin-left: 20px !important; color: white;">
                <strong>
                    Edit Nasabah
                </strong>
            </h1>
        </div>
        <div class="main-content" >
            <div class="container-fluid" >
                        <div class="panel col-md-12">
                            <div class="panel-body" style=" padding: 10px 10px 20px 10px;font-size: 16px ">
                                @foreach($data as $datas)
                                    <form method="post" action="/customer/{{$datas->idNasabah}}">
                                        @csrf
                                        @method('patch')
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>ID Nasabah</label>
                                                <input type="text" class="form-control"value="{{$datas->idNasabah}}" disabled >
                                            </div>
                                            <div class="col-md-6" style="margin-bottom: 20px;">
                                                <label>Nama</label>
                                                <input type="text" class="form-control
                                                 @error('name') is-invalid @enderror" autofocus value="{{$datas->name}}"
                                                       placeholder="Masukkan nama pegawai" name="name">
                                                @error('name')
                                                <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12" style="margin-bottom: 20px;">
                                                <label>Nomor KTP</label>
                                                <input type="text" class="form-control @error('noKtp')
                                                    is-invalid @enderror" name="noKtp" value="{{$datas->noKtp}}">
                                                @error('noKtp')
                                                <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12" style="margin-bottom: 20px;">
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
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6" >
                                                <label>Alamat</label>
                                                <input type="text" class="form-control @error('alamat')
                                                    is-invalid @enderror" name="alamat" value="{{$datas->alamat}}" >
                                                @error('alamat')
                                                <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6" style="margin-bottom: 20px;">
                                                <label>Password</label>
                                                <input type="text" class="form-control @error('password') is-invalid @enderror"
                                                       name="password" placeholder="Masukkan password" value="{{$datas->password}}">
                                                @error('password')
                                                <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>QR Code</label>
                                                <input type="text" class="form-control" name="alamat"
                                                       value="{{$datas->qrcode}}" disabled>
                                            </div>
                                            <div class="col-md-6" style="margin-bottom: 20px;">
                                                <label>Kode Collector</label>
                                                <input type="text" class="form-control @error('kodeCollector')
                                                    is-invalid @enderror" name="kodeCollector" value="{{$datas->kodeCollector}}" disabled >
                                                @error('kodeCollector')
                                                <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>Kode Tabungan</label>
                                                <input type="text" class="form-control" name="alamat"
                                                       value="{{$datas->kodeTabungan}}" disabled>
                                            </div>
                                            <div class="col-md-6" style="margin-bottom: 20px;">
                                                <label>PP Nomor</label>
                                                <input type="text" class="form-control" name="alamat"
                                                       value="{{$datas->ppNomor}}" disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary float-right">Perbaharui Data</button>
                                            </div>
                                        </div>
                                    </form>
                                @endforeach
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

