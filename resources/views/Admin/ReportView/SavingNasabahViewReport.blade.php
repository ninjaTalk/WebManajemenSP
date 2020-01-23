<!DOCTYPE html>
<html>
<head>
    <title>Report Transaction</title>
</head>
<body>
<style type="text/css">
    #ReportView{
        align-content: center;
        background-color: white;
    }
    #textHeading{
        width: 500px;
        text-align: left;
    }
    #SpaceBox{
        margin-top: 50px;
    }
    #tabFot tr th{
        font-style: normal;
        border-collapse: separate;
        border: 1px solid white;
    }
    #tabFot{
        width: 600px;
    }
    #tabFot tr th{
        padding-bottom: 40px;
    }
    .txt{
        text-align: center;

    }
    .fLeft{
        float: left;
    }
    .fRight{
        float: right;
    }
    table{
        width: 600px;
        margin-top: 20px;
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
    }
    label{
        font-size: 14px;
    }
    form{
        text-align: left;
    }
    table tr td,
    table tr th{
        font-family: "Times New Roman", serif;
        border: 1px solid black;
        font-size: 12pt;
        text-align: center;
        padding: 5px 12px 5px 12px;
    }
    #l1{
        font-size: 22px;
    }
    .l2{
        font-size: 14px;
    }
    #l3{
        font-size: 18px;
    }
    #image{
        float: outside;
        text-align: justify;
    }
    #heading{
        text-align: center;
    }

</style>

<div id="ReportView">
    <div>
        <img id="image" src="{{public_path('admin/assets/img/new logo.png')}}"
             alt="logo" height="70px" width="75px">
    </div>
    <div id="heading">
        <label id="l1"><strong>KOPERASI CATUR SARI CAHAYA</strong></label>
        <div></div>
        <label class="l2"><strong>ALAMAT KANTOR Jl. ERLANGGA NO. 3 BANGLI</strong></label>
        <div style="margin-top: 20px"></div>
        <label id="l3"><strong>TABUNGAN NASABAH</strong></label>
    </div>
    <hr>
    <hr>
    <div id="textHeading">
        <form class="float-left">
            <label><strong>NAMA:  {{$capsule['user']->name}}</strong></label>
            <div></div>
            <label><strong>ALAMAT: {{$capsule['user']->alamat}}</strong></label>
            <div></div>
            <label><strong>KODE TABUNGAN : {{$capsule['user']->kodeTabungan}}</strong></label>
            <div></div>
        </form>
    </div>

    <table>
        <thead >
        <tr>
            <th style="width: 80px">Tanggal Isi</th>
            <th style="width: 100px">Nominal Isi</th>
            <th style="width: 100px">Saldo</th>
            <th style="width: 100px">Nama Collector</th>
        </tr>
        </thead>
        <tbody>
        @foreach($capsule['transaction'] as $datas)
            <tr>
                <th>{{$datas->tglInput}}</th>
                <th>Rp. {{number_format($datas->debit, 0, "", ",")}}</th>
                <th>Rp. {{number_format($datas->saldoTabungan, 0, "", ",")}}</th>
                <th>{{$datas->name}}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
