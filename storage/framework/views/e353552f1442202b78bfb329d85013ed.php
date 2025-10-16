<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - SisPerpus</title>
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
            display: flex;
            flex-direction: column;
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
            flex: 1;
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
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
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

        /* ===== CONTENT AREA ===== */
        .content-area {
            padding: 2rem;
            max-width: 1400px;
            margin: 2rem auto;
        }

        /* ===== SETTINGS SECTIONS ===== */
        .settings-container {
            display: grid;
            gap: 2rem;
        }

        .settings-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.6s ease-out both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .settings-section:nth-child(1) { animation-delay: 0.1s; }
        .settings-section:nth-child(2) { animation-delay: 0.2s; }
        .settings-section:nth-child(3) { animation-delay: 0.3s; }
        .settings-section:nth-child(4) { animation-delay: 0.4s; }

        .settings-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border);
        }

        .section-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .section-title {
            flex: 1;
        }

        .section-title h2 {
            font-size: 1.5rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .section-title p {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        /* ===== SETTINGS ITEMS ===== */
        .settings-items {
            display: grid;
            gap: 1rem;
        }

        .settings-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem;
            background: var(--light);
            border-radius: 12px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .settings-item:hover {
            background: white;
            border-color: var(--primary);
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }

        .item-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(102, 126, 234, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.2rem;
        }

        .item-details h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .item-details p {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .item-action {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-light);
        }

        /* ===== TOGGLE SWITCH ===== */
        .toggle-switch {
            position: relative;
            width: 50px;
            height: 26px;
            background: #cbd5e1;
            border-radius: 13px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .toggle-switch.active {
            background: var(--primary);
        }

        .toggle-slider {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .toggle-switch.active .toggle-slider {
            transform: translateX(24px);
        }

        /* ===== BADGE ===== */
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-primary {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary);
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
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
        }

        @media (max-width: 768px) {
            .header {
                padding: 0 1rem;
            }

            .header-title {
                font-size: 1.25rem;
            }

            .content-area {
                padding: 1.5rem 1rem;
            }

            .settings-section {
                padding: 1.5rem;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .settings-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .item-action {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <?php echo $__env->make('components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <h2 class="header-title">Pengaturan</h2>
                
                <div class="header-actions">
                    <div class="notification-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <div class="settings-container">
                    <!-- Account Settings -->
                    <div class="settings-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <div class="section-title">
                                <h2>Akun & Profil</h2>
                                <p>Kelola informasi akun dan profil Anda</p>
                            </div>
                        </div>
                        <div class="settings-items">
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-user-edit"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Edit Profil</h3>
                                        <p>Ubah nama, email, dan informasi pribadi</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-key"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Ubah Password</h3>
                                        <p>Perbarui password untuk keamanan akun</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Foto Profil</h3>
                                        <p>Upload atau ubah foto profil Anda</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Verifikasi Akun</h3>
                                        <p>Status verifikasi akun Anda</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <span class="badge badge-success">Terverifikasi</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Notification Settings -->
                    <div class="settings-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="section-title">
                                <h2>Notifikasi</h2>
                                <p>Kelola preferensi notifikasi Anda</p>
                            </div>
                        </div>
                        <div class="settings-items">
                            <div class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Notifikasi Email</h3>
                                        <p>Terima notifikasi melalui email</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <div class="toggle-switch active">
                                        <div class="toggle-slider"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Pengingat Jatuh Tempo</h3>
                                        <p>Notifikasi saat buku hampir jatuh tempo</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <div class="toggle-switch active">
                                        <div class="toggle-slider"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Buku Baru & Rekomendasi</h3>
                                        <p>Update tentang buku baru dan rekomendasi</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <div class="toggle-switch">
                                        <div class="toggle-slider"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-bullhorn"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Pengumuman Perpustakaan</h3>
                                        <p>Notifikasi pengumuman penting</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <div class="toggle-switch active">
                                        <div class="toggle-slider"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Privacy & Security -->
                    <div class="settings-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="section-title">
                                <h2>Privasi & Keamanan</h2>
                                <p>Kelola pengaturan privasi dan keamanan</p>
                            </div>
                        </div>
                        <div class="settings-items">
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-user-lock"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Privasi Profil</h3>
                                        <p>Atur siapa yang bisa melihat profil Anda</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <span class="badge badge-primary">Publik</span>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-history"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Riwayat Aktivitas</h3>
                                        <p>Lihat dan kelola riwayat aktivitas Anda</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Perangkat Terhubung</h3>
                                        <p>Kelola perangkat yang terhubung ke akun</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-download"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Download Data Saya</h3>
                                        <p>Unduh salinan data akun Anda</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Preferences -->
                    <div class="settings-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-sliders-h"></i>
                            </div>
                            <div class="section-title">
                                <h2>Preferensi</h2>
                                <p>Sesuaikan tampilan dan pengalaman Anda</p>
                            </div>
                        </div>
                        <div class="settings-items">
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-palette"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Tema & Tampilan</h3>
                                        <p>Light mode, dark mode, atau otomatis</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <span class="badge badge-primary">Light</span>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-language"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Bahasa</h3>
                                        <p>Pilih bahasa tampilan aplikasi</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <span class="badge badge-primary">Indonesia</span>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-book-reader"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Preferensi Membaca</h3>
                                        <p>Genre favorit dan rekomendasi buku</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <div class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-volume-up"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Suara & Notifikasi</h3>
                                        <p>Aktifkan atau nonaktifkan suara notifikasi</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <div class="toggle-switch active">
                                        <div class="toggle-slider"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Help & Support -->
                    <div class="settings-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div class="section-title">
                                <h2>Bantuan & Dukungan</h2>
                                <p>Dapatkan bantuan dan informasi lebih lanjut</p>
                            </div>
                        </div>
                        <div class="settings-items">
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Panduan Pengguna</h3>
                                        <p>Pelajari cara menggunakan aplikasi</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-life-ring"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Pusat Bantuan</h3>
                                        <p>FAQ dan artikel bantuan</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-comment-dots"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Hubungi Kami</h3>
                                        <p>Kirim pesan ke tim dukungan</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Syarat & Ketentuan</h3>
                                        <p>Baca syarat dan ketentuan layanan</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item">
                                <div class="item-info">
                                    <div class="item-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3>Tentang Aplikasi</h3>
                                        <p>SisPerpus v1.0.0</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="settings-section">
                        <div class="section-header">
                            <div class="section-icon" style="background: linear-gradient(135deg, var(--danger), #dc2626);">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="section-title">
                                <h2>Zona Berbahaya</h2>
                                <p>Tindakan yang memerlukan perhatian khusus</p>
                            </div>
                        </div>
                        <div class="settings-items">
                            <a href="#" class="settings-item" style="border-color: rgba(239, 68, 68, 0.2);">
                                <div class="item-info">
                                    <div class="item-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                                        <i class="fas fa-user-slash"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3 style="color: var(--danger);">Nonaktifkan Akun</h3>
                                        <p>Nonaktifkan akun Anda sementara</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right" style="color: var(--danger);"></i>
                                </div>
                            </a>
                            <a href="#" class="settings-item" style="border-color: rgba(239, 68, 68, 0.2);">
                                <div class="item-info">
                                    <div class="item-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                                        <i class="fas fa-trash-alt"></i>
                                    </div>
                                    <div class="item-details">
                                        <h3 style="color: var(--danger);">Hapus Akun</h3>
                                        <p>Hapus akun Anda secara permanen</p>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <i class="fas fa-chevron-right" style="color: var(--danger);"></i>
                                </div>
                            </a>
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

        // Toggle switches
        document.querySelectorAll('.toggle-switch').forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.toggle('active');
            });
        });

        // Prevent settings items with toggle from navigating
        document.querySelectorAll('.settings-item').forEach(item => {
            const toggle = item.querySelector('.toggle-switch');
            if (toggle) {
                item.style.cursor = 'default';
                item.addEventListener('click', function(e) {
                    if (e.target === toggle || toggle.contains(e.target)) {
                        e.preventDefault();
                    }
                });
            }
        });

        // Smooth scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.settings-section').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Perpustakaan1_project\resources\views/dashboard/setting-anggota.blade.php ENDPATH**/ ?>