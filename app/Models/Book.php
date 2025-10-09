<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'author', 'isbn', 'category_id', 'description',
        'stock', 'available', 'publisher', 'published_year', 'cover_image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
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