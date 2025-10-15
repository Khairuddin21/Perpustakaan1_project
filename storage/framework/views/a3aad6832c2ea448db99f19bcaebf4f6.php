<!-- Admin Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h1 class="sidebar-title">
            <i class="fas fa-book-open"></i>
            SisPerpus
        </h1>
        <p class="sidebar-subtitle">Sistem Perpustakaan Digital</p>
    </div>
    
    <div class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Menu Utama</div>
            <a href="<?php echo e(route('dashboard')); ?>" class="nav-item active">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Manajemen Data</div>
            <a href="#" class="nav-item" data-page="books">
                <i class="fas fa-book"></i>
                Kelola Buku
            </a>
            <a href="#" class="nav-item" data-page="categories">
                <i class="fas fa-tags"></i>
                Kategori Buku
            </a>
            <a href="#" class="nav-item" data-page="users">
                <i class="fas fa-users"></i>
                Kelola Anggota
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Transaksi</div>
            <a href="#" class="nav-item" data-page="loans">
                <i class="fas fa-hand-holding"></i>
                Peminjaman Buku
            </a>
            <a href="<?php echo e(route('returns.index')); ?>" class="nav-item" data-page="returns">
                <i class="fas fa-undo"></i>
                Pengembalian Buku
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Laporan</div>
            <a href="#" class="nav-item" data-page="reports">
                <i class="fas fa-chart-bar"></i>
                Laporan & Statistik
            </a>
            <a href="#" class="nav-item" data-page="analytics">
                <i class="fas fa-analytics"></i>
                Analisis Data
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Pengaturan</div>
            <a href="#" class="nav-item" data-page="settings">
                <i class="fas fa-cog"></i>
                Pengaturan Sistem
            </a>
        </div>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\PERPUSTAKAAN\resources\views/components/admin-sidebar.blade.php ENDPATH**/ ?>