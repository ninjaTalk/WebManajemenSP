@extends('layouts/master')
@section('title', 'Data Transaksi')
@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading">
                        <h3>Data Transaksi</h3>
                        <div class="form-group">
                            <form action="/selectiveCollect" method="get">
                                <div class="form-group form-inline col-md-8" >
                                    <label class="form-group form-control">Pilih Area Collector</label>
                                    <select id="selector" name="kodeCollector" class="form-group form-control">
                                            @foreach($capsule['collect'] as $data2)
                                                <option>{{$data2->kodeCollector}}</option>
                                            @endforeach
                                    </select>
                                </span>
                                    <input  type="submit" value="CARI" class="btn btn-primary">
                                </div>
                            </form>
                        </div>

                        <form action="/PSavings" method="get">
                            <input type="hidden" id="cloneDate" name="cloneCollect" value="{{$capsule['selected']}}">
                            <input onclick="setClone()" type="submit" class="btn btn-danger" value="CETAK">
                        </form>

                    </div>
                    <div class="panel-body">
                        <div class="panel-body">
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
                            <div class="card-body">
                                <ul class="list-group pagination col-md-12">
                                    <table id="example"
                                           class="table table-striped table-bordered responsive">
                                        <thead class="col-mid-8">
                                        <tr>
                                            <th>ID</th>
                                            <th>KODE TABUNGAN</th>
                                            <th>NAMA NASABAH</th>
                                            <th>ALAMAT</th>
                                            <th>SALDO AKHIR</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($capsule['data'] as $datas)
                                            <tr>
                                                <th>{{$datas->idNasabah}}</th>
                                                <th>{{$datas->kodeTabungan}}</th>
                                                <th>{{$datas->name}}</th>
                                                <th>{{$datas->alamat}}</th>
                                                <th>{{$datas->saldo}}</th>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        function setClone() {
            var date = document.getElementById("myDate").value;
            alert(date);
            document.getElementById("cloneDate").defaultValue = document.getElementById("selector").value + "";
        }
    </script>
    <script src="jquery-3.4.1.min.js"></script>
@endsection

