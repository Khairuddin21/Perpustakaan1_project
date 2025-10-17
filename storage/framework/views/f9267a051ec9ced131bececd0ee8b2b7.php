<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Laporan Pustakawan - <?php echo e(config('app.name', 'Sistem Perpustakaan')); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Custom Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/dashboard.css']); ?>
    
    <style>
        .loan-requests-container {
            padding: 2rem;
        }
        
        .page-header {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            background: white;
            color: #6366f1;
            border: 2px solid #6366f1;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(99, 102, 241, 0.1);
        }
        
        .btn-back:hover {
            background: #6366f1;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .header-text {
            flex: 1;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .page-title i {
            color: #6366f1;
        }
        
        .page-subtitle {
            color: #64748b;
            font-size: 1rem;
        }

        /* Filter Section Styles */
        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            border: 2px solid #e2e8f0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-label i {
            color: #6366f1;
            font-size: 0.875rem;
        }

        .filter-input {
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .filter-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .btn-filter {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }

        /* Stats Grid Styles */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            --stat-color: #6366f1;
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            border: 2px solid #e2e8f0;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--stat-color);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border-color: var(--stat-color);
        }

        .stat-content {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: white;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
        }

        .stat-info {
            flex: 1;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        /* Card Styles */
        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            border: 2px solid #e2e8f0;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .data-table thead {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        }

        .data-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 700;
            color: #1e293b;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
        }

        .data-table tbody tr {
            transition: all 0.2s ease;
        }

        .data-table tbody tr:hover {
            background: #f8fafc;
        }

        .status-badge {
            padding: 0.375rem 1rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .status-badge i {
            font-size: 0.625rem;
        }

        .status-badge.pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            border: 2px solid #fbbf24;
        }

        .status-badge.borrowed {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            border: 2px solid #3b82f6;
        }

        .status-badge.returned {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border: 2px solid #10b981;
        }

        .status-badge.overdue {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border: 2px solid #ef4444;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .loan-requests-container {
                padding: 1rem;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .data-table {
                font-size: 0.875rem;
            }

            .data-table th,
            .data-table td {
                padding: 0.75rem;
            }
        }
    </style>
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
                    
                    <h1 class="header-title">Laporan & Statistik</h1>
                    
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
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="loan-requests-container">
                <div class="page-header">
                    <div class="header-text">
                        <h2 class="page-title"><i class="fas fa-chart-bar"></i> Laporan & Statistik</h2>
                        <p class="page-subtitle">Ringkasan aktivitas peminjaman dan pengembalian</p>
                    </div>
                </div>

                <div class="filter-section">
                    <form method="GET" action="<?php echo e(route('pustakawan.reports')); ?>">
                        <div class="filter-grid">
                            <div class="filter-group">
                                <label class="filter-label"><i class="fas fa-calendar"></i> Bulan</label>
                                <select name="month" class="filter-input">
                                    <option value="">Semua</option>
                                    <?php for($m = 1; $m <= 12; $m++): ?>
                                        <option value="<?php echo e($m); ?>" <?php echo e(request('month') == $m ? 'selected' : ''); ?>><?php echo e(\DateTime::createFromFormat('!m', $m)->format('F')); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="filter-group">
                                <label class="filter-label"><i class="fas fa-calendar-alt"></i> Tahun</label>
                                <select name="year" class="filter-input">
                                    <?php for($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                                        <option value="<?php echo e($y); ?>" <?php echo e(request('year', date('Y')) == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="filter-group">
                                <label class="filter-label"><i class="fas fa-filter"></i> Status</label>
                                <select name="status" class="filter-input">
                                    <option value="">Semua</option>
                                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                    <option value="borrowed" <?php echo e(request('status') == 'borrowed' ? 'selected' : ''); ?>>Dipinjam</option>
                                    <option value="returned" <?php echo e(request('status') == 'returned' ? 'selected' : ''); ?>>Dikembalikan</option>
                                    <option value="overdue" <?php echo e(request('status') == 'overdue' ? 'selected' : ''); ?>>Terlambat</option>
                                </select>
                            </div>

                            <div class="filter-group">
                                <button type="submit" class="btn-filter" style="width: 100%;">
                                    <i class="fas fa-search"></i>
                                    Terapkan Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-icon">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number"><?php echo e($summary['total']); ?></h3>
                                <p class="stat-label">Total Transaksi</p>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card" style="--stat-color: #6366f1;">
                        <div class="stat-content">
                            <div class="stat-icon" style="background:#6366f1; box-shadow: 0 4px 14px rgba(99,102,241,0.4);">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number"><?php echo e($summary['borrowed']); ?></h3>
                                <p class="stat-label">Sedang Dipinjam</p>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card" style="--stat-color: #ef4444;">
                        <div class="stat-content">
                            <div class="stat-icon" style="background:#ef4444; box-shadow: 0 4px 14px rgba(239,68,68,0.4);">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number"><?php echo e($summary['overdue']); ?></h3>
                                <p class="stat-label">Terlambat</p>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card" style="--stat-color: #10b981;">
                        <div class="stat-content">
                            <div class="stat-icon" style="background:#10b981; box-shadow: 0 4px 14px rgba(16,185,129,0.4);">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-number"><?php echo e($summary['returned']); ?></h3>
                                <p class="stat-label">Dikembalikan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="padding: 1.5rem; border-radius: 1rem; background: #fff; margin-bottom: 1.5rem; border: 2px solid #e2e8f0;">
                    <h3 style="margin-bottom: 1rem; color: #1e293b;">Distribusi Status</h3>
                    <div style="max-width: 400px; margin: 0 auto;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <div class="card" style="padding: 1.5rem; border-radius: 1rem; background: #fff; border: 2px solid #e2e8f0;">
                    <h3 style="margin-bottom: 1rem; color: #1e293b;">Detail Peminjaman</h3>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Peminjam</th>
                                    <th>Judul Buku</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td><?php echo e(optional($loan->loan_date ?? $loan->request_date)->format('d M Y, H:i')); ?></td>
                                        <td><?php echo e($loan->user->name); ?></td>
                                        <td><?php echo e($loan->book->title); ?></td>
                                        <td><?php echo e($loan->due_date ? \Carbon\Carbon::parse($loan->due_date)->format('d M Y, H:i') : '-'); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo e($loan->status); ?>"><?php echo e(ucfirst($loan->status)); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" style="text-align:center; color:#64748b; padding: 1rem;">Tidak ada data</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const chartData = <?php echo json_encode($chartData, 15, 512) ?>;
        const ctx = document.getElementById('statusChart');
        if (ctx && chartData) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Jumlah',
                        data: chartData.data,
                        backgroundColor: ['#f59e0b', '#6366f1', '#10b981', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/dashboard.js']); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PERPUSTAKAAN\resources\views/dashboard/pustakawan-reports.blade.php ENDPATH**/ ?>