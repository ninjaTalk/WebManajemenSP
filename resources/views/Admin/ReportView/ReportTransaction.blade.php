@extends('layouts/master')
@section('title', 'Laporan Transaksi')
@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel" style="padding-top: 10px">
                    <div class="panel-body" style="background-color: #00b488;padding-left: 0; padding-top: 0;padding-bottom: 0;">
                        <div class="col-md-1" style="margin-right: 10px; background-color: white">
                            <img src="{{asset('admin/assets/img/bayar.png')}}"
                                 width="95" height="90" alt="Icon_transaksi" >
                        </div>
                        <div class="col-md-6 mr-3 float-right" style="color: white">
                            <h3>
                                <strong>Laporan Transaksi</strong>
                            </h3>
                            <p>Menampilkan data transaksi berdasarkan <strong>Kode Collector</strong> dan <strong>Tanggal Transaksi</strong></p>
                        </div>
                    </div>
                    <hr style="margin: 10px 0 0 0"/>
                    <div class="panel-heading" >
                        <div class="form-group">
                            <form action="/selectiveReport" method="get">
                                <div class="form-group form-inline col-md-8" >
                                    <label class="form-group form-control">Pilih Area Collector</label>
                                    <select id="selector" name="kodeCollector" class="form-group form-control">
                                        @foreach($capsule['collect'] as $data2)
                                            <option>{{$data2->kodeCollector}}</option>
                                        @endforeach
                                    </select>
                                    <input type="date" style="padding-bottom: 10px" id="myDate" class="form-control" name="tanggal" value="{{$capsule['date']}}">
                                    <span class="input-group-prepend ml-1">
                                    <input  type="submit" value="CARI" class="btn btn-primary">
                                </span>
                                </div>
                            </form>
                            <form action="/PTransaction" method="get">
                                <input type="hidden" id="cloneDate" name="clone">
                                <input type="hidden" id="cloneCollet" name="cloneCollect" value="{{$capsule['selected']}}">
                                <input onclick="setClone()" type="submit" class="btn btn-danger" value="CETAK">
                            </form>
                        </div>

                    </div>
                    <div class="panel-body" style="margin-top: -40px;">
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
{{--                                <a href="/PTransaction/{{$capsule['date']}}" class="btn btn-danger">CETAK</a>--}}
                            <div class="card-body">
                                <ul class="list-group pagination col-md-12">
                                    <table id="example"
                                           class="table table-striped table-bordered responsive">
                                        <thead class="col-mid-8">
                                        <tr>
                                            <th>Tanggal Input</th>
                                            <th>Nama Nasabah</th>
                                            <th>Jenis Transaksi</th>
                                            <th>Kode Tabungan</th>
                                            <th>Debit</th>
                                            <th>PP Nomor</th>
                                            <th>Debt</th>
                                            <th>Nama Collector</th>
                                            <th>Ket</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($capsule['data'] as $datas)
                                            @if($datas->description != null)
                                                <tr style="background-color: #c7254e; color: white">
                                            @else
                                                <tr>
                                            @endif
                                                    <th>{{$datas->tglInput}}</th>
                                                    <th>{{$datas->nameCus}}</th>
                                                    <th>{{$datas->transactionType}}</th>
                                                    @if($datas->debit != null)
                                                        <th>{{$datas->kodeTabungan}}</th>
                                                        <th>Rp.{{number_format($datas->debit, 0, "", ",")}}</th>
                                                    @else
                                                        <th></th>
                                                        <th></th>
                                                    @endif

                                                    @if($datas->debt != null)
                                                        @if($datas->ppNomor == "-")
                                                            <th>LUNAS</th>
                                                        @else
                                                            <th>{{$datas->ppNomor}}</th>
                                                        @endif
                                                        <th>Rp.{{number_format($datas->debt, 0, "", ",")}}</th>
                                                    @else
                                                        <th></th>
                                                        <th></th>
                                                    @endif
                                                    <th>{{$datas->name}}</th>
                                                    <th>{{$datas->description}}</th>
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
            //alert(date);
            document.getElementById("cloneDate").defaultValue = document.getElementById("myDate").value + "";
        }
    </script>
    <script src="jquery-3.4.1.min.js"></script>
@endsection

