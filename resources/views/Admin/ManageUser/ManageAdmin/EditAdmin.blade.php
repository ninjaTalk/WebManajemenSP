@extends('layouts/master')
@section('title', 'Edit Admin')

@section('content')
    <div class="main">
        <div style="width: auto; background-color: #3399ff; padding: 10px 5px 5px 5px;">
            <h1 style="margin-bottom: 30px !important;margin-left: 20px !important;color: white;text-transform: uppercase" >
                <strong>
                    EDIT Admin
                </strong>
            </h1>
        </div>
        <div class="container-fluid" style="padding-left: 0" >
            <div class="main" style="padding: 0 0 0 0">
                <div class="main-content" >
                    <div class="panel col-md-9">
                        <div class="panel-body" style=" padding: 35px 25px 25px 40px; font-size: 16px ">
                            @foreach($data as $datas)
                                <form method="post" action="/admins/{{$datas->idPegawai}}">
                                    @csrf
                                    @method('patch')
                                    <div class="form-group">
                                        <label>Kode Collector</label>
                                        <input type="text" class="form-control"value="{{$datas->idPegawai}}" disabled >
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
                                        <label>Jenis Kelamin</label>
                                        <input type="hidden" id="lGender" value="{{$datas->gender}}">
                                        <div>
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
                                        <label>Kode Collector</label>
                                        <input type="text" class="form-control @error('kodeCollector')
                                            is-invalid @enderror" name="kodeCollector" value="{{$datas->kodeCollector}}" disabled >
                                        @error('kodeCollector')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="text" class="form-control @error('password') is-invalid @enderror"
                                               name="password" placeholder="Masukkan password" value="{{$datas->password}}">
                                        @error('password')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
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
