<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengembalian Buku - {{ config('app.name', 'Sistem Perpustakaan') }}</title>
    
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
                    <a href="{{ route('dashboard') }}" class="nav-item">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Transaksi</div>
                    <a href="#" class="nav-item" data-page="loans">
                        <i class="fas fa-hand-holding"></i>
                        Peminjaman Buku
                    </a>
                    <a href="{{ route('returns.index') }}" class="nav-item active" data-page="returns">
                        <i class="fas fa-undo"></i>
                        Pengembalian Buku
                    </a>
                    <a href="#" class="nav-item" data-page="overdue">
                        <i class="fas fa-clock"></i>
                        Buku Terlambat
                    </a>
                </div>
                
                @if(auth()->user()->isAdmin())
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
                @endif
                
                <div class="nav-section">
                    <div class="nav-section-title">Laporan</div>
                    <a href="#" class="nav-item" data-page="reports">
                        <i class="fas fa-chart-bar"></i>
                        Laporan & Statistik
                    </a>
                    <a href="{{ route('returns.history') }}" class="nav-item" data-page="history">
                        <i class="fas fa-history"></i>
                        Riwayat Pengembalian
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
                    
                    <h1 class="header-title">Pengembalian Buku</h1>
                    
                    <div class="header-actions">
                        <a href="{{ route('returns.history') }}" class="action-btn secondary">
                            <i class="fas fa-history"></i>
                            Riwayat
                        </a>
                        
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
                    <h2 class="welcome-title">Pengembalian Buku 📖</h2>
                    <p class="welcome-subtitle">Proses pengembalian buku yang dipinjam anggota dengan mudah dan cepat.</p>
                </div>

                <!-- Notifications -->
                @if(session('success'))
                    <div class="notification-card success fade-in">
                        <div class="notification-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="notification-content">
                            <h4>Berhasil!</h4>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="notification-card error fade-in">
                        <div class="notification-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="notification-content">
                            <h4>Error!</h4>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Search Section -->
                <div class="search-section slide-up">
                    <div class="search-card">
                        <div class="search-header">
                            <h3 class="search-title">
                                <i class="fas fa-search"></i>
                                Cari Peminjaman
                            </h3>
                        </div>
                        <form action="{{ route('returns.search') }}" method="GET" class="search-form">
                            <div class="search-input-group">
                                <input type="text" 
                                       name="search" 
                                       value="{{ $search ?? '' }}"
                                       placeholder="Cari berdasarkan nama anggota, email, judul buku, atau ISBN..." 
                                       class="search-input">
                                <button type="submit" class="search-btn">
                                    <i class="fas fa-search"></i>
                                    Cari
                                </button>
                                @if(isset($search))
                                <a href="{{ route('returns.index') }}" class="search-reset">
                                    <i class="fas fa-times"></i>
                                    Reset
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Returns Table -->
                @if($borrowed_loans->count() > 0)
                    <div class="data-section slide-up">
                        <div class="data-card">
                            <div class="data-header">
                                <h3 class="data-title">
                                    <i class="fas fa-list"></i>
                                    Daftar Peminjaman Aktif
                                </h3>
                                <div class="data-stats">
                                    <span class="stat-badge">{{ $borrowed_loans->count() }} peminjaman</span>
                                </div>
                            </div>
                            <div class="table-container">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Anggota</th>
                                            <th>Buku</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($borrowed_loans as $loan)
                                        <tr class="table-row {{ $loan->isOverdue() ? 'overdue' : '' }}">
                                            <td class="member-cell">
                                                <div class="member-info">
                                                    <div class="member-avatar">
                                                        {{ strtoupper(substr($loan->user->name, 0, 2)) }}
                                                    </div>
                                                    <div class="member-details">
                                                        <div class="member-name">{{ $loan->user->name }}</div>
                                                        <div class="member-email">{{ $loan->user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="book-cell">
                                                <div class="book-info">
                                                    <div class="book-title">{{ $loan->book->title }}</div>
                                                    <div class="book-author">{{ $loan->book->author }}</div>
                                                </div>
                                            </td>
                                            <td class="date-cell">
                                                <div class="date-info">
                                                    <i class="fas fa-calendar-plus"></i>
                                                    {{ $loan->loan_date->format('d M Y') }}
                                                </div>
                                            </td>
                                            <td class="due-cell {{ $loan->isOverdue() ? 'overdue' : '' }}">
                                                <div class="due-info">
                                                    <i class="fas fa-calendar-check"></i>
                                                    {{ $loan->due_date->format('d M Y') }}
                                                    @if($loan->isOverdue())
                                                        <div class="overdue-badge">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                            Terlambat {{ $loan->due_date->diffInDays(now()) }} hari
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="status-cell">
                                                <span class="status-badge {{ $loan->isOverdue() ? 'overdue' : 'active' }}">
                                                    <i class="fas {{ $loan->isOverdue() ? 'fa-exclamation-triangle' : 'fa-clock' }}"></i>
                                                    {{ $loan->isOverdue() ? 'Terlambat' : 'Dipinjam' }}
                                                </span>
                                            </td>
                                            <td class="action-cell">
                                                <a href="{{ route('returns.show', $loan->id) }}" class="action-btn primary">
                                                    <i class="fas fa-undo"></i>
                                                    Proses Pengembalian
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($borrowed_loans->hasPages())
                            <div class="pagination-wrapper">
                                {{ $borrowed_loans->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="empty-state slide-up">
                        <div class="empty-state-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="empty-state-title">Tidak Ada Peminjaman Aktif</h3>
                        <p class="empty-state-description">
                            @if(isset($search))
                                Tidak ditemukan peminjaman yang sesuai dengan pencarian "{{ $search }}".
                            @else
                                Semua buku sudah dikembalikan. Tidak ada peminjaman yang perlu diproses saat ini.
                            @endif
                        </p>
                        <div class="empty-state-actions">
                            @if(isset($search))
                                <a href="{{ route('returns.index') }}" class="action-btn secondary">
                                    <i class="fas fa-list"></i>
                                    Lihat Semua Peminjaman
                                </a>
                            @endif
                            <a href="{{ route('dashboard') }}" class="action-btn primary">
                                <i class="fas fa-tachometer-alt"></i>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
    
    <!-- Additional Styles for Returns Page -->
    <style>
        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .action-btn.primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.3);
        }

        .action-btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px 0 rgba(99, 102, 241, 0.4);
        }

        .action-btn.secondary {
            background: white;
            color: var(--dark-text);
            border: 1px solid var(--border-color);
        }

        .action-btn.secondary:hover {
            background: var(--light-bg);
            transform: translateY(-1px);
        }

        .notification-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification-card.success {
            border-left: 4px solid var(--success-color);
        }

        .notification-card.error {
            border-left: 4px solid var(--danger-color);
        }

        .notification-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }

        .notification-card.success .notification-icon {
            background: var(--success-color);
        }

        .notification-card.error .notification-icon {
            background: var(--danger-color);
        }

        .notification-content h4 {
            margin: 0 0 0.25rem;
            font-weight: 600;
            color: var(--dark-text);
        }

        .notification-content p {
            margin: 0;
            color: var(--light-text);
        }

        .search-section {
            margin-bottom: 2rem;
        }

        .search-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
        }

        .search-header {
            margin-bottom: 1.5rem;
        }

        .search-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark-text);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-input-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-input {
            flex: 1;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .search-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-1px);
        }

        .search-reset {
            background: var(--light-text);
            color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-reset:hover {
            background: var(--danger-color);
            transform: translateY(-1px);
        }

        .data-section {
            margin-bottom: 2rem;
        }

        .data-card {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .data-header {
            padding: 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .data-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-text);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .stat-badge {
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: var(--light-bg);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--dark-text);
            border-bottom: 1px solid var(--border-color);
        }

        .data-table td {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .table-row:hover {
            background: var(--light-bg);
        }

        .table-row.overdue {
            background: rgba(239, 68, 68, 0.05);
        }

        .member-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .member-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .member-name {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 0.25rem;
        }

        .member-email {
            font-size: 0.875rem;
            color: var(--light-text);
        }

        .book-title {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 0.25rem;
        }

        .book-author {
            font-size: 0.875rem;
            color: var(--light-text);
        }

        .date-info, .due-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--light-text);
        }

        .due-cell.overdue .due-info {
            color: var(--danger-color);
            font-weight: 600;
        }

        .overdue-badge {
            margin-top: 0.5rem;
            font-size: 0.75rem;
            color: var(--danger-color);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-badge.active {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .status-badge.overdue {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
        }

        .empty-state-icon {
            font-size: 4rem;
            color: var(--success-color);
            margin-bottom: 1.5rem;
        }

        .empty-state-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-text);
            margin: 0 0 1rem;
        }

        .empty-state-description {
            color: var(--light-text);
            margin: 0 0 2rem;
            font-size: 1.1rem;
        }

        .empty-state-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .pagination-wrapper {
            padding: 2rem;
            border-top: 1px solid var(--border-color);
        }

        @media (max-width: 768px) {
            .search-input-group {
                flex-direction: column;
            }

            .data-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .empty-state-actions {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
    
    <!-- Scripts loaded via Vite -->
</body>
</html>