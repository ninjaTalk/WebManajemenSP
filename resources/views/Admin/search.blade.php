@extends('layouts/master')
@section('title', 'Data Anggoata')

@section('content')
    <div class="container" style="margin-left: 1px;" >
        <div class="row">
            <div class="col-md-auto"  >
                <div class="main" style="background-color: white; padding-top: 10px;"  >
                    <div class="main-content" style="padding-top: 60px; ">
                        <div class="container-fluid">
                            @if(session()->has('success'))
                                <div class="alert alert-success m-0 p-2">
                                    {{session()->get('success')}}
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-warning m-0 p-2">
                                    {{session()->get('error')}}
                                </div>
                            @endif
                            <form action="/getSearch" style="margin-top: 30px" method="get">
                                <div class="form-group form-inline col-md-auto" >
                                    <div class="pl-5">
                                        <h3 ><strong>Pencarian</strong></h3>

                                        <p style=" font-size:12px;margin-top: -5px;">Masukkan ID User untuk memperoleh <strong>Biodata</strong> Pengguna,
                                            Kode Tabungan untuk melihat data <strong>SIMPANAN</strong> Nasabah, & PP Nomor untuk
                                            memperoleh data <strong>PINJAMAN</strong> Nasabah.
                                        </p>
                                    </div>
                                    <input type="text" class="form-control
                                                @error('keyword') is-invalid @enderror" autofocus
                                           placeholder="Masukkan keyword" name="keyword" required>
                                    @error('keyword')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                    <span class="input-group-prepend">
                                <input  type="submit" value="CARI DATA" class="btn btn-primary">
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
