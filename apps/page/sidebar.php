<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-ungu sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <i class="fas fa-store-alt fa-fw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Page</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="produk.php">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Daftar Produk</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="customer.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Daftar Customer</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="penjualan.php">
            <i class="fas fa-fw fa-store"></i>
            <span>Penjualan</span></a>
    </li>

    <!-- <li class="nav-item">
        <a class="nav-link" href="returPenjualan.php">
            <i class="fas fa-exchange-alt fa-fw"></i>
            <span>Retur Penjualan</span></a>
    </li> -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-folder"></i>
            <span>Daftar Laporan</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Laporan:</h6>
                <a class="collapse-item" href="laporan.php">Daftar Laporan Penjualan</a>
                <!-- <a class="collapse-item" href="laporanRetur.php">Daftar Laporan Retur</a> -->
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Account
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="profile.php">
            <i class="fas fa-fw fa-user-edit"></i>
            <span>Admin Profile</span></a>
    </li>

    <?php if ($_SESSION['admin']['role'] === 'admin') : ?>
        <li class="nav-item">
            <a class="nav-link" href="addAdmin.php">
                <i class="fas fa-fw fa-user-tie"></i>
                <span>Tambah Admin</span></a>
        </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="logout.php">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>