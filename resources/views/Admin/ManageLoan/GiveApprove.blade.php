@extends('layouts/master')
@section('title', 'Tambah Pinjaman')

@section('content')
    <div class="main">
        <div style="width: auto; background-color: #00b488; padding: 10px 5px 5px 5px;">
            <h1 style="margin-bottom: 30px !important;margin-left: 20px !important; color: white;">
                <strong>
                    Pengesahan Pinjaman
                </strong>
            </h1>
        </div>
        <div class="main-content" >
            <div class="container-fluid" >
                <div class="panel">
                    <div class="panel-body" style=" padding: 30px 25px 25px 40px ">
                        <form id="formApprove" method="post" action="/loan/{{$loan->id}}">
                            @csrf
                            @method('patch')
                                <div class="form-group" style="margin-bottom: 20px !important;">
                                    <label>Nasabah </label>
                                    <input type="text" disabled class="form-control" value="{{$loan->name}}">
                                    <input type="hidden" name="id" class="form-control" value="{{$loan->id}}">
                                </div>
                                <div class="form-group" style="margin-bottom: 20px !important;">
                                    <label>No KTP </label>
                                    <input type="text" disabled class="form-control" value="{{$loan->noKtp}}">

                                </div>
                                <div class="form-group col-md-12" style="margin-bottom: 20px !important; padding-left: 0; margin-left: 0;padding-right: 0; margin-right: 0">
                                    <div class="col-md-6" style="margin-left: 0;padding-left: 0">
                                        <label>Tanggal Pinjaman </label>
                                        <input type="text" disabled class="form-control"  value="{{$loan->tglPinjam}}">
                                    </div>
                                    <div class="col-md-6" style="margin-right: 0;padding-right: 0">
                                        <label>Jenis Bunga</label>
                                        <input type="text" disabled class="form-control" value="{{$loan->loanType}}">
                                    </div>
                                </div>
                                <div class="form-group " style="margin-bottom: 20px !important;">

                                </div>
                                <div class="form-group col-md-12" style="margin-bottom: 30px !important; margin-left: 0;padding-left: 0;padding-right: 0; margin-right: 0">
                                    <div class="col-md-6" style="margin-left: 0;padding-left: 0">
                                        <label>Jumlah Pinjaman</label>
                                        <input type="text" disabled class="form-control" value="Rp.{{number_format($loan->saldoPinjaman, 0, "", ",")}}">
                                    </div>
                                    <div class="col-md-6" style="margin-right: 0;padding-right: 0">
                                        <label>Pokok Pinjaman</label>
                                        <input type="text" disabled class="form-control" value="Rp. {{number_format($loan->pokokPinjaman, 0, "", ",")}}">
                                    </div>
                                </div>
                            <div class="form-group col-md-12" style="margin-bottom: 30px !important; margin-left: 0;padding-left: 0;padding-right: 0; margin-right: 0">
                                <div class="col-md-6" style="margin-left: 0;padding-left: 0">
                                    <label>Jaminan</label>
                                    <input type="text" disabled class="form-control" value="{{$loan->jaminan}} ">
                                </div>
                                <div class="col-md-6" style="margin-right: 0;padding-right: 0">
                                    <label>Dibuat Pada</label>
                                    <input type="text" disabled class="form-control" value="{{$loan->created_at}}">
                                </div>
                            </div>
                            <button type="submit" onclick="$('#formApprove').submit()" class="btn btn-success col-md-2">Setujui Pinjaman</button>

                        </form>
                        <a class="btn btn-warning col-md-2" style="margin-left: 20px" href="#" onclick="
                            if (window.confirm('Apakah anda yakin ingin menolak pinjaman ini ? ')){
                            $('#formReject{{$loan->id}}').submit()
                            }
                            ">Menolak Pinjaman</a>
                        <form action="{{route('loan.reject', $loan->id)}}"
                              id="formReject{{$loan->id}}" method="POST">
                            @csrf
                        </form>
{{--                        <div class="col-lg-1">--}}
{{--                        </div>--}}
                        <a class="btn btn-danger col-md-2" style="margin-left: 20px" href="#" onclick="
                            if (window.confirm('Apakah anda yakin ingin menghapus data ini ? ')){
                                $('#formDelete{{$loan->id}}').submit()
                            }
                            ">Hapus</a>
                        <form action="{{route('loan.destroy', $loan->id)}}"
                              id="formDelete{{$loan->id}}" method="POST">
                            @method('delete')
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
