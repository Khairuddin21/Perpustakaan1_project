<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReturnController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Jika admin atau pustakawan, tampilkan semua buku yang dipinjam
        if (in_array($user->role, ['admin', 'pustakawan'])) {
            $borrowedBooks = Loan::with(['book', 'user'])
                ->whereIn('status', ['borrowed', 'overdue'])
                ->where('return_hidden', false)
                ->orderBy('due_date', 'asc')
                ->get();
        } else {
            // Jika user biasa, tampilkan hanya buku miliknya
            $borrowedBooks = Loan::with(['book'])
                ->where('user_id', $user->id)
                ->whereIn('status', ['borrowed', 'overdue'])
                ->where('return_hidden', false)
                ->orderBy('due_date', 'asc')
                ->get();
        }

        return view('dashboard.returns', compact('borrowedBooks'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $borrowed_loans = Loan::with(['user', 'book'])
            ->active()
            ->where(function($query) use ($search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('book', function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->orderBy('due_date', 'asc')
            ->paginate(10);

        return view('returns.index', compact('borrowed_loans', 'search'));
    }

    public function show($id)
    {
        $loan = Loan::with(['user', 'book'])->findOrFail($id);
        
        if ($loan->status === 'returned') {
            return redirect()->route('returns.index')
                ->with('error', 'Buku ini sudah dikembalikan.');
        }

        $days_borrowed = $loan->getDaysBorrowed();
        $is_overdue = $loan->isOverdue();
        $days_overdue = $loan->getDaysOverdue();

        return view('returns.show', compact('loan', 'days_borrowed', 'is_overdue', 'days_overdue'));
    }

    public function process(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
            'condition' => 'required|in:good,damaged,lost'
        ]);

        DB::beginTransaction();
        
        try {
            $loan = Loan::with('book')->findOrFail($id);
            
            // Validasi status
            if ($loan->status === 'returned') {
                DB::rollBack();
                return redirect()->route('returns.index')
                    ->with('error', 'Buku ini sudah dikembalikan.');
            }

            // Update loan record
            $loan->return_date = Carbon::now();
            $loan->status = 'returned';
            $loan->condition = $request->input('condition');
            $loan->notes = $request->input('notes');
            
            if (!$loan->save()) {
                throw new \Exception('Gagal menyimpan data pengembalian');
            }

            // Update book availability
            $book = $loan->book;
            $book->available = $book->available + 1;
            
            // Validasi stok
            if ($book->available > $book->stock) {
                throw new \Exception('Stok buku melebihi total stok yang tersedia');
            }
            
            if (!$book->save()) {
                throw new \Exception('Gagal mengupdate ketersediaan buku');
            }

            // Log activity
            Log::info('Book returned', [
                'loan_id' => $loan->id,
                'book_id' => $book->id,
                'user_id' => $loan->user_id,
                'condition' => $loan->condition,
                'returned_by' => Auth::id()
            ]);

            DB::commit();

            return redirect()->route('returns.index')
                ->with('success', "Buku '{$book->title}' berhasil dikembalikan.");

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Return process failed', [
                'loan_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function history(Request $request)
    {
        $query = Loan::with(['user', 'book'])
            ->returned();

        // Filter by date if provided
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('return_date', '>=', $request->from_date);
        }
        
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('return_date', '<=', $request->to_date);
        }

        $returned_loans = $query->orderBy('return_date', 'desc')
            ->paginate(15);

        return view('returns.history', compact('returned_loans'));
    }

    /**
     * Show return page for logged-in user
     */
    public function userReturns()
    {
        $borrowedBooks = Loan::with(['book'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['borrowed', 'overdue'])
            ->where('return_hidden', false)
            ->orderBy('due_date', 'asc')
            ->get();

        return view('dashboard.returns', compact('borrowedBooks'));
    }

    /**
     * Submit return request from user
     */
    public function submitReturn(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'return_nis' => 'required|string|max:50',
            'return_borrower_name' => 'required|string|max:255',
            'return_notes' => 'nullable|string|max:500',
            'return_condition' => 'required|in:baik,rusak_ringan,rusak_berat'
        ]);

        try {
            $loan = Loan::where('id', $request->loan_id)
                ->where('user_id', Auth::id())
                ->whereIn('status', ['borrowed', 'overdue'])
                ->firstOrFail();

            // Update loan with return request information
            $loan->return_nis = $request->return_nis;
            $loan->return_borrower_name = $request->return_borrower_name;
            $loan->return_notes = $request->return_notes;
            $loan->return_condition = $request->return_condition;
            $loan->return_request_date = Carbon::now();
            $loan->save();

            return response()->json([
                'success' => true,
                'message' => 'Permintaan pengembalian berhasil diajukan. Silakan datang ke perpustakaan untuk mengembalikan buku.'
            ]);

        } catch (\Exception $e) {
            Log::error('Return request failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'loan_id' => $request->loan_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengajukan pengembalian: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear/delete return request from user
     */
    public function clearReturnRequest(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id'
        ]);

        try {
            $loan = Loan::where('id', $request->loan_id)
                ->where('user_id', Auth::id())
                ->whereIn('status', ['borrowed', 'overdue'])
                ->whereNotNull('return_request_date')
                ->firstOrFail();

            // Mark this return as hidden for the user (keeps full data in DB for admins)
            $loan->return_hidden = true;
            $loan->save();

            Log::info('Return request cleared', [
                'user_id' => Auth::id(),
                'loan_id' => $request->loan_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Riwayat pengembalian berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            Log::error('Clear return request failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'loan_id' => $request->loan_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus riwayat: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show admin returns page with all active loans
     * Khusus untuk admin, bukan pustakawan
     */
    public function adminIndex()
    {
        $borrowedLoans = Loan::with(['user', 'book'])
            ->active()
            ->orderBy('due_date', 'asc')
            ->paginate(15);

        $totalLoans = Loan::active()->count();

        return view('dashboard.admin-returns', compact('borrowedLoans', 'totalLoans'));
    }

    /**
     * Search loans in admin returns page
     * Khusus untuk admin
     */
    public function adminSearch(Request $request)
    {
        $search = $request->input('search');
        
        $borrowedLoans = Loan::with(['user', 'book'])
            ->active()
            ->where(function($query) use ($search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('book', function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->orderBy('due_date', 'asc')
            ->paginate(15);

        $totalLoans = $borrowedLoans->total();

        return view('dashboard.admin-returns', compact('borrowedLoans', 'totalLoans'));
    }

    /**
     * Process return from admin page
     * Khusus untuk admin
     */
    public function adminProcess(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
            'condition' => 'required|in:good,damaged,lost'
        ]);

        DB::beginTransaction();
        
        try {
            $loan = Loan::with('book')->findOrFail($id);
            
            // Validasi status
            if ($loan->status === 'returned') {
                DB::rollBack();
                return redirect()->route('admin.returns.index')
                    ->with('error', 'Buku ini sudah dikembalikan.');
            }

            // Cek apakah ada notes dari user yang perlu digabung
            $adminNotes = $request->input('notes');
            if ($loan->return_notes && $adminNotes) {
                // Gabungkan notes dari user dan admin
                $combinedNotes = "Request User: " . $loan->return_notes . " | Admin: " . $adminNotes;
            } else {
                $combinedNotes = $adminNotes ?: $loan->return_notes;
            }

            // Update loan record - SET STATUS RETURNED untuk menghilangkan dari active()
            $loan->return_date = Carbon::now();
            $loan->status = 'returned'; // PENTING: Ini membuat loan hilang dari daftar aktif
            $loan->condition = $request->input('condition');
            $loan->notes = $combinedNotes;
            
            if (!$loan->save()) {
                throw new \Exception('Gagal menyimpan data pengembalian');
            }

            // Update book availability
            $book = $loan->book;
            $book->available = $book->available + 1;
            
            // Validasi stok
            if ($book->available > $book->stock) {
                throw new \Exception('Stok buku melebihi total stok yang tersedia');
            }
            
            if (!$book->save()) {
                throw new \Exception('Gagal mengupdate ketersediaan buku');
            }

            // Log activity dengan detail lengkap
            Log::info('Book returned by admin', [
                'loan_id' => $loan->id,
                'book_id' => $book->id,
                'book_title' => $book->title,
                'user_id' => $loan->user_id,
                'user_name' => $loan->user->name,
                'condition' => $loan->condition,
                'return_date' => $loan->return_date->format('Y-m-d H:i:s'),
                'loan_date' => $loan->loan_date->format('Y-m-d'),
                'was_request' => $loan->return_request_date ? true : false,
                'returned_by_admin_id' => Auth::id(),
                'admin_name' => Auth::user()->name
            ]);

            DB::commit();

            return redirect()->route('admin.returns.index')
                ->with('success', "Buku '{$book->title}' berhasil dikembalikan. Buku telah masuk ke laporan dan stok tersedia diperbarui.");

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Admin return process failed', [
                'loan_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'admin_id' => Auth::id()
            ]);
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}