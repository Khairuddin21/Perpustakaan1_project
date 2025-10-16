<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Dashboard Pustakawan - <?php echo e(config('app.name', 'Sistem Perpustakaan')); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/dashboard.css', 'resources/js/dashboard.js']); ?>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php if (isset($component)) { $__componentOriginal3669d248200f2dc31f2689292901c050 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3669d248200f2dc31f2689292901c050 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pustakawan-sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pustakawan-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3669d248200f2dc31f2689292901c050)): ?>
<?php $attributes = $__attributesOriginal3669d248200f2dc31f2689292901c050; ?>
<?php unset($__attributesOriginal3669d248200f2dc31f2689292901c050); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3669d248200f2dc31f2689292901c050)): ?>
<?php $component = $__componentOriginal3669d248200f2dc31f2689292901c050; ?>
<?php unset($__componentOriginal3669d248200f2dc31f2689292901c050); ?>
<?php endif; ?>
        
        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <div class="header-content">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <h1 class="header-title">Dashboard Pustakawan</h1>
                    
                    <div class="header-actions">
                        <div class="user-info">
                            <div class="user-avatar">
                                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

                            </div>
                            <div class="user-details">
                                <div class="user-name"><?php echo e(auth()->user()->name); ?></div>
                                <div class="user-role"><?php echo e(ucfirst(auth()->user()->role)); ?></div>
                            </div>
                        </div>
                        
                        <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="nav-item" style="background: none; border: none; color: #64748b; padding: 0.5rem 1rem; border-radius: 0.5rem; transition: all 0.3s ease;">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Welcome Section -->
                <div class="welcome-section fade-in">
                    <h2 class="welcome-title">Selamat Datang, <?php echo e(auth()->user()->name); ?>! 📚</h2>
                    <p class="welcome-subtitle">Kelola transaksi peminjaman dan pengembalian buku dengan mudah dan efisien.</p>
                </div>
                
                <!-- Statistics Grid -->
                <div class="stats-grid">
                    <div class="stat-card loans" data-stat="total_loans">
                        <div class="stat-content">
                            <div class="stat-icon">
                                <i class="fas fa-hand-holding"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number"><?php echo e($stats['total_loans']); ?></h3>
                                <p class="stat-label">Sedang Dipinjam</p>
                                <p class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i>
                                    +5 hari ini
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card" style="--stat-color: #ef4444;" data-stat="overdue_loans">
                        <div class="stat-content">
                            <div class="stat-icon" style="background: #ef4444; box-shadow: 0 4px 14px 0 rgba(239, 68, 68, 0.4);">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number"><?php echo e($stats['overdue_loans']); ?></h3>
                                <p class="stat-label">Buku Terlambat</p>
                                <p class="stat-change negative">
                                    <i class="fas fa-arrow-down"></i>
                                    -2 dari kemarin
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card" style="--stat-color: #10b981;" data-stat="returned_today">
                        <div class="stat-content">
                            <div class="stat-icon" style="background: #10b981; box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.4);">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number"><?php echo e($stats['returned_today']); ?></h3>
                                <p class="stat-label">Dikembalikan Hari Ini</p>
                                <p class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i>
                                    +8 dari kemarin
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Cards -->
                <div class="action-grid">
                    <div class="action-card" data-action="borrow">
                        <div class="action-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <h3 class="action-title">Peminjaman Buku</h3>
                        <p class="action-description">Proses peminjaman buku baru untuk anggota perpustakaan dengan scan barcode atau pencarian manual.</p>
                    </div>
                    
                    <div class="action-card" data-action="return">
                        <div class="action-icon">
                            <i class="fas fa-undo-alt"></i>
                        </div>
                        <h3 class="action-title">Pengembalian Buku</h3>
                        <p class="action-description">Kelola pengembalian buku dan perhitungan denda otomatis untuk keterlambatan.</p>
                    </div>
                    
                    <div class="action-card" data-action="search">
                        <div class="action-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="action-title">Cari Buku</h3>
                        <p class="action-description">Cari informasi buku, status ketersediaan, dan riwayat peminjaman.</p>
                    </div>
                    
                    <div class="action-card" data-action="overdue">
                        <div class="action-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="action-title">Buku Terlambat</h3>
                        <p class="action-description">Kelola dan pantau buku yang terlambat dikembalikan beserta denda yang berlaku.</p>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="recent-activity">
                    <div class="activity-header">
                        <h3 class="activity-title">Aktivitas Terkini</h3>
                    </div>
                    <ul class="activity-list">
                        <li class="activity-item">
                            <div class="activity-avatar">MD</div>
                            <div class="activity-content">
                                <p class="activity-text">Maya Dewi meminjam buku "Algoritma dan Pemrograman"</p>
                                <p class="activity-time">5 menit yang lalu</p>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-avatar">RH</div>
                            <div class="activity-content">
                                <p class="activity-text">Rizki Hermawan mengembalikan buku "Struktur Data"</p>
                                <p class="activity-time">12 menit yang lalu</p>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-avatar">AP</div>
                            <div class="activity-content">
                                <p class="activity-text">Andi Pratama meminjam buku "Sistem Basis Data"</p>
                                <p class="activity-time">25 menit yang lalu</p>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-avatar">SF</div>
                            <div class="activity-content">
                                <p class="activity-text">Sari Fitria mengembalikan 2 buku (Terlambat 3 hari)</p>
                                <p class="activity-time">45 menit yang lalu</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Scripts loaded via Vite -->
</body>
</html><?php /**PATH C:\xampp\htdocs\Perpustakaan1_project\resources\views/dashboard/pustakawan.blade.php ENDPATH**/ ?>