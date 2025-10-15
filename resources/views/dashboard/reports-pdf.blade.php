<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #6366f1;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #1e293b;
            margin: 0 0 5px 0;
            font-size: 24px;
        }
        
        .header p {
            color: #64748b;
            margin: 5px 0;
        }
        
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        
        .summary-row {
            display: table-row;
        }
        
        .summary-cell {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
        }
        
        .summary-value {
            font-size: 28px;
            font-weight: bold;
            color: #1e293b;
            margin: 0 0 5px 0;
        }
        
        .summary-label {
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
        }
        
        .table-container {
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        table thead {
            background: #6366f1;
            color: white;
        }
        
        table th {
            padding: 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
        }
        
        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
        }
        
        table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-borrowed {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .status-returned {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-overdue {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            color: #94a3b8;
            font-size: 10px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 LAPORAN PEMINJAMAN BUKU</h1>
        <p>Sistem Perpustakaan Digital</p>
        <p><strong>Periode:</strong> {{ $month }} {{ $year }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB</p>
    </div>
    
    <h2 class="section-title">Ringkasan Data</h2>
    <div class="summary">
        <div class="summary-row">
            <div class="summary-cell">
                <div class="summary-value">{{ $summary['total'] }}</div>
                <div class="summary-label">Total Peminjaman</div>
            </div>
            <div class="summary-cell">
                <div class="summary-value">{{ $summary['borrowed'] }}</div>
                <div class="summary-label">Sedang Dipinjam</div>
            </div>
            <div class="summary-cell">
                <div class="summary-value">{{ $summary['returned'] }}</div>
                <div class="summary-label">Dikembalikan</div>
            </div>
            <div class="summary-cell">
                <div class="summary-value">{{ $summary['overdue'] }}</div>
                <div class="summary-label">Terlambat</div>
            </div>
        </div>
    </div>
    
    <h2 class="section-title">Detail Peminjaman</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 12%">Tanggal</th>
                    <th style="width: 20%">Peminjam</th>
                    <th style="width: 30%">Judul Buku</th>
                    <th style="width: 12%">Jatuh Tempo</th>
                    <th style="width: 12%">Status</th>
                    <th style="width: 9%">Durasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $index => $loan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($loan->loan_date ?? $loan->request_date)->format('d M Y') }}</td>
                    <td>{{ $loan->user->name }}</td>
                    <td>{{ $loan->book->title }}</td>
                    <td>{{ $loan->due_date ? \Carbon\Carbon::parse($loan->due_date)->format('d M Y') : '-' }}</td>
                    <td>
                        <span class="status-badge status-{{ $loan->status }}">
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
                                    ->diffInDays(\Carbon\Carbon::now()->startOfDay());
                                echo $days . ' hari';
                            } else {
                                echo '-';
                            }
                        @endphp
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px; color: #94a3b8;">
                        Tidak ada data peminjaman untuk periode ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="footer">
        <p><strong>Catatan:</strong> Laporan ini digenerate secara otomatis oleh Sistem Perpustakaan Digital</p>
        <p>© {{ date('Y') }} Perpustakaan Digital. All rights reserved.</p>
    </div>
</body>
</html>
