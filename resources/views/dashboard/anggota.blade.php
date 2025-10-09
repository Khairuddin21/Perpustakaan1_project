<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota - SisPerpus</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #667eea;
            --primary-dark: #5568d3;
            --secondary: #764ba2;
            --accent: #f093fb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --dark: #1e293b;
            --light: #f8fafc;
            --border: #e2e8f0;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--text-dark);
        }

        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; /* Add flex display */
            flex-direction: column; /* Stack items vertically */
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .logo-container i {
            font-size: 2rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 10px rgba(102, 126, 234, 0.5));
        }

        .sidebar-title {
            font-size: 1.75rem;
            font-weight: 800;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #f093fb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-subtitle {
            font-size: 0.875rem;
            color: #94a3b8;
            font-weight: 400;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
            flex: 1; /* Take up remaining space */
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0 1.5rem;
            margin-bottom: 0.75rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1.5rem;
            color: #e2e8f0;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.2), transparent);
            transition: width 0.3s ease;
        }

        .nav-item:hover {
            background: rgba(102, 126, 234, 0.1);
            border-left-color: var(--primary);
        }

        .nav-item:hover::before {
            width: 100%;
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.2), transparent);
            border-left-color: var(--accent);
            color: white;
            font-weight: 600;
        }

        .nav-item i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        .notification-badge {
            margin-left: auto;
            background: var(--danger);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            font-weight: 600;
        }

        .sidebar-footer {
            /* Remove sticky positioning */
            /* position: sticky; */
            /* bottom: 0; */
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto; /* Push to bottom of sidebar */
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .user-details {
            flex: 1;
        }

        .user-details strong {
            display: block;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .user-details small {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .logout-btn {
            width: 100%;
            padding: 0.75rem;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* ===== HEADER ===== */
        .header {
            background: white;
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .menu-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border: none;
            background: var(--light);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 1rem;
        }

        .menu-toggle:hover {
            background: var(--primary);
            color: white;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            width: 300px;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        .notification-icon {
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .notification-icon:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .notification-icon .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* ===== CONTENT AREA ===== */
        .content-area {
            padding: 2rem;
            max-width: 1400px;
        }

        .welcome-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(102, 126, 234, 0.2);
            backdrop-filter: blur(10px);
        }

        .welcome-section h1 {
            font-size: 2rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            color: white;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .welcome-section p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
        }

        /* ===== STATS CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.5s ease forwards;
            opacity: 0;
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card {
            transform: translateY(20px);
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.2);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }

        .stat-card.primary .stat-icon {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(102, 126, 234, 0.2));
            color: var(--primary);
        }

        .stat-card.success .stat-icon {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.2));
            color: var(--success);
        }

        .stat-card.warning .stat-icon {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.2));
            color: var(--warning);
        }

        .stat-card.info .stat-icon {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.2));
            color: var(--info);
        }

        .stat-value {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
            font-family: 'Poppins', sans-serif;
        }

        .stat-label {
            font-size: 0.95rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* ===== SECTION TITLE ===== */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        .view-all-btn {
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .view-all-btn:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
        }

        /* ===== ACTIVE LOANS ===== */
        .loans-section {
            margin-bottom: 2rem;
        }

        .loans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .loan-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            gap: 1.5rem;
        }

        .loan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.15);
        }

        .loan-book-cover {
            width: 80px;
            height: 110px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .loan-details {
            flex: 1;
        }

        .loan-book-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .loan-book-author {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .loan-date-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .loan-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .loan-date i {
            color: var(--primary);
        }

        .due-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .due-badge.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .due-badge.warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .due-badge.danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--border);
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-light);
            margin-bottom: 1.5rem;
        }

        /* ===== FEATURED BOOKS ===== */
        .books-section {
            margin-bottom: 2rem;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .book-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.2);
        }

        .book-cover {
            width: 100%;
            height: 280px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            position: relative;
        }

        .book-availability {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            backdrop-filter: blur(10px);
        }

        .book-availability.available {
            background: rgba(16, 185, 129, 0.9);
            color: white;
        }

        .book-availability.unavailable {
            background: rgba(239, 68, 68, 0.9);
            color: white;
        }

        .book-info {
            padding: 1.25rem;
        }

        .book-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary);
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .book-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-author {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .book-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            flex: 1;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--border);
            color: var(--text-dark);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* ===== QUICK ACTIONS ===== */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .action-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.15);
        }

        .action-card i {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .action-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .action-card p {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .search-box input {
                width: 200px;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 0 1rem;
            }

            .header-title {
                font-size: 1.25rem;
            }

            .search-box {
                display: none;
            }

            .content-area {
                padding: 1rem;
            }

            .welcome-section h1 {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .loans-grid {
                grid-template-columns: 1fr;
            }

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 1rem;
            }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        @include('components.sidebar', ['activeLoans' => $active_loans])

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <h2 class="header-title">Dashboard Anggota</h2>
                
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
                    <h1>👋 Selamat Datang, {{ auth()->user()->name }}!</h1>
                    <p>Temukan buku favorit Anda dan nikmati pengalaman membaca yang menyenangkan</p>
                </div>

                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <div class="stat-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="stat-value">{{ $active_loans->count() }}</div>
                        <div class="stat-label">Buku Dipinjam</div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-value">{{ $loan_history->where('status', 'returned')->count() }}</div>
                        <div class="stat-label">Buku Dikembalikan</div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-value">
                            {{ $active_loans->filter(function($loan) {
                                return \Carbon\Carbon::parse($loan->due_date)->diffInDays(now()) <= 3;
                            })->count() }}
                        </div>
                        <div class="stat-label">Segera Jatuh Tempo</div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-value">{{ $featured_books->count() }}</div>
                        <div class="stat-label">Buku Tersedia</div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="section-header">
                    <h2 class="section-title">🚀 Aksi Cepat</h2>
                </div>
                <div class="quick-actions">
                    <a href="{{ route('books.browse') }}" class="action-card">
                        <i class="fas fa-compass"></i>
                        <h3>Jelajahi Buku</h3>
                        <p>Temukan koleksi buku terbaru</p>
                    </a>
                    <a href="{{ route('books.browse') }}" class="action-card">
                        <i class="fas fa-search-plus"></i>
                        <h3>Cari Buku</h3>
                        <p>Cari buku berdasarkan judul atau penulis</p>
                    </a>
                    <a href="#" class="action-card">
                        <i class="fas fa-history"></i>
                        <h3>Riwayat</h3>
                        <p>Lihat riwayat peminjaman Anda</p>
                    </a>
                </div>

                <!-- Active Loans Section -->
                @if($active_loans->count() > 0)
                <div class="loans-section">
                    <div class="section-header">
                        <h2 class="section-title">📚 Buku yang Sedang Dipinjam</h2>
                    </div>
                    <div class="loans-grid">
                        @foreach($active_loans as $loan)
                        <div class="loan-card fade-in">
                            <div class="loan-book-cover">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="loan-details">
                                <h3 class="loan-book-title">{{ $loan->book->title }}</h3>
                                <p class="loan-book-author">{{ $loan->book->author }}</p>
                                <div class="loan-date-info">
                                    <div class="loan-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Dipinjam: {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</span>
                                    </div>
                                    <div class="loan-date">
                                        <i class="fas fa-calendar-check"></i>
                                        <span>Jatuh Tempo: {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</span>
                                    </div>
                                </div>
                                @php
                                    $daysLeft = \Carbon\Carbon::parse($loan->due_date)->diffInDays(now(), false);
                                    $badgeClass = $daysLeft < 0 ? 'danger' : ($daysLeft <= 3 ? 'warning' : 'success');
                                    $badgeText = $daysLeft < 0 ? 'Terlambat ' . abs($daysLeft) . ' hari' : ($daysLeft == 0 ? 'Jatuh tempo hari ini' : $daysLeft . ' hari lagi');
                                @endphp
                                <span class="due-badge {{ $badgeClass }}">{{ $badgeText }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="loans-section">
                    <div class="section-header">
                        <h2 class="section-title">📚 Buku yang Sedang Dipinjam</h2>
                    </div>
                    <div class="empty-state">
                        <i class="fas fa-book-open"></i>
                        <h3>Belum Ada Buku yang Dipinjam</h3>
                        <p>Mulai jelajahi koleksi kami dan pinjam buku favorit Anda!</p>
                        <a href="{{ route('books.browse') }}" class="btn btn-primary" style="display: inline-flex; text-decoration: none; max-width: 200px; margin: 0 auto;">
                            <i class="fas fa-book"></i>
                            Jelajahi Buku
                        </a>
                    </div>
                </div>
                @endif

                <!-- Featured Books Section -->
                <div class="books-section">
                    <div class="section-header">
                        <h2 class="section-title">✨ Buku Terbaru & Populer</h2>
                        <a href="{{ route('books.browse') }}" class="view-all-btn">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="books-grid">
                        @foreach($featured_books as $book)
                        <div class="book-card fade-in" onclick="window.location.href='{{ route('books.show', $book->id) }}'">
                            <div class="book-cover">
                                <i class="fas fa-book"></i>
                                <span class="book-availability {{ $book->available > 0 ? 'available' : 'unavailable' }}">
                                    {{ $book->available > 0 ? 'Tersedia' : 'Dipinjam' }}
                                </span>
                            </div>
                            <div class="book-info">
                                <span class="book-category">{{ $book->category->name ?? 'Umum' }}</span>
                                <h3 class="book-title">{{ $book->title }}</h3>
                                <p class="book-author">{{ $book->author }}</p>
                                <div class="book-actions">
                                    <button class="btn btn-primary" onclick="event.stopPropagation(); alert('Fitur peminjaman akan segera tersedia!')">
                                        <i class="fas fa-hand-holding"></i>
                                        Pinjam
                                    </button>
                                    <button class="btn btn-outline" onclick="event.stopPropagation(); window.location.href='{{ route('books.show', $book->id) }}'">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Search functionality
        const searchInput = document.getElementById('headerSearch');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const searchTerm = this.value.trim();
                    if (searchTerm) {
                        window.location.href = '{{ route("books.browse") }}?search=' + encodeURIComponent(searchTerm);
                    }
                }
            });
        }

        // Add fade-in animation to elements
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
