
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - {{ config('app.name', 'Sistem Perpustakaan') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    @vite(['resources/css/dashboard.css', 'resources/js/dashboard.js'])
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
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
                    <a href="{{ route('dashboard') }}" class="nav-item active">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Manajemen Data</div>
                    <a href="#" class="nav-item" data-page="books">
                        <i class="fas fa-book"></i>
                        Kelola Buku
                    </a>
                    <a href="#" class="nav-item" data-page="categories">
                        <i class="fas fa-tags"></i>
                        Kategori Buku
                    </a>
                    <a href="#" class="nav-item" data-page="users">
                        <i class="fas fa-users"></i>
                        Kelola Anggota
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Transaksi</div>
                    <a href="#" class="nav-item" data-page="loans">
                        <i class="fas fa-hand-holding"></i>
                        Peminjaman Buku
                    </a>
                    <a href="{{ route('returns.index') }}" class="nav-item" data-page="returns">
                        <i class="fas fa-undo"></i>
                        Pengembalian Buku
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Laporan</div>
                    <a href="#" class="nav-item" data-page="reports">
                        <i class="fas fa-chart-bar"></i>
                        Laporan & Statistik
                    </a>
                    <a href="#" class="nav-item" data-page="analytics">
                        <i class="fas fa-analytics"></i>
                        Analisis Data
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Pengaturan</div>
                    <a href="#" class="nav-item" data-page="settings">
                        <i class="fas fa-cog"></i>
                        Pengaturan Sistem
                    </a>
                </div>
            </div>
        </nav>
        
        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <div class="header-content">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <h1 class="header-title">Dashboard Administrator</h1>
                    
                    <div class="header-actions">
                        <div class="user-info">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="user-details">
                                <div class="user-name">{{ auth()->user()->name }}</div>
                                <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-item" style="background: none; border: none; color: #64748b; padding: 0.5rem 1rem; border-radius: 0.5rem; transition: all 0.3s ease;">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Welcome Section -->
                <div class="welcome-section fade-in">
                    <h2 class="welcome-title">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                    <p class="welcome-subtitle">Kelola sistem perpustakaan dengan mudah dan efisien. Berikut adalah ringkasan data terkini.</p>
                </div>
                
                <!-- Statistics Grid -->
                <div class="stats-grid">
                    <div class="stat-card books" data-stat="total_books">
                        <div class="stat-content">
                            <div class="stat-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number">{{ $stats['total_books'] }}</h3>
                                <p class="stat-label">Total Buku</p>
                                <p class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i>
                                    +12% dari bulan lalu
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card users" data-stat="total_users">
                        <div class="stat-content">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number">{{ $stats['total_users'] }}</h3>
                                <p class="stat-label">Total Anggota</p>
                                <p class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i>
                                    +8% dari bulan lalu
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card loans" data-stat="total_loans">
                        <div class="stat-content">
                            <div class="stat-icon">
                                <i class="fas fa-hand-holding"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number">{{ $stats['total_loans'] }}</h3>
                                <p class="stat-label">Sedang Dipinjam</p>
                                <p class="stat-change negative">
                                    <i class="fas fa-arrow-down"></i>
                                    -3% dari bulan lalu
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card categories" data-stat="total_categories">
                        <div class="stat-content">
                            <div class="stat-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number">{{ $stats['total_categories'] }}</h3>
                                <p class="stat-label">Kategori Buku</p>
                                <p class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i>
                                    +2 kategori baru
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Cards -->
                <div class="action-grid">
                    <div class="action-card" data-action="borrow">
                        <div class="action-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <h3 class="action-title">Peminjaman Buku</h3>
                        <p class="action-description">Proses peminjaman buku untuk anggota perpustakaan dengan sistem yang mudah dan cepat.</p>
                    </div>
                    
                    <div class="action-card" data-action="return">
                        <div class="action-icon">
                            <i class="fas fa-undo-alt"></i>
                        </div>
                        <h3 class="action-title">Pengembalian Buku</h3>
                        <p class="action-description">Kelola pengembalian buku dan perhitungan denda jika ada keterlambatan.</p>
                    </div>
                    
                    <div class="action-card" data-action="books">
                        <div class="action-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3 class="action-title">Kelola Buku</h3>
                        <p class="action-description">Tambah, edit, atau hapus data buku dalam sistem perpustakaan.</p>
                    </div>
                    
                    <div class="action-card" data-action="users">
                        <div class="action-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h3 class="action-title">Kelola Anggota</h3>
                        <p class="action-description">Manajemen data anggota perpustakaan dan hak akses mereka.</p>
                    </div>
                    
                    <div class="action-card" data-action="reports">
                        <div class="action-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="action-title">Laporan & Statistik</h3>
                        <p class="action-description">Lihat laporan komprehensif dan analisis data perpustakaan.</p>
                    </div>
                    
                    <div class="action-card" data-action="categories">
                        <div class="action-icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <h3 class="action-title">Kategori Buku</h3>
                        <p class="action-description">Kelola kategori dan klasifikasi buku untuk organisasi yang lebih baik.</p>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="recent-activity">
                    <div class="activity-header">
                        <h3 class="activity-title">Aktivitas Terkini</h3>
                    </div>
                    <ul class="activity-list">
                        <li class="activity-item">
                            <div class="activity-avatar">JD</div>
                            <div class="activity-content">
                                <p class="activity-text">John Doe meminjam buku "Pemrograman Web dengan Laravel"</p>
                                <p class="activity-time">2 menit yang lalu</p>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-avatar">SA</div>
                            <div class="activity-content">
                                <p class="activity-text">Siti Aminah mengembalikan buku "Database Management System"</p>
                                <p class="activity-time">15 menit yang lalu</p>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-avatar">AB</div>
                            <div class="activity-content">
                                <p class="activity-text">Ahmad Budi mendaftar sebagai anggota baru</p>
                                <p class="activity-time">1 jam yang lalu</p>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-avatar">RP</div>
                            <div class="activity-content">
                                <p class="activity-text">Rina Permata meminjam buku "Artificial Intelligence"</p>
                                <p class="activity-time">2 jam yang lalu</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Scripts loaded via Vite -->
</body>
</html>