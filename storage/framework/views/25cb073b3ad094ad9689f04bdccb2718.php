<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota - SisPerpus</title>
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

        html {
            scroll-behavior: smooth;
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
        /* Ensure cover images fill the card nicely */
        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
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


        .loan-book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            display: block;
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
            overflow-x: hidden;
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
            position: relative;
            z-index: 5;
            background: rgba(207, 232, 240, 0.13);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            margin: 2rem auto;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        /* ===== HERO SECTION ===== */
        .hero-section {
            background: linear-gradient(135deg, rgba(181, 228, 255, 0.438), rgba(187, 188, 189, 0.26)), url('<?php echo e(asset('Gambar/background.jpg')); ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* Use flexible height so inner content never overflows into next section */
            min-height: 420px;
            padding: 2rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            margin: 0;
            margin-bottom: 2rem;
            overflow: hidden;
            z-index: 1;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
            z-index: 1;
        }

        /* Ensure no residual transforms push the hero into header/content */
        .hero-section { transform: translate3d(0, 0, 0); will-change: auto; }

        @keyframes shimmer {
            0% { transform: translateX(-100%) skewX(-15deg); }
            100% { transform: translateX(200%) skewX(-15deg); }
        }

        .hero-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 2;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: float 6s infinite ease-in-out;
        }

        .particle:nth-child(1) { width: 4px; height: 4px; left: 10%; animation-delay: -0.5s; }
        .particle:nth-child(2) { width: 6px; height: 6px; left: 20%; animation-delay: -1s; }
        .particle:nth-child(3) { width: 3px; height: 3px; left: 30%; animation-delay: -1.5s; }
        .particle:nth-child(4) { width: 5px; height: 5px; left: 40%; animation-delay: -2s; }
        .particle:nth-child(5) { width: 4px; height: 4px; left: 50%; animation-delay: -2.5s; }
        .particle:nth-child(6) { width: 6px; height: 6px; left: 60%; animation-delay: -3s; }
        .particle:nth-child(7) { width: 3px; height: 3px; left: 70%; animation-delay: -3.5s; }
        .particle:nth-child(8) { width: 5px; height: 5px; left: 80%; animation-delay: -4s; }
        .particle:nth-child(9) { width: 4px; height: 4px; left: 90%; animation-delay: -4.5s; }

        @keyframes float {
            0%, 100% { 
                transform: translateY(100%) rotate(0deg); 
                opacity: 0; 
            }
            10%, 90% { 
                opacity: 1; 
            }
            50% { 
                transform: translateY(-20px) rotate(180deg); 
                opacity: 1; 
            }
        }

        .hero-content {
            max-width: 900px;
            padding: 1rem 2rem 2.5rem; /* add bottom padding so content doesn't visually collide */
            z-index: 10;
            position: relative;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            color: #0f172a;
            text-shadow: 0 2px 12px rgba(255, 255, 255, 0.9);
            animation: heroTitle 1.5s ease-out;
            position: relative;
            font-family: 'Poppins', sans-serif;
            --cursor-display: none;
        }

        .hero-title::after {
            content: '|';
            color: #0f172a;
            animation: blink 1s infinite;
            font-weight: 100;
            display: var(--cursor-display, none);
        }

        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }


        @keyframes underlineExpand {
            from { width: 0; }
            to { width: 100px; }
        }

        .hero-subtitle {
            font-size: 1.3rem;
            font-weight: 400;
            margin-bottom: 2.5rem;
            color: rgb(0, 0, 0);
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
            opacity: 0.95;
            animation: heroSubtitle 1.5s ease-out 0.3s both;
            line-height: 1.6;
            position: relative;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
            animation: heroStats 1.5s ease-out 0.6s both;
        }

        .hero-stat {
            text-align: center;
            background: rgb(143, 179, 255);
            padding: 1rem 1.5rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-stat-number {
            font-size: 2rem;
            font-weight: 800;
            display: block;
            margin-bottom: 0.3rem;
        }

        .hero-stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .hero-cta {
            display: inline-flex;
            gap: 1.5rem;
            animation: heroCta 1.5s ease-out 0.9s both;
        }

        .hero-btn {
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1.1rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            position: relative;
            overflow: hidden;
        }

        .hero-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .hero-btn:hover::before {
            left: 100%;
        }

        .hero-btn.primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .hero-btn.primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }

        .hero-btn.secondary {
            background: rgba(255, 255, 255, 0.897);
            color: rgb(0, 0, 0);
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(15px);
        }

        .hero-btn.secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, 0.5);
        }

        @keyframes heroTitle {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes heroSubtitle {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 0.95;
                transform: translateY(0);
            }
        }

        @keyframes heroStats {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes heroCta {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            z-index: 10;
            animation: slideInFromTop 0.8s ease-out;
        }

        @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .welcome-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .welcome-text {
            flex: 1;
            min-width: 300px;
        }

        .welcome-text h1 {
            font-size: 2.5rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .welcome-text p {
            color: #64748b;
            font-size: 1.1rem;
            font-weight: 500;
            line-height: 1.6;
        }

        .widgets-container {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .widget {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(102, 126, 234, 0.2);
            min-width: 180px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .widget:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        .clock-widget {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
        }

        .clock-time {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            font-family: 'Courier New', monospace;
        }

        .clock-date {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .weather-widget {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
            border: none;
        }

        .weather-temp {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .weather-desc {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .progress-widget {
            background: linear-gradient(135deg, #fa709a, #fee140);
            color: white;
            border: none;
        }

        .progress-title {
            font-size: 0.9rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .progress-fill {
            height: 100%;
            background: white;
            border-radius: 4px;
            transition: width 2s ease;
            animation: progressFill 2s ease-out;
        }

        @keyframes progressFill {
            from { width: 0%; }
        }

        .progress-text {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .widgets-container {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .widget {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(102, 126, 234, 0.2);
            min-width: 180px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .widget:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        .clock-widget {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
        }

        .clock-time {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            font-family: 'Courier New', monospace;
        }

        .clock-date {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .weather-widget {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
            border: none;
        }

        .weather-temp {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .weather-desc {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .progress-widget {
            background: linear-gradient(135deg, #fa709a, #fee140);
            color: white;
            border: none;
        }

        .progress-title {
            font-size: 0.9rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .progress-fill {
            height: 100%;
            background: white;
            border-radius: 4px;
            transition: width 2s ease;
            animation: progressFill 2s ease-out;
        }

        @keyframes progressFill {
            from { width: 0%; }
        }

        .progress-text {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        /* ===== STATS CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            text-align: center;
            position: relative;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            animation: slideUp 0.6s ease-out both;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
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
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--card-color), var(--card-color-light));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 10px;
            right: 10px;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, var(--card-color-light) 0%, transparent 70%);
            opacity: 0.1;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 
                0 20px 50px rgba(0, 0, 0, 0.12),
                0 0 30px rgba(102, 126, 234, 0.15);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-card:hover::after {
            opacity: 0.2;
            transform: scale(1.2);
        }
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 1.5rem;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stat-icon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.4s ease;
        }

        .stat-card:hover .stat-icon::before {
            width: 100px;
            height: 100px;
        }

        .stat-card.primary {
            --card-color: #667eea;
            --card-color-light: #764ba2;
        }

        .stat-card.primary .stat-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .stat-card.success {
            --card-color: #10b981;
            --card-color-light: #34d399;
        }

        .stat-card.success .stat-icon {
            background: linear-gradient(135deg, #10b981, #34d399);
        }

        .stat-card.warning {
            --card-color: #f59e0b;
            --card-color-light: #fbbf24;
        }

        .stat-card.warning .stat-icon {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }

        .stat-card.info {
            --card-color: #3b82f6;
            --card-color-light: #60a5fa;
        }

        .stat-card.info .stat-icon {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
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
            padding: 1rem 0;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .view-all-btn {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .view-all-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
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
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            gap: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .loan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #667eea, #764ba2);
            transition: all 0.3s ease;
        }

        .loan-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.12),
                0 0 30px rgba(102, 126, 234, 0.1);
        }

        .loan-card:hover::before {
            width: 6px;
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
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
        }

        .empty-state::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .empty-state i {
            font-size: 4rem;
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.75rem;
            font-family: 'Poppins', sans-serif;
        }

        .empty-state p {
            color: #64748b;
            margin-bottom: 2rem;
            font-size: 1.05rem;
            line-height: 1.6;
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
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
        }

        .book-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .book-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 40px rgba(102, 126, 234, 0.15);
        }

        .book-card:hover::before {
            opacity: 1;
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
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .action-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.12),
                0 0 30px rgba(102, 126, 234, 0.1);
            text-decoration: none;
            color: inherit;
        }

        .action-card:hover::before {
            left: 100%;
        }

        .action-card i {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 4px 8px rgba(102, 126, 234, 0.3));
            transition: all 0.3s ease;
        }

        .action-card:hover i {
            transform: scale(1.1);
        }

        .action-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #1e293b;
            font-family: 'Poppins', sans-serif;
        }

        .action-card p {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.5;
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

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .hero-section {
                min-height: 360px;
                padding: 1.5rem 0;
            }

            .hero-stats {
                flex-direction: column;
                gap: 1rem;
            }

            .hero-stat {
                padding: 0.8rem 1.2rem;
            }

            .widgets-container {
                justify-content: center;
            }

            .welcome-header {
                flex-direction: column;
                text-align: center;
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
                padding: 1.5rem 1rem 1rem;
            }

            .welcome-section h1 {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .loans-grid {
                grid-template-columns: 1fr;
            }

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 1rem;
            }

            .hero-section {
                min-height: 320px;
                padding: 1.25rem 0;
                background-attachment: scroll;
            }

            .hero-title {
                font-size: 2rem;
                margin-bottom: 0.8rem;
            }

            .hero-subtitle {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }

            .hero-stats {
                flex-direction: column;
                gap: 0.8rem;
                margin-bottom: 1.5rem;
            }

            .hero-stat {
                padding: 0.8rem 1rem;
                min-width: auto;
            }

            .hero-stat-number {
                font-size: 1.5rem;
            }

            .hero-stat-label {
                font-size: 0.8rem;
            }

            .hero-cta {
                flex-direction: column;
                align-items: center;
                gap: 0.8rem;
            }

            .hero-btn {
                padding: 0.8rem 1.5rem;
                font-size: 0.9rem;
                min-width: 200px;
                justify-content: center;
            }

            .widgets-container {
                flex-direction: column;
                gap: 1rem;
                width: 100%;
            }

            .widget {
                min-width: auto;
                width: 100%;
            }

            .clock-time {
                font-size: 1.5rem;
            }

            .weather-temp {
                font-size: 1.3rem;
            }

            .welcome-section {
                padding: 1.5rem;
            }

            .stat-card {
                padding: 1.5rem 1rem;
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }

            .stat-value {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero-section {
                min-height: 300px;
                padding: 1rem 0 1.25rem;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .hero-subtitle {
                font-size: 0.9rem;
                margin-bottom: 1rem;
            }

            .hero-stats {
                gap: 0.5rem;
                margin-bottom: 1rem;
            }

            .hero-stat {
                padding: 0.6rem 0.8rem;
            }

            .hero-stat-number {
                font-size: 1.2rem;
            }

            .hero-btn {
                padding: 0.7rem 1.2rem;
                font-size: 0.85rem;
                min-width: 180px;
            }

            .welcome-section {
                padding: 1rem;
            }

            .content-area {
                padding: 1.5rem 1rem 1rem;
            }

            .widget {
                padding: 1rem;
            }

            .clock-time {
                font-size: 1.3rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            }

            .stat-card {
                padding: 1rem 0.8rem;
            }

            .stat-value {
                font-size: 1.8rem;
            }
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
            width: 800px;
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

        /* ===== BORROWED BOOKS STYLES ===== */
        .borrowed-books-list {
            display: grid;
            gap: 1.5rem;
        }

        .borrowed-book-item {
            display: flex;
            gap: 1.5rem;
            padding: 1.5rem;
            background: var(--light);
            border-radius: 15px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .borrowed-book-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .borrowed-book-cover {
            width: 80px;
            height: 120px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .borrowed-book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .borrowed-book-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .borrowed-book-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .borrowed-book-author {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .borrowed-book-dates {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }

        .borrowed-book-date {
            font-size: 0.8rem;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .borrowed-book-status {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-badge.borrowed {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .status-badge.overdue {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .status-badge.due-soon {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .extend-btn {
            background: var(--success);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .extend-btn:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        /* ===== HISTORY STYLES ===== */
        .history-filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1rem;
            background: var(--light);
            border-radius: 12px;
        }

        .history-filters select,
        .history-filters input {
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .history-filters select:focus,
        .history-filters input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .history-filters input {
            flex: 1;
        }

        .loan-history-list {
            display: grid;
            gap: 1rem;
        }

        .history-item {
            display: flex;
            gap: 1rem;
            padding: 1.5rem;
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .history-item:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .history-book-cover {
            width: 60px;
            height: 90px;
            border-radius: 6px;
            overflow: hidden;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .history-book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .history-book-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .history-book-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .history-book-author {
            color: var(--text-light);
            font-size: 0.85rem;
        }

        .history-dates {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .history-date {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .history-status {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ===== REQUEST FORM STYLES ===== */
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

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        /* ===== RESPONSIVE MODAL ===== */
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

            .borrowed-book-item,
            .history-item {
                flex-direction: column;
                text-align: center;
            }

            .borrowed-book-cover,
            .history-book-cover {
                align-self: center;
            }

            .book-preview {
                flex-direction: column;
                text-align: center;
            }

            .preview-cover {
                align-self: center;
            }

            .history-filters {
                flex-direction: column;
            }

            .preview-details {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }
        }

        /* ===== EMPTY STATE ===== */
        .empty-state-modal {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-light);
        }

        .empty-state-modal i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state-modal h3 {
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        /* ===== LOADING STATE ===== */
        .loading-state {
            text-align: center;
            padding: 2rem;
            color: var(--text-light);
        }

        .loading-spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 3px solid rgba(102, 126, 234, 0.1);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== NOTIFICATION SYSTEM ===== */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-left: 4px solid var(--info);
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 10000;
            animation: slideInRight 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 400px;
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
            gap: 0.5rem;
            flex: 1;
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
            background: var(--light);
            color: var(--text-dark);
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

        /* ===== PROFILE MODAL STYLES ===== */
        .profile-content {
            padding: 1rem;
        }

        .profile-avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .profile-info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .profile-info-item label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .profile-info-item label i {
            color: var(--primary);
            width: 20px;
        }

        .profile-value {
            padding: 0.75rem 1rem;
            background: var(--light);
            border-radius: 8px;
            border: 1px solid var(--border);
            color: var(--text-dark);
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <?php echo $__env->make('components.sidebar', ['activeLoans' => $active_loans, 'upcomingDueLoans' => $upcoming_due_loans], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
                        <?php if($upcoming_due_loans->count() > 0): ?>
                        <span class="badge"><?php echo e($upcoming_due_loans->count()); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </header>

            <!-- Hero Section -->
            <div class="hero-section">
                <div class="hero-particles">
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                </div>
                <div class="hero-content">
                    <h1 class="hero-title" id="typing-title">Sistem Perpustakaan Digital</h1>
                    <p class="hero-subtitle">Jelajahi dunia pengetahuan dengan koleksi buku terlengkap dan pengalaman membaca yang tak terlupakan</p>
                    
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <span class="hero-stat-number"><?php echo e($featured_books->count()); ?></span>
                            <span class="hero-stat-label">Buku Tersedia</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-number"><?php echo e($active_loans->count()); ?></span>
                            <span class="hero-stat-label">Sedang Dipinjam</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-number"><?php echo e(auth()->user()->created_at->diffForHumans()); ?></span>
                            <span class="hero-stat-label">Member Sejak</span>
                        </div>
                    </div>

                    <div class="hero-cta">
                        <a href="<?php echo e(route('books.browse')); ?>" class="hero-btn primary">
                            <i class="fas fa-compass"></i>
                            Jelajahi Buku
                        </a>
                        <a href="#featured-books" class="hero-btn secondary">
                            <i class="fas fa-star"></i>
                            Buku Populer
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Welcome Section -->
                <div class="welcome-section fade-in">
                    <div class="welcome-header">
                        <div class="welcome-text">
                            <h1>👋 Selamat Datang, <?php echo e(auth()->user()->name); ?>!</h1>
                            <p>Temukan buku favorit Anda dan nikmati pengalaman membaca yang menyenangkan</p>
                        </div>
                        <div class="widgets-container">
                            <div class="widget clock-widget">
                                <div class="clock-time" id="current-time">00:00:00</div>
                                <div class="clock-date" id="current-date">Loading...</div>
                            </div>
                            <div class="widget weather-widget">
                                <div class="weather-temp">
                                    <i class="fas fa-sun"></i> 28°C
                                </div>
                                <div class="weather-desc">Cerah Berawan</div>
                            </div>
                            <div class="widget progress-widget">
                                <div class="progress-title">Target Baca Bulan Ini</div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 65%"></div>
                                </div>
                                <div class="progress-text">13 dari 20 buku</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <div class="stat-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="stat-value"><?php echo e($active_loans->count()); ?></div>
                        <div class="stat-label">Buku Dipinjam</div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-value"><?php echo e($loan_history->where('status', 'returned')->count()); ?></div>
                        <div class="stat-label">Buku Dikembalikan</div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-value">
                            <?php echo e($active_loans->filter(function($loan) {
                                return \Carbon\Carbon::parse($loan->due_date)->diffInDays(now()) <= 3;
                            })->count()); ?>

                        </div>
                        <div class="stat-label">Segera Jatuh Tempo</div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-value"><?php echo e($featured_books->count()); ?></div>
                        <div class="stat-label">Buku Tersedia</div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="section-header">
                    <h2 class="section-title">🚀 Aksi Cepat</h2>
                </div>
                <div class="quick-actions">
                    <a href="<?php echo e(route('books.browse')); ?>" class="action-card">
                        <i class="fas fa-compass"></i>
                        <h3>Jelajahi Buku</h3>
                        <p>Temukan koleksi buku terbaru</p>
                    </a>
                    <a href="<?php echo e(route('books.browse')); ?>" class="action-card">
                        <i class="fas fa-search-plus"></i>
                        <h3>Cari Buku</h3>
                        <p>Cari buku berdasarkan judul atau penulis</p>
                    </a>
                    <a href="#" class="action-card" onclick="showBorrowedBooks()">
                        <i class="fas fa-book-reader"></i>
                        <h3>Sedang Dipinjam</h3>
                        <p>Kelola buku yang sedang Anda pinjam</p>
                    </a>
                    <a href="#" class="action-card" onclick="showLoanHistory()">
                        <i class="fas fa-history"></i>
                        <h3>Riwayat Peminjaman</h3>
                        <p>Lihat riwayat peminjaman Anda</p>
                    </a>
                </div>

                <!-- Active Loans Section -->
                <?php if($active_loans->count() > 0): ?>
                <div class="loans-section">
                    <div class="section-header">
                        <h2 class="section-title">📚 Buku yang Sedang Dipinjam</h2>
                    </div>
                    <div class="loans-grid">
                        <?php $__currentLoopData = $active_loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="loan-card fade-in">
                            <div class="loan-book-cover">
                                <?php
                                    $cover = $loan->book->cover_image ?? null;
                                    // Determine if it's a full URL or a storage path
                                    $isUrl = $cover && (\Illuminate\Support\Str::startsWith($cover, ['http://', 'https://']));
                                    $src = $cover ? ($isUrl ? $cover : asset($cover)) : null;
                                ?>
                                <?php if($src): ?>
                                    <img src="<?php echo e($src); ?>" alt="<?php echo e($loan->book->title); ?> cover" onerror="this.style.display='none'">
                                <?php else: ?>
                                    <i class="fas fa-book"></i>
                                <?php endif; ?>
                            </div>
                            <div class="loan-details">
                                <h3 class="loan-book-title"><?php echo e($loan->book->title); ?></h3>
                                <p class="loan-book-author"><?php echo e($loan->book->author); ?></p>
                                <div class="loan-date-info">
                                    <div class="loan-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Dipinjam: <?php echo e(\Carbon\Carbon::parse($loan->loan_date)->format('d M Y')); ?></span>
                                    </div>
                                    <div class="loan-date">
                                        <i class="fas fa-calendar-check"></i>
                                        <span>Jatuh Tempo: <?php echo e(\Carbon\Carbon::parse($loan->due_date)->format('d M Y')); ?></span>
                                    </div>
                                </div>
                                <?php
                                    // Calculate days left properly
                                    $now = \Carbon\Carbon::now()->startOfDay();
                                    $dueDate = \Carbon\Carbon::parse($loan->due_date)->startOfDay();
                                    $daysLeft = $now->diffInDays($dueDate, false);
                                    
                                    // Determine badge class and text
                                    if ($daysLeft < 0) {
                                        $badgeClass = 'danger';
                                        $badgeText = 'Terlambat ' . abs($daysLeft) . ' hari';
                                    } elseif ($daysLeft == 0) {
                                        $badgeClass = 'danger';
                                        $badgeText = 'Jatuh tempo hari ini';
                                    } elseif ($daysLeft <= 3) {
                                        $badgeClass = 'warning';
                                        $badgeText = $daysLeft . ' hari lagi';
                                    } else {
                                        $badgeClass = 'success';
                                        $badgeText = $daysLeft . ' hari lagi';
                                    }
                                ?>
                                <span class="due-badge <?php echo e($badgeClass); ?>"><?php echo e($badgeText); ?></span>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="loans-section">
                    <div class="section-header">
                        <h2 class="section-title">📚 Buku yang Sedang Dipinjam</h2>
                    </div>
                    <div class="empty-state">
                        <i class="fas fa-book-open"></i>
                        <h3>Belum Ada Buku yang Dipinjam</h3>
                        <p>Mulai jelajahi koleksi kami dan pinjam buku favorit Anda!</p>
                        <a href="<?php echo e(route('books.browse')); ?>" class="btn btn-primary" style="display: inline-flex; text-decoration: none; max-width: 200px; margin: 0 auto;">
                            <i class="fas fa-book"></i>
                            Jelajahi Buku
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Featured Books Section -->
                <div class="books-section" id="featured-books">
                    <div class="section-header">
                        <h2 class="section-title">✨ Buku Terbaru & Populer</h2>
                        <a href="<?php echo e(route('books.browse')); ?>" class="view-all-btn">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="books-grid">
                        <?php $__currentLoopData = $featured_books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="book-card fade-in" onclick="window.location.href='<?php echo e(route('books.show', $book->id)); ?>'">
                            <div class="book-cover">
                                <?php
                                    $cover = $book->cover_image ?? null;
                                    $isUrl = $cover && (\Illuminate\Support\Str::startsWith($cover, ['http://', 'https://']));
                                    $src = $cover ? ($isUrl ? $cover : asset($cover)) : null;
                                ?>
                                <?php if($src): ?>
                                    <img src="<?php echo e($src); ?>" alt="<?php echo e($book->title); ?> cover" onerror="this.style.display='none'">
                                <?php else: ?>
                                    <i class="fas fa-book"></i>
                                <?php endif; ?>
                                <span class="book-availability <?php echo e($book->available > 0 ? 'available' : 'unavailable'); ?>">
                                    <?php echo e($book->available > 0 ? 'Tersedia' : 'Dipinjam'); ?>

                                </span>
                            </div>
                            <div class="book-info">
                                <span class="book-category"><?php echo e($book->category->name ?? 'Umum'); ?></span>
                                <h3 class="book-title"><?php echo e($book->title); ?></h3>
                                <p class="book-author"><?php echo e($book->author); ?></p>
                                <div class="book-actions">
                                    <button class="btn btn-primary" onclick="event.stopPropagation(); alert('Fitur peminjaman akan segera tersedia!')">
                                        <i class="fas fa-hand-holding"></i>
                                        Pinjam
                                    </button>
                                    <button class="btn btn-outline" onclick="event.stopPropagation(); window.location.href='<?php echo e(route('books.show', $book->id)); ?>'">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Borrowed Books -->
    <div class="modal-overlay" id="borrowedBooksModal">
        <div class="modal-container">
            <div class="modal-header">
                <h2><i class="fas fa-book-reader"></i> Buku yang Sedang Dipinjam</h2>
                <button class="modal-close" onclick="closeBorrowedBooksModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <div class="borrowed-books-list" id="borrowedBooksList">
                    <!-- Borrowed books will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Loan History -->
    <div class="modal-overlay" id="loanHistoryModal">
        <div class="modal-container">
            <div class="modal-header">
                <h2><i class="fas fa-history"></i> Riwayat Peminjaman</h2>
                <button class="modal-close" onclick="closeLoanHistoryModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <div class="history-filters">
                    <select id="historyFilter" onchange="filterHistory()">
                        <option value="all">Semua Status</option>
                        <option value="returned">Sudah Dikembalikan</option>
                        <option value="borrowed">Sedang Dipinjam</option>
                        <option value="overdue">Terlambat</option>
                    </select>
                    <input type="text" id="historySearch" placeholder="Cari judul buku..." onkeyup="searchHistory()">
                </div>
                <div class="loan-history-list" id="loanHistoryList">
                    <!-- Loan history will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Request Loan Modal -->
    <div class="modal-overlay" id="requestLoanModal">
        <div class="modal-container">
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
                    <form id="loanRequestForm">
                        <div class="form-group">
                            <label for="loanDuration">Durasi Peminjaman</label>
                            <select id="loanDuration" name="loan_duration" required>
                                <option value="7">7 Hari</option>
                                <option value="14" selected>14 Hari</option>
                                <option value="21">21 Hari</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="loanNotes">Catatan (Opsional)</label>
                            <textarea id="loanNotes" name="notes" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="closeRequestLoanModal()">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                                Ajukan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="modal-overlay" id="profileModal">
        <div class="modal-container">
            <div class="modal-header">
                <h2><i class="fas fa-user-circle"></i> Profil Saya</h2>
                <button class="modal-close" onclick="closeProfileModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <div class="profile-content">
                    <div class="profile-avatar-large">
                        <?php echo e(strtoupper(substr(Auth::user()->name, 0, 2))); ?>

                    </div>
                    <div class="profile-info">
                        <div class="profile-info-item">
                            <label><i class="fas fa-user"></i> Nama Lengkap</label>
                            <div class="profile-value"><?php echo e(Auth::user()->name); ?></div>
                        </div>
                        <div class="profile-info-item">
                            <label><i class="fas fa-envelope"></i> Email</label>
                            <div class="profile-value"><?php echo e(Auth::user()->email); ?></div>
                        </div>
                        <div class="profile-info-item">
                            <label><i class="fas fa-shield-alt"></i> Role</label>
                            <div class="profile-value"><?php echo e(ucfirst(Auth::user()->role)); ?></div>
                        </div>
                        <div class="profile-info-item">
                            <label><i class="fas fa-calendar-alt"></i> Bergabung Sejak</label>
                            <div class="profile-value"><?php echo e(\Carbon\Carbon::parse(Auth::user()->created_at)->format('d M Y')); ?></div>
                        </div>
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

        // Clock Widget
        function updateClock() {
            const now = new Date();
            const timeElement = document.getElementById('current-time');
            const dateElement = document.getElementById('current-date');
            
            if (timeElement && dateElement) {
                const timeString = now.toLocaleTimeString('id-ID', { 
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                
                const dateString = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                timeElement.textContent = timeString;
                dateElement.textContent = dateString;
            }
        }

        // Update clock every second
        updateClock();
        setInterval(updateClock, 1000);

        // Typing effect for hero title
        function typeWriter(element, text, speed = 100) {
            if (!element) return;
            
            // Remove the ::after cursor temporarily
            element.style.setProperty('--cursor-display', 'none');
            element.innerHTML = '';
            let i = 0;
            
            const timer = setInterval(() => {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                } else {
                    clearInterval(timer);
                    // Show cursor after typing is complete
                    setTimeout(() => {
                        element.style.setProperty('--cursor-display', 'inline');
                    }, 500);
                }
            }, speed);
        }

        // Initialize typing effect when page loads
        window.addEventListener('load', () => {
            const titleElement = document.getElementById('typing-title');
            if (titleElement) {
                setTimeout(() => {
                    typeWriter(titleElement, 'Sistem Perpustakaan Digital', 60);
                }, 500);
            }
        });

        // Parallax effect for hero section - DISABLED to fix collision issue
        // let ticking = false;
        // function updateParallax() {
        //     const scrolled = window.pageYOffset;
        //     const heroSection = document.querySelector('.hero-section');
        //     
        //     if (heroSection && window.innerWidth > 768) {
        //         const rate = scrolled * -0.2;
        //         heroSection.style.transform = `translate3d(0, ${rate}px, 0)`;
        //     }
        //     ticking = false;
        // }

        // window.addEventListener('scroll', () => {
        //     if (!ticking) {
        //         requestAnimationFrame(updateParallax);
        //         ticking = true;
        //     }
        // });

        // Enhanced card hover effects
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
                this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Animated counter for stats
        function animateCounter(element, target, duration = 2000) {
            if (!element) return;
            
            const start = 0;
            const increment = target / (duration / 16);
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current);
            }, 16);
        }

        // Search functionality
        const searchInput = document.getElementById('headerSearch');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const searchTerm = this.value.toLowerCase();
                    if (searchTerm.length > 2) {
                        console.log('Searching for:', searchTerm);
                    }
                }, 300);
            });

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const searchTerm = this.value.trim();
                    if (searchTerm) {
                        window.location.href = '<?php echo e(route("books.browse")); ?>?search=' + encodeURIComponent(searchTerm);
                    }
                }
            });
        }

        // Initialize counters and animations when in view
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    
                    // Animate stat counters
                    const statValue = entry.target.querySelector('.stat-value');
                    if (statValue && !statValue.classList.contains('animated')) {
                        const target = parseInt(statValue.textContent);
                        if (!isNaN(target)) {
                            statValue.classList.add('animated');
                            animateCounter(statValue, target);
                        }
                    }
                    
                    // Animate progress bars
                    const progressBars = entry.target.querySelectorAll('.progress-fill');
                    progressBars.forEach(bar => {
                        if (!bar.classList.contains('animated')) {
                            bar.classList.add('animated');
                            const width = bar.style.width;
                            bar.style.width = '0%';
                            setTimeout(() => {
                                bar.style.width = width;
                            }, 500);
                        }
                    });
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in, .stat-card, .action-card').forEach(el => {
            observer.observe(el);
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add ripple effect to buttons
        function createRipple(event) {
            const button = event.currentTarget;
            const circle = document.createElement('span');
            const diameter = Math.max(button.clientWidth, button.clientHeight);
            const radius = diameter / 2;

            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
            circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
            circle.classList.add('ripple');

            const ripple = button.getElementsByClassName('ripple')[0];
            if (ripple) {
                ripple.remove();
            }

            button.appendChild(circle);
        }

        // Add ripple effect CSS
        const rippleStyle = document.createElement('style');
        rippleStyle.textContent = `
            .ripple {
                position: absolute;
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 600ms linear;
                background-color: rgba(255, 255, 255, 0.7);
                pointer-events: none;
            }
            
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(rippleStyle);

        // Apply ripple effect to buttons
        document.querySelectorAll('.hero-btn, .btn').forEach(button => {
            button.style.position = 'relative';
            button.style.overflow = 'hidden';
            button.addEventListener('click', createRipple);
        });

        // Enhanced page load animations with staggered entrance
        window.addEventListener('load', () => {
            // Smooth page entrance
            document.body.style.opacity = '1';
            
            // Staggered content animation
            const contentSections = document.querySelectorAll('.content-area > *');
            contentSections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                section.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                
                setTimeout(() => {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, 100 + (index * 150));
            });
        });

        // Enhanced hover effects for interactive elements
        document.addEventListener('DOMContentLoaded', () => {
            // Add magnetic effect to buttons
            const buttons = document.querySelectorAll('.btn, .view-all-btn, .action-card');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function(e) {
                    this.style.transform = 'translateY(-2px) scale(1.02)';
                });
                
                button.addEventListener('mouseleave', function(e) {
                    this.style.transform = 'translateY(0) scale(1)';
                });
                
                // Add ripple effect
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple-effect');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
            
            // Add parallax effect to cards
            const cards = document.querySelectorAll('.stat-card, .book-card, .loan-card');
            cards.forEach(card => {
                card.addEventListener('mousemove', function(e) {
                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    const rotateX = (y - centerY) / 10;
                    const rotateY = (centerX - x) / 10;
                    
                    this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateZ(0)';
                });
            });
        });

        // Add CSS for enhanced animations
        const enhancedAnimationStyle = document.createElement('style');
        enhancedAnimationStyle.textContent = `
            body {
                opacity: 0;
                transition: opacity 0.5s ease-in-out;
            }
            
            .ripple-effect {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: scale(0);
                animation: ripple-animation 0.6s linear;
                pointer-events: none;
            }
            
            @keyframes ripple-animation {
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
            
            .content-area {
                animation: contentFadeIn 0.8s ease-out;
            }
            
            @keyframes contentFadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .stat-card, .action-card, .book-card, .loan-card {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                will-change: transform;
            }
            
            .widget {
                animation: slideIn 0.6s ease-out backwards;
            }
            
            .widget:nth-child(1) { animation-delay: 0.1s; }
            .widget:nth-child(2) { animation-delay: 0.2s; }
            .widget:nth-child(3) { animation-delay: 0.3s; }
            
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateX(30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            .fade-in {
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.6s ease;
            }
            
            .fade-in.visible {
                opacity: 1;
                transform: translateY(0);
            }
        `;
        document.head.appendChild(enhancedAnimationStyle);

        // ===== MODAL FUNCTIONS =====
        
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
                                        `<img src="${book.book.cover_image.startsWith('http') ? book.book.cover_image : '/' + book.book.cover_image}" alt="${book.book.title}">` : 
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
                                        <span class="status-badge ${book.status}">${book.status_text}</span>
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

        // Show Profile Modal
        function showProfileModal() {
            const modal = document.getElementById('profileModal');
            modal.classList.add('active');
        }

        // Close Profile Modal
        function closeProfileModal() {
            document.getElementById('profileModal').classList.remove('active');
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
                                        `<img src="${history.book.cover_image.startsWith('http') ? history.book.cover_image : '/' + history.book.cover_image}" alt="${history.book.title}">` : 
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
                                        <span class="status-badge ${history.status}">${history.status_text}</span>
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

        // Request Book Loan
        function requestBookLoan(bookId) {
            // Fetch book details first
            fetch(`/api/books/${bookId}`)
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
                                `<img src="${book.cover_image.startsWith('http') ? book.cover_image : '/' + book.cover_image}" alt="${book.title}">` : 
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
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Gagal memuat detail buku', 'error');
            });
        }

        // Close Request Loan Modal
        function closeRequestLoanModal() {
            document.getElementById('requestLoanModal').classList.remove('active');
        }

        // Submit Loan Request
        document.getElementById('loanRequestForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const bookId = this.dataset.bookId;
            const loanDuration = document.getElementById('loanDuration').value;
            const notes = document.getElementById('loanNotes').value;
            
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
                body: JSON.stringify({
                    book_id: bookId,
                    loan_duration: loanDuration,
                    notes: notes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeRequestLoanModal();
                    // Refresh page or update UI
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

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

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
            }
        });

        // Normalize any decimal day counts in due badges (defensive UI cleanup)
        document.addEventListener('DOMContentLoaded', function() {
            const normalizeText = (text) => {
                if (!text || typeof text !== 'string') return text;
                const lower = text.toLowerCase();
                if (lower.includes('jatuh tempo hari ini')) return text;
                // Decide rounding mode: floor for 'terlambat', ceil for 'hari lagi'
                const rounder = lower.includes('terlambat') ? Math.floor : (lower.includes('hari lagi') ? Math.ceil : Math.round);
                return text.replace(/(\d+[.,]\d+|\d+)(?=\s*hari)/gi, (m) => {
                    const n = Number(m.replace(',', '.'));
                    if (Number.isNaN(n)) return m;
                    return String(rounder(n));
                });
            };

            document.querySelectorAll('.due-badge').forEach((el) => {
                const original = el.textContent.trim();
                const normalized = normalizeText(original);
                if (normalized !== original) {
                    el.textContent = normalized;
                }
            });
        });

        // Make functions globally available
        window.showBorrowedBooks = showBorrowedBooks;
        window.closeBorrowedBooksModal = closeBorrowedBooksModal;
        window.showLoanHistory = showLoanHistory;
        window.closeLoanHistoryModal = closeLoanHistoryModal;
        window.showProfileModal = showProfileModal;
        window.closeProfileModal = closeProfileModal;
        window.filterHistory = filterHistory;
        window.searchHistory = searchHistory;
        window.requestBookLoan = requestBookLoan;
        window.closeRequestLoanModal = closeRequestLoanModal;
        window.extendLoan = extendLoan;
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Perpustakaan1_project\resources\views/dashboard/anggota.blade.php ENDPATH**/ ?>