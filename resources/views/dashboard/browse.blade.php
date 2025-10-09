<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajahi Buku - SisPerpus</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- HANYA load Font Awesome dan Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* RESET SEMUA STYLES DULU */
        *, *::before, *::after {
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }

        /* Override Tailwind/Bootstrap */
        .container, .row, .col, .d-flex, .flex, .grid {
            all: unset !important;
        }

        :root {
            --primary: #667eea !important;
            --primary-dark: #5568d3 !important;
            --secondary: #764ba2 !important;
            --accent: #f093fb !important;
            --success: #10b981 !important;
            --warning: #f59e0b !important;
            --danger: #ef4444 !important;
            --info: #3b82f6 !important;
            --dark: #1e293b !important;
            --light: #f8fafc !important;
            --border: #e2e8f0 !important;
            --text-dark: #1e293b !important;
            --text-light: #64748b !important;
            --sidebar-width: 280px !important;
            --header-height: 70px !important;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            min-height: 100vh !important;
            color: var(--text-dark) !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden !important;
        }

        .dashboard-wrapper {
            display: flex !important;
            min-height: 100vh !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* ===== SIDEBAR - SAMA SEPERTI ANGGOTA.BLADE.PHP ===== */
        .sidebar {
            width: var(--sidebar-width) !important;
            background: linear-gradient(180deg, #1e293b 0%, #334155 100%) !important;
            color: white !important;
            position: fixed !important;
            height: 100vh !important;
            overflow-y: auto !important;
            z-index: 1000 !important;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15) !important;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            display: flex !important;
            flex-direction: column !important;
            left: 0 !important;
            top: 0 !important;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px !important;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05) !important;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2) !important;
            border-radius: 10px !important;
        }

        .sidebar.collapsed {
            transform: translateX(-100%) !important;
        }

        .sidebar-header {
            padding: 2rem 1.5rem !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            background: rgba(0, 0, 0, 0.2) !important;
            margin: 0 !important;
        }

        .logo-container {
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
            margin-bottom: 0.5rem !important;
        }

        .logo-container i {
            font-size: 2rem !important;
            background: linear-gradient(135deg, #667eea, #764ba2) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            filter: drop-shadow(0 0 10px rgba(102, 126, 234, 0.5)) !important;
        }

        .sidebar-title {
            font-size: 1.75rem !important;
            font-weight: 800 !important;
            font-family: 'Poppins', sans-serif !important;
            background: linear-gradient(135deg, #667eea, #f093fb) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            margin: 0 !important;
        }

        .sidebar-subtitle {
            font-size: 0.875rem !important;
            color: #94a3b8 !important;
            font-weight: 400 !important;
            margin: 0 !important;
        }

        .sidebar-nav {
            padding: 1.5rem 0 !important;
            flex: 1 !important;
            margin: 0 !important;
        }

        .nav-section {
            margin-bottom: 2rem !important;
        }

        .nav-section-title {
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            color: #94a3b8 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
            padding: 0 1.5rem !important;
            margin-bottom: 0.75rem !important;
        }

        /* ===== NAV ITEM - SAMA SEPERTI ANGGOTA.BLADE.PHP ===== */
        .nav-item {
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
            padding: 0.875rem 1.5rem !important;
            color: #e2e8f0 !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
            border-left: 3px solid transparent !important;
            position: relative !important;
            overflow: hidden !important;
            border: none !important;
            background: none !important;
            width: 100% !important;
            text-align: left !important;
            font: inherit !important;
            cursor: pointer !important;
            margin: 0 !important;
        }

        .nav-item::before {
            content: '' !important;
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 0 !important;
            height: 100% !important;
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.2), transparent) !important;
            transition: width 0.3s ease !important;
        }

        .nav-item:hover {
            background: rgba(102, 126, 234, 0.1) !important;
            border-left: 3px solid var(--primary) !important;
        }

        .nav-item:hover::before {
            width: 100% !important;
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.2), transparent) !important;
            border-left: 3px solid var(--accent) !important;
            color: white !important;
            font-weight: 600 !important;
        }

        .nav-item.active::before {
            width: 100% !important;
        }

        .nav-item i {
            font-size: 1.1rem !important;
            width: 24px !important;
            text-align: center !important;
            flex-shrink: 0 !important;
        }

        .notification-badge {
            margin-left: auto !important;
            background: var(--danger) !important;
            color: white !important;
            font-size: 0.75rem !important;
            padding: 0.25rem 0.5rem !important;
            border-radius: 10px !important;
            font-weight: 600 !important;
            min-width: 1.5rem !important;
            text-align: center !important;
        }

        .sidebar-footer {
            margin-top: auto !important;
            padding: 1.5rem !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
            background: rgba(0, 0, 0, 0.2) !important;
        }

        .user-card {
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
            margin-bottom: 1rem !important;
            padding: 1rem !important;
            background: rgba(255, 255, 255, 0.05) !important;
            border-radius: 12px !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .user-avatar {
            width: 50px !important;
            height: 50px !important;
            border-radius: 50% !important;
            background: linear-gradient(135deg, var(--primary), var(--secondary)) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: 700 !important;
            font-size: 1.25rem !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3) !important;
        }

        .user-details {
            flex: 1 !important;
        }

        .user-details strong {
            display: block !important;
            font-size: 0.95rem !important;
            margin-bottom: 0.25rem !important;
        }

        .user-details small {
            font-size: 0.8rem !important;
            color: #94a3b8 !important;
        }

        .logout-btn {
            width: 100% !important;
            padding: 0.75rem !important;
            background: rgba(239, 68, 68, 0.1) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: #fca5a5 !important;
            border-radius: 8px !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.5rem !important;
        }

        .logout-btn:hover {
            background: var(--danger) !important;
            color: white !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1 !important;
            margin-left: var(--sidebar-width) !important;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            width: calc(100% - var(--sidebar-width)) !important;
        }

        .main-content.expanded {
            margin-left: 0 !important;
            width: 100% !important;
        }

        /* ===== HEADER ===== */
        .header {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
            padding: 1rem 2rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 500 !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
            margin: 0 !important;
        }

        .menu-toggle {
            display: none !important;
            background: none !important;
            border: none !important;
            font-size: 1.5rem !important;
            color: var(--text-dark) !important;
            cursor: pointer !important;
            padding: 0.5rem !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
        }

        .menu-toggle:hover {
            background: rgba(102, 126, 234, 0.1) !important;
            color: var(--primary) !important;
        }

        .header-title {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            background: linear-gradient(135deg, var(--primary), var(--secondary)) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            margin: 0 !important;
        }

        .header-actions {
            margin-left: auto !important;
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
        }

        .search-box {
            position: relative !important;
        }

        .search-box input {
            width: 300px !important;
            padding: 0.75rem 1rem 0.75rem 3rem !important;
            border: 2px solid var(--border) !important;
            border-radius: 12px !important;
            font-size: 0.95rem !important;
            transition: all 0.3s ease !important;
            background: white !important;
        }

        .search-box input:focus {
            outline: none !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
        }

        .search-box i {
            position: absolute !important;
            left: 1rem !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: var(--text-light) !important;
        }

        .notification-icon {
            position: relative !important;
            padding: 0.75rem !important;
            background: rgba(102, 126, 234, 0.1) !important;
            border-radius: 12px !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            color: var(--primary) !important;
        }

        .notification-icon:hover {
            background: rgba(102, 126, 234, 0.15) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2) !important;
        }

        .notification-icon .badge {
            position: absolute !important;
            top: 0.25rem !important;
            right: 0.25rem !important;
            background: var(--danger) !important;
            color: white !important;
            font-size: 0.7rem !important;
            padding: 0.1rem 0.4rem !important;
            border-radius: 8px !important;
            min-width: 1.2rem !important;
            text-align: center !important;
        }

        /* ===== CONTENT AREA ===== */
        .content-area {
            padding: 2rem !important;
            max-width: 1400px !important;
            margin: 0 auto !important;
        }

        /* ===== WELCOME SECTION ===== */
        .welcome-section {
            text-align: center !important;
            padding: 2.5rem 2rem !important;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border-radius: 20px !important;
            margin-bottom: 2rem !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .welcome-section::before {
            content: '' !important;
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            height: 100% !important;
            width: 6px !important;
            background: linear-gradient(180deg, var(--accent), var(--primary)) !important;
        }

        .welcome-section h1 {
            font-size: 2.5rem !important;
            font-weight: 800 !important;
            background: linear-gradient(135deg, var(--primary), var(--secondary)) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            margin-bottom: 0.5rem !important;
            font-family: 'Poppins', sans-serif !important;
        }

        .welcome-section p {
            color: var(--text-light) !important;
            font-size: 1.1rem !important;
            font-weight: 500 !important;
            margin: 0 !important;
        }

        /* ===== FILTERS & SEARCH ===== */
        .filters-section {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            padding: 2rem !important;
            border-radius: 20px !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
            margin-bottom: 2rem !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .filters-section::before {
            content: '' !important;
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            height: 100% !important;
            width: 6px !important;
            background: linear-gradient(180deg, var(--accent), var(--primary)) !important;
        }

        .search-container {
            position: relative !important;
            margin-bottom: 1.5rem !important;
        }

        .search-input {
            width: 100% !important;
            padding: 1rem 1rem 1rem 3rem !important;
            border: 2px solid rgba(102, 126, 234, 0.2) !important;
            border-radius: 15px !important;
            font-size: 1rem !important;
            transition: all 0.3s ease !important;
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(10px) !important;
        }

        .search-input:focus {
            outline: none !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1) !important;
            background: white !important;
        }

        .search-icon {
            position: absolute !important;
            left: 1rem !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: var(--primary) !important;
            font-size: 1.1rem !important;
        }

        .filters-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) !important;
            gap: 1rem !important;
            align-items: end !important;
        }

        .filter-group {
            display: flex !important;
            flex-direction: column !important;
            gap: 0.5rem !important;
        }

        .filter-label {
            font-weight: 600 !important;
            color: var(--text-dark) !important;
            font-size: 0.9rem !important;
        }

        .filter-select {
            padding: 0.75rem 1rem !important;
            border: 2px solid rgba(102, 126, 234, 0.2) !important;
            border-radius: 10px !important;
            background: rgba(255, 255, 255, 0.8) !important;
            font-size: 0.9rem !important;
            transition: all 0.3s ease !important;
        }

        .filter-select:focus {
            outline: none !important;
            border-color: var(--primary) !important;
            background: white !important;
        }

        .filter-buttons {
            display: flex !important;
            gap: 0.5rem !important;
        }

        .btn {
            padding: 0.75rem 1.5rem !important;
            border: none !important;
            border-radius: 10px !important;
            font-size: 0.9rem !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            justify-content: center !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary)) !important;
            color: white !important;
        }

        .btn-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3) !important;
        }

        .btn-secondary {
            background: rgba(102, 126, 234, 0.1) !important;
            color: var(--primary) !important;
            border: 2px solid rgba(102, 126, 234, 0.2) !important;
        }

        .btn-secondary:hover {
            background: rgba(102, 126, 234, 0.15) !important;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%) !important;
            }

            .sidebar.active {
                transform: translateX(0) !important;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .menu-toggle {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
        }

        @media (max-width: 767px) {
            .content-area {
                padding: 1rem !important;
            }

            .header {
                padding: 1rem !important;
            }

            .search-box input {
                width: 200px !important;
            }

            .welcome-section h1 {
                font-size: 2rem !important;
            }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards !important;
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
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
                    <a href="{{ route('dashboard') }}" class="nav-item">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Koleksi Buku</div>
                    <a href="{{ route('books.browse') }}" class="nav-item active">
                        <i class="fas fa-book"></i>
                        <span>Jelajahi Buku</span>
                    </a>
                    <a href="#" class="nav-item" onclick="document.querySelector('.search-input').focus(); return false;">
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
                    <a href="#" class="nav-item">
                        <i class="fas fa-hand-holding-heart"></i>
                        <span>Sedang Dipinjam</span>
                        @if(isset($active_loans) && $active_loans->count() > 0)
                        <span class="notification-badge">{{ $active_loans->count() }}</span>
                        @endif
                    </a>
                    <a href="#" class="nav-item">
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
                        <span class="notification-badge">3</span>
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

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <h2 class="header-title">Jelajahi Koleksi Buku</h2>
                
                <div class="header-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Cari buku..." id="headerSearch">
                    </div>
                    
                    <div class="notification-icon">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Welcome Section -->
                <div class="welcome-section fade-in">
                    <h1>📚 Koleksi Perpustakaan</h1>
                    <p>Temukan dan pinjam buku favorit Anda dari koleksi perpustakaan yang lengkap</p>
                </div>

                <!-- Filters & Search -->
                <div class="filters-section fade-in">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Cari berdasarkan judul, penulis, atau ISBN..." 
                               value="{{ request('search') }}" id="searchInput">
                    </div>
                    
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label class="filter-label">Kategori</label>
                            <select class="filter-select" id="categoryFilter">
                                <option value="">Semua Kategori</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->books_count ?? 0 }})
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">Status</label>
                            <select class="filter-select" id="statusFilter">
                                <option value="">Semua Status</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">Urutkan</label>
                            <select class="filter-select" id="sortFilter">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                                <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>Penulis A-Z</option>
                            </select>
                        </div>
                        
                        <div class="filter-buttons">
                            <button class="btn btn-primary" onclick="applyFilters()">
                                <i class="fas fa-search"></i>
                                Cari
                            </button>
                            <button class="btn btn-secondary" onclick="clearFilters()">
                                <i class="fas fa-times"></i>
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Books Section -->
                <div class="books-section">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); padding: 1.5rem; border-radius: 15px; border: 1px solid rgba(255, 255, 255, 0.2); position: relative; overflow: hidden;">
                        <div style="position: absolute; left: 0; top: 0; height: 100%; width: 6px; background: linear-gradient(180deg, var(--accent), var(--primary));"></div>
                        <div>
                            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-dark); margin: 0;">Hasil Pencarian</h2>
                            <div style="color: var(--text-light); font-size: 0.9rem; margin: 0;">
                                @if(isset($books))
                                    Menampilkan {{ $books->firstItem() ?? 0 }}-{{ $books->lastItem() ?? 0 }} 
                                    dari {{ $books->total() }} buku
                                @else
                                    Menampilkan 0 buku
                                @endif
                            </div>
                        </div>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <button style="padding: 0.5rem; border: 2px solid rgba(102, 126, 234, 0.2); background: var(--primary); color: white; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;" onclick="toggleView('grid')" id="gridView">
                                <i class="fas fa-th"></i>
                            </button>
                            <button style="padding: 0.5rem; border: 2px solid rgba(102, 126, 234, 0.2); background: rgba(255, 255, 255, 0.8); border-radius: 8px; cursor: pointer; transition: all 0.3s ease;" onclick="toggleView('list')" id="listView">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>

                    @if(isset($books) && $books->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;" id="booksGrid">
                        @foreach($books as $index => $book)
                        <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; overflow: hidden; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; cursor: pointer; position: relative; border: 1px solid rgba(255, 255, 255, 0.2);" class="book-card fade-in" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 16px 40px rgba(102, 126, 234, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 32px rgba(0, 0, 0, 0.1)'">
                            <div style="width: 100%; height: 300px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; position: relative;">
                                <i class="fas fa-book"></i>
                                <span style="position: absolute; top: 1rem; right: 1rem; padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; backdrop-filter: blur(10px); {{ $book->available > 0 ? 'background: rgba(16, 185, 129, 0.2); color: #065f46; border: 1px solid rgba(16, 185, 129, 0.3);' : 'background: rgba(239, 68, 68, 0.2); color: #991b1b; border: 1px solid rgba(239, 68, 68, 0.3);' }}">
                                    {{ $book->available > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </div>
                            <div style="padding: 1.5rem;">
                                <span style="color: var(--primary); font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; display: block;">{{ $book->category->name ?? 'Umum' }}</span>
                                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $book->title }}</h3>
                                <p style="color: var(--text-light); font-size: 0.9rem; margin-bottom: 1rem;">{{ $book->author }}</p>
                                <div style="display: flex; gap: 1rem; margin-bottom: 1rem; font-size: 0.8rem; color: var(--text-light);">
                                    <span><i class="fas fa-calendar"></i> {{ $book->publication_year ?? 'N/A' }}</span>
                                    <span><i class="fas fa-copy"></i> {{ $book->stock }} eksemplar</span>
                                    <span><i class="fas fa-check-circle"></i> {{ $book->available }} tersedia</span>
                                </div>
                                <div style="display: flex; gap: 0.5rem;">
                                    @if($book->available > 0)
                                    <button style="padding: 0.5rem 1rem; font-size: 0.8rem; background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; border: none; border-radius: 10px; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 0.5rem;" onclick="borrowBook({{ $book->id }})" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(102, 126, 234, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                        <i class="fas fa-hand-holding"></i>
                                        Pinjam
                                    </button>
                                    @else
                                    <button style="padding: 0.5rem 1rem; font-size: 0.8rem; background: rgba(102, 126, 234, 0.1); color: var(--primary); border: 2px solid rgba(102, 126, 234, 0.2); border-radius: 10px; cursor: not-allowed; display: inline-flex; align-items: center; gap: 0.5rem;" disabled>
                                        <i class="fas fa-clock"></i>
                                        Tidak Tersedia
                                    </button>
                                    @endif
                                    <button style="padding: 0.5rem 1rem; font-size: 0.8rem; background: transparent; color: var(--primary); border: 2px solid var(--primary); border-radius: 10px; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 0.5rem;" onclick="viewDetails({{ $book->id }})" onmouseover="this.style.background='var(--primary)'; this.style.color='white'" onmouseout="this.style.background='transparent'; this.style.color='var(--primary)'">
                                        <i class="fas fa-info-circle"></i>
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @else
                    <div style="text-align: center; padding: 4rem 2rem; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); position: relative; overflow: hidden;">
                        <div style="position: absolute; left: 0; top: 0; height: 100%; width: 6px; background: linear-gradient(180deg, var(--accent), var(--primary));"></div>
                        <i class="fas fa-search" style="font-size: 4rem; color: var(--text-light); margin-bottom: 1rem;"></i>
                        <h3 style="font-size: 1.5rem; color: var(--text-dark); margin-bottom: 0.5rem;">Tidak Ada Buku Ditemukan</h3>
                        <p style="color: var(--text-light); margin-bottom: 2rem;">Maaf, tidak ada buku yang sesuai dengan kriteria pencarian Anda. Coba ubah filter atau kata kunci pencarian.</p>
                        <button class="btn btn-primary" onclick="clearFilters()">
                            <i class="fas fa-refresh"></i>
                            Reset Pencarian
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('active');
            
            if (window.innerWidth >= 1024) {
                mainContent.classList.toggle('expanded');
            }
        });

        // Search functionality
        let searchTimeout;
        document.getElementById('searchInput')?.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                applyFilters();
            }, 500);
        });

        // Header search
        document.getElementById('headerSearch')?.addEventListener('input', function() {
            document.getElementById('searchInput').value = this.value;
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                applyFilters();
            }, 500);
        });

        // Apply filters
        function applyFilters() {
            const search = document.getElementById('searchInput')?.value || '';
            const category = document.getElementById('categoryFilter')?.value || '';
            const status = document.getElementById('statusFilter')?.value || '';
            const sort = document.getElementById('sortFilter')?.value || '';
            
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (category) params.append('category', category);
            if (status) params.append('status', status);
            if (sort) params.append('sort', sort);
            
            const url = `{{ route('books.browse') }}${params.toString() ? '?' + params.toString() : ''}`;
            window.location.href = url;
        }

        // Clear filters
        function clearFilters() {
            window.location.href = '{{ route('books.browse') }}';
        }

        // Toggle view
        function toggleView(view) {
            const grid = document.getElementById('booksGrid');
            const gridBtn = document.getElementById('gridView');
            const listBtn = document.getElementById('listView');
            
            if (view === 'list') {
                grid.style.gridTemplateColumns = '1fr';
                document.querySelectorAll('.book-card').forEach(card => {
                    card.style.display = 'flex';
                    card.style.alignItems = 'center';
                    card.style.padding = '1.5rem';
                });
                gridBtn.style.background = 'rgba(255, 255, 255, 0.8)';
                gridBtn.style.color = 'var(--primary)';
                listBtn.style.background = 'var(--primary)';
                listBtn.style.color = 'white';
            } else {
                grid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(280px, 1fr))';
                document.querySelectorAll('.book-card').forEach(card => {
                    card.style.display = 'block';
                    card.style.padding = '0';
                });
                listBtn.style.background = 'rgba(255, 255, 255, 0.8)';
                listBtn.style.color = 'var(--primary)';
                gridBtn.style.background = 'var(--primary)';
                gridBtn.style.color = 'white';
            }
        }

        // Borrow book
        function borrowBook(bookId) {
            if (confirm('Apakah Anda yakin ingin meminjam buku ini?')) {
                alert('Fitur peminjaman akan segera tersedia!');
            }
        }

        // View book details
        function viewDetails(bookId) {
            if (!bookId || bookId === null || bookId === undefined) {
                console.error('Book ID tidak valid:', bookId);
                alert('Terjadi kesalahan: ID buku tidak valid');
                return;
            }
            
            const baseUrl = '{{ url("/books") }}';
            window.location.href = `${baseUrl}/${bookId}`;
        }
    </script>
</body>
</html>