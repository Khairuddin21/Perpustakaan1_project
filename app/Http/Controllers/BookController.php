<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookRating;
use App\Models\BookComment;
use App\Models\BookWishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
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
