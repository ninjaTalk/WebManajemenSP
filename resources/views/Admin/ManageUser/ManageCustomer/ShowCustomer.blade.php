@extends('layouts/master')
@section('title', 'Data Nasabah')

@section('content')

    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading" style="background-color: #00b488;color: white;">
                        <img style="float: left;margin-right: 10px;" src="{{asset('admin/assets/img/customers_white.png')}}"
                             alt="icon_admin" height="75px"/>
                        <h3><strong>Data Nasabah</strong></h3>
                        <h5 style="margin-top: -5px;margin-left: 10px">Menampilkan Data Nasabah, beserta fungsi - fungsi pengelolaan user Nasabah</h5>
                    </div>
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
                         <div style="margin-top: 20px;"></div>
                         <div class="card-body">
                             <a href="/customer/create" class="btn btn-primary">Tambah Nasabah Baru</a>
                            <ul class="list-group pagination col-md-12">
                                <table class="table table-striped table-bordered">
                                    <thead class="col-mid-8">
                                    <tr>
                                        <th >ID</th>
                                        <th>Name</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>No Ktp</th>
                                        <th>Kode Collector</th>
                                        <th>Nama Collector</th>
                                        <th>View</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $datas)
                                        <tr>
                                            <th>{{$datas->idNasabah}}</th>
                                            <th>{{$datas->name}}</th>
                                            <th>{{$datas->gender}}</th>
                                            <th>{{$datas->alamat}}</th>
                                            <th>{{$datas->noKtp}}</th>
                                            <th>{{$datas->kodeCollector}}</th>
                                            <th>{{$datas->namePegawai}}</th>
                                            <th>
                                                <a class="btn btn-primary" href="/customer/{{$datas->idNasabah}}/edit">Edit</a>
                                                <a class="btn btn-danger" href="#" onclick="
                                                    if (window.confirm('Apakah anda yakin ingin menghapus data ini ? ')){
                                                    $('#formDelete{{$datas->idNasabah}}').submit()
                                                    }
                                                    ">delete</a>
                                                <form action="{{route('customer.destroy', $datas->idNasabah)}}"
                                                      id="formDelete{{$datas->idNasabah}}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                </form>
                                            </th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if(count($data)>=1)
                                    {{$data->Links()}}
                                @endif
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
