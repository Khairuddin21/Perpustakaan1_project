<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Pustakawan - SisPerpus</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    @vite(['resources/css/dashboard.css'])
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <x-pustakawan-sidebar />

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <div class="reports-container">
                <div class="page-header">
                    <div class="header-left">
                        <a href="{{ route('dashboard') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <div class="header-text">
                            <h1><i class="fas fa-chart-bar"></i> Laporan & Statistik</h1>
                            <p>Ringkasan aktivitas peminjaman dan pengembalian</p>
                        </div>
                    </div>
                </div>

                <div class="filter-section">
                    <form method="GET" action="{{ route('pustakawan.reports') }}">
                        <div class="filter-grid">
                            <div class="filter-group">
                                <label class="filter-label"><i class="fas fa-calendar"></i> Bulan</label>
                                <select name="month" class="filter-input">
                                    <option value="">Semua</option>
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ \DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="filter-group">
                                <label class="filter-label"><i class="fas fa-calendar-alt"></i> Tahun</label>
                                <select name="year" class="filter-input">
                                    @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                        <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="filter-group">
                                <label class="filter-label"><i class="fas fa-filter"></i> Status</label>
                                <select name="status" class="filter-input">
                                    <option value="">Semua</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
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
                                <h3 class="stat-number">{{ $summary['total'] }}</h3>
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
                                <h3 class="stat-number">{{ $summary['borrowed'] }}</h3>
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
                                <h3 class="stat-number">{{ $summary['overdue'] }}</h3>
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
                                <h3 class="stat-number">{{ $summary['returned'] }}</h3>
                                <p class="stat-label">Dikembalikan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="padding: 1.5rem; border-radius: 1rem; background: #fff; margin-bottom: 1.5rem; border: 2px solid #e2e8f0;">
                    <h3 style="margin-bottom: 1rem; color: #1e293b;">Distribusi Status</h3>
                    <canvas id="statusChart" height="100"></canvas>
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
                                @forelse ($loans as $index => $loan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ optional($loan->loan_date ?? $loan->request_date)->format('d M Y, H:i') }}</td>
                                        <td>{{ $loan->user->name }}</td>
                                        <td>{{ $loan->book->title }}</td>
                                        <td>{{ $loan->due_date ? \Carbon\Carbon::parse($loan->due_date)->format('d M Y, H:i') : '-' }}</td>
                                        <td>
                                            <span class="status-badge {{ $loan->status }}">{{ ucfirst($loan->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align:center; color:#64748b; padding: 1rem;">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const chartData = @json($chartData);
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
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }
    </script>

    @vite(['resources/js/dashboard.js'])
</body>
</html>
