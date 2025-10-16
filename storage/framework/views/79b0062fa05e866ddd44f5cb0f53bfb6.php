<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Pengembalian Buku - <?php echo e(config('app.name', 'Sistem Perpustakaan')); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/dashboard.css', 'resources/js/dashboard.js']); ?>
    
    <style>
        /* Additional styles for returns page */
        .returns-table-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 2rem;
        }
        
        .returns-table-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .returns-table-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .search-box {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }
        
        .search-form {
            display: flex;
            gap: 1rem;
        }
        
        .search-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.95rem;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-search {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-reset {
            padding: 0.75rem 1.5rem;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-reset:hover {
            background: #4b5563;
        }
        
        .returns-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .returns-table thead th {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: #1e293b;
            border-bottom: 2px solid #e2e8f0;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .returns-table tbody td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .returns-table tbody tr {
            transition: all 0.2s ease;
        }
        
        .returns-table tbody tr:hover {
            background: #f8fafc;
        }
        
        .returns-table tbody tr.overdue {
            background: #fef2f2;
        }
        
        .returns-table tbody tr.has-request {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
        }
        
        .returns-table tbody tr.has-request:hover {
            background: #dcfce7;
        }
        
        .member-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .member-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        .member-details {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .member-name {
            font-weight: 600;
            color: #1e293b;
        }
        
        .member-email {
            font-size: 0.875rem;
            color: #64748b;
        }
        
        .book-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .book-title {
            font-weight: 600;
            color: #1e293b;
        }
        
        .book-author {
            font-size: 0.875rem;
            color: #64748b;
        }
        
        .date-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .date-info i {
            color: #667eea;
        }
        
        .overdue .date-info {
            color: #ef4444;
            font-weight: 600;
        }
        
        .overdue-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            margin-top: 0.35rem;
            padding: 0.25rem 0.5rem;
            background: #fee2e2;
            color: #dc2626;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-badge.borrowed {
            background: rgba(59, 130, 246, 0.1);
            color: #2563eb;
        }
        
        .status-badge.overdue {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }
        
        .btn-process {
            padding: 0.625rem 1.25rem;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            width: 100%;
            justify-content: center;
        }
        
        .btn-process:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(245, 158, 11, 0.3);
        }
        
        .btn-approve {
            padding: 0.625rem 1.25rem;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            width: 100%;
            justify-content: center;
        }
        
        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(16, 185, 129, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            color: #64748b;
            font-size: 1rem;
        }
        
        .pagination-wrapper {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .alert-success {
            background: #d1fae5;
            border: 1px solid #10b981;
            color: #065f46;
        }
        
        .alert-error {
            background: #fee2e2;
            border: 1px solid #ef4444;
            color: #991b1b;
        }
        
        .alert i {
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Admin -->
        <?php echo $__env->make('components.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <div class="header-content">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <h1 class="header-title">Pengembalian Buku</h1>
                    
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
                    <h2 class="welcome-title">Pengembalian Buku 📚</h2>
                    <p class="welcome-subtitle">Kelola dan proses pengembalian buku yang dipinjam oleh anggota perpustakaan.</p>
                </div>
                
                <!-- Alerts -->
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo e(session('success')); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if(session('error')): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo e(session('error')); ?></span>
                    </div>
                <?php endif; ?>
                
                <!-- Search Box -->
                <div class="search-box">
                    <form action="<?php echo e(route('admin.returns.search')); ?>" method="GET" class="search-form">
                        <input 
                            type="text" 
                            name="search" 
                            class="search-input"
                            placeholder="Cari berdasarkan nama anggota, email, judul buku, atau ISBN..."
                            value="<?php echo e(request('search')); ?>"
                        >
                        <button type="submit" class="btn-search">
                            <i class="fas fa-search"></i>
                            Cari
                        </button>
                        <?php if(request('search')): ?>
                            <a href="<?php echo e(route('admin.returns.index')); ?>" class="btn-reset">
                                <i class="fas fa-times"></i>
                                Reset
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
                
                <!-- Returns Table -->
                <div class="returns-table-container">
                    <div class="returns-table-header">
                        <h2>
                            <i class="fas fa-list"></i>
                            Daftar Peminjaman Aktif
                            <?php if(isset($totalLoans)): ?>
                                <span style="font-size: 0.9rem; font-weight: 500; opacity: 0.9;">(<?php echo e($totalLoans); ?> peminjaman)</span>
                            <?php endif; ?>
                        </h2>
                    </div>
                    
                    <?php if($borrowedLoans->count() > 0): ?>
                        <table class="returns-table">
                            <thead>
                                <tr>
                                    <th>Anggota</th>
                                    <th>Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $borrowedLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="<?php echo e($loan->isOverdue() ? 'overdue' : ''); ?> <?php echo e($loan->return_request_date ? 'has-request' : ''); ?>">
                                        <td>
                                            <div class="member-info">
                                                <div class="member-avatar">
                                                    <?php echo e(strtoupper(substr($loan->user->name, 0, 2))); ?>

                                                </div>
                                                <div class="member-details">
                                                    <div class="member-name"><?php echo e($loan->user->name); ?></div>
                                                    <div class="member-email"><?php echo e($loan->user->email); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="book-info">
                                                <div class="book-title"><?php echo e($loan->book->title); ?></div>
                                                <div class="book-author"><?php echo e($loan->book->author); ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="date-info">
                                                <i class="fas fa-calendar-plus"></i>
                                                <?php echo e($loan->loan_date->format('d M Y')); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="date-info">
                                                <i class="fas fa-calendar-check"></i>
                                                <?php echo e($loan->due_date->format('d M Y')); ?>

                                                <?php if($loan->isOverdue()): ?>
                                                    <div class="overdue-badge">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                        Terlambat <?php echo e($loan->due_date->diffInDays(now())); ?> hari
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge <?php echo e($loan->isOverdue() ? 'overdue' : 'borrowed'); ?>">
                                                <i class="fas <?php echo e($loan->isOverdue() ? 'fa-exclamation-triangle' : 'fa-clock'); ?>"></i>
                                                <?php echo e($loan->isOverdue() ? 'Terlambat' : 'Dipinjam'); ?>

                                            </span>
                                            <?php if($loan->return_request_date): ?>
                                                <span class="status-badge" style="background: rgba(16, 185, 129, 0.1); color: #059669; margin-top: 0.5rem; display: inline-flex;">
                                                    <i class="fas fa-paper-plane"></i>
                                                    Ada Request
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($loan->return_request_date): ?>
                                                <!-- User sudah request pengembalian -->
                                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                                    <button 
                                                        onclick="approveReturnRequest(<?php echo e($loan->id); ?>, '<?php echo e($loan->user->name); ?>', '<?php echo e($loan->book->title); ?>', '<?php echo e(optional($loan->return_request_date)->format('d M Y, g:i A')); ?>', '<?php echo e($loan->return_condition); ?>', '<?php echo e($loan->return_notes); ?>')"
                                                        class="btn-approve"
                                                        style="background: linear-gradient(135deg, #10b981, #059669);"
                                                    >
                                                        <i class="fas fa-check-circle"></i>
                                                        ACC Pengembalian
                                                    </button>
                                                    <span style="font-size: 0.75rem; color: #64748b; text-align: center;">
                                                        <i class="fas fa-info-circle"></i>
                                                        Request: <?php echo e(optional($loan->return_request_date)->format('d M Y, g:i A')); ?>

                                                    </span>
                                                </div>
                                            <?php else: ?>
                                                <!-- Belum ada request, admin bisa force -->
                                                <button 
                                                    onclick="forceReturn(<?php echo e($loan->id); ?>, '<?php echo e($loan->user->name); ?>', '<?php echo e($loan->book->title); ?>', <?php echo e($loan->isOverdue() ? 'true' : 'false'); ?>, <?php echo e($loan->isOverdue() ? $loan->due_date->diffInDays(now()) : 0); ?>)"
                                                    class="btn-process"
                                                >
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    Force Pengembalian
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        
                        <?php if(method_exists($borrowedLoans, 'hasPages') && $borrowedLoans->hasPages()): ?>
                            <div class="pagination-wrapper">
                                <?php echo e($borrowedLoans->links()); ?>

                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-check-circle"></i>
                            <h3>Tidak Ada Peminjaman Aktif</h3>
                            <p>
                                <?php if(request('search')): ?>
                                    Tidak ditemukan peminjaman yang sesuai dengan pencarian "<?php echo e(request('search')); ?>".
                                <?php else: ?>
                                    Semua buku sudah dikembalikan. Tidak ada peminjaman yang perlu diproses saat ini.
                                <?php endif; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Function untuk ACC Request Pengembalian dari User
        function approveReturnRequest(loanId, userName, bookTitle, requestDate, returnCondition, returnNotes) {
            // Normalisasi kondisi dari request user (baik/rusak_ringan/rusak_berat) ke nilai valid server (good/damaged/lost)
            const mapUserCondition = (c) => {
                if (!c) return 'good';
                const val = String(c).toLowerCase();
                if (val === 'baik' || val === 'good') return 'good';
                if (val === 'rusak_ringan' || val === 'rusak_berat' || val === 'rusak' || val === 'damaged') return 'damaged';
                if (val === 'hilang' || val === 'lost') return 'lost';
                return 'good';
            };
            const normalized = mapUserCondition(returnCondition);

            Swal.fire({
                title: 'ACC Request Pengembalian',
                html: `
                    <div style="text-align: left; padding: 1rem;">
                        <div style="background: #e0f2fe; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #0284c7;">
                            <h4 style="margin: 0 0 0.5rem 0; color: #0c4a6e;">
                                <i class="fas fa-info-circle"></i> Informasi Request
                            </h4>
                            <p style="margin: 0.5rem 0;"><strong>Peminjam:</strong> ${userName}</p>
                            <p style="margin: 0.5rem 0;"><strong>Buku:</strong> ${bookTitle}</p>
                            <p style="margin: 0.5rem 0;"><strong>Tanggal Request:</strong> ${requestDate}</p>
                            <p style="margin: 0.5rem 0;"><strong>Kondisi Dilaporkan:</strong> 
                                <span style="padding: 0.25rem 0.5rem; background: #dbeafe; color: #1e40af; border-radius: 4px; font-size: 0.85rem;">
                                    ${returnCondition === 'baik' ? 'Baik' : (returnCondition === 'rusak_ringan' ? 'Rusak Ringan' : (returnCondition === 'rusak_berat' ? 'Rusak Berat' : (normalized === 'damaged' ? 'Rusak' : (normalized === 'lost' ? 'Hilang' : 'Baik'))))}
                                </span>
                            </p>
                            ${returnNotes ? `<p style="margin: 0.5rem 0;"><strong>Catatan User:</strong><br><span style="font-style: italic; color: #64748b;">"${returnNotes}"</span></p>` : ''}
                        </div>
                        <div style="background: #fef3c7; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #f59e0b;">
                            <p style="margin: 0; color: #92400e;">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Perhatian:</strong> Pastikan buku sudah diterima dan sesuai dengan kondisi yang dilaporkan sebelum ACC.
                            </p>
                        </div>
                        <div style="margin-top: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Verifikasi Kondisi Buku:</label>
                            <select id="verified-condition" class="swal2-input" style="width: 100%; padding: 0.5rem; margin: 0;">
                                <option value="good" ${normalized === 'good' ? 'selected' : ''}>Baik - Sesuai/Tidak ada kerusakan</option>
                                <option value="damaged" ${normalized === 'damaged' ? 'selected' : ''}>Rusak - Ada kerusakan</option>
                                <option value="lost" ${normalized === 'lost' ? 'selected' : ''}>Hilang/Tidak Dikembalikan</option>
                            </select>
                        </div>
                        <div style="margin-top: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Catatan Admin (Opsional):</label>
                            <textarea id="admin-notes" class="swal2-textarea" placeholder="Tambahkan catatan verifikasi admin..." style="width: 100%; min-height: 80px;"></textarea>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check"></i> ACC & Proses Pengembalian',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                width: '700px',
                preConfirm: () => {
                    return {
                        condition: document.getElementById('verified-condition').value,
                        notes: document.getElementById('admin-notes').value
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    submitReturn(loanId, result.value.condition, result.value.notes);
                }
            });
        }

        // Function untuk Force Pengembalian (buku hilang/terlambat/kondisi khusus)
        function forceReturn(loanId, userName, bookTitle, isOverdue, daysOverdue) {
            let warningMessage = '';
            let suggestedCondition = 'good';
            
            if (isOverdue) {
                warningMessage = `
                    <div style="background: #fee2e2; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #dc2626;">
                        <p style="margin: 0; color: #991b1b;">
                            <i class="fas fa-exclamation-circle"></i>
                            <strong>Buku Terlambat ${daysOverdue} Hari!</strong><br>
                            Pastikan untuk mencatat kondisi buku dan alasan keterlambatan.
                        </p>
                    </div>
                `;
            } else {
                warningMessage = `
                    <div style="background: #fef3c7; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #f59e0b;">
                        <p style="margin: 0; color: #92400e;">
                            <i class="fas fa-info-circle"></i>
                            <strong>Force Pengembalian:</strong><br>
                            Gunakan ini untuk kondisi khusus seperti buku hilang, rusak parah, atau pengembalian paksa.
                        </p>
                    </div>
                `;
            }
            
            Swal.fire({
                title: 'Force Pengembalian Buku',
                html: `
                    <div style="text-align: left; padding: 1rem;">
                        <div style="background: #f3f4f6; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                            <p style="margin: 0.5rem 0;"><strong>Peminjam:</strong> ${userName}</p>
                            <p style="margin: 0.5rem 0;"><strong>Buku:</strong> ${bookTitle}</p>
                        </div>
                        ${warningMessage}
                        <div style="margin-top: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Kondisi Buku:</label>
                            <select id="force-condition" class="swal2-input" style="width: 100%; padding: 0.5rem; margin: 0;">
                                <option value="good">Baik - Tidak ada kerusakan</option>
                                <option value="damaged">Rusak - Ada kerusakan (ringan/sedang)</option>
                                <option value="lost" ${isOverdue ? 'selected' : ''}>Hilang - Buku tidak dikembalikan/hilang</option>
                            </select>
                        </div>
                        <div style="margin-top: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Alasan Force Pengembalian <span style="color: #dc2626;">*</span>:</label>
                            <textarea id="force-reason" class="swal2-textarea" placeholder="Wajib diisi: Jelaskan alasan force pengembalian (contoh: buku hilang, anggota tidak kooperatif, dll)" style="width: 100%; min-height: 100px;" required></textarea>
                        </div>
                        <div style="background: #fee2e2; padding: 0.75rem; border-radius: 6px; margin-top: 1rem;">
                            <p style="margin: 0; font-size: 0.875rem; color: #991b1b;">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Peringatan:</strong> Force pengembalian akan dicatat dalam sistem dan tidak bisa dibatalkan.
                            </p>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-exclamation-triangle"></i> Force Pengembalian',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                width: '700px',
                preConfirm: () => {
                    const reason = document.getElementById('force-reason').value;
                    if (!reason || reason.trim().length < 10) {
                        Swal.showValidationMessage('Alasan force pengembalian harus diisi minimal 10 karakter!');
                        return false;
                    }
                    return {
                        condition: document.getElementById('force-condition').value,
                        notes: 'FORCE RETURN - ' + reason
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Konfirmasi kedua
                    Swal.fire({
                        title: 'Konfirmasi Force Pengembalian',
                        html: `
                            <p style="color: #dc2626; font-weight: 600;">
                                <i class="fas fa-exclamation-triangle"></i>
                                Apakah Anda yakin ingin melakukan force pengembalian?
                            </p>
                            <p style="color: #64748b; font-size: 0.9rem; margin-top: 0.5rem;">
                                Tindakan ini akan dicatat dan tidak dapat dibatalkan.
                            </p>
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Force Pengembalian',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                    }).then((confirmResult) => {
                        if (confirmResult.isConfirmed) {
                            submitReturn(loanId, result.value.condition, result.value.notes);
                        }
                    });
                }
            });
        }

        // Function untuk submit pengembalian
        function submitReturn(loanId, condition, notes) {
            // Show loading
            Swal.fire({
                title: 'Memproses...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/returns/${loanId}/process`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrfToken);
            
            const conditionInput = document.createElement('input');
            conditionInput.type = 'hidden';
            conditionInput.name = 'condition';
            conditionInput.value = condition;
            form.appendChild(conditionInput);
            
            const notesInput = document.createElement('input');
            notesInput.type = 'hidden';
            notesInput.name = 'notes';
            notesInput.value = notes;
            form.appendChild(notesInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Perpustakaan1_project\resources\views/dashboard/admin-returns.blade.php ENDPATH**/ ?>