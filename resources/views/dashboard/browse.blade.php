<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajahi Buku - SisPerpus</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@zxing/library@latest"></script>
    
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
            height: 460px;
            display: flex;
            flex-direction: column;
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
            flex-shrink: 0;
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
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
            line-height: 1.2;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.4rem;
        }

        .book-author {
            color: var(--text-light);
            font-size: 0.75rem;
            margin-bottom: 0.5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .book-meta {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            margin-bottom: 0.5rem;
            font-size: 0.7rem;
            color: var(--text-light);
        }

        .book-meta span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .book-content-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .book-content-footer {
            margin-top: auto;
            padding-top: 0.5rem;
        }

        .book-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .book-rating-stars {
            display: flex;
            gap: 0.125rem;
        }

        .book-rating-stars i {
            font-size: 0.875rem;
            color: #f59e0b;
        }

        .book-rating-stars i.far {
            color: #e2e8f0;
        }

        .book-rating-text {
            font-size: 0.75rem;
            color: var(--text-light);
            font-weight: 500;
        }

        .book-actions {
            display: flex;
            gap: 0.375rem;
            margin-top: 0.75rem;
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

        /* ===== BORROWED BOOKS MODAL ===== */
        .borrowed-books-container {
            max-height: 60vh;
            overflow-y: auto;
        }

        .borrowed-book-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.8);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .borrowed-book-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.1);
        }

        .borrowed-book-cover {
            width: 60px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .borrowed-book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .borrowed-book-cover i {
            font-size: 1.5rem;
            color: white;
        }

        .borrowed-book-info {
            flex: 1;
        }

        .borrowed-book-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .borrowed-book-author {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 0.75rem;
        }

        .borrowed-book-dates {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .borrowed-book-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .borrowed-book-date i {
            color: var(--primary);
        }

        .borrowed-book-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .extend-btn {
            background: var(--warning);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .extend-btn:hover {
            background: #e08900;
            transform: translateY(-1px);
        }

        /* ===== LOAN HISTORY MODAL ===== */
        .history-controls {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .filter-group,
        .search-group {
            flex: 1;
            position: relative;
        }

        .history-controls select,
        .history-controls input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .history-controls select:focus,
        .history-controls input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-group i {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        .loan-history-container {
            max-height: 60vh;
            overflow-y: auto;
        }

        .history-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.8);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .history-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.1);
        }

        .history-book-cover {
            width: 60px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .history-book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .history-book-cover i {
            font-size: 1.5rem;
            color: white;
        }

        .history-book-info {
            flex: 1;
        }

        .history-book-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .history-book-author {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 0.75rem;
        }

        .history-dates {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .history-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .history-date i {
            color: var(--primary);
        }

        .history-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .empty-state-modal {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-light);
        }

        .empty-state-modal i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .empty-state-modal h3 {
            font-size: 1.25rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.pending {
            background: rgba(251, 191, 36, 0.1);
            color: #f59e0b;
            border: 1px solid rgba(251, 191, 36, 0.2);
        }

        .status-badge.borrowed {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .status-badge.returned {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-badge.overdue {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .status-badge.rejected {
            background: rgba(107, 114, 128, 0.1);
            color: #6b7280;
            border: 1px solid rgba(107, 114, 128, 0.2);
        }

        .loading-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-light);
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid var(--border);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== NOTIFICATION SYSTEM ===== */
        .notification {
            position: fixed;
            top: 2rem;
            right: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 10000;
            animation: slideInNotification 0.3s ease-out;
            max-width: 400px;
            border-left: 4px solid var(--info);
        }

        .notification-success {
            border-left-color: var(--success);
        }

        .notification-error {
            border-left-color: var(--danger);
        }

        .notification-warning {
            border-left-color: var(--warning);
        }

        .notification-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }

        .notification-content i {
            font-size: 1.25rem;
        }

        .notification-success .notification-content i {
            color: var(--success);
        }

        .notification-error .notification-content i {
            color: var(--danger);
        }

        .notification-warning .notification-content i {
            color: var(--warning);
        }

        .notification-info .notification-content i {
            color: var(--info);
        }

        .notification-content span {
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .notification button {
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .notification button:hover {
            background: rgba(0, 0, 0, 0.1);
            color: var(--text-dark);
        }

        @keyframes slideInNotification {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
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

        /* ===== MODAL STYLES ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-container {
            background: white;
            border-radius: 20px;
            max-width: 90vw;
            max-height: 90vh;
            width: 600px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transform: translateY(-50px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-overlay.active .modal-container {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            padding: 2rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-content {
            padding: 2rem;
            max-height: 70vh;
            overflow-y: auto;
        }

        .request-form {
            display: grid;
            gap: 2rem;
        }

        .book-preview {
            display: flex;
            gap: 1.5rem;
            padding: 1.5rem;
            background: var(--light);
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .preview-cover {
            width: 100px;
            height: 150px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }

        .preview-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-info {
            flex: 1;
        }

        .preview-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .preview-author {
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .preview-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.75rem;
            font-size: 0.85rem;
        }

        .preview-detail {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-light);
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-group select,
        .form-group textarea {
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Duration Selector */
        .duration-selector {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

        .duration-btn {
            padding: 0.75rem 1rem;
            border: 2px solid var(--border);
            background: white;
            color: var(--text-dark);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            font-weight: 500;
            min-width: 70px;
            text-align: center;
        }

        .duration-btn:hover {
            border-color: var(--primary);
            background: rgba(102, 126, 234, 0.05);
            transform: translateY(-1px);
        }

        .duration-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        /* ===== ENHANCED LOAN MODAL ===== */
        .loan-modal-container {
            max-width: 800px;
            width: 95vw;
        }

        /* ===== TAB NAVIGATION ===== */
        .tab-navigation {
            display: flex;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border);
            background: var(--light);
            border-radius: 12px 12px 0 0;
            overflow: hidden;
        }

        .tab-btn {
            background: none;
            border: none;
            padding: 1rem 1.5rem;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-light);
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex: 1;
            text-align: center;
            justify-content: center;
        }

        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
            background: white;
        }

        .tab-btn:hover {
            color: var(--primary);
            background: rgba(102, 126, 234, 0.05);
        }

        .tab-content {
            display: none;
            margin-bottom: 1.5rem;
        }

        .tab-content.active {
            display: block;
        }

        /* ===== SECTION HEADERS ===== */
        .camera-section h4,
        .identity-section h4,
        .photo-section h4,
        .loan-details h4 {
            margin: 0 0 1rem 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border);
        }

        .section-description {
            margin: 0 0 1.5rem 0;
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
            color: var(--text-light);
            line-height: 1.5;
        }

        /* ===== VERIFICATION PANEL ===== */
        .verification-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem 2rem;
        }

        .verification-item label {
            display: block;
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 0.35rem;
        }

        .readonly-value {
            padding: 0.75rem 0.9rem;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-dark);
            min-height: 42px;
            display: flex;
            align-items: center;
        }

        /* ===== CAMERA SECTION ===== */
        .camera-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            margin: 0 auto 1rem;
            border-radius: 12px;
            overflow: hidden;
            background: #000;
        }

        #qrVideo {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .camera-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.3);
            color: white;
            text-align: center;
        }

        .scan-frame {
            width: 200px;
            height: 200px;
            border: 2px solid #fff;
            border-radius: 12px;
            position: relative;
            margin-bottom: 1rem;
            animation: scanPulse 2s ease-in-out infinite;
        }

        @keyframes scanPulse {
            0%, 100% { opacity: 0.7; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.02); }
        }

        .scan-frame::before,
        .scan-frame::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 3px solid var(--primary);
        }

        .scan-frame::before {
            top: -3px;
            left: -3px;
            border-right: none;
            border-bottom: none;
        }

        .scan-frame::after {
            bottom: -3px;
            right: -3px;
            border-left: none;
            border-top: none;
        }

        .camera-controls {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .scan-result {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .result-item label {
            font-weight: 600;
            color: var(--success);
            margin-bottom: 0.5rem;
            display: block;
        }

        #qrData {
            width: 100%;
            min-height: 60px;
            resize: vertical;
            background: white;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.5rem;
            font-family: monospace;
        }

        /* ===== FORM LAYOUTS ===== */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        /* ===== PHOTO SECTION ===== */
        .photo-capture {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .photo-preview {
            width: 120px;
            height: 120px;
            border: 2px dashed var(--border);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: var(--light);
            color: var(--text-light);
            text-align: center;
            overflow: hidden;
        }

        .photo-preview i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .photo-preview p {
            font-size: 0.8rem;
            margin: 0;
        }

        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .photo-controls {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        /* ===== PHOTO MODAL ===== */
        .photo-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            z-index: 10001;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo-modal-content {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            max-width: 500px;
            width: 90vw;
        }

        .photo-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .photo-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .photo-header button {
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: var(--text-light);
            padding: 0.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .photo-header button:hover {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .photo-camera {
            position: relative;
            margin-bottom: 1rem;
            border-radius: 12px;
            overflow: hidden;
            background: #000;
        }

        #photoVideo {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .photo-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .modal-container {
                width: 95vw;
                max-height: 95vh;
            }

            .modal-header {
                padding: 1.5rem;
            }

            .modal-content {
                padding: 1.5rem;
            }

            .book-preview {
                flex-direction: column;
                text-align: center;
            }

            .preview-cover {
                align-self: center;
            }

            .preview-details {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }
        }

    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        @include('components.sidebar', ['activeLoans' => isset($active_loans) ? $active_loans : collect()])

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
                    <div class="books-header">
                        <div>
                            <h2>Hasil Pencarian</h2>
                            <div class="books-meta">
                                @if(isset($books))
                                    Menampilkan {{ $books->firstItem() ?? 0 }}-{{ $books->lastItem() ?? 0 }} 
                                    dari {{ $books->total() }} buku
                                @else
                                    Menampilkan 0 buku
                                @endif
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

                    @if(isset($books) && $books->count() > 0)
                    <div class="books-grid" id="booksGrid">
                        @foreach($books as $index => $book)
                        <div class="book-card fade-in">
                            <div class="book-image">
                                @php
                                    $cover = $book->cover_image ?? null;
                                    $isUrl = $cover && (\Illuminate\Support\Str::startsWith($cover, ['http://', 'https://']));
                                    $src = $cover ? ($isUrl ? $cover : asset('storage/'.$cover)) : null;
                                @endphp
                                @if($src)
                                    <img src="{{ $src }}" alt="{{ $book->title }} cover" onerror="this.style.display='none'">
                                @else
                                    <i class="fas fa-book"></i>
                                @endif
                                <span class="book-status {{ $book->available > 0 ? 'available' : 'unavailable' }}">
                                    {{ $book->available > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </div>
                            <div class="book-content">
                                <div class="book-content-main">
                                    <span class="book-category">{{ $book->category->name ?? 'Umum' }}</span>
                                    <h3 class="book-title">{{ $book->title }}</h3>
                                    <p class="book-author">{{ $book->author }}</p>
                                    <div class="book-meta">
                                        <span><i class="fas fa-calendar"></i> {{ $book->publication_year ?? 'N/A' }}</span>
                                        <span><i class="fas fa-copy"></i> {{ $book->stock }} eksemplar</span>
                                        <span><i class="fas fa-check-circle"></i> {{ $book->available }} tersedia</span>
                                    </div>
                                </div>
                                <div class="book-content-footer">
                                    <!-- Book Rating -->
                                    @php
                                        $avgRating = $book->averageRating();
                                        $ratingCount = $book->ratingsCount();
                                    @endphp
                                    @if($ratingCount > 0)
                                    <div class="book-rating">
                                        <div class="book-rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= round($avgRating))
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="book-rating-text">{{ number_format($avgRating, 1) }} ({{ $ratingCount }})</span>
                                    </div>
                                    @endif
                                    
                                    <div class="book-actions">
                                        @if($book->available > 0)
                                        <button class="book-btn book-btn-primary" onclick="borrowBook({{ $book->id }})">
                                            <i class="fas fa-hand-holding"></i>
                                            Pinjam
                                        </button>
                                        @else
                                        <button class="book-btn book-btn-disabled" disabled>
                                            <i class="fas fa-clock"></i>
                                            Tidak Tersedia
                                        </button>
                                        @endif
                                        <button class="book-btn book-btn-secondary" onclick="viewDetails({{ $book->id }})">
                                            <i class="fas fa-info-circle"></i>
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @else
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <h3>Tidak Ada Buku Ditemukan</h3>
                        <p>Maaf, tidak ada buku yang sesuai dengan kriteria pencarian Anda. Coba ubah filter atau kata kunci pencarian.</p>
                        <button class="btn btn-primary" onclick="clearFilters()">
                            <i class="fas fa-refresh"></i>
                            Reset Pencarian
                        </button>
                    </div>
                    @endif

                    @if(isset($books) && $books instanceof \Illuminate\Pagination\LengthAwarePaginator && $books->hasPages())
                    <!-- Pagination Section -->
                    <div class="pagination-section">
                        <div class="pagination-wrapper">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($books->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $books->previousPageUrl() }}" rel="prev">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($books->getUrlRange(1, min(10, $books->lastPage())) as $page => $url)
                                        @if ($page == $books->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Show dots if there are more than 10 pages --}}
                                    @if($books->lastPage() > 10)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $books->url($books->lastPage()) }}">{{ $books->lastPage() }}</a>
                                        </li>
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if ($books->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $books->nextPageUrl() }}" rel="next">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                            
                            @if(isset($books) && $books->total() > 0)
                            <div class="pagination-info">
                                Halaman {{ $books->currentPage() }} dari {{ $books->lastPage() }} 
                                ({{ $books->total() }} total buku)
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Request Loan Modal -->
    <div class="modal-overlay" id="requestLoanModal">
        <div class="modal-container loan-modal-container">
            <div class="modal-header">
                <h2><i class="fas fa-hand-holding"></i> Ajukan Peminjaman Buku</h2>
                <button class="modal-close" onclick="closeRequestLoanModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <div class="request-form">
                    <div class="book-preview" id="bookPreview">
                        <!-- Book details will be loaded here -->
                    </div>
                    
                    <!-- Tab Navigation -->
                    <div class="tab-navigation">
                        <button class="tab-btn active" onclick="switchTab('qr-scan')" id="qr-tab-btn">
                            <i class="fas fa-qrcode"></i>
                            Scan QR Code
                        </button>
                        <button class="tab-btn" onclick="switchTab('manual-input')" id="manual-tab-btn">
                            <i class="fas fa-edit"></i>
                            Input Manual
                        </button>
                    </div>

                    <form id="loanRequestForm">
                        <!-- QR Scan Tab -->
                        <div id="qr-scan-tab" class="tab-content active">
                            <div class="camera-section">
                                <h4><i class="fas fa-camera"></i> Scan QR Code Identitas</h4>
                                <div class="camera-container">
                                    <video id="qrVideo" autoplay playsinline></video>
                                    <canvas id="qrCanvas" style="display: none;"></canvas>
                                    <div class="camera-overlay">
                                        <div class="scan-frame"></div>
                                        <p>Arahkan kamera ke QR Code pada kartu identitas</p>
                                    </div>
                                </div>
                                <div class="camera-controls">
                                    <button type="button" class="btn btn-primary" onclick="startQRScanner()">
                                        <i class="fas fa-camera"></i> Mulai Scan
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="stopQRScanner()">
                                        <i class="fas fa-stop"></i> Stop
                                    </button>
                                </div>
                                <div id="qrResult" class="scan-result" style="display: none;">
                                    <div class="result-item">
                                        <label>Data yang terdeteksi:</label>
                                        <textarea id="qrData" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Verification Section for QR Tab -->
                            <div class="identity-section">
                                <h4><i class="fas fa-shield-check"></i> Verifikasi Data dari QR</h4>
                                <p class="section-description">Setelah QR terbaca, data dari QR akan tampil di bawah untuk diverifikasi.</p>
                                <div class="verification-grid">
                                    <div class="verification-item">
                                        <label>Nama Lengkap</label>
                                        <div class="readonly-value" id="qrVerifyFullName">—</div>
                                    </div>
                                    <div class="verification-item">
                                        <label>Kelas</label>
                                        <div class="readonly-value" id="qrVerifyStudentClass">—</div>
                                    </div>
                                    <div class="verification-item">
                                        <label>Jurusan</label>
                                        <div class="readonly-value" id="qrVerifyMajor">—</div>
                                    </div>
                                    <div class="verification-item">
                                        <label>NISN</label>
                                        <div class="readonly-value" id="qrVerifyNisn">—</div>
                                    </div>
                                    <div class="verification-item">
                                        <label>NIS</label>
                                        <div class="readonly-value" id="qrVerifyNis">—</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Manual Input Tab -->
                        <div id="manual-input-tab" class="tab-content">
                            <div class="identity-section">
                                <h4><i class="fas fa-id-card"></i> Data Identitas</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="nisn">NISN (Nomor Induk Siswa Nasional)</label>
                                        <input type="text" id="nisn" name="nisn" placeholder="Masukkan NISN" maxlength="20">
                                    </div>
                                    <div class="form-group">
                                        <label for="nis">NIS (Nomor Induk Siswa)</label>
                                        <input type="text" id="nis" name="nis" placeholder="Masukkan NIS" maxlength="20">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="fullName">Nama Lengkap</label>
                                        <input type="text" id="fullName" name="full_name" placeholder="Masukkan nama lengkap" maxlength="100" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="studentClass">Kelas</label>
                                        <input type="text" id="studentClass" name="student_class" placeholder="Contoh: XII IPA 1" maxlength="20" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="major">Jurusan</label>
                                        <input type="text" id="major" name="major" placeholder="Contoh: IPA, IPS, Bahasa" maxlength="50" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Photo Capture Section (Common for both tabs) -->
                        <div class="photo-section">
                            <h4><i class="fas fa-camera-retro"></i> Foto Peminjam</h4>
                            <div class="photo-capture">
                                <div class="photo-preview" id="photoPreview">
                                    <i class="fas fa-user-circle"></i>
                                    <p>Belum ada foto</p>
                                </div>
                                <div class="photo-controls">
                                    <button type="button" class="btn btn-primary" onclick="startPhotoCapture()">
                                        <i class="fas fa-camera"></i> Ambil Foto
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="retakePhoto()" id="retakeBtn" style="display: none;">
                                        <i class="fas fa-redo"></i> Foto Ulang
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Camera Modal for Photo -->
                        <div id="photoModal" class="photo-modal" style="display: none;">
                            <div class="photo-modal-content">
                                <div class="photo-header">
                                    <h3>Ambil Foto Peminjam</h3>
                                    <button type="button" onclick="closePhotoModal()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="photo-camera">
                                    <video id="photoVideo" autoplay playsinline></video>
                                    <canvas id="photoCanvas" style="display: none;"></canvas>
                                </div>
                                <div class="photo-actions">
                                    <button type="button" class="btn btn-primary" onclick="capturePhoto()">
                                        <i class="fas fa-camera"></i> Ambil Foto
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="closePhotoModal()">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Loan Details -->
                        <div class="loan-details">
                            <h4><i class="fas fa-calendar-alt"></i> Detail Peminjaman</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="loanDuration">Durasi Peminjaman</label>
                                    <div class="duration-selector">
                                        <button type="button" class="duration-btn" data-days="1">1 Hari</button>
                                        <button type="button" class="duration-btn" data-days="2">2 Hari</button>
                                        <button type="button" class="duration-btn" data-days="3">3 Hari</button>
                                        <button type="button" class="duration-btn" data-days="4">4 Hari</button>
                                        <button type="button" class="duration-btn" data-days="5">5 Hari</button>
                                        <button type="button" class="duration-btn" data-days="6">6 Hari</button>
                                        <button type="button" class="duration-btn active" data-days="7">7 Hari</button>
                                    </div>
                                    <input type="hidden" id="loanDuration" name="loan_duration" value="7" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="loanNotes">Catatan (Opsional)</label>
                                <textarea id="loanNotes" name="notes" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="closeRequestLoanModal()">Batal</button>
                            <button type="submit" class="btn btn-primary" id="submitLoanBtn">
                                <i class="fas fa-paper-plane"></i>
                                Ajukan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Borrowed Books Modal -->
    <div class="modal-overlay" id="borrowedBooksModal">
        <div class="modal-container">
            <div class="modal-header">
                <h2><i class="fas fa-book-reader"></i> Buku yang Sedang Dipinjam</h2>
                <button class="modal-close" onclick="closeBorrowedBooksModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <div class="borrowed-books-container">
                    <div id="borrowedBooksList">
                        <!-- Borrowed books will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loan History Modal -->
    <div class="modal-overlay" id="loanHistoryModal">
        <div class="modal-container">
            <div class="modal-header">
                <h2><i class="fas fa-history"></i> Riwayat Peminjaman</h2>
                <button class="modal-close" onclick="closeLoanHistoryModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <div class="history-controls">
                    <div class="filter-group">
                        <select id="historyFilter" onchange="filterHistory()">
                            <option value="all">Semua Status</option>
                            <option value="pending">Menunggu Persetujuan</option>
                            <option value="borrowed">Sedang Dipinjam</option>
                            <option value="returned">Dikembalikan</option>
                            <option value="overdue">Terlambat</option>
                        </select>
                    </div>
                    <div class="search-group">
                        <input type="text" id="historySearch" placeholder="Cari buku..." onkeyup="searchHistory()">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                <div class="loan-history-container">
                    <div id="loanHistoryList">
                        <!-- Loan history will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ===== CAMERA AND QR SCANNER FUNCTIONALITY =====
        let qrCodeReader = null;
    let qrVideoStream = null;
    let qrDecodeControls = null; // ZXing decode controls to stop decoding
        let photoVideoStream = null;
        let currentCapturedPhoto = null;
    // Store last parsed QR values for submission
    let lastQrParsed = { fullName: null, studentClass: null, major: null, nisn: null, nis: null };

        // Initialize QR Code Reader
        function initializeQRReader() {
            if (typeof ZXing !== 'undefined') {
                qrCodeReader = new ZXing.BrowserQRCodeReader();
            }
        }

        // Tab Switching
        function switchTab(tabName) {
            // Remove active class from all tabs and contents
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            // Resolve the correct button ID (handle legacy IDs)
            let btnId = null;
            if (tabName === 'qr-scan') btnId = 'qr-tab-btn';
            if (tabName === 'manual-input') btnId = 'manual-tab-btn';

            // Prefer mapped ID; fallback to pattern-based ID if exists
            const btnEl = document.getElementById(btnId) || document.getElementById(tabName + '-tab-btn');
            const contentEl = document.getElementById(tabName + '-tab');

            if (btnEl) btnEl.classList.add('active');
            if (contentEl) contentEl.classList.add('active');

            // Stop any running cameras when switching tabs
            stopQRScanner();
        }

        // Start QR Scanner
    async function startQRScanner() {
            try {
        // Ensure any previous session is fully stopped
        stopQRScanner();
                const video = document.getElementById('qrVideo');
                
                if (!qrCodeReader) {
                    initializeQRReader();
                }

                if (!qrCodeReader) {
                    throw new Error('QR Code reader tidak tersedia');
                }

                // Request camera permission
                const constraints = {
                    video: {
                        facingMode: 'environment', // Use back camera if available
                        width: { ideal: 640 },
                        height: { ideal: 480 }
                    }
                };

                qrVideoStream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = qrVideoStream;

                // Start decoding and keep controls to stop later
                qrDecodeControls = qrCodeReader.decodeFromVideoDevice(undefined, video, (result, error) => {
                    if (result) {
                        handleQRScanResult(result.text);
                    }
                    if (error && !(error instanceof ZXing.NotFoundException)) {
                        console.error('QR Scan Error:', error);
                    }
                });

                showNotification('Kamera berhasil diaktifkan', 'success');
            } catch (error) {
                console.error('Camera Error:', error);
                showNotification('Gagal mengakses kamera: ' + error.message, 'error');
            }
        }

        // Stop QR Scanner
        function stopQRScanner() {
            if (qrVideoStream) {
                qrVideoStream.getTracks().forEach(track => track.stop());
                qrVideoStream = null;
            }
            
            if (qrCodeReader) {
                try { qrCodeReader.reset(); } catch (e) { /* ignore */ }
            }

            if (qrDecodeControls && typeof qrDecodeControls.stop === 'function') {
                try { qrDecodeControls.stop(); } catch (e) { /* ignore */ }
                qrDecodeControls = null;
            }

            const video = document.getElementById('qrVideo');
            if (video) {
                video.srcObject = null;
            }
        }

        // Handle QR Scan Result
        function handleQRScanResult(data) {
            document.getElementById('qrData').value = data;
            document.getElementById('qrResult').style.display = 'block';
            
            // Try to parse the QR data if it's structured
            try {
                const parsed = JSON.parse(data);
                // Map common keys
                lastQrParsed.fullName = parsed.fullName || parsed.nama || parsed.name || null;
                lastQrParsed.studentClass = parsed.studentClass || parsed.kelas || null;
                lastQrParsed.major = parsed.major || parsed.jurusan || null;
                lastQrParsed.nisn = parsed.nisn || null;
                lastQrParsed.nis = parsed.nis || null;

                // Update verification panel
                const setText = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val || '—'; };
                setText('qrVerifyFullName', lastQrParsed.fullName);
                setText('qrVerifyStudentClass', lastQrParsed.studentClass);
                setText('qrVerifyMajor', lastQrParsed.major);
                setText('qrVerifyNisn', lastQrParsed.nisn);
                setText('qrVerifyNis', lastQrParsed.nis);

                showNotification('Data QR berhasil dipindai', 'success');
            } catch (e) {
                showNotification('Data QR berhasil dipindai', 'success');
            }
            
            stopQRScanner();
        }

        // Start Photo Capture
        async function startPhotoCapture() {
            try {
                document.getElementById('photoModal').style.display = 'flex';
                
                const video = document.getElementById('photoVideo');
                const constraints = {
                    video: {
                        facingMode: 'user', // Use front camera for selfie
                        width: { ideal: 640 },
                        height: { ideal: 480 }
                    }
                };

                photoVideoStream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = photoVideoStream;

                showNotification('Kamera foto berhasil diaktifkan', 'success');
            } catch (error) {
                console.error('Photo Camera Error:', error);
                showNotification('Gagal mengakses kamera: ' + error.message, 'error');
                closePhotoModal();
            }
        }

        // Capture Photo
        function capturePhoto() {
            const video = document.getElementById('photoVideo');
            const canvas = document.getElementById('photoCanvas');
            const ctx = canvas.getContext('2d');

            // Set canvas dimensions
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Draw video frame to canvas
            ctx.drawImage(video, 0, 0);

            // Convert to base64
            currentCapturedPhoto = canvas.toDataURL('image/jpeg', 0.8);

            // Update preview
            const preview = document.getElementById('photoPreview');
            preview.innerHTML = `<img src="${currentCapturedPhoto}" alt="Captured Photo">`;

            // Show retake button
            document.getElementById('retakeBtn').style.display = 'inline-block';

            closePhotoModal();
            showNotification('Foto berhasil diambil', 'success');
        }

        // Retake Photo
        function retakePhoto() {
            currentCapturedPhoto = null;
            document.getElementById('photoPreview').innerHTML = `
                <i class="fas fa-user-circle"></i>
                <p>Belum ada foto</p>
            `;
            document.getElementById('retakeBtn').style.display = 'none';
            startPhotoCapture();
        }

        // Close Photo Modal
        function closePhotoModal() {
            document.getElementById('photoModal').style.display = 'none';
            
            if (photoVideoStream) {
                photoVideoStream.getTracks().forEach(track => track.stop());
                photoVideoStream = null;
            }

            const video = document.getElementById('photoVideo');
            if (video) {
                video.srcObject = null;
            }
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeQRReader();
            initializeDurationButtons();
        });

        // Duration Button Functionality
        function initializeDurationButtons() {
            const durationButtons = document.querySelectorAll('.duration-btn');
            const hiddenInput = document.getElementById('loanDuration');

            durationButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    durationButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Update hidden input value
                    const days = this.getAttribute('data-days');
                    hiddenInput.value = days;
                    
                    console.log('Duration selected:', days, 'days');
                });
            });
        }

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
                            window.location.href = '{{ route("books.browse") }}?search=' + encodeURIComponent(searchTerm);
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
            
            const url = `{{ route('books.browse') }}${params.toString() ? '?' + params.toString() : ''}`;
            
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
                window.location.href = '{{ route('books.browse') }}';
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
            
            // Check if user is authenticated
            @guest
                showNotification('Silakan login terlebih dahulu untuk meminjam buku', 'warning');
                return;
            @endguest
            
            // Open request loan modal with book details
            requestBookLoan(bookId);
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
                    const baseUrl = '{{ url("/books") }}';
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

        // ===== LOAN REQUEST FUNCTIONS =====
        
        // Request Book Loan
        function requestBookLoan(bookId) {
            // Fetch book details first
            fetch(`/api/books/${bookId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const book = data.book;
                    const modal = document.getElementById('requestLoanModal');
                    const bookPreview = document.getElementById('bookPreview');
                    
                    // Populate book preview
                    bookPreview.innerHTML = `
                        <div class="preview-cover">
                            ${book.cover_image ? 
                                `<img src="${book.cover_image.startsWith('http') ? book.cover_image : '/storage/' + book.cover_image}" alt="${book.title}">` : 
                                '<i class="fas fa-book"></i>'
                            }
                        </div>
                        <div class="preview-info">
                            <h3 class="preview-title">${book.title}</h3>
                            <p class="preview-author">oleh ${book.author}</p>
                            <div class="preview-details">
                                <div class="preview-detail">
                                    <i class="fas fa-tag"></i>
                                    <span>${book.category?.name || 'Umum'}</span>
                                </div>
                                <div class="preview-detail">
                                    <i class="fas fa-calendar"></i>
                                    <span>${book.publication_year || 'N/A'}</span>
                                </div>
                                <div class="preview-detail">
                                    <i class="fas fa-copy"></i>
                                    <span>${book.available} tersedia</span>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Store book ID for form submission
                    document.getElementById('loanRequestForm').dataset.bookId = bookId;
                    
                    // Show modal
                    modal.classList.add('active');
                } else {
                    showNotification('Gagal memuat detail buku', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Gagal memuat detail buku', 'error');
            });
        }

        // Close Request Loan Modal (defined later with reset)

        // Submit Loan Request
        if (document.getElementById('loanRequestForm')) {
            document.getElementById('loanRequestForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                console.log('Form submission started');
                
                const bookId = this.dataset.bookId;
                const loanDuration = document.getElementById('loanDuration').value;
                const notes = document.getElementById('loanNotes').value;
                
                // Get identification method and data (robust to missing active button)
                let identificationMethod = 'manual_input';
                const activeBtn = document.querySelector('.tab-btn.active');
                if (activeBtn) {
                    identificationMethod = activeBtn.id === 'qr-tab-btn' ? 'qr_scan' : 'manual_input';
                } else {
                    // Fallback: check which tab content is visible
                    const qrTabActive = document.getElementById('qr-scan-tab')?.classList.contains('active');
                    identificationMethod = qrTabActive ? 'qr_scan' : 'manual_input';
                }
                
                // Collect form data based on active tab
                let nisn = null;
                let nis = null;
                let fullName = null;
                let studentClass = null;
                let major = null;
                let qrData = null;

                if (identificationMethod === 'qr_scan') {
                    qrData = document.getElementById('qrData').value;
                    // Use parsed values from QR only (no manual inputs on QR tab)
                    fullName = lastQrParsed.fullName;
                    studentClass = lastQrParsed.studentClass;
                    major = lastQrParsed.major;
                    nisn = lastQrParsed.nisn;
                    nis = lastQrParsed.nis;
                } else {
                    fullName = document.getElementById('fullName').value || null;
                    studentClass = document.getElementById('studentClass').value || null;
                    major = document.getElementById('major').value || null;
                    nisn = document.getElementById('nisn').value || null;
                    nis = document.getElementById('nis').value || null;
                }

                // Validation
                if (identificationMethod === 'qr_scan' && !qrData) {
                    showNotification('Silakan scan QR code terlebih dahulu', 'warning');
                    return;
                }
                if (!fullName) {
                    showNotification('Nama lengkap harus diisi', 'warning');
                    return;
                }

                if (!studentClass) {
                    showNotification('Kelas harus diisi', 'warning');
                    return;
                }

                if (!major) {
                    showNotification('Jurusan harus diisi', 'warning');
                    return;
                }

                if (!currentCapturedPhoto) {
                    showNotification('Silakan ambil foto peminjam terlebih dahulu', 'warning');
                    return;
                }
                
                const formData = {
                    book_id: bookId,
                    loan_duration: loanDuration,
                    notes: notes,
                    full_name: fullName,
                    student_class: studentClass,
                    major: major,
                    nisn: nisn,
                    nis: nis,
                    borrower_photo: currentCapturedPhoto,
                    qr_data: qrData,
                    identification_method: identificationMethod
                };
                
                console.log('Form data:', formData);
                
                // Show loading
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
                submitBtn.disabled = true;
                
                // Submit request
                fetch('/api/request-loan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        showNotification(data.message, 'success');
                        closeRequestLoanModal();
                        // Reset form and clear photo
                        this.reset();
                        resetLoanForm();
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });
        }

        // Reset Loan Form
        function resetLoanForm() {
            // Reset photo
            currentCapturedPhoto = null;
            document.getElementById('photoPreview').innerHTML = `
                <i class="fas fa-user-circle"></i>
                <p>Belum ada foto</p>
            `;
            document.getElementById('retakeBtn').style.display = 'none';
            
            // Reset QR result
            document.getElementById('qrResult').style.display = 'none';
            document.getElementById('qrData').value = '';
            // Clear verification panel and stored parsed values
            lastQrParsed = { fullName: null, studentClass: null, major: null, nisn: null, nis: null };
            ['qrVerifyFullName','qrVerifyStudentClass','qrVerifyMajor','qrVerifyNisn','qrVerifyNis']
                .forEach(id => { const el = document.getElementById(id); if (el) el.textContent = '—'; });
            
            // Reset form fields - Manual tab
            document.getElementById('fullName').value = '';
            document.getElementById('studentClass').value = '';
            document.getElementById('major').value = '';
            document.getElementById('nisn').value = '';
            document.getElementById('nis').value = '';
            
            // Reset duration to default (7 days)
            document.querySelectorAll('.duration-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector('.duration-btn[data-days="7"]').classList.add('active');
            document.getElementById('loanDuration').value = '7';
            
            // Reset notes
            document.getElementById('loanNotes').value = '';
            
            // Reset to first tab
            switchTab('qr-scan');
            
            // Stop any running cameras
            stopQRScanner();
            closePhotoModal();
        }

        // Enhanced close modal function
        function closeRequestLoanModal() {
            document.getElementById('requestLoanModal').classList.remove('active');
            resetLoanForm();
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
            }
        });

        // ===== BORROWED BOOKS MODAL FUNCTIONS =====
        
        // Show Borrowed Books Modal
        function showBorrowedBooks() {
            const modal = document.getElementById('borrowedBooksModal');
            const booksList = document.getElementById('borrowedBooksList');
            
            // Show modal
            modal.classList.add('active');
            
            // Show loading
            booksList.innerHTML = `
                <div class="loading-state">
                    <div class="loading-spinner"></div>
                    <p>Memuat buku yang sedang dipinjam...</p>
                </div>
            `;
            
            // Fetch borrowed books
            fetch('/api/borrowed-books', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.borrowed_books.length === 0) {
                        booksList.innerHTML = `
                            <div class="empty-state-modal">
                                <i class="fas fa-book-open"></i>
                                <h3>Tidak Ada Buku yang Sedang Dipinjam</h3>
                                <p>Mulai jelajahi koleksi kami dan pinjam buku favorit Anda!</p>
                            </div>
                        `;
                    } else {
                        booksList.innerHTML = data.borrowed_books.map(book => `
                            <div class="borrowed-book-item">
                                <div class="borrowed-book-cover">
                                    ${book.book.cover_image ? 
                                        `<img src="${book.book.cover_image.startsWith('http') ? book.book.cover_image : '/storage/' + book.book.cover_image}" alt="${book.book.title}">` : 
                                        '<i class="fas fa-book"></i>'
                                    }
                                </div>
                                <div class="borrowed-book-info">
                                    <h3 class="borrowed-book-title">${book.book.title}</h3>
                                    <p class="borrowed-book-author">oleh ${book.book.author}</p>
                                    <div class="borrowed-book-dates">
                                        <div class="borrowed-book-date">
                                            <i class="fas fa-calendar-alt"></i>
                                            Dipinjam: ${book.loan_date}
                                        </div>
                                        <div class="borrowed-book-date">
                                            <i class="fas fa-calendar-check"></i>
                                            Jatuh Tempo: ${book.due_date}
                                        </div>
                                    </div>
                                    <div class="borrowed-book-status">
                                        <span class="status-badge ${book.status}">${formatStatusText(book.status_text)}</span>
                                        ${book.can_extend ? 
                                            `<button class="extend-btn" onclick="extendLoan(${book.id})">
                                                <i class="fas fa-clock"></i> Perpanjang
                                            </button>` : ''
                                        }
                                    </div>
                                </div>
                            </div>
                        `).join('');
                    }
                } else {
                    booksList.innerHTML = `
                        <div class="empty-state-modal">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h3>Gagal Memuat Data</h3>
                            <p>${data.message || 'Terjadi kesalahan saat memuat data.'}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                booksList.innerHTML = `
                    <div class="empty-state-modal">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>Gagal Memuat Data</h3>
                        <p>Terjadi kesalahan saat memuat data. Silakan coba lagi.</p>
                    </div>
                `;
            });
        }

        // Close Borrowed Books Modal
        function closeBorrowedBooksModal() {
            document.getElementById('borrowedBooksModal').classList.remove('active');
        }

        // Format status text to remove decimals near 'hari'
        // - 'Terlambat 7.2057 hari' -> 'Terlambat 7 hari' (floor)
        // - '2.9 hari lagi' -> '3 hari lagi' (ceil)
        function formatStatusText(text) {
            if (!text || typeof text !== 'string') return text;
            const lower = text.toLowerCase();
            const rounder = lower.includes('terlambat')
                ? Math.floor
                : Math.ceil; // default to ceil for remaining days text
            // Replace the number immediately before the word 'hari'
            return text.replace(/(\d+[.,]\d+|\d+)(?=\s*hari)/gi, (m) => {
                const n = Number(m.replace(',', '.'));
                if (Number.isNaN(n)) return m;
                return String(rounder(n));
            });
        }

        // ===== LOAN HISTORY MODAL FUNCTIONS =====
        
        // Show Loan History Modal
        function showLoanHistory() {
            const modal = document.getElementById('loanHistoryModal');
            const historyList = document.getElementById('loanHistoryList');
            
            // Show modal
            modal.classList.add('active');
            
            // Load history
            loadLoanHistory();
        }

        // Close Loan History Modal
        function closeLoanHistoryModal() {
            document.getElementById('loanHistoryModal').classList.remove('active');
        }

        // Load Loan History
        function loadLoanHistory(status = 'all', search = '') {
            const historyList = document.getElementById('loanHistoryList');
            
            // Show loading
            historyList.innerHTML = `
                <div class="loading-state">
                    <div class="loading-spinner"></div>
                    <p>Memuat riwayat peminjaman...</p>
                </div>
            `;
            
            // Build query parameters
            const params = new URLSearchParams();
            if (status !== 'all') params.append('status', status);
            if (search) params.append('search', search);
            
            // Fetch loan history
            fetch('/api/loan-history?' + params.toString(), {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.loan_history.length === 0) {
                        historyList.innerHTML = `
                            <div class="empty-state-modal">
                                <i class="fas fa-history"></i>
                                <h3>Tidak Ada Riwayat Peminjaman</h3>
                                <p>Belum ada riwayat peminjaman yang sesuai dengan filter.</p>
                            </div>
                        `;
                    } else {
                        historyList.innerHTML = data.loan_history.map(history => `
                            <div class="history-item">
                                <div class="history-book-cover">
                                    ${history.book.cover_image ? 
                                        `<img src="${history.book.cover_image.startsWith('http') ? history.book.cover_image : '/storage/' + history.book.cover_image}" alt="${history.book.title}">` : 
                                        '<i class="fas fa-book"></i>'
                                    }
                                </div>
                                <div class="history-book-info">
                                    <h3 class="history-book-title">${history.book.title}</h3>
                                    <p class="history-book-author">oleh ${history.book.author}</p>
                                    <div class="history-dates">
                                        ${history.request_date ? `
                                            <div class="history-date">
                                                <i class="fas fa-paper-plane"></i>
                                                Diajukan: ${history.request_date}
                                            </div>
                                        ` : ''}
                                        ${history.loan_date ? `
                                            <div class="history-date">
                                                <i class="fas fa-calendar-alt"></i>
                                                Dipinjam: ${history.loan_date}
                                            </div>
                                        ` : ''}
                                        ${history.return_date ? `
                                            <div class="history-date">
                                                <i class="fas fa-calendar-check"></i>
                                                Dikembalikan: ${history.return_date}
                                            </div>
                                        ` : ''}
                                    </div>
                                    <div class="history-status">
                                        <span class="status-badge ${history.status}">${formatStatusText(history.status_text)}</span>
                                        <span style="font-size: 0.8rem; color: var(--text-light);">${history.duration}</span>
                                    </div>
                                </div>
                            </div>
                        `).join('');
                    }
                } else {
                    historyList.innerHTML = `
                        <div class="empty-state-modal">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h3>Gagal Memuat Data</h3>
                            <p>${data.message || 'Terjadi kesalahan saat memuat data.'}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                historyList.innerHTML = `
                    <div class="empty-state-modal">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>Gagal Memuat Data</h3>
                        <p>Terjadi kesalahan saat memuat data. Silakan coba lagi.</p>
                    </div>
                `;
            });
        }

        // Filter History
        function filterHistory() {
            const status = document.getElementById('historyFilter').value;
            const search = document.getElementById('historySearch').value;
            loadLoanHistory(status, search);
        }

        // Search History
        function searchHistory() {
            const status = document.getElementById('historyFilter').value;
            const search = document.getElementById('historySearch').value;
            loadLoanHistory(status, search);
        }

        // Extend Loan
        function extendLoan(loanId) {
            if (!confirm('Apakah Anda yakin ingin memperpanjang peminjaman buku ini selama 7 hari?')) {
                return;
            }
            
            fetch(`/api/extend-loan/${loanId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    // Refresh borrowed books list
                    showBorrowedBooks();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
            });
        }

        // Notification System
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.notification');
            existingNotifications.forEach(notification => notification.remove());
            
            // Create notification
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas fa-${getNotificationIcon(type)}"></i>
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            // Add to page
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        function getNotificationIcon(type) {
            const icons = {
                success: 'check-circle',
                error: 'exclamation-circle',
                warning: 'exclamation-triangle',
                info: 'info-circle'
            };
            return icons[type] || 'info-circle';
        }

        // Make functions globally available
        window.requestBookLoan = requestBookLoan;
        window.closeRequestLoanModal = closeRequestLoanModal;
        window.showBorrowedBooks = showBorrowedBooks;
        window.closeBorrowedBooksModal = closeBorrowedBooksModal;
        window.showLoanHistory = showLoanHistory;
        window.closeLoanHistoryModal = closeLoanHistoryModal;
        window.filterHistory = filterHistory;
        window.searchHistory = searchHistory;
        window.extendLoan = extendLoan;
        
        // View Book Details
        window.viewDetails = function(bookId) {
            window.location.href = '/books/' + bookId;
        };

        // If navigated with ?loan=BOOK_ID, open the loan modal automatically
        (function autoOpenLoanFromQuery() {
            try {
                const url = new URL(window.location.href);
                const loanParam = url.searchParams.get('loan');
                if (loanParam) {
                    const bookId = parseInt(loanParam, 10);
                    if (!isNaN(bookId)) {
                        requestBookLoan(bookId);
                        // Clean the query param without reload
                        url.searchParams.delete('loan');
                        window.history.replaceState({}, '', url.pathname + (url.searchParams.toString() ? '?' + url.searchParams.toString() : ''));
                    }
                }
            } catch (_) { /* noop */ }
        })();
    </script>
</body>
</html>