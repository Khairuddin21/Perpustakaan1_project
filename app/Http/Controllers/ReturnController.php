<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReturnController extends Controller
{
    public function index()
    {
        $borrowed_loans = Loan::with(['user', 'book'])
            ->active()
            ->orderBy('due_date', 'asc')
            ->paginate(10);

        return view('returns.index', compact('borrowed_loans'));
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
                'returned_by' => auth()->id()
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
            ->where('user_id', auth()->id())
            ->whereIn('status', ['borrowed', 'overdue'])
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
                ->where('user_id', auth()->id())
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
                'user_id' => auth()->id(),
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
                ->where('user_id', auth()->id())
                ->whereIn('status', ['borrowed', 'overdue'])
                ->whereNotNull('return_request_date')
                ->firstOrFail();

            // Clear return request data
            $loan->return_nis = null;
            $loan->return_borrower_name = null;
            $loan->return_notes = null;
            $loan->return_condition = null;
            $loan->return_request_date = null;
            $loan->save();

            Log::info('Return request cleared', [
                'user_id' => auth()->id(),
                'loan_id' => $request->loan_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Riwayat pengembalian berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            Log::error('Clear return request failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'loan_id' => $request->loan_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus riwayat: ' . $e->getMessage()
            ], 500);
        }
    }
}