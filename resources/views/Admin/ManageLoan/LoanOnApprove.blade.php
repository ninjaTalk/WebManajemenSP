@extends('layouts.master')
@section('title', 'Data Pinjaman')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-body" style="background-color: #5fb95f;
                    padding: 0 0 0 0; margin-bottom: 10px;">
                        <div class="col-md-1" style="margin-right: 10px; background-color: white">
                            <img  src="{{asset('admin/assets/img/contract.png')}}"
                                  width="80" height="80" alt="Icon_pinjaman" >
                        </div>
                        <div class="col-md-6 mr-3 float-right" style="color: white">
                            <h3>
                                <strong>Pengesahan Pinjaman</strong>
                            </h3>
                            <h5 style="margin-top: -5px;margin-left: 10px">
                                Halaman ini menampilkan data pinajaman yang masih belum disetujui
                            </h5>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{session()->get('success')}}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-warning">
                                {{session()->get('error')}}
                            </div>
                        @endif

                            <table class="col-md-12">
                                <tr>
                                    <th style="margin-left: 0;padding-left: 0" class="col-md-"><a href="/loan/create" class="btn btn-primary ">Tambah Pinjaman Baru</a></th>
                                    <th class="col-md-1" style="margin-right: 0;padding-right: 0"><a href="/lunas" class="btn btn-info">Pinjaman LUNAS</a></th>
                                    <th style="margin-right: 0;padding-right: 0" class="col-md-1"><a href="/loan" class="btn btn-info">Pinjaman BERJALAN</a></th>
                                    <th  class="col-md-1"><a href="/loanApprove" class="btn btn-info">Pengesahan Pinjaman</a></th>
                                </tr>
                            </table>

                        <div class="card-body">
                            <div style="margin-top: 50px"></div>
                            <ul class="list-group">
                                @foreach($data as $datas)
                                    <a href="/loan/{{$datas->id}}/edit">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="mr-2">{{$datas->name}} | {{$datas->ppNomor}} | {{$datas->saldoPinjaman}}</span>
                                        </li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="jquery-3.4.1.min.js"></script>
@endsection
