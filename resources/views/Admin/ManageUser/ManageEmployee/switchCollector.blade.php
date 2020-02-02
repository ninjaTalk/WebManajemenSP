@extends('layouts/master')
@section('title', 'Penggantian Collector')

@section('content')

    <div class="main">
        <div style="width: auto; background-color: #00b488; padding: 10px 5px 5px 5px;">
            <h1 style="margin-bottom: 30px !important;margin-left: 20px !important; color: white;">
                <strong>
                   Ganti Collector
                </strong>
            </h1>
        </div>
        <div class="main-content" >
            <div class="container-fluid" >
                <div class="panel">
                    <div class="panel-body" style=" padding: 30px 25px 25px 40px ">
                        <form method="post" action="/employee/changeCollector">
                            @csrf
                            <input type="hidden" name="kodeCollector" value="{{$data['user']}}">
                            <div class="form-group">
                                <label> Pilih Colector </label>
                                <select class="form-control" name="idPegawai" id="idUser" >
                                    @foreach($data['data'] as $datas)
                                        <option value="{{$datas->idPegawai}}"> {{$datas->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Ubah Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
