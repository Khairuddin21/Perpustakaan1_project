<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajahi Buku - SisPerpus</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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
            width: calc(100% - var(--sidebar-width));
        }

        .main-content.expanded {
            margin-left: 0;
            width: 100%;
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

        /* ===== FILTERS & SEARCH ===== */
        .filters-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .filters-section::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 6px;
            background: linear-gradient(180deg, var(--accent), var(--primary));
        }

        .search-container {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1.1rem;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .filter-select {
            padding: 0.75rem 1rem;
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
        }

        .filter-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary);
            border: 2px solid rgba(102, 126, 234, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(102, 126, 234, 0.15);
        }

        /* ===== BOOKS GRID ===== */
        .books-section {
            margin-bottom: 2rem;
        }

        .books-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .books-header::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 6px;
            background: linear-gradient(180deg, var(--accent), var(--primary));
        }

        .books-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .books-meta {
            color: var(--text-light);
            font-size: 0.9rem;
            margin: 0;
        }

        .view-toggle {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .view-btn {
            padding: 0.5rem;
            border: 2px solid rgba(102, 126, 234, 0.2);
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--primary);
        }

        .view-btn.active {
            background: var(--primary);
            color: white;
        }

        .view-btn:hover {
            background: var(--primary);
            color: white;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .book-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(102, 126, 234, 0.2);
        }

        .book-image {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            position: relative;
        }

        .book-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            backdrop-filter: blur(10px);
        }

        .book-status.available {
            background: rgba(16, 185, 129, 0.2);
            color: #065f46;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .book-status.unavailable {
            background: rgba(239, 68, 68, 0.2);
            color: #991b1b;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .book-content {
            padding: 1.5rem;
        }

        .book-category {
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            display: block;
        }

        .book-title {
            font-size: 1.1rem;
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
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .book-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .book-meta span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .book-actions {
            display: flex;
            gap: 0.5rem;
        }

        .book-btn {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .book-btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .book-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .book-btn-secondary {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .book-btn-secondary:hover {
            background: var(--primary);
            color: white;
        }

        .book-btn-disabled {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary);
            border: 2px solid rgba(102, 126, 234, 0.2);
            cursor: not-allowed;
        }

        .no-results {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .no-results::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 6px;
            background: linear-gradient(180deg, var(--accent), var(--primary));
        }

        .no-results i {
            font-size: 4rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .no-results h3 {
            font-size: 1.5rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .no-results p {
            color: var(--text-light);
            margin-bottom: 2rem;
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

            .filters-grid {
                grid-template-columns: 1fr;
            }

            .books-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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

            .filters-section {
                padding: 1.5rem;
            }

            .books-grid {
                grid-template-columns: 1fr;
            }

            .book-meta {
                flex-direction: column;
                gap: 0.5rem;
            }

            .book-actions {
                flex-direction: column;
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
            animation: fadeIn 0.6s ease forwards;
        }

    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <?php echo $__env->make('components.sidebar', ['activeLoans' => isset($active_loans) ? $active_loans : collect()], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
                               value="<?php echo e(request('search')); ?>" id="searchInput">
                    </div>
                    
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label class="filter-label">Kategori</label>
                            <select class="filter-select" id="categoryFilter">
                                <option value="">Semua Kategori</option>
                                <?php if(isset($categories)): ?>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" 
                                            <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?> (<?php echo e($category->books_count ?? 0); ?>)
                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">Status</label>
                            <select class="filter-select" id="statusFilter">
                                <option value="">Semua Status</option>
                                <option value="available" <?php echo e(request('status') == 'available' ? 'selected' : ''); ?>>Tersedia</option>
                                <option value="unavailable" <?php echo e(request('status') == 'unavailable' ? 'selected' : ''); ?>>Tidak Tersedia</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">Urutkan</label>
                            <select class="filter-select" id="sortFilter">
                                <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Terbaru</option>
                                <option value="oldest" <?php echo e(request('sort') == 'oldest' ? 'selected' : ''); ?>>Terlama</option>
                                <option value="title" <?php echo e(request('sort') == 'title' ? 'selected' : ''); ?>>Judul A-Z</option>
                                <option value="author" <?php echo e(request('sort') == 'author' ? 'selected' : ''); ?>>Penulis A-Z</option>
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
                    <div class="books-header">
                        <div>
                            <h2>Hasil Pencarian</h2>
                            <div class="books-meta">
                                <?php if(isset($books)): ?>
                                    Menampilkan <?php echo e($books->firstItem() ?? 0); ?>-<?php echo e($books->lastItem() ?? 0); ?> 
                                    dari <?php echo e($books->total()); ?> buku
                                <?php else: ?>
                                    Menampilkan 0 buku
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="view-toggle">
                            <button class="view-btn active" onclick="toggleView('grid')" id="gridView">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="view-btn" onclick="toggleView('list')" id="listView">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>

                    <?php if(isset($books) && $books->count() > 0): ?>
                    <div class="books-grid" id="booksGrid">
                        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="book-card fade-in">
                            <div class="book-image">
                                <i class="fas fa-book"></i>
                                <span class="book-status <?php echo e($book->available > 0 ? 'available' : 'unavailable'); ?>">
                                    <?php echo e($book->available > 0 ? 'Tersedia' : 'Tidak Tersedia'); ?>

                                </span>
                            </div>
                            <div class="book-content">
                                <span class="book-category"><?php echo e($book->category->name ?? 'Umum'); ?></span>
                                <h3 class="book-title"><?php echo e($book->title); ?></h3>
                                <p class="book-author"><?php echo e($book->author); ?></p>
                                <div class="book-meta">
                                    <span><i class="fas fa-calendar"></i> <?php echo e($book->publication_year ?? 'N/A'); ?></span>
                                    <span><i class="fas fa-copy"></i> <?php echo e($book->stock); ?> eksemplar</span>
                                    <span><i class="fas fa-check-circle"></i> <?php echo e($book->available); ?> tersedia</span>
                                </div>
                                <div class="book-actions">
                                    <?php if($book->available > 0): ?>
                                    <button class="book-btn book-btn-primary" onclick="borrowBook(<?php echo e($book->id); ?>)">
                                        <i class="fas fa-hand-holding"></i>
                                        Pinjam
                                    </button>
                                    <?php else: ?>
                                    <button class="book-btn book-btn-disabled" disabled>
                                        <i class="fas fa-clock"></i>
                                        Tidak Tersedia
                                    </button>
                                    <?php endif; ?>
                                    <button class="book-btn book-btn-secondary" onclick="viewDetails(<?php echo e($book->id); ?>)">
                                        <i class="fas fa-info-circle"></i>
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <?php else: ?>
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <h3>Tidak Ada Buku Ditemukan</h3>
                        <p>Maaf, tidak ada buku yang sesuai dengan kriteria pencarian Anda. Coba ubah filter atau kata kunci pencarian.</p>
                        <button class="btn btn-primary" onclick="clearFilters()">
                            <i class="fas fa-refresh"></i>
                            Reset Pencarian
                        </button>
                    </div>
                    <?php endif; ?>
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

        // Legacy search functionality for backward compatibility
        const searchInput = document.getElementById('headerSearch');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const searchTerm = this.value.trim();
                    if (searchTerm) {
                        window.location.href = '<?php echo e(route("books.browse")); ?>?search=' + encodeURIComponent(searchTerm);
                    }
                }
            });
        }

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
            
            const url = `<?php echo e(route('books.browse')); ?>${params.toString() ? '?' + params.toString() : ''}`;
            window.location.href = url;
        }

        // Clear filters
        function clearFilters() {
            window.location.href = '<?php echo e(route('books.browse')); ?>';
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
                });
                gridBtn.classList.remove('active');
                listBtn.classList.add('active');
            } else {
                grid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(280px, 1fr))';
                document.querySelectorAll('.book-card').forEach(card => {
                    card.style.display = 'block';
                    card.style.alignItems = 'initial';
                });
                listBtn.classList.remove('active');
                gridBtn.classList.add('active');
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
            
            const baseUrl = '<?php echo e(url("/books")); ?>';
            window.location.href = `${baseUrl}/${bookId}`;
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
</html><?php /**PATH C:\xampp\htdocs\PERPUSTAKAAN\resources\views/dashboard/browse.blade.php ENDPATH**/ ?>