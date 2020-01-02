@extends('layouts/master')
@section('title', 'Penggantian Collector')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="main">
                    <div class="main-content">
                        <div class="container-fluid">
                            <h1>Ganti Collector</h1>
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
    </div>
@endsection
