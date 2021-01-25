<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>StraGiinT</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('ssa2')}}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('ssa2')}}/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{asset('ssa2')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    @stack('bgstyle')
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
    @guest @else
    @include('layouts.comp')
    @endguest
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex h-100 mx-auto flex-column">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar shadow">
            <!-- Topbar Navbar -->
            @guest
            <a class="navbar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <div class="sidebar-brand-icon">
                    <!--<i class="fas fa-virus" alt="logo"></i>-->
                </div>StraGiinT</a>
            <div class="topbar-divider d-none d-sm-block"></div>
            @endguest
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-secondary" href="{{ route('home') }}"> Home </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-secondary" href="/about"> About </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-secondary" href="/buku"> Buku </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto"> 
                <div class="topbar-divider d-none d-sm-block"></div>
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                    
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown no-arrow">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" v-pre>
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle" src="{{asset('ssa2')}}/img/undraw_profile.svg">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </nav>
        <!-- End of Topbar -->
        @yield('content')
        <footer class="sticky-footer bg-white mt-auto">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; StraGiinT 2020</span>
                </div>
            </div>
        </footer>
    </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('ssa2')}}/vendor/jquery/jquery.min.js"></script>
    <script src="{{asset('ssa2')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('ssa2')}}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('ssa2')}}/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="{{asset('ssa2')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('ssa2')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('ssa2')}}/js/demo/datatables-demo.js"></script>
    @stack('enscript')
    @stack('modalscript')
    @stack('detailscript')
</body>
</html>
