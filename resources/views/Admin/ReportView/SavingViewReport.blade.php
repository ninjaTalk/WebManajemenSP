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
        font-family: "Times New Roman", serif;
        border: 1px solid black;
        font-size: 12pt;
        text-align: justify;
        padding: 8px;
    }
</style>
<center>
    <h6>MENU UTAMA</h6>
    <h4>SALDO SIMPANAN BULAN {{$capsule['mouth']}} {{$capsule['year']}} </h4>
    <h4>NAMA KOLEKTOR : {{$capsule['collect']->name}}</h4>
    <h4>KODE AREA : {{$capsule['selected']}}</h4>

    <table>
        <thead >
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
                <th>Rp. {{$datas->saldo}}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
</center>

</body>
</html>
