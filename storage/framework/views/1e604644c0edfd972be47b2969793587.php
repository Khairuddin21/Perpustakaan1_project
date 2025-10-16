<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital - Selamat Datang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-primary: #FFFFFF;
            --bg-secondary: #F5F8FA;
            --text-primary: #0F1419;
            --text-secondary: #536471;
            --text-disabled: #8899AC;
            --divider: rgba(15, 20, 25, 0.12);
            --hover: rgba(205, 2, 107, 0.1);
            --selected: rgba(205, 2, 107, 0.2);
            --accent: #CD026B;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Header */
        .header {
            background-color: var(--bg-primary);
            border-bottom: 1px solid var(--divider);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            text-decoration: none;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background-color: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .btn {
            padding: 0.625rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background-color: #B80260;
        }

        .btn-outline {
            background-color: transparent;
            color: var(--accent);
            border: 1px solid var(--accent);
        }

        .btn-outline:hover {
            background-color: var(--hover);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%);
            padding: 4rem 2rem;
            text-align: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .hero-image {
            margin-top: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-image img {
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Features Section */
        .features {
            padding: 4rem 2rem;
            background-color: var(--bg-primary);
        }

        .features-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            color: var(--text-primary);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background-color: var(--bg-secondary);
            padding: 2rem;
            border-radius: 16px;
            transition: all 0.3s;
            border: 1px solid var(--divider);
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            background-color: var(--hover);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background-color: var(--accent);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-primary);
        }

        .feature-card p {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Stats Section */
        .stats {
            background-color: var(--bg-secondary);
            padding: 3rem 2rem;
        }

        .stats-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h2 {
            font-size: 3rem;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            font-size: 1.125rem;
            color: var(--text-secondary);
        }

        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, var(--accent) 0%, #9B0251 100%);
            padding: 4rem 2rem;
            text-align: center;
            color: white;
        }

        .cta-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .btn-white {
            background-color: white;
            color: var(--accent);
        }

        .btn-white:hover {
            background-color: var(--bg-secondary);
        }

        /* Footer */
        .footer {
            background-color: var(--text-primary);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .footer p {
            color: var(--text-disabled);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .stat-item h2 {
                font-size: 2rem;
            }

            .cta h2 {
                font-size: 1.75rem;
            }

            .header-content {
                padding: 0;
            }
        }

        /* Animations */
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

        .hero-content, .feature-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .feature-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .feature-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .feature-card:nth-child(4) {
            animation-delay: 0.3s;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="/" class="logo">
                <div class="logo-icon">📚</div>
                <span>Perpustakaan Digital</span>
            </a>
            <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Masuk</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Jelajahi Dunia Pengetahuan Digital</h1>
            <p>Akses ribuan buku, kelola peminjaman dengan mudah, dan nikmati pengalaman membaca yang modern</p>
            <div class="hero-buttons">
                <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Mulai Sekarang</a>
                <a href="#features" class="btn btn-outline">Pelajari Lebih Lanjut</a>
            </div>
        </div>
        <div class="hero-image">
            <svg viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                <!-- Illustration SVG -->
                <rect x="50" y="50" width="500" height="300" rx="20" fill="#F5F8FA"/>
                <rect x="80" y="100" width="150" height="200" rx="10" fill="#CD026B" opacity="0.1"/>
                <rect x="250" y="100" width="150" height="200" rx="10" fill="#CD026B" opacity="0.15"/>
                <rect x="420" y="100" width="150" height="200" rx="10" fill="#CD026B" opacity="0.2"/>
                <!-- Books -->
                <rect x="90" y="120" width="130" height="160" rx="8" fill="#CD026B"/>
                <rect x="260" y="120" width="130" height="160" rx="8" fill="#9B0251"/>
                <rect x="430" y="120" width="130" height="160" rx="8" fill="#CD026B"/>
                <!-- Details -->
                <circle cx="155" cy="200" r="30" fill="white" opacity="0.3"/>
                <circle cx="325" cy="200" r="30" fill="white" opacity="0.3"/>
                <circle cx="495" cy="200" r="30" fill="white" opacity="0.3"/>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="features-content">
            <h2 class="section-title">Fitur Unggulan</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📖</div>
                    <h3>Koleksi Lengkap</h3>
                    <p>Akses ribuan buku dari berbagai kategori dan genre. Temukan bacaan favorit Anda dengan mudah.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Peminjaman Cepat</h3>
                    <p>Sistem peminjaman digital yang cepat dan efisien. Tidak perlu antre lagi!</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3>Pencarian Mudah</h3>
                    <p>Temukan buku yang Anda cari dengan fitur pencarian canggih berdasarkan judul, penulis, atau kategori.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⭐</div>
                    <h3>Rating & Review</h3>
                    <p>Baca review dari pembaca lain dan berikan rating untuk membantu komunitas menemukan buku terbaik.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💾</div>
                    <h3>Wishlist</h3>
                    <p>Simpan buku yang ingin Anda baca nanti ke dalam daftar wishlist pribadi Anda.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Riwayat Lengkap</h3>
                    <p>Lihat riwayat peminjaman dan pengembalian buku Anda dengan detail dan terorganisir.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-content">
            <div class="stat-item">
                <h2>10,000+</h2>
                <p>Koleksi Buku</p>
            </div>
            <div class="stat-item">
                <h2>5,000+</h2>
                <p>Anggota Aktif</p>
            </div>
            <div class="stat-item">
                <h2>50,000+</h2>
                <p>Peminjaman</p>
            </div>
            <div class="stat-item">
                <h2>98%</h2>
                <p>Kepuasan</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-content">
            <h2>Siap Memulai Perjalanan Membaca?</h2>
            <p>Bergabunglah dengan ribuan pembaca lainnya dan nikmati akses ke perpustakaan digital terbaik</p>
            <a href="<?php echo e(route('login')); ?>" class="btn btn-white">Masuk Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Perpustakaan Digital. Semua hak dilindungi.</p>
    </footer>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Perpustakaan1_project\resources\views/welcome.blade.php ENDPATH**/ ?>