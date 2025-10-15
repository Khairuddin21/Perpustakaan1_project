<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\BookRating;
use App\Models\BookComment;
use App\Models\BookWishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display all books for admin management
     */
    public function index(Request $request)
    {
        $query = Book::with('category');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by availability
        if ($request->has('availability') && $request->availability !== '') {
            if ($request->availability == 'available') {
                $query->where('available', '>', 0);
            } else {
                $query->where('available', 0);
            }
        }
        
        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $books = $query->paginate(12);
        $categories = Category::all();
        
        // Statistics
        $totalBooks = Book::count();
        $availableBooks = Book::where('available', '>', 0)->count();
        $totalStock = Book::sum('stock');
        $categoriesCount = Category::count();
        
        return view('dashboard.admin-books', compact(
            'books', 
            'categories',
            'totalBooks',
            'availableBooks',
            'totalStock',
            'categoriesCount'
        ));
    }
    
    /**
     * Store a newly created book
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books,isbn',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'required|string|max:255',
            'published_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image_url' => 'nullable|url'
        ]);
        
        $data = $request->all();
        $data['available'] = $request->stock;
        
        // Handle cover image upload or URL
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('Gambar'), $imageName);
            $data['cover_image'] = 'Gambar/' . $imageName;
        } elseif ($request->filled('cover_image_url')) {
            $data['cover_image'] = $request->cover_image_url;
        }
        
        $book = Book::create($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan',
            'book' => $book->load('category')
        ]);
    }
    
    /**
     * Display the specified book for editing
     */
    public function edit($id)
    {
        $book = Book::with('category')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'book' => $book
        ]);
    }
    
    /**
     * Update the specified book
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $id,
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'required|string|max:255',
            'published_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image_url' => 'nullable|url'
        ]);
        
        $data = $request->all();
        
        // Calculate available based on stock changes
        $stockDiff = $request->stock - $book->stock;
        $data['available'] = max(0, $book->available + $stockDiff);
        
        // Handle cover image upload or URL
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists and is local file
            if ($book->cover_image && !filter_var($book->cover_image, FILTER_VALIDATE_URL) && file_exists(public_path($book->cover_image))) {
                unlink(public_path($book->cover_image));
            }
            
            $image = $request->file('cover_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('Gambar'), $imageName);
            $data['cover_image'] = 'Gambar/' . $imageName;
        } elseif ($request->filled('cover_image_url')) {
            // Delete old image if exists and is local file
            if ($book->cover_image && !filter_var($book->cover_image, FILTER_VALIDATE_URL) && file_exists(public_path($book->cover_image))) {
                unlink(public_path($book->cover_image));
            }
            $data['cover_image'] = $request->cover_image_url;
        }
        
        $book->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil diperbarui',
            'book' => $book->load('category')
        ]);
    }
    
    /**
     * Remove the specified book
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        
        // Check if book has active loans
        $activeLoans = $book->loans()->whereIn('status', ['pending', 'approved'])->count();
        if ($activeLoans > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus buku yang sedang dipinjam'
            ], 422);
        }
        
        // Delete cover image if exists and is local file
        if ($book->cover_image && !filter_var($book->cover_image, FILTER_VALIDATE_URL) && file_exists(public_path($book->cover_image))) {
            unlink(public_path($book->cover_image));
        }
        
        $book->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus'
        ]);
    }
    /**
     * Display the specified book detail
     */
    public function show($id)
    {
        $book = Book::with(['category', 'ratings', 'comments.user'])->findOrFail($id);
        
        $user = Auth::user();
        
        // Get rating statistics
        $averageRating = $book->averageRating();
        $ratingsCount = $book->ratingsCount();
        
        // Get user's rating if exists
        $userRating = $user ? $book->ratings()->where('user_id', $user->id)->first() : null;
        
        // Check if user has wishlisted this book
        $isWishlisted = $user ? BookWishlist::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->exists() : false;
        
        // Get comments
        $comments = $book->comments;
        $commentsCount = $comments->count();
        
        return view('dashboard.book-detail', compact(
            'book',
            'averageRating',
            'ratingsCount',
            'userRating',
            'isWishlisted',
            'comments',
            'commentsCount'
        ));
    }

    /**
     * Rate a book
     */
    public function rateBook(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu'
            ], 401);
        }

        $book = Book::findOrFail($id);

        // Update or create rating
        $rating = BookRating::updateOrCreate(
            ['user_id' => $user->id, 'book_id' => $book->id],
            ['rating' => $request->rating]
        );

        return response()->json([
            'success' => true,
            'message' => 'Rating berhasil disimpan',
            'rating' => $rating,
            'average' => $book->averageRating(),
            'count' => $book->ratingsCount()
        ]);
    }

    /**
     * Toggle wishlist
     */
    public function toggleWishlist($id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu'
            ], 401);
        }

        $book = Book::findOrFail($id);

        $wishlist = BookWishlist::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $wishlisted = false;
            $message = 'Buku dihapus dari wishlist';
        } else {
            BookWishlist::create([
                'user_id' => $user->id,
                'book_id' => $book->id
            ]);
            $wishlisted = true;
            $message = 'Buku ditambahkan ke wishlist';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'wishlisted' => $wishlisted
        ]);
    }

    /**
     * Add comment
     */
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu'
            ], 401);
        }

        $book = Book::findOrFail($id);

        $comment = BookComment::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'comment' => $request->comment
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan',
            'comment' => $comment->load('user')
        ]);
    }

    /**
     * Get user's wishlist
     */
    public function getWishlist()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu'
            ], 401);
        }

        $wishlists = BookWishlist::with('book.category')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'wishlists' => $wishlists
        ]);
    }
}
