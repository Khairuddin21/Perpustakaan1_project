<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Buku - SisPerpus</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        /* ===== CONTENT AREA ===== */
        .content-area {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Page Header */
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .page-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #6b7280;
            font-size: 1rem;
        }

        /* Empty State */
        .empty-state {
            background: white;
            padding: 4rem 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .empty-state i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .empty-state .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .empty-state .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.4);
        }

        /* Books Grid */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        /* Book Card */
        .book-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .book-card-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .book-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .book-author {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .book-card-body {
            padding: 1.5rem;
        }

        .book-info-row {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: #f9fafb;
            border-radius: 8px;
        }

        .book-info-row i {
            font-size: 1.1rem;
            color: var(--primary);
            margin-right: 0.75rem;
            width: 20px;
        }

        .book-info-row .label {
            font-weight: 600;
            color: #6b7280;
            margin-right: 0.5rem;
        }

        .book-info-row .value {
            color: var(--dark);
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-badge.borrowed {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-badge.overdue {
            background: #fee2e2;
            color: #991b1b;
        }

        .return-form {
            border-top: 2px solid #f3f4f6;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
        }

        .return-form h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-help {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .btn-return {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-return:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(16, 185, 129, 0.4);
        }

        .btn-return:disabled {
            background: #d1d5db;
            cursor: not-allowed;
            transform: none;
        }

        .return-requested {
            background: #fef3c7;
            border: 2px solid #fbbf24;
            padding: 1rem 3.5rem 1rem 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            position: relative;
            display: flex;
            align-items: center;
        }

        .return-requested i {
            color: #d97706;
            margin-right: 0.5rem;
        }

        .return-requested p {
            color: #92400e;
            font-weight: 600;
            margin: 0;
            flex: 1;
        }

        .btn-clear-request {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            background: #dc2626;
            color: white;
            border: 2px solid #991b1b;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }

        .btn-clear-request:hover {
            background: #b91c1c;
            border-color: #7f1d1d;
            transform: translateY(-50%) scale(1.15);
            box-shadow: 0 4px 16px rgba(220, 38, 38, 0.5);
        }

        .btn-clear-request:active {
            transform: translateY(-50%) scale(1.05);
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
        }

        .btn-clear-request i {
            color: white !important;
            margin: 0;
            line-height: 1;
        }

        /* Fade in animation for dynamically added form */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
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

            .books-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .books-grid {
                grid-template-columns: 1fr;
            }

            .content-area {
                padding: 1rem;
            }

            .header {
                padding: 0 1rem;
            }

            .header-title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <?php echo $__env->make('components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="main-content" id="mainContent">
            <div class="header">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="header-title">
                    <h1>Pengembalian Buku</h1>
                </div>
            </div>

            <div class="content-area">
                <div class="page-header">
                    <h2><i class="fas fa-undo-alt"></i> Pengembalian Buku</h2>
                    <p>Ajukan pengembalian untuk buku yang sedang Anda pinjam. Isi formulir di bawah ini dan datang ke perpustakaan untuk mengembalikan buku secara fisik.</p>
                </div>

                <?php if($borrowedBooks->isEmpty()): ?>
                    <div class="empty-state">
                        <i class="fas fa-book-open"></i>
                        <h3>Tidak Ada Buku yang Dipinjam</h3>
                        <p>Anda belum memiliki buku yang sedang dipinjam saat ini.</p>
                        <a href="<?php echo e(route('books.browse')); ?>" class="btn">
                            <i class="fas fa-search"></i> Jelajahi Buku
                        </a>
                    </div>
                <?php else: ?>
                    <div class="books-grid">
                        <?php $__currentLoopData = $borrowedBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="book-card">
                                <div class="book-card-header">
                                    <div class="book-title"><?php echo e($loan->book->title); ?></div>
                                    <div class="book-author"><?php echo e($loan->book->author); ?></div>
                                </div>

                                <div class="book-card-body">
                                    <div class="book-info-row">
                                        <i class="fas fa-calendar"></i>
                                        <span class="label">Tanggal Pinjam:</span>
                                        <span class="value"><?php echo e($loan->loan_date->format('d M Y')); ?></span>
                                    </div>

                                    <div class="book-info-row">
                                        <i class="fas fa-calendar-check"></i>
                                        <span class="label">Jatuh Tempo:</span>
                                        <span class="value"><?php echo e($loan->due_date->format('d M Y')); ?></span>
                                    </div>

                                    <div class="book-info-row">
                                        <i class="fas fa-hourglass-half"></i>
                                        <span class="label">Status:</span>
                                        <?php
                                            $today = \Carbon\Carbon::now()->startOfDay();
                                            $dueDate = \Carbon\Carbon::parse($loan->due_date)->startOfDay();
                                            $daysRemaining = $today->diffInDays($dueDate, false);
                                        ?>
                                        <?php if($daysRemaining < 0): ?>
                                            <span class="status-badge overdue">Terlambat <?php echo e(abs($daysRemaining)); ?> hari</span>
                                        <?php elseif($daysRemaining == 0): ?>
                                            <span class="status-badge overdue">Jatuh tempo hari ini</span>
                                        <?php else: ?>
                                            <span class="status-badge borrowed"><?php echo e($daysRemaining); ?> hari lagi</span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if(!$loan->return_request_date): ?>
                                        <div class="return-form">
                                            <h4><i class="fas fa-clipboard-list"></i> Formulir Pengembalian</h4>
                                            <form class="return-request-form" data-loan-id="<?php echo e($loan->id); ?>">
                                                <div class="form-group">
                                                    <label for="return_nis_<?php echo e($loan->id); ?>">
                                                        <i class="fas fa-id-card"></i> NIS <span style="color: red;">*</span>
                                                    </label>
                                                    <input 
                                                        type="text" 
                                                        id="return_nis_<?php echo e($loan->id); ?>" 
                                                        name="return_nis" 
                                                        placeholder="Masukkan NIS Anda"
                                                        value="<?php echo e($loan->nis ?? ''); ?>"
                                                        required
                                                    >
                                                    <div class="form-help">Nomor Induk Siswa Anda</div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="return_borrower_name_<?php echo e($loan->id); ?>">
                                                        <i class="fas fa-user"></i> Nama Lengkap <span style="color: red;">*</span>
                                                    </label>
                                                    <input 
                                                        type="text" 
                                                        id="return_borrower_name_<?php echo e($loan->id); ?>" 
                                                        name="return_borrower_name" 
                                                        placeholder="Masukkan nama lengkap Anda"
                                                        value="<?php echo e(auth()->user()->name); ?>"
                                                        required
                                                    >
                                                    <div class="form-help">Nama sesuai identitas</div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="return_condition_<?php echo e($loan->id); ?>">
                                                        <i class="fas fa-clipboard-check"></i> Kondisi Buku <span style="color: red;">*</span>
                                                    </label>
                                                    <select 
                                                        id="return_condition_<?php echo e($loan->id); ?>" 
                                                        name="return_condition" 
                                                        required
                                                    >
                                                        <option value="">-- Pilih Kondisi --</option>
                                                        <option value="baik">Baik (Tidak ada kerusakan)</option>
                                                        <option value="rusak_ringan">Rusak Ringan (Lecet/sobek kecil)</option>
                                                        <option value="rusak_berat">Rusak Berat (Halaman hilang/rusak parah)</option>
                                                    </select>
                                                    <div class="form-help">Pilih kondisi buku saat ini</div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="return_notes_<?php echo e($loan->id); ?>">
                                                        <i class="fas fa-comment-alt"></i> Catatan Tambahan (Opsional)
                                                    </label>
                                                    <textarea 
                                                        id="return_notes_<?php echo e($loan->id); ?>" 
                                                        name="return_notes" 
                                                        placeholder="Jelaskan kerusakan atau catatan lainnya (jika ada)"
                                                    ></textarea>
                                                    <div class="form-help">Deskripsikan kondisi atau masalah buku jika ada</div>
                                                </div>

                                                <button type="submit" class="btn-return">
                                                    <i class="fas fa-paper-plane"></i>
                                                    Ajukan Pengembalian
                                                </button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <div class="return-requested" id="return-requested-<?php echo e($loan->id); ?>">
                                            <p>
                                                <i class="fas fa-check-circle"></i>
                                                Permintaan pengembalian sudah diajukan pada <?php echo e(\Carbon\Carbon::parse($loan->return_request_date)->format('d M Y H:i')); ?>

                                            </p>
                                            <button 
                                                type="button" 
                                                class="btn-clear-request" 
                                                onclick="clearReturnRequest(<?php echo e($loan->id); ?>)"
                                                title="Hapus riwayat pengembalian"
                                            >
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Form submission handler (reusable function)
        function attachFormSubmitHandler(form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const loanId = this.dataset.loanId;
                const submitBtn = this.querySelector('.btn-return');
                const formData = new FormData(this);
                
                // Validate required fields
                const nis = formData.get('return_nis');
                const name = formData.get('return_borrower_name');
                const condition = formData.get('return_condition');
                
                if (!nis || !name || !condition) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Data Tidak Lengkap',
                        text: 'Mohon lengkapi semua field yang wajib diisi (NIS, Nama, dan Kondisi Buku).',
                        confirmButtonColor: '#667eea'
                    });
                    return;
                }
                
                // Confirm submission
                const result = await Swal.fire({
                    title: 'Konfirmasi Pengembalian',
                    html: `
                        <div style="text-align: left; padding: 1rem;">
                            <p style="margin-bottom: 1rem;">Apakah Anda yakin ingin mengajukan pengembalian dengan data berikut?</p>
                            <div style="background: #f3f4f6; padding: 1rem; border-radius: 8px;">
                                <p style="margin: 0.5rem 0;"><strong>NIS:</strong> ${nis}</p>
                                <p style="margin: 0.5rem 0;"><strong>Nama:</strong> ${name}</p>
                                <p style="margin: 0.5rem 0;"><strong>Kondisi:</strong> ${condition === 'baik' ? 'Baik' : condition === 'rusak_ringan' ? 'Rusak Ringan' : 'Rusak Berat'}</p>
                                ${formData.get('return_notes') ? `<p style="margin: 0.5rem 0;"><strong>Catatan:</strong> ${formData.get('return_notes')}</p>` : ''}
                            </div>
                            <p style="margin-top: 1rem; color: #d97706; font-weight: 600;">
                                <i class="fas fa-exclamation-triangle"></i> Setelah mengajukan, silakan datang ke perpustakaan untuk mengembalikan buku secara fisik.
                            </p>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Ajukan',
                    cancelButtonText: 'Batal',
                    width: '600px'
                });
                
                if (!result.isConfirmed) {
                    return;
                }
                
                // Disable button
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
                
                try {
                    const response = await fetch('/api/returns/submit', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            loan_id: loanId,
                            return_nis: nis,
                            return_borrower_name: name,
                            return_condition: condition,
                            return_notes: formData.get('return_notes') || ''
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        await Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            confirmButtonColor: '#10b981'
                        });
                        
                        // Reload page to show updated status
                        window.location.reload();
                    } else {
                        throw new Error(data.message);
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: error.message || 'Terjadi kesalahan saat mengajukan pengembalian.',
                        confirmButtonColor: '#ef4444'
                    });
                    
                    // Re-enable button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Ajukan Pengembalian';
                }
            });
        }

        // Attach handlers to all existing forms
        document.querySelectorAll('.return-request-form').forEach(form => {
            attachFormSubmitHandler(form);
        });

        // Clear return request function
        async function clearReturnRequest(loanId) {
            // Confirm deletion
            const result = await Swal.fire({
                title: 'Hapus Riwayat Pengembalian?',
                html: `
                    <div style="text-align: left; padding: 1rem;">
                        <p style="margin-bottom: 1rem;">Apakah Anda yakin ingin menghapus riwayat pengembalian ini?</p>
                        <div style="background: #fee2e2; padding: 1rem; border-radius: 8px; border-left: 4px solid #ef4444;">
                            <p style="margin: 0; color: #991b1b; font-weight: 600;">
                                <i class="fas fa-exclamation-triangle"></i> Perhatian:
                            </p>
                            <p style="margin: 0.5rem 0 0; color: #7f1d1d;">
                                Data permintaan pengembalian akan dihapus dan Anda perlu mengajukan ulang jika ingin mengembalikan buku.
                            </p>
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                width: '500px'
            });

            if (!result.isConfirmed) {
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch('/api/returns/clear', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        loan_id: loanId
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Close loading alert
                    Swal.close();

                    // Find the current card and grid
                    const returnRequestedBox = document.getElementById(`return-requested-${loanId}`);
                    const bookCard = returnRequestedBox.closest('.book-card');
                    const booksGrid = document.querySelector('.books-grid');

                    // Fade out and remove the WHOLE card
                    bookCard.style.transition = 'all 0.25s ease';
                    bookCard.style.opacity = '0';
                    bookCard.style.transform = 'scale(0.98)';

                    setTimeout(() => {
                        // Remove the card
                        if (bookCard && bookCard.parentNode) {
                            bookCard.parentNode.removeChild(bookCard);
                        }

                        // If no more cards, show empty-state
                        if (!booksGrid || booksGrid.querySelectorAll('.book-card').length === 0) {
                            const emptyHTML = `
                                <div class="empty-state" style="animation: fadeIn 0.2s ease;">
                                    <i class=\"fas fa-book-open\"></i>
                                    <h3>Tidak Ada Buku yang Dipinjam</h3>
                                    <p>Anda belum memiliki buku yang sedang dipinjam saat ini.</p>
                                    <a href=\"<?php echo e(route('books.browse')); ?>\" class=\"btn\">
                                        <i class=\"fas fa-search\"></i> Jelajahi Buku
                                    </a>
                                </div>`;

                            if (booksGrid) {
                                booksGrid.outerHTML = emptyHTML;
                            }
                        }

                        // Success toast
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Riwayat pengembalian dihapus',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }, 250);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: error.message || 'Terjadi kesalahan saat menghapus riwayat.',
                    confirmButtonColor: '#ef4444'
                });
            }
        }

        // Menu toggle functionality
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mainContent.classList.toggle('expanded');
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Placeholder functions for sidebar navigation (if not defined elsewhere)
        if (typeof showBorrowedBooks === 'undefined') {
            window.showBorrowedBooks = function() {
                window.location.href = '<?php echo e(route("dashboard")); ?>';
            };
        }

        if (typeof showLoanHistory === 'undefined') {
            window.showLoanHistory = function() {
                window.location.href = '<?php echo e(route("dashboard")); ?>';
            };
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PERPUSTAKAAN\resources\views/dashboard/returns.blade.php ENDPATH**/ ?>