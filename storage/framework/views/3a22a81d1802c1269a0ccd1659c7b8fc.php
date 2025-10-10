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
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
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
            margin: 2rem auto;
            position: relative;
            z-index: 5;
            background: rgba(207, 232, 240, 0.13);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .content-area::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
            border-radius: 2px;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
        }

        .welcome-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            z-index: 10;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 0%; }
            50% { background-position: 100% 0%; }
        }

        .welcome-section::after {
            display: none;
        }

        .welcome-section h1 {
            font-size: 2rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            position: relative;
            z-index: 2;
        }

        .welcome-section p {
            color: var(--text-light);
            font-size: 1.1rem;
            font-weight: 400;
            line-height: 1.6;
            position: relative;
            z-index: 2;
        }

        /* ===== FILTERS & SEARCH ===== */
        .filters-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
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
            width: 4px;
            background: linear-gradient(180deg, var(--primary), var(--secondary));
        }

        .search-container {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid rgba(102, 126, 234, 0.15);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            font-weight: 400;
            color: var(--text-dark);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
            background: white;
            transform: translateY(-1px);
        }

        .search-input::placeholder {
            color: var(--text-light);
        }

        .search-icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .search-container:focus-within .search-icon {
            color: var(--primary-dark);
            transform: translateY(-50%) scale(1.1);
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .filter-label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
            letter-spacing: 0.025em;
        }

        .filter-select {
            padding: 0.875rem 1rem;
            border: 2px solid rgba(102, 126, 234, 0.15);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--text-dark);
            font-weight: 400;
            cursor: pointer;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
            transform: translateY(-1px);
        }

        .filter-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.25rem;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
            letter-spacing: 0.025em;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #f8fafc;
            color: var(--primary);
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary:hover {
            background: #f1f5f9;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
        }

        /* ===== BOOKS GRID ===== */
        .books-section {
            margin-bottom: 3rem;
        }

        .books-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            padding: 2rem;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .books-header::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(180deg, var(--primary), var(--secondary));
        }

        .books-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .books-meta {
            color: var(--text-light);
            font-size: 0.875rem;
            margin: 0.25rem 0 0 0;
            font-weight: 400;
        }

        .view-toggle {
            display: flex;
            gap: 0.375rem;
            align-items: center;
            background: #f8fafc;
            padding: 0.375rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .view-btn {
            padding: 0.5rem;
            border: none;
            background: transparent;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .view-btn.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
        }

        .view-btn:hover {
            background: var(--primary);
            color: white;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.25rem;
            align-items: start;
        }

        .book-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.12),
                0 8px 16px rgba(102, 126, 234, 0.1);
        }

        .book-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            position: relative;
            overflow: hidden;
        }

        .book-image::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, 0.8));
            z-index: 2;
        }

        .book-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            position: relative;
            z-index: 1;
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
            background: rgba(16, 185, 129, 0.726);
            color: #065f46;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .book-status.unavailable {
            background: rgba(239, 68, 68, 0.63);
            color: #991b1b;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .book-content { 
            padding: 1rem;
            position: relative;
            background: linear-gradient(
                to bottom,
                rgba(255, 255, 255, 0.7) 0%,
                rgba(255, 255, 255, 0.9) 30%,
                rgba(255, 255, 255, 0.95) 100%
            );
            backdrop-filter: blur(10px);
            margin-top: -20px;
            border-radius: 15px 15px 0 0;
            z-index: 3;
            overflow: hidden;
        }

        .book-content::before {
            content: '';
            position: absolute;
            top: -30px;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: var(--book-cover);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.06;
            z-index: -1;
            filter: blur(1px);
        }

        .book-category {
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.375rem;
            display: block;
        }

        .book-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.375rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-author {
            color: var(--text-light);
            font-size: 0.8rem;
            margin-bottom: 0.75rem;
        }

        .book-meta {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            font-size: 0.7rem;
            color: var(--text-light);
        }

        .book-meta span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .book-actions {
            display: flex;
            gap: 0.375rem;
        }

        .book-btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            text-decoration: none;
            font-weight: 500;
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
            padding: 3rem 2rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .no-results::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
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

        /* ===== PAGINATION ===== */
        .pagination-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            margin-top: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pagination .page-item {
            margin: 0;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0.5rem 0.75rem;
            text-decoration: none;
            border: 1px solid rgba(102, 126, 234, 0.15);
            border-radius: 10px;
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .pagination .page-link:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .pagination .page-item.disabled .page-link {
            color: #cbd5e1;
            border-color: #f1f5f9;
            background: #f8fafc;
            cursor: not-allowed;
        }

        .pagination .page-item.disabled .page-link:hover {
            transform: none;
            box-shadow: none;
            background: #f8fafc;
            color: #cbd5e1;
        }

        .pagination-info {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-left: 2rem;
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
                gap: 1.5rem;
                text-align: center;
            }

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }

            .content-area {
                padding: 1.5rem;
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

            .welcome-section {
                padding: 2rem 1.5rem;
            }

            .welcome-section h1 {
                font-size: 2rem;
            }

            .filters-section {
                padding: 1.5rem;
            }

            .filters-grid {
                gap: 1rem;
            }

            .filter-buttons {
                grid-column: 1 / -1;
                justify-content: center;
            }

            .books-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
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

        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        .slide-in {
            animation: slideInFromLeft 0.5s ease forwards;
        }

        .scale-in {
            animation: scaleIn 0.4s ease forwards;
        }

        /* Staggered animation for book cards */
        .book-card {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeIn 0.6s ease forwards;
        }

        .book-card:nth-child(1) { animation-delay: 0.1s; }
        .book-card:nth-child(2) { animation-delay: 0.2s; }
        .book-card:nth-child(3) { animation-delay: 0.3s; }
        .book-card:nth-child(4) { animation-delay: 0.4s; }
        .book-card:nth-child(5) { animation-delay: 0.5s; }
        .book-card:nth-child(6) { animation-delay: 0.6s; }
        .book-card:nth-child(n+7) { animation-delay: 0.7s; }

        /* Hover effects */
        .filter-select:hover {
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        .search-input:hover {
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        /* Loading state */
        .loading {
            animation: pulse 1.5s ease-in-out infinite;
        }

        /* Smooth transitions for all interactive elements */
        * {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar for the page */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
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
                                <?php
                                    $cover = $book->cover_image ?? null;
                                    $isUrl = $cover && (\Illuminate\Support\Str::startsWith($cover, ['http://', 'https://']));
                                    $src = $cover ? ($isUrl ? $cover : asset('storage/'.$cover)) : null;
                                ?>
                                <?php if($src): ?>
                                    <img src="<?php echo e($src); ?>" alt="<?php echo e($book->title); ?> cover" onerror="this.style.display='none'">
                                <?php else: ?>
                                    <i class="fas fa-book"></i>
                                <?php endif; ?>
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

                    <?php if(isset($books) && $books instanceof \Illuminate\Pagination\LengthAwarePaginator && $books->hasPages()): ?>
                    <!-- Pagination Section -->
                    <div class="pagination-section">
                        <div class="pagination-wrapper">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    
                                    <?php if($books->onFirstPage()): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo e($books->previousPageUrl()); ?>" rel="prev">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    
                                    <?php $__currentLoopData = $books->getUrlRange(1, min(10, $books->lastPage())); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($page == $books->currentPage()): ?>
                                            <li class="page-item active">
                                                <span class="page-link"><?php echo e($page); ?></span>
                                            </li>
                                        <?php else: ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    
                                    <?php if($books->lastPage() > 10): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo e($books->url($books->lastPage())); ?>"><?php echo e($books->lastPage()); ?></a>
                                        </li>
                                    <?php endif; ?>

                                    
                                    <?php if($books->hasMorePages()): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo e($books->nextPageUrl()); ?>" rel="next">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                            
                            <?php if(isset($books) && $books->total() > 0): ?>
                            <div class="pagination-info">
                                Halaman <?php echo e($books->currentPage()); ?> dari <?php echo e($books->lastPage()); ?> 
                                (<?php echo e($books->total()); ?> total buku)
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enhanced toggle sidebar with smooth animations
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            // Add smooth transition
            sidebar.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            sidebar.classList.toggle('active');
            
            if (window.innerWidth >= 1024) {
                mainContent.style.transition = 'margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                mainContent.classList.toggle('expanded');
            }
        });

        // Enhanced close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                    sidebar.classList.remove('active');
                }
            }
        });

        // Enhanced search functionality with loading states
        let searchTimeout;
        document.getElementById('searchInput')?.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchInput = this;
            
            // Add loading visual feedback
            searchInput.style.backgroundImage = 'linear-gradient(90deg, transparent 0%, rgba(102, 126, 234, 0.1) 50%, transparent 100%)';
            searchInput.style.backgroundSize = '200% 100%';
            searchInput.style.animation = 'shimmer 1.5s infinite';
            
            searchTimeout = setTimeout(() => {
                searchInput.style.animation = '';
                searchInput.style.backgroundImage = '';
                applyFilters();
            }, 800);
        });

        // Enhanced header search with smooth sync
        document.getElementById('headerSearch')?.addEventListener('input', function() {
            const mainSearchInput = document.getElementById('searchInput');
            if (mainSearchInput) {
                mainSearchInput.value = this.value;
                
                // Trigger the main search input event
                mainSearchInput.dispatchEvent(new Event('input'));
            }
        });

        // Enhanced enter key handling
        const searchInput = document.getElementById('headerSearch');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const searchTerm = this.value.trim();
                    
                    // Add quick loading feedback
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                        if (searchTerm) {
                            window.location.href = '<?php echo e(route("books.browse")); ?>?search=' + encodeURIComponent(searchTerm);
                        }
                    }, 150);
                }
            });
        }

        // Enhanced apply filters with better UX
        function applyFilters() {
            const search = document.getElementById('searchInput')?.value || '';
            const category = document.getElementById('categoryFilter')?.value || '';
            const status = document.getElementById('statusFilter')?.value || '';
            const sort = document.getElementById('sortFilter')?.value || '';
            
            // Add loading state to the entire books section
            const booksSection = document.querySelector('.books-section');
            if (booksSection) {
                booksSection.style.opacity = '0.7';
                booksSection.style.transform = 'scale(0.98)';
                booksSection.style.transition = 'all 0.3s ease';
            }
            
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (category) params.append('category', category);
            if (status) params.append('status', status);
            if (sort) params.append('sort', sort);
            
            const url = `<?php echo e(route('books.browse')); ?>${params.toString() ? '?' + params.toString() : ''}`;
            
            // Smooth navigation with delay
            setTimeout(() => {
                window.location.href = url;
            }, 300);
        }

        // Enhanced clear filters with animation
        function clearFilters() {
            // Animate all filter inputs
            const filterElements = [
                document.getElementById('searchInput'),
                document.getElementById('categoryFilter'),
                document.getElementById('statusFilter'),
                document.getElementById('sortFilter')
            ];
            
            filterElements.forEach((element, index) => {
                if (element) {
                    setTimeout(() => {
                        element.style.transform = 'scale(0.95)';
                        element.style.opacity = '0.7';
                        
                        setTimeout(() => {
                            element.value = '';
                            element.style.transform = 'scale(1)';
                            element.style.opacity = '1';
                        }, 100);
                    }, index * 50);
                }
            });
            
            // Navigate after animation
            setTimeout(() => {
                window.location.href = '<?php echo e(route('books.browse')); ?>';
            }, 400);
        }

        // Enhanced toggle view with smooth transitions
        function toggleView(view) {
            const grid = document.getElementById('booksGrid');
            const gridBtn = document.getElementById('gridView');
            const listBtn = document.getElementById('listView');
            
            // Add transition for smooth layout change
            grid.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            
            if (view === 'list') {
                grid.style.gridTemplateColumns = '1fr';
                grid.style.gap = '1rem';
                
                // Animate each book card
                document.querySelectorAll('.book-card').forEach((card, index) => {
                    setTimeout(() => {
                        card.style.transition = 'all 0.3s ease';
                        card.style.display = 'flex';
                        card.style.alignItems = 'center';
                        card.style.minHeight = '200px';
                    }, index * 50);
                });
                
                gridBtn.classList.remove('active');
                listBtn.classList.add('active');
            } else {
                grid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(320px, 1fr))';
                grid.style.gap = '2rem';
                
                // Animate each book card back
                document.querySelectorAll('.book-card').forEach((card, index) => {
                    setTimeout(() => {
                        card.style.transition = 'all 0.3s ease';
                        card.style.display = 'block';
                        card.style.alignItems = 'initial';
                        card.style.minHeight = 'auto';
                    }, index * 30);
                });
                
                listBtn.classList.remove('active');
                gridBtn.classList.add('active');
            }
            
            // Add ripple effect to clicked button
            const activeBtn = view === 'list' ? listBtn : gridBtn;
            activeBtn.style.transform = 'scale(0.9)';
            setTimeout(() => {
                activeBtn.style.transform = 'scale(1)';
            }, 150);
        }

        // Enhanced borrow book with better feedback
        function borrowBook(bookId) {
            const button = event.target.closest('.book-btn-primary');
            if (!button) return;
            
            // Disable button and show loading
            const originalContent = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Meminjam...';
            button.disabled = true;
            button.style.cursor = 'not-allowed';
            
            // Simulate API call (replace with actual implementation)
            setTimeout(() => {
                if (confirm('Apakah Anda yakin ingin meminjam buku ini?')) {
                    // Show success state
                    button.innerHTML = '<i class="fas fa-check"></i> Dipinjam!';
                    button.style.background = 'var(--success)';
                    
                    // Show notification
                    showNotification('Buku berhasil dipinjam!', 'success');
                    
                    // Reset after delay
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.disabled = false;
                        button.style.cursor = 'pointer';
                        button.style.background = '';
                    }, 2000);
                } else {
                    // Reset if cancelled
                    button.innerHTML = originalContent;
                    button.disabled = false;
                    button.style.cursor = 'pointer';
                }
            }, 1000);
        }

        // Enhanced view details with loading state
        function viewDetails(bookId) {
            if (!bookId || bookId === null || bookId === undefined) {
                console.error('Book ID tidak valid:', bookId);
                showNotification('Terjadi kesalahan: ID buku tidak valid', 'error');
                return;
            }
            
            const button = event.target.closest('.book-btn-secondary');
            if (button) {
                // Add loading animation
                const originalContent = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                button.style.transform = 'scale(0.95)';
                
                setTimeout(() => {
                    const baseUrl = '<?php echo e(url("/books")); ?>';
                    window.location.href = `${baseUrl}/${bookId}`;
                }, 500);
            }
        }

        // Enhanced notification system
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            document.querySelectorAll('.notification').forEach(n => n.remove());
            
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            
            const icon = type === 'success' ? 'check-circle' : 
                        type === 'error' ? 'exclamation-circle' : 'info-circle';
            
            notification.innerHTML = `
                <i class="fas fa-${icon}"></i>
                <span>${message}</span>
                <button onclick="this.parentNode.remove()" style="background: none; border: none; color: inherit; margin-left: auto; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            // Enhanced notification styles
            const colors = {
                success: '#10b981',
                error: '#ef4444',
                info: '#3b82f6'
            };
            
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${colors[type]};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
                z-index: 10000;
                transform: translateX(100%);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                display: flex;
                align-items: center;
                gap: 0.75rem;
                max-width: 400px;
                font-weight: 500;
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            requestAnimationFrame(() => {
                notification.style.transform = 'translateX(0)';
            });
            
            // Auto remove
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 4000);
        }

        // Enhanced intersection observer with staggered animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add visible class for CSS animations
                    entry.target.classList.add('visible');
                    
                    // Staggered animation for book cards
                    if (entry.target.classList.contains('book-card')) {
                        const index = Array.from(entry.target.parentNode.children).indexOf(entry.target);
                        entry.target.style.animationDelay = `${index * 100}ms`;
                    }
                }
            });
        }, observerOptions);

        // Enhanced page initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Apply image overlay effect
            applyImageOverlayEffect();
            
            // Observe all animatable elements
            document.querySelectorAll('.fade-in, .book-card').forEach(el => {
                observer.observe(el);
            });
            
            // Add entrance animations with stagger
            const sectionsToAnimate = [
                '.welcome-section',
                '.filters-section', 
                '.books-header'
            ];
            
            sectionsToAnimate.forEach((selector, index) => {
                const element = document.querySelector(selector);
                if (element) {
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(30px)';
                    
                    setTimeout(() => {
                        element.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }, index * 200 + 300);
                }
            });
        });

        // Function to apply image overlay effect to book cards
        function applyImageOverlayEffect() {
            const bookCards = document.querySelectorAll('.book-card');
            
            bookCards.forEach(card => {
                const image = card.querySelector('.book-image img');
                const content = card.querySelector('.book-content');
                
                if (image && content) {
                    // Get image source
                    const imageSrc = image.src;
                    
                    // Apply the image as CSS custom property
                    content.style.setProperty('--book-cover', `url('${imageSrc}')`);
                    
                    // Add class for styling
                    content.classList.add('has-cover-overlay');
                }
            });
        }

        // Add dynamic CSS for enhanced animations
        const dynamicStyles = document.createElement('style');
        dynamicStyles.textContent = `
            @keyframes shimmer {
                0% { background-position: -200% 0; }
                100% { background-position: 200% 0; }
            }
            
            .visible {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }
            
            .notification {
                animation: slideInRight 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            .book-card:hover .book-image {
                transform: scale(1.02);
                transition: transform 0.3s ease;
            }
            
            .filter-select:focus,
            .search-input:focus {
                box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
            }
            
            .book-content.has-cover-overlay::before {
                opacity: 0.08;
                filter: blur(2px) saturate(0.7);
            }
            
            .book-content.has-cover-overlay {
                background: linear-gradient(
                    to bottom,
                    rgba(255, 255, 255, 0.85) 0%,
                    rgba(255, 255, 255, 0.92) 30%,
                    rgba(255, 255, 255, 0.97) 100%
                );
            }
            
            .book-content.has-cover-overlay .book-title,
            .book-content.has-cover-overlay .book-author,
            .book-content.has-cover-overlay .book-category {
                text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
                position: relative;
                z-index: 2;
            }
        `;
        document.head.appendChild(dynamicStyles);
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\PERPUSTAKAAN\resources\views/dashboard/browse.blade.php ENDPATH**/ ?>