<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($book->title); ?> - <?php echo e(config('app.name', 'Sistem Perpustakaan')); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/dashboard.css']); ?>
    
    <style>
        .book-detail-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 0;
            font-family: 'Inter', sans-serif;
        }
        
        .detail-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .detail-header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .back-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
        
        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        
        .book-detail-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
            animation: fadeInUp 0.8s ease-out;
        }
        
        .book-detail-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideInUp 0.8s ease-out 0.2s both;
        }
        
        .book-hero-section {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 3rem;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .book-hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 200px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            opacity: 0.5;
            z-index: 0;
        }
        
        .book-cover-section {
            position: relative;
            z-index: 1;
        }
        
        .book-cover-container {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }
        
        .book-cover-container:hover {
            transform: scale(1.02) rotateY(5deg);
        }
        
        .book-cover-large {
            width: 100%;
            height: auto;
            max-height: 600px;
            object-fit: cover;
            display: block;
        }
        
        .no-cover-large {
            width: 100%;
            height: 500px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .no-cover-large::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .no-cover-large i {
            font-size: 5rem;
            margin-bottom: 1rem;
            opacity: 0.8;
            position: relative;
            z-index: 1;
        }
        
        .no-cover-large span {
            font-size: 1.125rem;
            font-weight: 500;
            position: relative;
            z-index: 1;
        }
        
        .book-info-section {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .book-title-large {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.2;
            margin: 0 0 1rem 0;
            animation: fadeInRight 0.8s ease-out 0.4s both;
        }
        
        .book-author-large {
            font-size: 1.5rem;
            color: #64748b;
            margin: 0 0 1.5rem 0;
            font-weight: 500;
            animation: fadeInRight 0.8s ease-out 0.5s both;
        }
        
        .book-author-large strong {
            color: #6366f1;
            font-weight: 600;
        }
        
        .book-category-badge {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            animation: fadeInRight 0.8s ease-out 0.6s both;
            align-self: flex-start;
        }
        
        .book-status-section {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 2rem;
            animation: fadeInRight 0.8s ease-out 0.7s both;
        }
        
        .status-badge {
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .status-available {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        
        .status-unavailable {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        
        .book-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            animation: fadeInRight 0.8s ease-out 0.8s both;
        }
        
        .btn-primary-modern {
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }
        
        .btn-secondary-modern {
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.9);
            color: #6366f1;
            border: 2px solid #6366f1;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-secondary-modern:hover {
            background: #6366f1;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
        }
        
        .book-meta-section {
            background: rgba(248, 250, 252, 0.8);
            border-radius: 1.5rem;
            padding: 2rem;
            margin-top: 2rem;
            animation: fadeIn 0.8s ease-out 0.9s both;
        }
        
        .meta-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .book-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .meta-item-modern {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }
        
        .meta-item-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .meta-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        
        .meta-label {
            font-size: 0.875rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .meta-value {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        .book-description-section {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            margin-top: 2rem;
            animation: fadeIn 0.8s ease-out 1s both;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        
        .description-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .description-text {
            font-size: 1.125rem;
            line-height: 1.8;
            color: #475569;
            margin: 0;
        }
        
        .alert-modern {
            padding: 1.5rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 600;
            font-size: 1rem;
            animation: pulse 2s infinite;
        }
        
        .alert-info-modern {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            border: 2px solid #3b82f6;
        }
        
        .alert-warning-modern {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            border: 2px solid #f59e0b;
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
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .book-hero-section {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 2rem;
            }
            
            .book-cover-container {
                max-width: 300px;
                margin: 0 auto;
            }
            
            .book-title-large {
                font-size: 2rem;
                text-align: center;
            }
            
            .book-author-large {
                text-align: center;
            }
            
            .book-category-badge {
                align-self: center;
            }
            
            .book-actions {
                flex-direction: column;
            }
            
            .detail-header-content {
                padding: 0 1rem;
            }
            
            .book-detail-container {
                padding: 2rem 1rem;
            }
            
            .book-meta-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="book-detail-page">
    <!-- Header -->
    <header class="detail-header">
        <div class="detail-header-content">
            <a href="<?php echo e(route('dashboard')); ?>" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>
            
            <h1 class="page-title">Detail Buku</h1>
            
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <div class="book-detail-container">
        <div class="book-detail-card">
            <!-- Hero Section -->
            <div class="book-hero-section">
                <div class="book-cover-section">
                    <div class="book-cover-container">
                        <?php if($book->cover_image): ?>
                            <img src="<?php echo e($book->cover_image); ?>" alt="<?php echo e($book->title); ?>" class="book-cover-large" onerror="this.parentElement.innerHTML='<div class=\'no-cover-large\'><i class=\'fas fa-book\'></i><span>Cover Tidak Tersedia</span></div>'">
                        <?php else: ?>
                            <div class="no-cover-large">
                                <i class="fas fa-book"></i>
                                <span>Cover Tidak Tersedia</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="book-info-section">
                    <h1 class="book-title-large"><?php echo e($book->title); ?></h1>
                    <p class="book-author-large">oleh <strong><?php echo e($book->author); ?></strong></p>
                    <div class="book-category-badge"><?php echo e($book->category->name ?? 'Uncategorized'); ?></div>
                    
                    <div class="book-status-section">
                        <?php if($book->available > 0): ?>
                            <div class="status-badge status-available">
                                <i class="fas fa-check-circle"></i>
                                Tersedia (<?php echo e($book->available); ?> eksemplar)
                            </div>
                        <?php else: ?>
                            <div class="status-badge status-unavailable">
                                <i class="fas fa-times-circle"></i>
                                Tidak Tersedia
                            </div>
                        <?php endif; ?>
                        
                        <div class="status-badge" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
                            <i class="fas fa-hashtag"></i>
                            ID: <?php echo e($book->id); ?>

                        </div>
                    </div>
                    
                    <div class="book-actions">
                        <?php if($hasActiveLoan): ?>
                            <div class="alert-modern alert-info-modern">
                                <i class="fas fa-info-circle"></i>
                                <span>Anda sedang meminjam buku ini</span>
                            </div>
                        <?php elseif($book->available > 0): ?>
                            <button class="btn-primary-modern" onclick="requestLoan()">
                                <i class="fas fa-hand-holding"></i>
                                Ajukan Peminjaman
                            </button>
                            <button class="btn-secondary-modern" onclick="toggleFavorite()">
                                <i class="far fa-heart"></i>
                                Tambah ke Favorit
                            </button>
                        <?php else: ?>
                            <div class="alert-modern alert-warning-modern">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>Buku sedang tidak tersedia</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Book Metadata -->
            <div class="book-meta-section">
                <h3 class="meta-title">
                    <i class="fas fa-info-circle"></i>
                    Informasi Buku
                </h3>
                
                <div class="book-meta-grid">
                    <div class="meta-item-modern">
                        <div class="meta-icon">
                            <i class="fas fa-barcode"></i>
                        </div>
                        <div class="meta-label">ISBN</div>
                        <p class="meta-value"><?php echo e($book->isbn ?? 'Tidak tersedia'); ?></p>
                    </div>
                    
                    <div class="meta-item-modern">
                        <div class="meta-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="meta-label">Penerbit</div>
                        <p class="meta-value"><?php echo e($book->publisher ?? 'Tidak tersedia'); ?></p>
                    </div>
                    
                    <div class="meta-item-modern">
                        <div class="meta-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="meta-label">Tahun Terbit</div>
                        <p class="meta-value"><?php echo e($book->published_year ?? 'Tidak tersedia'); ?></p>
                    </div>
                    
                    <div class="meta-item-modern">
                        <div class="meta-icon">
                            <i class="fas fa-warehouse"></i>
                        </div>
                        <div class="meta-label">Total Stok</div>
                        <p class="meta-value"><?php echo e($book->stock); ?> eksemplar</p>
                    </div>
                </div>
            </div>
            
            <!-- Book Description -->
            <?php if($book->description): ?>
            <div class="book-description-section">
                <h3 class="description-title">
                    <i class="fas fa-align-left"></i>
                    Deskripsi Buku
                </h3>
                <p class="description-text"><?php echo e($book->description); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        function requestLoan() {
            Swal.fire({
                title: 'Ajukan Peminjaman?',
                text: 'Anda akan mengajukan peminjaman untuk buku "<?php echo e($book->title); ?>"',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6366f1',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Ajukan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Pengajuan peminjaman berhasil dikirim. Silakan hubungi pustakawan untuk konfirmasi.',
                        icon: 'success',
                        confirmButtonColor: '#6366f1'
                    });
                }
            });
        }
        
        function toggleFavorite() {
            const btn = document.querySelector('.btn-secondary-modern');
            const icon = btn.querySelector('i');
            
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                btn.innerHTML = '<i class="fas fa-heart"></i> Hapus dari Favorit';
                
                Swal.fire({
                    title: 'Ditambahkan!',
                    text: 'Buku berhasil ditambahkan ke favorit',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                btn.innerHTML = '<i class="far fa-heart"></i> Tambah ke Favorit';
                
                Swal.fire({
                    title: 'Dihapus!',
                    text: 'Buku berhasil dihapus dari favorit',
                    icon: 'info',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        }
        
        // Add entrance animations
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.meta-item-modern');
            elements.forEach((element, index) => {
                element.style.animationDelay = `${0.1 * index}s`;
                element.classList.add('fadeInUp');
            });
        });
    </script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\PERPUSTAKAAN\resources\views/dashboard/book-detail.blade.php ENDPATH**/ ?>