<!-- Admin Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h1 class="sidebar-title">
            <i class="fas fa-book-open"></i>
            SisPerpus
        </h1>
        <p class="sidebar-subtitle">Sistem Perpustakaan Digital</p>
    </div>
    
    <div class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Manajemen Data</div>
            <a href="{{ route('admin.books.index') }}" class="nav-item {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                Kelola Buku
            </a>
            <a href="#" class="nav-item" data-page="categories">
                <i class="fas fa-tags"></i>
                Kategori Buku
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Kelola Anggota
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Transaksi</div>
            <a href="{{ route('loan-requests') }}" class="nav-item {{ request()->routeIs('loan-requests') ? 'active' : '' }}">
                <i class="fas fa-hand-holding"></i>
                Akses Peminjaman
            </a>
            <a href="{{ route('admin.returns.index') }}" class="nav-item {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}">
                <i class="fas fa-undo"></i>
                Pengembalian Buku
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Laporan</div>
            <a href="{{ route('admin.reports') }}" class="nav-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                Laporan & Statistik
            </a>
        </div>
    </div>
</nav>
