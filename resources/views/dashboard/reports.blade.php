<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Peminjaman - {{ config('app.name', 'Sistem Perpustakaan') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Custom Styles -->
    @vite(['resources/css/dashboard.css'])
    
    <style>
        .reports-container {
            padding: 2rem;
        }
        
        .page-header {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }
        
        .header-left {
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
        
        .header-text h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .header-text h1 i {
            color: #6366f1;
        }
        
        .header-text p {
            color: #64748b;
            font-size: 1rem;
            margin: 0;
        }
        
        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-bottom: 2rem;
            border: 2px solid #e2e8f0;
        }
        
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            align-items: end;
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
        }
        
        .filter-input {
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
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
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }
        
        .btn-download {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        
        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        
        .btn-excel {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .btn-excel:hover {
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        
        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .summary-card {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }
        
        .summary-icon {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: white;
        }
        
        .summary-card.total .summary-icon {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
        }
        
        .summary-card.borrowed .summary-icon {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        
        .summary-card.returned .summary-icon {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        .summary-card.overdue .summary-icon {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        
        .summary-info {
            flex: 1;
        }
        
        .summary-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.25rem 0;
        }
        
        .summary-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 600;
        }
        
        .chart-section {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-bottom: 2rem;
            border: 2px solid #e2e8f0;
        }
        
        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        
        .chart-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .chart-title i {
            color: #6366f1;
        }
        
        .chart-container {
            position: relative;
            height: 400px;
        }
        
        .table-section {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 2px solid #e2e8f0;
        }
        
        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        
        .table-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .table-title i {
            color: #6366f1;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
        }
        
        .data-table thead {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        }
        
        .data-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .data-table td {
            padding: 1rem;
            color: #64748b;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .data-table tbody tr {
            transition: all 0.2s ease;
        }
        
        .data-table tbody tr:hover {
            background: #f8fafc;
        }
        
        .status-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }
        
        .status-badge.pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }
        
        .status-badge.borrowed {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
        }
        
        .status-badge.returned {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }
        
        .status-badge.overdue {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #94a3b8;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .empty-state h3 {
            font-size: 1.25rem;
            color: #64748b;
            margin: 0 0 0.5rem;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }
        
        .pagination-btn {
            padding: 0.5rem 1rem;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 0.5rem;
            color: #64748b;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover:not(:disabled) {
            border-color: #6366f1;
            color: #6366f1;
        }
        
        .pagination-btn.active {
            background: #6366f1;
            color: white;
            border-color: #6366f1;
        }
        
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .filter-grid {
                grid-template-columns: 1fr;
            }
            
            .chart-container {
                height: 300px;
            }
            
            .data-table {
                font-size: 0.875rem;
            }
            
            .data-table th,
            .data-table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        @include('components.admin-sidebar')
        
        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <div class="reports-container">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="header-left">
                        <a href="{{ route('dashboard') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <div class="header-text">
                            <h1>
                                <i class="fas fa-chart-line"></i>
                                Laporan Peminjaman Buku
                            </h1>
                            <p>Analisis dan statistik peminjaman perpustakaan</p>
                        </div>
                    </div>
                    <div class="header-actions">
                        <button class="btn-download btn-excel" onclick="downloadExcel()">
                            <i class="fas fa-file-excel"></i>
                            Download Excel
                        </button>
                        <button class="btn-download" onclick="downloadPDF()">
                            <i class="fas fa-file-pdf"></i>
                            Download PDF
                        </button>
                    </div>
                </div>
                
                <!-- Filter Section -->
                <div class="filter-section">
                    <form id="filterForm">
                        <div class="filter-grid">
                            <div class="filter-group">
                                <label class="filter-label">
                                    <i class="fas fa-calendar"></i>
                                    Bulan
                                </label>
                                <select class="filter-input" name="month" id="monthFilter">
                                    <option value="">Semua Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    Tahun
                                </label>
                                <select class="filter-input" name="year" id="yearFilter">
                                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                        <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label">
                                    <i class="fas fa-filter"></i>
                                    Status
                                </label>
                                <select class="filter-input" name="status" id="statusFilter">
                                    <option value="">Semua Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="borrowed">Dipinjam</option>
                                    <option value="returned">Dikembalikan</option>
                                    <option value="overdue">Terlambat</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <button type="submit" class="btn-filter">
                                    <i class="fas fa-search"></i>
                                    Terapkan Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Stats Summary -->
                <div class="stats-summary">
                    <div class="summary-card total">
                        <div class="summary-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="summary-info">
                            <h3 class="summary-value" id="totalLoans">{{ $summary['total'] ?? 0 }}</h3>
                            <p class="summary-label">Total Peminjaman</p>
                        </div>
                    </div>
                    <div class="summary-card borrowed">
                        <div class="summary-icon">
                            <i class="fas fa-hand-holding"></i>
                        </div>
                        <div class="summary-info">
                            <h3 class="summary-value" id="borrowedLoans">{{ $summary['borrowed'] ?? 0 }}</h3>
                            <p class="summary-label">Sedang Dipinjam</p>
                        </div>
                    </div>
                    <div class="summary-card returned">
                        <div class="summary-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="summary-info">
                            <h3 class="summary-value" id="returnedLoans">{{ $summary['returned'] ?? 0 }}</h3>
                            <p class="summary-label">Dikembalikan</p>
                        </div>
                    </div>
                    <div class="summary-card overdue">
                        <div class="summary-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="summary-info">
                            <h3 class="summary-value" id="overdueLoans">{{ $summary['overdue'] ?? 0 }}</h3>
                            <p class="summary-label">Terlambat</p>
                        </div>
                    </div>
                </div>
                
                <!-- Chart Section -->
                <div class="chart-section">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-chart-bar"></i>
                            Statistik Peminjaman
                        </h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="loanChart"></canvas>
                    </div>
                </div>
                
                <!-- Table Section -->
                <div class="table-section">
                    <div class="table-header">
                        <h3 class="table-title">
                            <i class="fas fa-table"></i>
                            Data Peminjaman
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table" id="loansTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Peminjam</th>
                                    <th>Buku</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Durasi</th>
                                </tr>
                            </thead>
                            <tbody id="loansTableBody">
                                @if($loans->count() > 0)
                                    @foreach($loans as $index => $loan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($loan->loan_date ?? $loan->request_date)->format('d M Y') }}</td>
                                        <td>{{ $loan->user->name }}</td>
                                        <td>{{ $loan->book->title }}</td>
                                        <td>{{ $loan->due_date ? \Carbon\Carbon::parse($loan->due_date)->format('d M Y') : '-' }}</td>
                                        <td>
                                            <span class="status-badge {{ $loan->status }}">
                                                {{ ucfirst($loan->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                if ($loan->loan_date && $loan->return_date) {
                                                    $days = \Carbon\Carbon::parse($loan->loan_date)->startOfDay()
                                                        ->diffInDays(\Carbon\Carbon::parse($loan->return_date)->startOfDay());
                                                    echo $days . ' hari';
                                                } elseif ($loan->loan_date) {
                                                    $days = \Carbon\Carbon::parse($loan->loan_date)->startOfDay()
                                                        ->diffInDays(now()->startOfDay());
                                                    echo $days . ' hari';
                                                } else {
                                                    echo '-';
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <i class="fas fa-inbox"></i>
                                                <h3>Tidak Ada Data</h3>
                                                <p>Belum ada data peminjaman untuk filter yang dipilih</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        let loanChart;
        
        // Initialize chart
        function initChart(labels, data) {
            const ctx = document.getElementById('loanChart').getContext('2d');
            
            if (loanChart) {
                loanChart.destroy();
            }
            
            loanChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: data,
                        backgroundColor: [
                            'rgba(99, 102, 241, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ],
                        borderColor: [
                            'rgba(99, 102, 241, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(239, 68, 68, 1)'
                        ],
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: '600'
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
        
        // Initialize chart with data
        @php
            $chartDataJson = $chartData ?? [
                'labels' => ['Pending', 'Dipinjam', 'Dikembalikan', 'Terlambat'],
                'data' => [0, 0, 0, 0]
            ];
        @endphp
        const chartData = @json($chartDataJson);
        initChart(chartData.labels, chartData.data);
        
        // Filter form submission
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const params = new URLSearchParams(formData);
            
            // Reload page with filter parameters
            window.location.href = `{{ route('admin.reports') }}?${params.toString()}`;
        });
        
        // Download PDF
        function downloadPDF() {
            const month = document.getElementById('monthFilter').value;
            const year = document.getElementById('yearFilter').value;
            const status = document.getElementById('statusFilter').value;
            
            const params = new URLSearchParams({
                month: month || '',
                year: year || '',
                status: status || ''
            });
            
            window.location.href = `{{ route('admin.reports.download') }}?${params.toString()}`;
        }
        
        // Download Excel
        function downloadExcel() {
            const month = document.getElementById('monthFilter').value;
            const year = document.getElementById('yearFilter').value;
            const status = document.getElementById('statusFilter').value;
            
            const params = new URLSearchParams({
                month: month || '',
                year: year || '',
                status: status || ''
            });
            
            window.location.href = `{{ route('admin.reports.download.excel') }}?${params.toString()}`;
        }
        
        // Menu toggle
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar')?.classList.toggle('active');
        });
    </script>
    
    @vite(['resources/js/dashboard.js'])
</body>
</html>
