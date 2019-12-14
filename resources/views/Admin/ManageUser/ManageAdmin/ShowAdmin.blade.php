@extends('layouts/master')
@section('title', 'Data Admin')
@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading">
                        <h3><strong>Data Admin</strong></h3>
                        <h5 style="margin-top: -5px;margin-left: 10px">Menampilkan Data Admin, beserta fungsi - fungsi pengelolaan user Admin</h5>
                    </div>
                    <div class="panel-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{session()->get('success')}}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-warning">
                                {{session()->get('error')}}
                            </div>
                        @endif
                        <a href="/admins/create" class="btn btn-primary">Tambah Admin Baru</a>
                        <div class="card-body">
                            <ul class="list-group pagination col-md-12">
                                <table id="coba"
                                       class="table table-striped table-bordered">
                                    <thead class="col-mid-8">
                                    <tr>
                                        <th >ID</th>
                                        <th>Name</th>
                                        <th>Jenis Kelamin</th>
                                        <th>View</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $datas)
                                        <tr>
                                            <th>{{$datas->idPegawai}}</th>
                                            <th>{{$datas->name}}</th>
                                            <th>{{$datas->gender}}</th>
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
                                @if(count($data)>6)
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
