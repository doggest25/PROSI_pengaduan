<div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/admin') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i> <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-header">Data Pengguna</li>
            
            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>Data User</p>
                </a>
            </li>
            <li class="nav-header">Data Pengaduan</li>
            <li class="nav-item">
                <a href="{{ url('/jpengaduan') }}" class="nav-link {{ ($activeMenu == 'jpengaduan') ? 'active' : '' }}">
                    <i class="nav-icon far fa-file-alt"></i>
                    <p>Jenis Pengaduan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/dpengaduan') }}" class="nav-link {{ ($activeMenu == 'dpengaduan') ? 'active' : '' }}">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Pengaduan Warga</p>
                </a>
            </li>
            <li class="nav-header">Perhitungan Prioritas Pengaduan</li>
            <li class="nav-item">
                <a href="{{ url('/prioritas/kriteria') }}" class="nav-link {{ ($activeMenu == 'kriteria') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>Jenis Kriteria</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/prioritas/pengaduanDiterima') }}" class="nav-link {{ ($activeMenu == 'diterima') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-star"></i>
                    <p>Mengisi Nilai Alternatif</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/prioritas/perhitungan') }}" class="nav-link {{ ($activeMenu == '') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-calculator"></i>
                    <p>Perhitungan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/hasil/accepted') }}" class="nav-link {{ ($activeMenu == 'hasil') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-exclamation" ></i>
                    <p>Daftar Prioritas</p>
                </a>
            </li>

            <li class="nav-header">Kritik & Saran</li>
            <li class="nav-item">
                <a href="{{ url('/pesan') }}" class="nav-link {{ ($activeMenu == 'pesan') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>Pesan Kritik & Saran</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link {{ ($activeMenu == '') ? 'active' : '' }}" onclick="event.preventDefault(); confirmLogout();">
                    <i class="fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
            </li>
            
           
 

        </ul>
    </nav>
</div>
