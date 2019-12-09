@extends('layouts/master')
@section('title', 'Data Anggoata')

@section('content')

    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-body">
                        <table class="col-md-8 p-3">
                            <tr>
                                <th>
                                    <a href="/employee" >
                                        <img src="{{asset('admin/assets/img/btnAdmin.png')}}"
                                             height="200px">
                                    </a>
                                </th>
                                <th width="100px"></th>
                                <th>
                                    <a href="/admins" >
                                        <img src="{{asset('admin/assets/img/btnPegawai.png')}}"
                                              height="200px">
                                    </a>
                                </th>
                            </tr>
                            <tr>
                                <th >
                                    <a href="/customer">
                                        <img style="margin-top: 20px" src="{{asset('admin/assets/img/btnNasabah.png')}}"
                                              height="200px">
                                    </a>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="jquery-3.4.1.min.js"></script>
@endsection
