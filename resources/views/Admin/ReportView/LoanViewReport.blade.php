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
</style>
<center>
    <div id="ReportView">
{{--        <img src="{{asset('admin/assets/img/logo.png')}}"--}}
{{--             alt="logo" height="75px">--}}
        <div id="heading">
            <label id="l1"><strong>KOPERASI CATUR SARI CAHAYA</strong></label>
            <div></div>
            <label class="l2"><strong>BADAN HUKUM : BH. NO. 08 / BH / XXVII.2 / 2008</strong></label>
            <div></div>
            <label class="l2"><strong>ALAMAT KANTOR Jl. ERLANGGA NO. 3 BANGLI</strong></label>
            <div style="margin-top: 20px"></div>
            <label id="l3"><strong>KITIR PEMBAYARAN</strong></label>
        </div>
        <hr>
        <hr>
        <center>
            <div id="textHeading">
                <form class="float-left">
                    <label><strong>NAMA:  {{$capsule['user']->name}}</strong></label>
                    <div></div>
                    <label><strong>ALAMAT: {{$capsule['user']->alamat}}</strong></label>
                    <div></div>
                    <label><strong>PP NOMOR : {{$capsule['user']->ppNomor}}</strong></label>
                    <div></div>
                    <label><strong>TANGGAl : {{$capsule['day']}} {{$capsule['mouth']}} {{$capsule['year']}}</strong></label>
                </form>
                <p>Kartu ini hendaknya dibawa setiap pembayaran angsuran</p>
                <label>Pokok Pinjaman :   <strong>Rp.{{$capsule['dataLoans']->saldoPinjaman}}</strong> dalam 10 kali Angsuran</label>
            </div>
        </center>
            <table>
                <thead >
                <tr>
                    {{--            <th>Bulan</th>--}}
                    <th>Tanggal</th>
                    <th>Pokok</th>
                    <th>Bunga 3%</th>
                    <th>Jumlah</th>
                    <th>Saldo Pinjaman</th>
                    <th>Paraf</th>
                </tr>
                </thead>
                <tbody>
                @foreach($capsule['data'] as $datas)
                    <tr>
                        <th>{{$datas->tglInput}}</th>
                        <th>{{$datas->debt}}</th>
                        <th>{{$datas->bunga}}</th>
                        <th>{{$datas->jml}}</th>
                        <th>{{$datas->sisaSaldo}}</th>
                        <th></th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        <div id="SpaceBox"></div>
        <div id="footer">
            <table id="tabFot">
                <thead>
                <tr>

                    <th class="txt">Penanggung</th>
                    <th class="fLeft"></th>
                    <th class="fRight"></th>
                    <th class="txt">Peminjam</th>

                </tr>
                </thead>
                <tbody>
                <tr>
                    <th class="txt">..................</th>
                    <th class="fLeft"></th>
                    <th class="fRight"></th>
                    <th class="txt">{{$capsule['user']->name}}</th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</center>
</body>
</html>
