<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'author', 'isbn', 'category_id', 'description',
        'stock', 'available', 'publisher', 'published_year', 'cover_image', 
        'pdf_file', 'created_by'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function ratings()
    {
        return $this->hasMany(BookRating::class);
    }

    public function comments()
    {
        return $this->hasMany(BookComment::class)->with('user')->latest();
    }

    public function wishlists()
    {
        return $this->hasMany(BookWishlist::class);
    }

    // Get average rating
    public function averageRating()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    // Get total ratings count
    public function ratingsCount()
    {
        return $this->ratings()->count();
    }

    // Check if book is available
    public function isAvailable()
    {
        return $this->available > 0;
    }

    // Get active loans
    public function activeLoan()
    {
        return $this->loans()->active()->first();
    }
}