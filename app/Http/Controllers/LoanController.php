<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LoanController extends Controller
{
    /**
     * Request a loan for a book
     */
    public function requestLoan(Request $request)
    {
        try {
            Log::info('Request loan started', ['request' => $request->all()]);
            
            $request->validate([
                'book_id' => 'required|exists:books,id',
                'loan_duration' => 'required|integer|min:1|max:30',
                'notes' => 'nullable|string|max:500',
                'nisn' => 'nullable|string|max:20',
                'nis' => 'nullable|string|max:20',
                'borrower_photo' => 'required|string', // base64 image
                'qr_data' => 'nullable|string',
                'identification_method' => 'required|in:qr_scan,manual_input'
            ]);

            Log::info('Validation passed');
            
            // Validate that either NISN or NIS is provided, or QR data exists
            if ($request->identification_method === 'manual_input' && !$request->nisn && !$request->nis) {
                return response()->json([
                    'success' => false,
                    'message' => 'NISN atau NIS harus diisi untuk metode input manual.'
                ], 400);
            }
            
            if ($request->identification_method === 'qr_scan' && !$request->qr_data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data QR code harus ada untuk metode scan QR.'
                ], 400);
            }

            $book = Book::findOrFail($request->book_id);
            
            Log::info('Book found', ['book' => $book->title]);
            
            // Check if book is available
            if ($book->available <= 0) {
                Log::warning('Book not available', ['book_id' => $request->book_id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, buku ini sedang tidak tersedia.'
                ], 400);
            }

            // Check if user already has pending request for this book
            $existingRequest = Loan::where('user_id', Auth::id())
                                  ->where('book_id', $request->book_id)
                                  ->where('status', 'pending')
                                  ->exists();

            if ($existingRequest) {
                Log::warning('User already has pending request', ['user_id' => Auth::id(), 'book_id' => $request->book_id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mengajukan peminjaman untuk buku ini. Silakan tunggu persetujuan admin.'
                ], 400);
            }

            // Check if user already borrowed this book and not returned
            $activeLoan = Loan::where('user_id', Auth::id())
                              ->where('book_id', $request->book_id)
                              ->whereIn('status', ['borrowed', 'overdue'])
                              ->exists();

            if ($activeLoan) {
                Log::warning('User already borrowed this book', ['user_id' => Auth::id(), 'book_id' => $request->book_id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Anda masih meminjam buku ini. Silakan kembalikan terlebih dahulu.'
                ], 400);
            }

            // Check user's active loans limit (max 5 books)
            $activeLoansCount = Loan::where('user_id', Auth::id())
                                   ->whereIn('status', ['borrowed', 'overdue', 'pending'])
                                   ->count();

            if ($activeLoansCount >= 5) {
                Log::warning('User reached loan limit', ['user_id' => Auth::id(), 'count' => $activeLoansCount]);
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mencapai batas maksimum peminjaman (5 buku). Silakan kembalikan atau tunggu persetujuan yang lain.'
                ], 400);
            }

            Log::info('All checks passed, creating loan');

            // Process borrower photo (save base64 to storage)
            $photoPath = null;
            if ($request->borrower_photo) {
                try {
                    // Remove data:image/jpeg;base64, or similar prefix
                    $photo = $request->borrower_photo;
                    if (strpos($photo, 'data:image') === 0) {
                        $photo = substr($photo, strpos($photo, ',') + 1);
                    }
                    
                    // Decode base64
                    $photoData = base64_decode($photo);
                    
                    // Generate unique filename
                    $filename = 'borrower_' . Auth::id() . '_' . time() . '.jpg';
                    $photoPath = 'borrower_photos/' . $filename;
                    
                    // Save to storage
                    Storage::disk('public')->put($photoPath, $photoData);
                    
                    Log::info('Photo saved', ['path' => $photoPath]);
                } catch (\Exception $e) {
                    Log::error('Error saving photo', ['error' => $e->getMessage()]);
                    // Continue without photo if save fails
                }
            }

            // Create loan request
            $loan = Loan::create([
                'user_id' => Auth::id(),
                'book_id' => $request->book_id,
                'request_date' => Carbon::now(),
                'loan_date' => null,
                'due_date' => null,
                'status' => 'pending',
                'notes' => $request->notes,
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'borrower_photo' => $photoPath,
                'qr_data' => $request->qr_data,
                'identification_method' => $request->identification_method
            ]);

            Log::info('Loan created successfully', ['loan_id' => $loan->id]);

            return response()->json([
                'success' => true,
                'message' => 'Permintaan peminjaman berhasil diajukan. Admin akan segera memproses permintaan Anda.',
                'loan' => $loan->load('book')
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in requestLoan', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Get user's borrowed books
     */
    public function getBorrowedBooks()
    {
        $borrowedBooks = Loan::with(['book', 'book.category'])
                            ->where('user_id', Auth::id())
                            ->whereIn('status', ['borrowed', 'overdue'])
                            ->orderBy('loan_date', 'desc')
                            ->get();

        // Update overdue status
        foreach ($borrowedBooks as $loan) {
            if ($loan->status === 'borrowed' && Carbon::now()->gt($loan->due_date)) {
                $loan->update(['status' => 'overdue']);
            }
        }

        return response()->json([
            'success' => true,
            'borrowed_books' => $borrowedBooks->map(function ($loan) {
                $daysLeft = $loan->due_date ? Carbon::now()->diffInDays($loan->due_date, false) : 0;
                $status = 'borrowed';
                
                if ($loan->status === 'overdue' || $daysLeft < 0) {
                    $status = 'overdue';
                } elseif ($daysLeft <= 3) {
                    $status = 'due-soon';
                }

                return [
                    'id' => $loan->id,
                    'book' => $loan->book,
                    'loan_date' => $loan->loan_date->format('d M Y'),
                    'due_date' => $loan->due_date->format('d M Y'),
                    'days_left' => $daysLeft,
                    'status' => $status,
                    'status_text' => $this->getStatusText($status, $daysLeft),
                    'can_extend' => $this->canExtendLoan($loan)
                ];
            })
        ]);
    }

    /**
     * Get user's loan history
     */
    public function getLoanHistory(Request $request)
    {
        $query = Loan::with(['book', 'book.category'])
                    ->where('user_id', Auth::id());

        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search by book title if provided
        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('book', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            });
        }

        $loanHistory = $query->orderBy('created_at', 'desc')
                            ->paginate(10);

        return response()->json([
            'success' => true,
            'loan_history' => $loanHistory->map(function ($loan) {
                return [
                    'id' => $loan->id,
                    'book' => $loan->book,
                    'request_date' => $loan->request_date ? $loan->request_date->format('d M Y') : null,
                    'loan_date' => $loan->loan_date ? $loan->loan_date->format('d M Y') : null,
                    'due_date' => $loan->due_date ? $loan->due_date->format('d M Y') : null,
                    'return_date' => $loan->return_date ? $loan->return_date->format('d M Y') : null,
                    'status' => $loan->status,
                    'status_text' => $this->getHistoryStatusText($loan->status),
                    'duration' => $this->getLoanDuration($loan),
                    'notes' => $loan->notes
                ];
            }),
            'pagination' => [
                'current_page' => $loanHistory->currentPage(),
                'last_page' => $loanHistory->lastPage(),
                'per_page' => $loanHistory->perPage(),
                'total' => $loanHistory->total()
            ]
        ]);
    }

    /**
     * Extend loan duration
     */
    public function extendLoan(Request $request, $id)
    {
        $loan = Loan::where('id', $id)
                   ->where('user_id', Auth::id())
                   ->where('status', 'borrowed')
                   ->firstOrFail();

        // Check if loan can be extended (only once and not overdue)
        if ($loan->due_date < Carbon::now()) {
            return response()->json([
                'success' => false,
                'message' => 'Buku yang sudah terlambat tidak dapat diperpanjang.'
            ], 400);
        }

        // Check if already extended (you can add a field 'extended' to track this)
        // For now, we'll allow extension if due date is more than original loan period

        // Extend for 7 days
        $newDueDate = Carbon::parse($loan->due_date)->addDays(7);
        $loan->update(['due_date' => $newDueDate]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil diperpanjang 7 hari.',
            'new_due_date' => $newDueDate->format('d M Y')
        ]);
    }

    /**
     * Get pending loan requests (for admin)
     */
    public function getPendingRequests()
    {
        $pendingRequests = Loan::with(['user', 'book', 'book.category'])
                              ->where('status', 'pending')
                              ->orderBy('request_date', 'asc')
                              ->get();

        return response()->json([
            'success' => true,
            'pending_requests' => $pendingRequests
        ]);
    }

    /**
     * Approve loan request (for admin)
     */
    public function approveLoan(Request $request, $id)
    {
        // Make loan_duration optional, default to 7 days
        $request->validate([
            'loan_duration' => 'nullable|integer|min:1|max:30'
        ]);

        $loan = Loan::with('book')->findOrFail($id);

        if ($loan->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan peminjaman ini sudah diproses.'
            ], 400);
        }

        // Check book availability
        if ($loan->book->available <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak tersedia.'
            ], 400);
        }

        $duration = $request->loan_duration ?? 7; // Default 7 days

        DB::transaction(function () use ($loan, $duration) {
            // Update loan
            $loanDate = Carbon::now();
            $dueDate = $loanDate->copy()->addDays($duration);

            $loan->update([
                'status' => 'borrowed',
                'loan_date' => $loanDate,
                'due_date' => $dueDate,
                'approved_by' => Auth::id(),
                'approved_at' => Carbon::now()
            ]);

            // Update book availability
            $loan->book->decrement('available');
        });

        Log::info('Loan approved', ['loan_id' => $loan->id, 'admin' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan peminjaman berhasil disetujui.',
            'loan' => $loan->load('user', 'book')
        ]);
    }

    /**
     * Reject loan request (for admin)
     */
    public function rejectLoan(Request $request, $id)
    {
        // Make reason optional
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan peminjaman ini sudah diproses.'
            ], 400);
        }

        $rejectionNote = $request->reason 
            ? $request->reason . ' (Ditolak oleh admin)' 
            : 'Ditolak oleh admin';

        $loan->update([
            'status' => 'rejected',
            'notes' => $rejectionNote
        ]);

        Log::info('Loan rejected', ['loan_id' => $loan->id, 'admin' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan peminjaman berhasil ditolak.',
            'loan' => $loan->load('user', 'book')
        ]);
    }

    /**
     * Helper functions
     */
    private function getStatusText($status, $daysLeft)
    {
        switch ($status) {
            case 'overdue':
                return 'Terlambat ' . abs($daysLeft) . ' hari';
            case 'due-soon':
                return $daysLeft == 0 ? 'Jatuh tempo hari ini' : $daysLeft . ' hari lagi';
            case 'borrowed':
                return $daysLeft . ' hari lagi';
            default:
                return 'Dipinjam';
        }
    }

    private function getHistoryStatusText($status)
    {
        $statusTexts = [
            'pending' => 'Menunggu Persetujuan',
            'borrowed' => 'Sedang Dipinjam',
            'returned' => 'Sudah Dikembalikan',
            'overdue' => 'Terlambat',
            'rejected' => 'Ditolak'
        ];

        return $statusTexts[$status] ?? $status;
    }

    private function getLoanDuration($loan)
    {
        if ($loan->loan_date && $loan->return_date) {
            return $loan->loan_date->diffInDays($loan->return_date) . ' hari';
        } elseif ($loan->loan_date && $loan->due_date) {
            return $loan->loan_date->diffInDays($loan->due_date) . ' hari (rencana)';
        }
        return '-';
    }

    private function canExtendLoan($loan)
    {
        // Can extend if not overdue and due date is within 3 days
        $daysLeft = Carbon::now()->diffInDays($loan->due_date, false);
        return $daysLeft >= 0 && $daysLeft <= 3;
    }

    /**
     * Get all loan requests for admin
     */
    public function getAllLoanRequests()
    {
        try {
            $loans = Loan::with(['user', 'book', 'book.category'])
                        ->orderByRaw("CASE 
                            WHEN status = 'pending' THEN 1
                            WHEN status = 'borrowed' THEN 2
                            WHEN status = 'overdue' THEN 3
                            ELSE 4 
                        END")
                        ->orderBy('request_date', 'desc')
                        ->get();

            return response()->json([
                'success' => true,
                'loans' => $loans
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching loan requests', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data peminjaman'
            ], 500);
        }
    }

    /**

    /**
     * Show loan requests page for admin
     */
    public function showLoanRequests()
    {
        return view('dashboard.loan-requests');
    }
}
