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

    <hr class="sidebar-divider my-0">
    <div class="sidebar-heading">
        
    </div>
    <li class="nav-item <?php if ($me == 1) echo 'active' ?>">
        <a class="nav-link" href="/user">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span></a>
    </li>
    
    <hr class="sidebar-divider my-0">
    <div class="sidebar-heading">
        Menu
    </div>
    <li class="nav-item <?php if ($me == 2) echo 'active' ?>">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item <?php if ($me == 3) echo 'active' ?>">
        <a class="nav-link" href="/data/buku">
            <i class="fas fa-fw fa-book"></i>
            <span>Buku</span></a>
    </li>

    <li class="nav-item <?php if ($me == 4) echo 'active' ?>">
        <a class="nav-link" href="/memory">
            <i class="fas fa-fw fa-archive"></i>
            <span>Storage</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item <?php if ($me == 5) echo 'active' ?>">
        <a class="nav-link" href="/keluhan">
            <i class="fas fa-fw fa-bullhorn"></i>
            <span>Lapor</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->