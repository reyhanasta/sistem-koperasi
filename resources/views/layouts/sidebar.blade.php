<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="pb-3 mt-3 mb-3 user-panel d-flex">
        <div class="image">
            <img src="{{ asset('adminlte/') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block"> {{ auth()->user()->name }}</a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
    {{-- <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
    <a href="{{ route('about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a>
    <a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'active' : '' }}">Products</a> --}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="fas fa-home nav-icon"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @hasanyrole(['admin','staff'])
            <li class="nav-item {{ request()->is('nasabah*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('nasabah*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-alt"></i>
                    <p>
                        Nasabah
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('nasabah.index') }}"
                            class="nav-link {{ request()->is('nasabah') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('nasabah.create') }}"
                            class="nav-link {{ request()->is('nasabah/create') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tambah</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ request()->is('tr*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('tr*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Transaksi<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('simpanan.index') }}"
                            class="nav-link {{ request()->is('trx/simpanan') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Simpanan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('penarikan.index') }}"
                            class="nav-link {{ request()->is('trx/penarikan') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Penarikan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pinjaman.index') }}"
                            class="nav-link {{ request()->is('trx/pinjaman') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Pinjaman</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endhasanyrole
            @role('admin')
            <li class="nav-item {{ request()->is('pegawai*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('pegawai*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Pegawai
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('pegawai.index') }}"
                            class="nav-link {{ request()->is('pegawai') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pegawai.create') }}"
                            class="nav-link {{ request()->is('pegawai/create') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tambah</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ request()->is('master-*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('master-*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Master Data
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('master-jabatan.index') }}"
                            class="nav-link {{ request()->is('master-jabatan') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Master Jabatan</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ request()->is('setting-*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('setting-*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-gear"></i>
                    <p>
                        Konfigurasi
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('migrasi.index') }}"
                            class="nav-link {{ request()->is('migrasi') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Migrasi</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endrole
            <li class="nav-item">
                <a href="{{ asset('adminlte/') }}/index3.html" class="nav-link">
                    <i class="fas fa-book nav-icon"></i>
                    <p>Halaman Template </p>
                </a>
            </li>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>