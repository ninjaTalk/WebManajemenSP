@extends('layouts.app')

@section('content')

    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading">
                        <a class="btn-info">
                            Transaksi Tabungan
                        </a>

                    </div>
                    <div class="panel-body">
                        <a href="/loan/create" class="btn btn-primary">Tambah Admin Baru</a>
                        <div class="card-body">
                            <ul class="list-group pagination col-md-10">
                                <table id="coba"
                                       class="table table-striped table-bordered">
                                    <thead class="col-mid-8">
                                    <tr>
                                        <th>Kode Transaksi</th>
                                        <th>ID Nasabah</th>
                                        <th>Tanggal Input</th>
                                        <th>Jenis Transaksi</th>
                                        <th>Debit</th>
                                        <th>Debt</th>
                                        <th>PP Nomor</th>
                                        <th>Kode Tabungan</th>
                                        <th>ID Pegawai</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $datas)
                                        <tr>
                                            <th>{{$datas->kodeTransaksi}}</th>
                                            <th>{{$datas->idNasabah}}</th>
                                            <th>{{$datas->tglInput}}</th>
                                            <th>{{$datas->transactionType}}</th>
                                            <th>{{$datas->debit}}</th>
                                            <th>{{$datas->debt}}</th>
                                            <th>{{$datas->ppNomor}}</th>
                                            <th>{{$datas->kodeTabungan}}</th>
                                            <th>{{$datas->idPegawai}}</th>
                                            <th>
                                                <a class="btn btn-primary" href="/admins/{{$datas->idPegawai}}/edit">Edit</a>
                                                <a class="btn btn-danger" href="#" onclick="
                                                    if (window.confirm('Apakah anda yakin ingin menghapus data ini ? ')){
                                                    $('#formDelete{{$datas->idPegawai}}').submit()
                                                    }
                                                    ">delete</a>
                                                <form action="{{route('admins.destroy', $datas->idPegawai)}}"
                                                      id="formDelete{{$datas->idPegawai}}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                </form>
                                            </th>
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
    <script src="jquery-3.4.1.min.js"></script>
@endsection
