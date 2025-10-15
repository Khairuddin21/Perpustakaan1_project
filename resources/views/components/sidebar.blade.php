<!-- Sidebar Component -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <i class="fas fa-book-reader"></i>
            <h1 class="sidebar-title">SisPerpus</h1>
        </div>
        <p class="sidebar-subtitle">Sistem Perpustakaan Digital</p>
    </div>
    
    <div class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Koleksi Buku</div>
            <a href="{{ route('books.browse') }}" class="nav-item {{ request()->routeIs('books.browse') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                <span>Jelajahi Buku</span>
            </a>
            <a href="#" class="nav-item" onclick="document.querySelector('.search-box input, .search-input').focus(); return false;">
                <i class="fas fa-search"></i>
                <span>Cari Buku</span>
            </a>
            <a href="{{ route('books.browse') }}" class="nav-item">
                <i class="fas fa-tags"></i>
                <span>Kategori</span>
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Peminjaman Saya</div>
            <a href="#" class="nav-item" onclick="showBorrowedBooks(); return false;">
                <i class="fas fa-hand-holding-heart"></i>
                <span>Sedang Dipinjam</span>
                @if(isset($upcomingDueLoans) && $upcomingDueLoans->count() > 0)
                <span class="notification-badge">{{ $upcomingDueLoans->count() }}</span>
                @endif
            </a>
            <a href="{{ route('user.returns') }}" class="nav-item {{ request()->routeIs('user.returns') ? 'active' : '' }}">
                <i class="fas fa-undo-alt"></i>
                <span>Pengembalian Buku</span>
            </a>
            <a href="#" class="nav-item" onclick="showLoanHistory(); return false;">
                <i class="fas fa-history"></i>
                <span>Riwayat Peminjaman</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-heart"></i>
                <span>Favorit</span>
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Akun</div>
            <a href="#" class="nav-item">
                <i class="fas fa-user-circle"></i>
                <span>Profil Saya</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span>
                @if(isset($upcomingDueLoans) && $upcomingDueLoans->count() > 0)
                <span class="notification-badge">{{ $upcomingDueLoans->count() }}</span>
                @endif
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="user-details">
                <strong>{{ auth()->user()->name }}</strong>
                <small>{{ ucfirst(auth()->user()->role) }}</small>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</nav>