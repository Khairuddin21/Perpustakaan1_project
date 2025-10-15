<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportController extends Controller
{
    /**
     * Display the reports page
     */
    public function index(Request $request)
    {
        $query = Loan::with(['user', 'book']);
        
        // Filter by month
        if ($request->filled('month')) {
            $query->whereMonth('loan_date', $request->month);
        }
        
        // Filter by year
        if ($request->filled('year')) {
            $query->whereYear('loan_date', $request->year);
        } else {
            // Default to current year if no year specified
            $query->whereYear('loan_date', date('Y'));
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Order by date
        $query->orderBy('loan_date', 'desc');
        
        $loans = $query->get();
        
        // Calculate summary
        $summary = [
            'total' => $loans->count(),
            'borrowed' => $loans->where('status', 'borrowed')->count(),
            'returned' => $loans->where('status', 'returned')->count(),
            'overdue' => $loans->where('status', 'overdue')->count(),
            'pending' => $loans->where('status', 'pending')->count(),
        ];
        
        // Prepare chart data
        $chartData = [
            'labels' => ['Pending', 'Dipinjam', 'Dikembalikan', 'Terlambat'],
            'data' => [
                $summary['pending'],
                $summary['borrowed'],
                $summary['returned'],
                $summary['overdue']
            ]
        ];
        
        return view('dashboard.reports', compact('loans', 'summary', 'chartData'));
    }
    
    /**
     * Download report as PDF
     */
    public function download(Request $request)
    {
        $query = Loan::with(['user', 'book']);
        
        // Apply same filters as index
        if ($request->filled('month')) {
            $query->whereMonth('loan_date', $request->month);
        }
        
        if ($request->filled('year')) {
            $query->whereYear('loan_date', $request->year);
        } else {
            $query->whereYear('loan_date', date('Y'));
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $query->orderBy('loan_date', 'desc');
        
        $loans = $query->get();
        
        // Calculate summary
        $summary = [
            'total' => $loans->count(),
            'borrowed' => $loans->where('status', 'borrowed')->count(),
            'returned' => $loans->where('status', 'returned')->count(),
            'overdue' => $loans->where('status', 'overdue')->count(),
            'pending' => $loans->where('status', 'pending')->count(),
        ];
        
        // Filter details for filename
        $month = $request->month ? Carbon::create()->month($request->month)->format('F') : 'All';
        $year = $request->year ?? date('Y');
        $filename = "Laporan_Peminjaman_{$month}_{$year}.pdf";
        
        // Generate PDF using Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        
        // Load view and convert to HTML
        $html = view('dashboard.reports-pdf', compact('loans', 'summary', 'month', 'year'))->render();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        return $dompdf->stream($filename);
    }
    
    /**
     * Download report as Excel (CSV format)
     */
    public function downloadExcel(Request $request)
    {
        $query = Loan::with(['user', 'book']);
        
        // Apply same filters as index
        if ($request->filled('month')) {
            $query->whereMonth('loan_date', $request->month);
        }
        
        if ($request->filled('year')) {
            $query->whereYear('loan_date', $request->year);
        } else {
            $query->whereYear('loan_date', date('Y'));
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $query->orderBy('loan_date', 'desc');
        
        $loans = $query->get();
        
        // Calculate summary
        $summary = [
            'total' => $loans->count(),
            'borrowed' => $loans->where('status', 'borrowed')->count(),
            'returned' => $loans->where('status', 'returned')->count(),
            'overdue' => $loans->where('status', 'overdue')->count(),
            'pending' => $loans->where('status', 'pending')->count(),
        ];
        
        // Filter details for filename
        $month = $request->month ? Carbon::create()->month($request->month)->format('F') : 'All';
        $year = $request->year ?? date('Y');
        $filename = "Laporan_Peminjaman_{$month}_{$year}.csv";
        
        // Set headers for CSV download
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($loans, $summary, $month, $year) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header information
            fputcsv($file, ['LAPORAN PEMINJAMAN BUKU - SISTEM PERPUSTAKAAN DIGITAL']);
            fputcsv($file, ['Periode:', "$month $year"]);
            fputcsv($file, ['Tanggal Cetak:', Carbon::now()->format('d F Y, g:i A')]);
            fputcsv($file, []); // Empty row
            
            // Summary
            fputcsv($file, ['RINGKASAN DATA']);
            fputcsv($file, ['Total Peminjaman', $summary['total']]);
            fputcsv($file, ['Sedang Dipinjam', $summary['borrowed']]);
            fputcsv($file, ['Dikembalikan', $summary['returned']]);
            fputcsv($file, ['Terlambat', $summary['overdue']]);
            fputcsv($file, []); // Empty row
            
            // Table headers
            fputcsv($file, ['DETAIL PEMINJAMAN']);
            fputcsv($file, ['No', 'Tanggal Pinjam', 'Peminjam', 'Judul Buku', 'Penulis', 'Jatuh Tempo', 'Status', 'Durasi (hari)']);
            
            // Table data
            foreach ($loans as $index => $loan) {
                // Calculate duration
                $duration = '-';
                if ($loan->loan_date && $loan->return_date) {
                    $duration = Carbon::parse($loan->loan_date)->startOfDay()
                        ->diffInDays(Carbon::parse($loan->return_date)->startOfDay());
                } elseif ($loan->loan_date) {
                    $duration = Carbon::parse($loan->loan_date)->startOfDay()
                        ->diffInDays(Carbon::now()->startOfDay());
                }
                
                fputcsv($file, [
                    $index + 1,
                    Carbon::parse($loan->loan_date ?? $loan->request_date)->format('d M Y, g:i A'),
                    $loan->user->name,
                    $loan->book->title,
                    $loan->book->author ?? '-',
                    $loan->due_date ? Carbon::parse($loan->due_date)->format('d M Y, g:i A') : '-',
                    ucfirst($loan->status),
                    $duration
                ]);
            }
            
            fputcsv($file, []); // Empty row
            fputcsv($file, ['Laporan ini digenerate secara otomatis oleh Sistem Perpustakaan Digital']);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
