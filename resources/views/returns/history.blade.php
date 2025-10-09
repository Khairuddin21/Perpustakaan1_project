<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Pengembalian - {{ config('app.name', 'Sistem Perpustakaan') }}</title>
    
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
                    <a href="{{ route('returns.index') }}" class="nav-item" data-page="returns">
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
                    <a href="{{ route('returns.history') }}" class="nav-item active" data-page="history">
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
                    
                    <h1 class="header-title">Riwayat Pengembalian</h1>
                    
                    <div class="header-actions">
                        <a href="{{ route('returns.index') }}" class="action-btn primary">
                            <i class="fas fa-undo"></i>
                            Proses Pengembalian
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
                    <h2 class="welcome-title">Riwayat Pengembalian 📚</h2>
                    <p class="welcome-subtitle">Daftar lengkap buku yang telah dikembalikan beserta detail transaksinya.</p>
                </div>

                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card" style="--stat-color: #10b981;">
                        <div class="stat-content">
                            <div class="stat-icon" style="background: #10b981; box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.4);">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number">{{ $returned_loans->count() }}</h3>
                                <p class="stat-label">Total Dikembalikan</p>
                                <p class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i>
                                    Sepanjang waktu
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card" style="--stat-color: #ef4444;">
                        <div class="stat-content">
                            <div class="stat-icon" style="background: #ef4444; box-shadow: 0 4px 14px 0 rgba(239, 68, 68, 0.4);">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number">{{ $returned_loans->where('return_date', '>', 'due_date')->count() }}</h3>
                                <p class="stat-label">Terlambat Dikembalikan</p>
                                <p class="stat-change negative">
                                    <i class="fas fa-clock"></i>
                                    Dengan denda
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card" style="--stat-color: #8b5cf6;">
                        <div class="stat-content">
                            <div class="stat-icon" style="background: #8b5cf6; box-shadow: 0 4px 14px 0 rgba(139, 92, 246, 0.4);">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number">{{ $returned_loans->where('return_date', '<=', 'due_date')->count() }}</h3>
                                <p class="stat-label">Tepat Waktu</p>
                                <p class="stat-change positive">
                                    <i class="fas fa-check"></i>
                                    Tanpa denda
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- History Table -->
                @if($returned_loans->count() > 0)
                    <div class="data-section slide-up">
                        <div class="data-card">
                            <div class="data-header">
                                <h3 class="data-title">
                                    <i class="fas fa-history"></i>
                                    Riwayat Pengembalian Buku
                                </h3>
                                <div class="data-stats">
                                    <span class="stat-badge">{{ $returned_loans->count() }} transaksi</span>
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
                                            <th>Tanggal Kembali</th>
                                            <th>Kondisi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($returned_loans as $loan)
                                        <tr class="table-row">
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
                                            <td class="date-cell">
                                                <div class="date-info">
                                                    <i class="fas fa-calendar-times"></i>
                                                    {{ $loan->due_date->format('d M Y') }}
                                                </div>
                                            </td>
                                            <td class="date-cell">
                                                <div class="date-info {{ $loan->return_date->gt($loan->due_date) ? 'overdue' : 'success' }}">
                                                    <i class="fas {{ $loan->return_date->gt($loan->due_date) ? 'fa-exclamation-triangle' : 'fa-check-circle' }}"></i>
                                                    {{ $loan->return_date->format('d M Y') }}
                                                </div>
                                                @if($loan->return_date->gt($loan->due_date))
                                                    <div class="overdue-info">
                                                        Terlambat {{ $loan->due_date->diffInDays($loan->return_date) }} hari
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="condition-cell">
                                                <span class="condition-badge {{ $loan->condition ?? 'good' }}">
                                                    @switch($loan->condition ?? 'good')
                                                        @case('good')
                                                            <i class="fas fa-check-circle"></i>
                                                            Baik
                                                            @break
                                                        @case('damaged')
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                            Rusak
                                                            @break
                                                        @case('lost')
                                                            <i class="fas fa-times-circle"></i>
                                                            Hilang
                                                            @break
                                                        @default
                                                            <i class="fas fa-check-circle"></i>
                                                            Baik
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td class="status-cell">
                                                <span class="status-badge {{ $loan->return_date->gt($loan->due_date) ? 'overdue' : 'success' }}">
                                                    @if($loan->return_date->gt($loan->due_date))
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                        Terlambat
                                                    @else
                                                        <i class="fas fa-check-circle"></i>
                                                        Tepat Waktu
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($returned_loans->hasPages())
                            <div class="pagination-wrapper">
                                {{ $returned_loans->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="empty-state slide-up">
                        <div class="empty-state-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3 class="empty-state-title">Belum Ada Riwayat Pengembalian</h3>
                        <p class="empty-state-description">
                            Belum ada buku yang dikembalikan. Riwayat pengembalian akan muncul di sini setelah ada transaksi pengembalian.
                        </p>
                        <div class="empty-state-actions">
                            <a href="{{ route('returns.index') }}" class="action-btn primary">
                                <i class="fas fa-undo"></i>
                                Proses Pengembalian
                            </a>
                            <a href="{{ route('dashboard') }}" class="action-btn secondary">
                                <i class="fas fa-tachometer-alt"></i>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
    
    <!-- Additional Styles for History Page -->
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
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
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

        .date-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--light-text);
        }

        .date-info.success {
            color: var(--success-color);
        }

        .date-info.overdue {
            color: var(--danger-color);
        }

        .overdue-info {
            font-size: 0.75rem;
            color: var(--danger-color);
            margin-top: 0.25rem;
        }

        .condition-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .condition-badge.good {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .condition-badge.damaged {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .condition-badge.lost {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
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

        .status-badge.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
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
            color: var(--light-text);
            margin-bottom: 1.5rem;
            opacity: 0.5;
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Catatan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($returned_loans as $loan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $loan->user->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $loan->user->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $loan->book->title }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $loan->book->author }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $loan->loan_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $loan->return_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $loan->notes ?: '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $returned_loans->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">Belum ada riwayat pengembalian.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection