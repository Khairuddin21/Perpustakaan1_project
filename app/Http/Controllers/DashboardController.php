<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $stats = [
                'total_books' => Book::count(),
                'total_users' => User::where('role', 'anggota')->count(),
                'total_loans' => Loan::where('status', 'borrowed')->count(),
                'total_categories' => Category::count(),
            ];
            return view('dashboard.admin', compact('stats'));
        } elseif ($user->isPustakawan()) {
            $stats = [
                'total_loans' => Loan::where('status', 'borrowed')->count(),
                'overdue_loans' => Loan::where('status', 'overdue')->count(),
                'returned_today' => Loan::whereDate('return_date', today())->count(),
            ];
            return view('dashboard.pustakawan', compact('stats'));
        } else {
            $active_loans = Loan::where('user_id', $user->id)
                               ->where('status', 'borrowed')
                               ->with('book')
                               ->get();
            $loan_history = Loan::where('user_id', $user->id)
                               ->with('book')
                               ->orderBy('created_at', 'desc')
                               ->limit(10)
                               ->get();
            
            // Get featured books for browsing
            $featured_books = Book::with('category')
                                 ->where('available', '>', 0)
                                 ->orderBy('created_at', 'desc')
                                 ->limit(8)
                                 ->get();
            
            // Get all categories for filtering with book counts
            $categories = Category::withCount(['books' => function($query) {
                $query->where('available', '>', 0);
            }])->orderBy('name')->get();
            
            return view('dashboard.anggota', compact('active_loans', 'loan_history', 'featured_books', 'categories'));
        }
    }
    
    public function browse(Request $request)
    {
        try {
            $query = Book::with('category');
            
            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%")
                      ->orWhere('isbn', 'like', "%{$search}%");
                });
            }
            
            // Category filter
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }
            
            // Status filter
            if ($request->filled('status')) {
                if ($request->status === 'available') {
                    $query->where('available', '>', 0);
                } elseif ($request->status === 'unavailable') {
                    $query->where('available', '<=', 0);
                }
            }
            
            // Sorting
            $sort = $request->get('sort', 'newest');
            switch ($sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'title':
                    $query->orderBy('title', 'asc');
                    break;
                case 'author':
                    $query->orderBy('author', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
            
            $books = $query->paginate(12);
            
            // Get categories with book count
            $categories = Category::withCount('books')->get();
            
            // Get user's active loans for sidebar notification
            $active_loans = Loan::where('user_id', Auth::id())
                               ->where('status', 'borrowed')
                               ->with('book')
                               ->get();
                               
            return view('dashboard.browse', compact('books', 'categories', 'active_loans'));
            
        } catch (\Exception $e) {
            Log::error('Error in browse method: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Terjadi kesalahan saat memuat halaman');
        }
    }
    
    public function search(Request $request)
    {
        $query = $request->get('q');
        $book_id = $request->get('id');
        
        if ($book_id) {
            // Search by book ID
            $book = Book::with('category')->where('id', $book_id)->where('available', '>', 0)->first();
            if ($book) {
                return response()->json(['book' => $book]);
            }
            return response()->json(['error' => 'Buku tidak ditemukan atau tidak tersedia'], 404);
        }
        
        if ($query) {
            $books = Book::with('category')
                        ->where('available', '>', 0)
                        ->where(function($q) use ($query) {
                            $q->where('title', 'like', '%' . $query . '%')
                              ->orWhere('author', 'like', '%' . $query . '%')
                              ->orWhere('isbn', 'like', '%' . $query . '%')
                              ->orWhere('description', 'like', '%' . $query . '%');
                        })
                        ->orderBy('title')
                        ->limit(8)
                        ->get();
            
            return response()->json([
                'books' => $books,
                'total' => $books->count()
            ]);
        }
        
        return response()->json(['books' => [], 'total' => 0]);
    }
    
    public function show($id)
    {
        try {
            $book = Book::with('category')->findOrFail($id);
            $user = Auth::user();
            
            // Check if user already has an active loan for this book
            $hasActiveLoan = Loan::where('user_id', $user->id)
                                ->where('book_id', $id)
                                ->where('status', 'borrowed')
                                ->exists();
            
            return view('dashboard.book-detail', compact('book', 'hasActiveLoan'));
        } catch (\Exception $e) {
            Log::error('Error in book show method: ' . $e->getMessage());
            return redirect()->route('books.browse')->with('error', 'Buku tidak ditemukan');
        }
    }

    public function getBookDetails($id)
    {
        try {
            $book = Book::with('category')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'book' => [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'isbn' => $book->isbn,
                    // DB uses published_year; keep both keys for backward compatibility in the UI
                    'publication_year' => $book->published_year,
                    'published_year' => $book->published_year,
                    'stock' => $book->stock,
                    'available' => $book->available,
                    'cover_image' => $book->cover_image,
                    'description' => $book->description,
                    'category' => $book->category
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting book details: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan'
            ], 404);
        }
    }
}