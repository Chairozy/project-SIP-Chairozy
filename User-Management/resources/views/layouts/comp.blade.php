<!--@section('sidebar')
<-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center">
    <div class="sidebar-brand-icon">
        <i class="fas fa-virus"></i>
    </div>
    <div class="sidebar-brand-text mx-3">StraGiinT</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Heading -->
<div class="sidebar-heading">
    Menu
</div>

<!-- Nav Item - Dashboard -->
<li class="nav-item {{($me == 1) ? 'active' : ''}}">
    <a class="nav-link" href="/user">
        <i class="fas fa-fw fa-users"></i>
        <span>Users</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

</ul>
<!-- End of Sidebar -->



<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
        

            <div class="topbar-divider d-none d-sm-block"></div>
            
            <!-- Nav Item - User Information -->
            <li class="nav-item">
                <a class="nav-link">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Guest</span>
                    <img class="img-profile rounded-circle"
                        src="{{asset('ssa2')}}/img/undraw_profile.svg">
                </a>
            </li>

        </ul>

    </nav>
    <!-- End of Topbar -->