<!DOCTYPE html>
<html>
<head>
    <title>Report Transaction</title>
</head>
<body>
<style type="text/css">
    table{
        border-collapse: collapse;
    }

    table tr td,
    table tr th{
        border: 1px solid black;
        font-size: 11pt;
        text-align: center;
        font-style: normal;
        font-family: "Times New Roman", sans-serif;
        padding: 8px;
    }
    #l1{
        font-family: Arial,sans-serif;
        text-transform: uppercase;
        font-size: 22px;
    }
    .l2{
        font-family: Arial,sans-serif;
        text-transform: uppercase;
        font-size: 14px;
    }
    #l3{
        font-family: Arial,sans-serif;
        text-transform: uppercase;
        font-size: 18px;
    }
    #image{
        float: outside;
        text-align: justify;
    }
    #heading{
        text-align: center;
    }
    .space{
        margin-top: 10px;
    }
</style>
    <img id="image" src="{{public_path('admin/assets/img/logo.png')}}"
         alt="logo" height="75px" width="75px">
    <div  id="heading">
        <label id="l1"><strong>{{$data['profile']->name}}</strong></label>
        <div class="space"></div>
        <label class="l2"><strong style="">Alamat Kantor {{$data['profile']->address}}</strong></label>
        <div></div>
        <label id="l3"><strong>Laporan Transaksi</strong></label>
    </div>
        <hr style="margin-top: 20px;">
        <hr>
            <form class="float-left">
                <label><strong>Kode Collector : {{$data['Collector']}}</strong></label>
                <p style="font-family: Times New Roman, sans-serif;">Tanggal Transaksi : Laporan ini merupakan data transaksi simpanan dan tabungan yang dilakukan pegawai pada tanggal
                    <strong>{{$data['date']}}</strong></p>
            </form>

        <table style="margin-top: 30px;" >
            <thead >
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
            @foreach($data['data'] as $datas)
                @if($datas->description != null)
                    <tr style="background-color: #8d9093; font-style: normal;">
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
                            <th>{{$datas->ppNomor}}</th>
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
</body>
</html>
