<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/linearicons/style.css')}}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/main.css')}}">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('admin/assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('admin/assets/img/favicon.png')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/stringMonthYear.js"></script>

    <title> @yield('title') </title>
</head>

<body>
<!-- WRAPPER -->
<div id="wrapper">
    <!-- NAVBAR -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="brand">
            <a href="/" style="font-size: 18px; color: #0c1312;">
                <img src="{{asset('admin/assets/img/logo.png')}}" style="background: #f8f8f8" width="60" height="60" alt="Logo Koperasi" >
                <strong>KOPERASI CATUR SARI CAHAYA</strong>
            </a>
            <!-- Right Side Of Navbar -->
        </div>

        <div class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
            </div>
            <div class="navbar-btn navbar-btn-right">
                <label style="padding-right: 20px">{{\Illuminate\Support\Facades\Session::get('name')}}</label>
                <a href="{{ route('logout') }}" class="btn btn-success update-pro"
                   title="Upgrade to Pro" target="_blank"
                   onclick="event.preventDefault();
                   if (window.confirm('Apakah anda yakin ingin keluar (logout) dari sistem ?')){
                       document.getElementById('logout-form').submit();
                   }">
                    <i class="fa fa-rocket"></i> <span>Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </nav>
{{--    </nav>--}}
    <!-- END NAVBAR -->
    <!-- LEFT SIDEBAR -->
    <div id="sidebar-nav" class="sidebar">
        <div class="sidebar-scroll">
            <nav>
                <ul class="nav">
                    <li><a href="/" class="active"><i class="lnr lnr-home"></i> <span>Beranda</span></a></li>
                    <li><a href="/ManageUser" class=""><i class="lnr lnr-users"></i> <span>Kelola Pengguna</span></a></li>
                    <li><a href="/saving" class=""><i class="lnr lnr-chart-bars"></i> <span>Simpanan</span></a></li>
                    <li><a href="/loan" class=""><i class="lnr lnr-book"></i> <span>Pinjaman</span></a></li>
                    <li><a href="/menuReport" class=""><i class="lnr lnr-printer"></i> <span>Cetak Laporan</span></a></li>
                    <li><a href="/search" class=""><i class="lnr lnr-cloud-check"></i> <span>Pencarian</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- END LEFT SIDEBAR -->
    <!-- MAIN -->
    <main class="py-4">
        @yield('content')
    </main>

<!-- END MAIN -->
    <div class="clearfix"></div>
    <footer>
        <div class="container-fluid">
            <p class="copyright">&copy; 2017 <a href="https://www.themeineed.com" target="_blank">Theme I Need</a>. All Rights Reserved.</p>
        </div>
    </footer>
</div>
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="{{asset('admin/assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin/assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('admin/assets/scripts/klorofil-common.js')}}"></script>


</body>

</html>
