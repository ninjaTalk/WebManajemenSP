@extends('layouts/master')
@section('title', 'Edit Transaksi')

@section('content')

    <div class="main">
        <div style="width: auto; background-color: #00b488; padding: 10px 5px 5px 5px;">
            <h1 style="margin-bottom: 30px !important;margin-left: 20px !important; color: white;">
                <strong>
                    Edit Transaksi
                </strong>
            </h1>
        </div>
        <div class="main-content" >
            <div class="container-fluid" >
                <div class="panel">
                    <div class="panel-body" style=" padding: 10px 25px 25px 40px ">
                        @foreach($data as $datas)
                            <form method="post" action="/transaction/{{$datas->id}}">
                                @csrf
                                @method('patch')
                                <div class="form-row">
                                    <div class="form-group col-md-6" style="padding-left: 0">
                                        <label>Kode Transaksi</label>
                                        <input type="text" class="form-control" autofocus value="{{$datas->kodeTransaksi}}"
                                               disabled placeholder="Masukkan nama pegawai" name="kodeTransaksi">
                                    </div>
                                    <div class="form-group col-md-6" style="padding-right: 0">
                                        <label>ID Nasabah</label>
                                        <input type="text" class="form-control"value="{{$datas->idNasabah}}" disabled >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="form-control"value="{{$datas->transactionType}}"
                                           name="transactionType" >
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="form-control"value="{{$datas->kodeTabungan}}"
                                           name="kodeTabungan"  >
                                    <input type="hidden" class="form-control"value="{{$datas->ppNomor}}"
                                           name="ppNomor" >
                                    <input type="hidden" class="form-control" value="{{$datas->tglInput}}"
                                           name="getTgl">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Input</label>
                                    <input type="text" class="form-control" autofocus value="{{$datas->tglInput}}"
                                           disabled>
                                </div>
                                @if($datas->debit!=null)
                                    <div class="form-group">
                                        <label>Debit</label>
                                        <input type="text" class="form-control @error('debit')
                                            is-invalid @enderror" name="debit" value="{{$datas->debit}}">
                                        @error('debit')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label>Nominal Pembayaran Sebelumnya</label>
                                        <input type="text" class="form-control @error('debt')
                                            is-invalid @enderror" name="debt" disabled value="Rp. {{number_format($datas->debt, 0, "", ",")}}">
                                        @error('debt')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group" >
                                        <label>Pilih Jenis Perubahan Pembayaran : </label>
                                        <input type="hidden" id="lStatus" value="{{$status}}">
                                        <div>
                                            <label class="radio-inline">
                                                <input type="radio" id="radio01" value="biasa" onclick="showHide()"
                                                       name="radioPay">Pembayaran Biasa
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" id="radio02" value="lunas" onclick="showHide()"
                                                       name="radioPay">Pembayaran Lunas
                                            </label>
                                        </div>
                                        <div id="countPay" style="display: block; margin-top: 10px">
                                            <input type="number" name="ModifiedPay" class="form-control @error('ModifiedPay')
                                                is-invalid @enderror" placeholder="Rp. {{$result}}">
                                            @error('ModifiedPay')
                                            <div class="alert alert-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="comment">Alasan Perubahan</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              rows="5" name="description"></textarea>
                                    @error('description')
                                    <div class="alert-danger">{{$message}}</div>
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


    <script type="text/javascript">
        $(document).ready(function () {
            getGender();
            //alert("Settings page was loaded");
        });
        function getGender(){
            var status = document.getElementById("lStatus").value;
            //document.getElementById('radio02').checked = true;
            if (status =="LUNAS"){
                document.getElementById("radio01").checked = false;
                document.getElementById("radio02").checked = true;
                setHide();
            }else if (status == "BERJALAN") {
                document.getElementById("radio01").checked = true;
                document.getElementById("radio02").checked = false;
                showHide();
            }
        }
        function showHide(){
            var reguler = document.getElementById("radio01");
            var countPay = document.getElementById("countPay");
            countPay.style.display =reguler.checked ? "block" : "none";
        }
        function setHide(){
            var payed = document.getElementById("radio02");
            var countPay = document.getElementById("countPay");
            countPay.style.display = payed.checked ? "none" : "block" ;
        }
    </script>
@endsection
