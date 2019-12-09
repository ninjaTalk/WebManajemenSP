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
                            <form action="/selectiveReport" method="get">
                                <div class="form-group form-inline col-md-8" >
                                    <input type="date" id="myDate" class="form-control" name="tanggal" value="{{$capsule['date']}}">
                                    <span class="input-group-prepend ml-1">
                                    <input  type="submit" value="CARI" class="btn btn-primary">
                                </span>
                                </div>
                            </form>
                        </div>

                            <form action="/PTransaction" method="get">
                                    <input type="hidden" id="cloneDate" name="clone">
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
{{--                                <a href="/PTransaction/{{$capsule['date']}}" class="btn btn-danger">CETAK</a>--}}
                            <div class="card-body">
                                <ul class="list-group pagination col-md-12">
                                    <table id="example"
                                           class="table table-striped table-bordered responsive">
                                        <thead class="col-mid-8">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tanggal Input</th>
                                            <th>Kode Tabungan</th>
                                            <th>PP Nomor</th>
                                            <th>Nama Nasabah</th>
                                            <th>Jenis Transaksi</th>
                                            <th>Debit</th>
                                            <th>Debt</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($capsule['data'] as $datas)
                                            <tr>
                                                <th>{{$datas->id}}</th>
                                                <th>{{$datas->tglInput}}</th>
                                                <th>{{$datas->kodeTabungan}}</th>
                                                <th>{{$datas->ppNomor}}</th>
                                                <th>{{$datas->name}}</th>
                                                <th>{{$datas->transactionType}}</th>
                                                <th>Rp.{{$datas->debit}}</th>
                                                <th>Rp.{{$datas->debt}}</th>
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
        // var temp;
        // $(document).ready(function () {
        //     var today = new Date();
        //     var dd = today.getDate();
        //     var mm = today.getMonth()+1; //January is 0!
        //     var yyyy = today.getFullYear();
        //     var date = document.getElementById("myDate").value;
        //     if(dd<10){
        //         dd='0'+dd;
        //     }
        //     if(mm<10){
        //         mm='0'+mm;
        //     }
        //     today = yyyy+'-'+mm+'-'+dd;
        //         document.getElementById("myDate").defaultValue = today + "";
        //
        // });
        function setClone() {
            var date = document.getElementById("myDate").value;
            alert(date);
            document.getElementById("cloneDate").defaultValue = document.getElementById("myDate").value + "";
        }
    </script>
    <script src="jquery-3.4.1.min.js"></script>
@endsection

