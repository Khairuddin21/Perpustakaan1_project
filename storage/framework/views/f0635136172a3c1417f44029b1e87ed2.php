<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Detail Pengembalian - <?php echo e(config('app.name', 'Sistem Perpustakaan')); ?></title>
    
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
                    <a href="<?php echo e(route('dashboard')); ?>" class="nav-item">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Transaksi</div>
                    <a href="#" class="nav-item" data-page="loans">
                        <i class="fas fa-hand-holding"></i>
                        Peminjaman Buku
                    </a>
                    <a href="<?php echo e(route('returns.index')); ?>" class="nav-item active" data-page="returns">
                        <i class="fas fa-undo"></i>
                        Pengembalian Buku
                    </a>
                    <a href="#" class="nav-item" data-page="overdue">
                        <i class="fas fa-clock"></i>
                        Buku Terlambat
                    </a>
                </div>
                
                <?php if(auth()->user()->isAdmin()): ?>
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
                <?php endif; ?>
                
                <div class="nav-section">
                    <div class="nav-section-title">Laporan</div>
                    <a href="#" class="nav-item" data-page="reports">
                        <i class="fas fa-chart-bar"></i>
                        Laporan & Statistik
                    </a>
                    <a href="<?php echo e(route('returns.history')); ?>" class="nav-item" data-page="history">
                        <i class="fas fa-history"></i>
                        Riwayat Pengembalian
                    </a>
                </div>
            </div>
        </nav>
        
        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <div class="header-content">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <h1 class="header-title">Detail Pengembalian Buku</h1>
                    
                    <div class="header-actions">
                        <a href="<?php echo e(route('returns.index')); ?>" class="action-btn secondary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        
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
                    <h2 class="welcome-title">Verifikasi Pengembalian 📖</h2>
                    <p class="welcome-subtitle">Periksa informasi peminjaman dan kondisi buku sebelum memproses pengembalian.</p>
                </div>

                <!-- Loan Information Card -->
                <div class="info-section slide-up">
                    <div class="info-card">
                        <div class="info-header">
                            <h3 class="info-title">
                                <i class="fas fa-info-circle"></i>
                                Informasi Peminjaman
                            </h3>
                            <?php if($is_overdue): ?>
                                <div class="status-badge overdue">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Terlambat <?php echo e($days_overdue); ?> hari
                                </div>
                            <?php else: ?>
                                <div class="status-badge success">
                                    <i class="fas fa-check-circle"></i>
                                    Tepat Waktu
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="info-grid">
                            <!-- Member Information -->
                            <div class="info-section-member">
                                <div class="member-card">
                                    <div class="member-header">
                                        <div class="member-avatar-large">
                                            <?php echo e(strtoupper(substr($loan->user->name, 0, 2))); ?>

                                        </div>
                                        <div class="member-info-details">
                                            <h4 class="member-name-large"><?php echo e($loan->user->name); ?></h4>
                                            <p class="member-role">Anggota Perpustakaan</p>
                                        </div>
                                    </div>
                                    <div class="member-contact">
                                        <div class="contact-item">
                                            <i class="fas fa-envelope"></i>
                                            <span><?php echo e($loan->user->email); ?></span>
                                        </div>
                                        <?php if($loan->user->phone): ?>
                                        <div class="contact-item">
                                            <i class="fas fa-phone"></i>
                                            <span><?php echo e($loan->user->phone); ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Book Information -->
                            <div class="info-section-book">
                                <div class="book-card">
                                    <div class="book-icon">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="book-details">
                                        <h4 class="book-title-large"><?php echo e($loan->book->title); ?></h4>
                                        <p class="book-author-large"><?php echo e($loan->book->author); ?></p>
                                        <p class="book-isbn">ISBN: <?php echo e($loan->book->isbn); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Loan Timeline -->
                        <div class="loan-timeline">
                            <div class="timeline-item">
                                <div class="timeline-icon start">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Tanggal Pinjam</h5>
                                    <p><?php echo e($loan->loan_date->format('d M Y')); ?></p>
                                </div>
                            </div>
                            
                            <div class="timeline-connector"></div>
                            
                            <div class="timeline-item">
                                <div class="timeline-icon <?php echo e($is_overdue ? 'danger' : 'warning'); ?>">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Jatuh Tempo</h5>
                                    <p class="<?php echo e($is_overdue ? 'text-danger' : ''); ?>"><?php echo e($loan->due_date->format('d M Y')); ?></p>
                                </div>
                            </div>
                            
                            <div class="timeline-connector"></div>
                            
                            <div class="timeline-item">
                                <div class="timeline-icon info">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Lama Pinjam</h5>
                                    <p><?php echo e($days_borrowed); ?> hari</p>
                                </div>
                            </div>
                        </div>

                        <?php if($is_overdue): ?>
                        <div class="overdue-alert">
                            <div class="alert-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="alert-content">
                                <h4>Keterlambatan Pengembalian</h4>
                                <p>Buku dikembalikan <strong><?php echo e($days_overdue); ?> hari</strong> melewati batas waktu yang ditentukan. Silakan proses pengembalian dan berikan catatan jika diperlukan.</p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Return Process Form -->
                <div class="form-section slide-up">
                    <div class="form-card">
                        <div class="form-header">
                            <h3 class="form-title">
                                <i class="fas fa-clipboard-check"></i>
                                Proses Pengembalian
                            </h3>
                        </div>
                        
                        <form action="<?php echo e(route('returns.process', $loan->id)); ?>" method="POST" class="return-form">
                            <?php echo csrf_field(); ?>
                            
                            <!-- Book Condition -->
                            <div class="form-group">
                                <label class="form-label required">
                                    <i class="fas fa-eye"></i>
                                    Kondisi Buku
                                </label>
                                <div class="radio-group">
                                    <div class="radio-item good">
                                        <input type="radio" id="condition_good" name="condition" value="good" required>
                                        <label for="condition_good">
                                            <div class="radio-icon">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                            <div class="radio-content">
                                                <h5>Baik</h5>
                                                <p>Tidak ada kerusakan, buku dalam kondisi sempurna</p>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="radio-item damaged">
                                        <input type="radio" id="condition_damaged" name="condition" value="damaged">
                                        <label for="condition_damaged">
                                            <div class="radio-icon">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>
                                            <div class="radio-content">
                                                <h5>Rusak</h5>
                                                <p>Ada kerusakan pada buku (robek, kotor, dll)</p>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="radio-item lost">
                                        <input type="radio" id="condition_lost" name="condition" value="lost">
                                        <label for="condition_lost">
                                            <div class="radio-icon">
                                                <i class="fas fa-times-circle"></i>
                                            </div>
                                            <div class="radio-content">
                                                <h5>Hilang</h5>
                                                <p>Buku tidak dikembalikan atau hilang</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['condition'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="error-message"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Notes -->
                            <div class="form-group">
                                <label for="notes" class="form-label">
                                    <i class="fas fa-sticky-note"></i>
                                    Catatan Tambahan
                                </label>
                                <textarea id="notes" 
                                          name="notes" 
                                          rows="4"
                                          class="form-textarea"
                                          placeholder="Tambahkan catatan jika diperlukan (opsional)"><?php echo e(old('notes')); ?></textarea>
                                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="error-message"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Action Buttons -->
                            <div class="form-actions">
                                <a href="<?php echo e(route('returns.index')); ?>" class="action-btn secondary large">
                                    <i class="fas fa-times"></i>
                                    Batal
                                </a>
                                <button type="submit" class="action-btn primary large">
                                    <i class="fas fa-check"></i>
                                    Proses Pengembalian
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Additional Styles for Return Show Page -->
    <style>
        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .action-btn.large {
            padding: 1rem 2rem;
            font-size: 1rem;
        }

        .action-btn.primary {
            background: linear-gradient(135deg, var(--success-color), #059669);
            color: white;
            box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.3);
        }

        .action-btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px 0 rgba(16, 185, 129, 0.4);
        }

        .action-btn.secondary {
            background: white;
            color: var(--dark-text);
            border: 1px solid var(--border-color);
        }

        .action-btn.secondary:hover {
            background: var(--light-bg);
            transform: translateY(-1px);
        }

        .info-section {
            margin-bottom: 2rem;
        }

        .info-card {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .info-header {
            padding: 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        }

        .info-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-text);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-badge.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .status-badge.overdue {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            padding: 2rem;
        }

        .member-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 1rem;
            padding: 2rem;
            color: white;
        }

        .member-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .member-avatar-large {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .member-name-large {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0 0 0.25rem;
        }

        .member-role {
            opacity: 0.8;
            font-size: 0.875rem;
            margin: 0;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            opacity: 0.9;
        }

        .book-card {
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 1rem;
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .book-icon {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .book-title-large {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark-text);
            margin: 0 0 0.5rem;
        }

        .book-author-large {
            color: var(--light-text);
            margin: 0 0 0.25rem;
        }

        .book-isbn {
            font-size: 0.875rem;
            color: var(--light-text);
            margin: 0;
        }

        .loan-timeline {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            margin: 0 2rem;
            border-top: 1px solid var(--border-color);
        }

        .timeline-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .timeline-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .timeline-icon.start {
            background: var(--info-color);
        }

        .timeline-icon.warning {
            background: var(--warning-color);
        }

        .timeline-icon.danger {
            background: var(--danger-color);
        }

        .timeline-icon.info {
            background: var(--secondary-color);
        }

        .timeline-content h5 {
            font-weight: 600;
            color: var(--dark-text);
            margin: 0 0 0.25rem;
        }

        .timeline-content p {
            color: var(--light-text);
            margin: 0;
        }

        .timeline-content p.text-danger {
            color: var(--danger-color);
            font-weight: 600;
        }

        .timeline-connector {
            width: 100px;
            height: 2px;
            background: var(--border-color);
            margin: 0 1rem;
        }

        .overdue-alert {
            margin: 2rem;
            padding: 1.5rem;
            background: rgba(239, 68, 68, 0.05);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 1rem;
            display: flex;
            gap: 1rem;
        }

        .alert-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--danger-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .alert-content h4 {
            color: var(--danger-color);
            font-weight: 700;
            margin: 0 0 0.5rem;
        }

        .alert-content p {
            color: var(--dark-text);
            margin: 0;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-card {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .form-header {
            padding: 2rem 2rem 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-text);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .return-form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 1rem;
        }

        .form-label.required::after {
            content: '*';
            color: var(--danger-color);
            margin-left: 0.25rem;
        }

        .radio-group {
            display: grid;
            gap: 1rem;
        }

        .radio-item {
            border: 2px solid var(--border-color);
            border-radius: 1rem;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .radio-item input[type="radio"] {
            display: none;
        }

        .radio-item label {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .radio-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
        }

        .radio-item input[type="radio"]:checked + label {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        }

        .radio-item.good input[type="radio"]:checked + label {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
        }

        .radio-item.damaged input[type="radio"]:checked + label {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1));
        }

        .radio-item.lost input[type="radio"]:checked + label {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
        }

        .radio-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .radio-item.good .radio-icon {
            background: var(--success-color);
        }

        .radio-item.damaged .radio-icon {
            background: var(--warning-color);
        }

        .radio-item.lost .radio-icon {
            background: var(--danger-color);
        }

        .radio-content h5 {
            font-weight: 600;
            color: var(--dark-text);
            margin: 0 0 0.25rem;
        }

        .radio-content p {
            color: var(--light-text);
            margin: 0;
            font-size: 0.875rem;
        }

        .form-textarea {
            width: 100%;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            resize: vertical;
            min-height: 120px;
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .loan-timeline {
                flex-direction: column;
                gap: 1rem;
            }

            .timeline-connector {
                width: 2px;
                height: 50px;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
    
    <!-- Scripts loaded via Vite -->
</body>
</html><?php /**PATH C:\xampp\htdocs\PERPUSTAKAAN\resources\views/returns/show.blade.php ENDPATH**/ ?>