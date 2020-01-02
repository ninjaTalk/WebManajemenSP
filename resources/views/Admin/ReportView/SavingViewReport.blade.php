<!DOCTYPE html>
<html>
<head>
    <title>Report Transaction</title>
</head>
<body>
<style type="text/css">
    table{

        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
    }

    table tr td,
    table tr th{
        font-family: "Times New Roman", sans-serif;
        border: 1px solid black;
        font-size: 11pt;
        text-align: center;
        padding: 8px;
    }
    #l1{
        font-family: "Times New Roman", sans-serif;
        text-transform: uppercase;
        font-size: 16px;
    }
    .l2{
        font-family: "Times New Roman", sans-serif;
        text-transform: uppercase;
        font-size: 14px;
    }
    #l3{
        font-family: "Times New Roman", sans-serif;
        text-transform: uppercase;
        font-size: 14px;
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
<center>
    <img id="image" src="{{public_path('admin/assets/img/logo.png')}}"
         alt="logo" height="75px" width="75px">
    <div  id="heading">
        <label>MENU UTAMA</label>
        <div></div>
        <label id="l1"><strong>SALDO SIMPANAN BULAN {{$capsule['mouth']}} {{$capsule['year']}}</strong></label>
        <div class="space"></div>
        <label class="l2"><strong>NAMA KOLEKTOR : {{$capsule['collect']->name}}</strong></label>
        <div></div>
        <label id="l3"><strong>KODE COLLECTOR : {{$capsule['selected']}}</strong></label>
    </div>
    <hr style="margin-top: 20px;">
    <hr>

    <table>
        <thead>
        <tr>
            <th>ID NASABAH</th>
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
</center>

</body>
</html>
