<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Sistem Informasi Kerja Praktik</title>

	<!-- Custom fonts for this template-->
	<link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />
	@yield('top')

</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
    <div class="sidebar-brand-icon rotate-n-15">
    <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SIKP<sup>O</sup></div>
    </a>

	<!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item ">
        <a class="nav-link" href="/koor/BimbinganKp">
        <i class="fas fa-fw fa-file"></i>
        <span>Daftar Bimbingan KP</span></a>
    </li>
	<li class="nav-item ">
        <a class="nav-link" href="/koor/UjianKp">
        <i class="fas fa-fw fa-file"></i>
        <span>Daftar Ujian KP</span></a>
    </li>
	<li class="nav-item ">
        <a class="nav-link" href="/koor/SuratKet">
        <i class="fas fa-fw fa-file"></i>
        <span>Daftar Pengajuan Surat Keterangan</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/koor/RegisPraKp">
        <i class="fas fa-fw fa-file"></i>
        <span>Daftar Pengajuan Pra KP</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/koor/RegisKp">
        <i class="fas fa-fw fa-book"></i>
        <span>Daftar Pengajuan KP</span></a>
    </li>
	<li class="nav-item ">
        <a class="nav-link" href="/koor/setUjian">
        <i class="fas fa-fw fa-file"></i>
        <span>Atur Ujian KP</span></a>
    </li>
	<li class="nav-item ">
        <a class="nav-link" href="/koor/BatasKp">
        <i class="fas fa-fw fa-file"></i>
        <span>Atur Batas Pelaksanaan KP</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>
        
        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
        
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->name}}</span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/logout" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
                </a>
            </div>
            </li>

        </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
        @yield('content')

        <!-- Page Heading -->
        <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div> -->

        <!-- Content Row -->
        
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; rpl2021ajm referenced by E E E F.</span>
        </div>
        </div>
    </footer>
    <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Yakin ingin Logout?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <ul class="nav navbar-nav navbar-right" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
					<li><a href="login">Logout
							<span class="glyphicon glyphicon-log-out"></a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</li>
				</ul>
        </div>
    </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('js/sb-admin-2.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

<!-- Page level plugins -->
<!-- <script src="vendor/chart.js/Chart.min.js"></script> -->

<!-- Page level custom scripts -->
<!-- <script src="js/demo/chart-area-demo.js"></script> -->
<!-- <script src="js/demo/chart-pie-demo.js"></script> -->

@yield('bottom')

</body>

</html>