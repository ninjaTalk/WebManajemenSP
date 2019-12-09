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
        font-size: 12pt;
        text-align: justify;
        padding: 8px;
    }
</style>
<center>
    <h4>Laporan Transaksi Koperasi Catur Sari Cahaya</h4>
        <h5>Bangli, {{$data['date']}}</h5>

        <table >
            <thead >
            <tr>
                <th>ID</th>
                <th>Tanggal Transaksi</th>
                <th>Kode Tabungan</th>
                <th>PP Nomor</th>
                <th>Nama Nasabah</th>
                <th>Jenis Transaksi</th>
                <th>Debit</th>
                <th>Debt</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['data'] as $datas)
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
</center>

</body>
</html>
