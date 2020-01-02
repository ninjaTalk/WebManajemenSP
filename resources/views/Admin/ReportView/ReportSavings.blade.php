@extends('layouts/master')
@section('title', 'Laporan Simpanan')
@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-body" style="background-color: #00b488;padding-left: 0; padding-top: 0;padding-bottom: 0;">
                        <div class="col-md-1" style="margin-right: 10px; background-color: white">
                            <img style="padding: 5px 0 5px 5px" src="{{asset('admin/assets/img/tabungan.png')}}"
                                 width="95" height="90" alt="Icon_tabungan" >
                        </div>
                        <div class="col-md-6 mr-3 float-right" style="color: white">
                            <h3>
                                <strong>Laporan Simpanan</strong>
                            </h3>
                            <p>Menampilkan data simapanan nasabah berdasarkan <strong>Kode Collector</strong></p>
                        </div>
                    </div>
                    <hr style="margin: 10px 0 0 0"/>
                    <div class="panel-heading">
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
                            <form action="/PSavings" method="get">
                                <input type="hidden" id="cloneDate" name="cloneCollect" value="{{$capsule['selected']}}">
                                <input onclick="setClone()" type="submit" class="btn btn-danger" value="CETAK">
                            </form>
                        </div>
                    </div>

                        <div class="panel-body" style="margin-top: -40px;">
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
                                                <th>Rp. {{number_format($datas->saldo, 0, "", ",")}}</th>
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
    <script type="text/javascript">

        function setClone() {
            var date = document.getElementById("myDate").value;
            //alert(date);
            //document.getElementById("cloneDate").defaultValue = document.getElementById("selector").value + "";
        }
    </script>
    <script src="jquery-3.4.1.min.js"></script>
@endsection

