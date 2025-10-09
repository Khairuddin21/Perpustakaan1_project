<!-- Sidebar Component -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <i class="fas fa-book-reader"></i>
            <h1 class="sidebar-title">SisPerpus</h1>
        </div>
        <p class="sidebar-subtitle">Sistem Perpustakaan Digital</p>
    </div>
    
    <div class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Menu Utama</div>
            <a href="<?php echo e(route('dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Koleksi Buku</div>
            <a href="<?php echo e(route('books.browse')); ?>" class="nav-item <?php echo e(request()->routeIs('books.browse') ? 'active' : ''); ?>">
                <i class="fas fa-book"></i>
                <span>Jelajahi Buku</span>
            </a>
            <a href="#" class="nav-item" onclick="document.querySelector('.search-box input, .search-input').focus(); return false;">
                <i class="fas fa-search"></i>
                <span>Cari Buku</span>
            </a>
            <a href="<?php echo e(route('books.browse')); ?>" class="nav-item">
                <i class="fas fa-tags"></i>
                <span>Kategori</span>
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Peminjaman Saya</div>
            <a href="#" class="nav-item">
                <i class="fas fa-hand-holding-heart"></i>
                <span>Sedang Dipinjam</span>
                <?php if($activeLoans->count() > 0): ?>
                <span class="notification-badge"><?php echo e($activeLoans->count()); ?></span>
                <?php endif; ?>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-history"></i>
                <span>Riwayat Peminjaman</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-heart"></i>
                <span>Favorit</span>
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Akun</div>
            <a href="#" class="nav-item">
                <i class="fas fa-user-circle"></i>
                <span>Profil Saya</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span>
                <span class="notification-badge">3</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">
                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

            </div>
            <div class="user-details">
                <strong><?php echo e(auth()->user()->name); ?></strong>
                <small><?php echo e(ucfirst(auth()->user()->role)); ?></small>
            </div>
        </div>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</nav><?php /**PATH C:\xampp\htdocs\PERPUSTAKAAN\resources\views/components/sidebar.blade.php ENDPATH**/ ?>