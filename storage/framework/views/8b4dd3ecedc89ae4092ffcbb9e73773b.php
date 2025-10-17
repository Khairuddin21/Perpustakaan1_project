<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Sistem Perpustakaan')); ?> - Selamat Datang</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/dashboard.css', 'resources/js/dashboard.js']); ?>
    
    <style>
        /* Landing Page Specific Styles */
        .landing-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .landing-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveBackground 20s linear infinite;
            opacity: 0.3;
        }
        
        @keyframes moveBackground {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(50px, 50px);
            }
        }
        
        .landing-card {
            background: white;
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-width: 1200px;
            width: 100%;
            overflow: hidden;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.8s ease-out;
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
        
        .landing-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 600px;
        }
        
        .landing-left {
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
        }
        
        .landing-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(102, 126, 234, 0.4);
        }
        
        .logo-text h1 {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--dark-text);
            margin: 0;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .logo-text p {
            font-size: 0.875rem;
            color: var(--light-text);
            margin: 0.25rem 0 0;
        }
        
        .landing-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark-text);
            margin: 0 0 1rem;
            line-height: 1.2;
        }
        
        .landing-title .highlight {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .landing-description {
            font-size: 1.125rem;
            color: var(--light-text);
            margin: 0 0 2.5rem;
            line-height: 1.7;
        }
        
        .landing-features {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2.5rem;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 0.75rem;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .feature-item:hover {
            border-color: #667eea;
            transform: translateX(5px);
            box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.2);
        }
        
        .feature-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #667eea;
            flex-shrink: 0;
        }
        
        .feature-text h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark-text);
            margin: 0 0 0.25rem;
        }
        
        .feature-text p {
            font-size: 0.875rem;
            color: var(--light-text);
            margin: 0;
        }
        
        .landing-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(102, 126, 234, 0.5);
        }
        
        .landing-right {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .landing-right::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            animation: moveBackground 15s linear infinite;
        }
        
        .landing-illustration {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .illustration-content {
            position: relative;
            z-index: 1;
        }
        
        .floating-elements {
            position: relative;
            width: 300px;
            height: 300px;
        }
        
        .floating-icon {
            position: absolute;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .floating-icon.icon-1 {
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            animation: float 3s ease-in-out infinite;
        }
        
        .floating-icon.icon-2 {
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            animation: float 3s ease-in-out infinite 0.5s;
        }
        
        .floating-icon.icon-3 {
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            animation: float 3s ease-in-out infinite 1s;
        }
        
        .floating-icon.icon-4 {
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            animation: float 3s ease-in-out infinite 1.5s;
        }
        
        .center-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #667eea;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(-50%);
            }
            50% {
                transform: translateY(-20px) translateX(-50%);
            }
        }
        
        .floating-icon.icon-2 {
            animation-name: floatRight;
        }
        
        @keyframes floatRight {
            0%, 100% {
                transform: translateY(-50%) translateX(0);
            }
            50% {
                transform: translateY(-50%) translateX(20px);
            }
        }
        
        .floating-icon.icon-4 {
            animation-name: floatLeft;
        }
        
        @keyframes floatLeft {
            0%, 100% {
                transform: translateY(-50%) translateX(0);
            }
            50% {
                transform: translateY(-50%) translateX(-20px);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: translate(-50%, -50%) scale(1);
            }
            50% {
                transform: translate(-50%, -50%) scale(1.05);
            }
        }
        
        .stats-preview {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 1rem;
            z-index: 2;
        }
        
        .stat-preview {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 1rem 1.5rem;
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            min-width: 100px;
        }
        
        .stat-preview-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            display: block;
        }
        
        .stat-preview-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.9);
            display: block;
            margin-top: 0.25rem;
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .landing-content {
                grid-template-columns: 1fr;
            }
            
            .landing-right {
                display: none;
            }
            
            .landing-left {
                padding: 3rem;
            }
        }
        
        @media (max-width: 640px) {
            .landing-container {
                padding: 1rem;
            }
            
            .landing-left {
                padding: 2rem;
            }
            
            .landing-title {
                font-size: 2rem;
            }
            
            .landing-description {
                font-size: 1rem;
            }
            
            .landing-cta {
                flex-direction: column;
            }
            
            .btn-login {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <div class="landing-card">
            <div class="landing-content">
                <!-- Left Side - Content -->
                <div class="landing-left">
                    <div class="landing-logo">
                        <div class="logo-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="logo-text">
                            <h1>SisPerpus</h1>
                            <p>Sistem Perpustakaan Digital</p>
                        </div>
                    </div>
                    
                    <h2 class="landing-title">
                        Selamat Datang di <span class="highlight">Perpustakaan Digital</span>
                    </h2>
                    
                    <p class="landing-description">
                        Platform perpustakaan modern yang memudahkan Anda dalam mengelola dan mengakses koleksi buku secara digital. Nikmati pengalaman membaca yang lebih baik dengan sistem yang efisien dan user-friendly.
                    </p>
                    
                    <div class="landing-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Koleksi Lengkap</h3>
                                <p>Ribuan buku dari berbagai kategori tersedia untuk Anda</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Pencarian Mudah</h3>
                                <p>Temukan buku favorit Anda dengan cepat dan mudah</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Akses 24/7</h3>
                                <p>Pinjam dan baca buku kapan saja, di mana saja</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Manajemen Efisien</h3>
                                <p>Sistem pengelolaan yang terintegrasi dan otomatis</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="landing-cta">
                        <a href="<?php echo e(route('login')); ?>" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i>
                            Masuk ke Sistem
                        </a>
                        <a href="#features" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i>
                            Register
                        </a>
                    </div>
                </div>
                
                <!-- Right Side - Illustration -->
                <div class="landing-right">
                    <div class="landing-illustration">
                        <div class="illustration-content">
                            <div class="floating-elements">
                                <div class="floating-icon icon-1">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="floating-icon icon-2">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="floating-icon icon-3">
                                    <i class="fas fa-pen-fancy"></i>
                                </div>
                                <div class="floating-icon icon-4">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <div class="center-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stats-preview">
                            <div class="stat-preview">
                                <span class="stat-preview-number">1000+</span>
                                <span class="stat-preview-label">Buku</span>
                            </div>
                            <div class="stat-preview">
                                <span class="stat-preview-number">500+</span>
                                <span class="stat-preview-label">Anggota</span>
                            </div>
                            <div class="stat-preview">
                                <span class="stat-preview-number">24/7</span>
                                <span class="stat-preview-label">Akses</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PERPUSTAKAAN\resources\views/landing.blade.php ENDPATH**/ ?>