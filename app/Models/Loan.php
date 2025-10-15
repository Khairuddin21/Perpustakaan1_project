<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'condition',
        'notes',
        'request_date',
        'approved_by',
        'approved_at',
        'nisn',
        'nis',
        'borrower_photo',
        'qr_data',
        'identification_method',
        'return_nis',
        'return_borrower_name',
        'return_notes',
        'return_request_date',
        'return_condition'
        ,'return_hidden'
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
        'request_date' => 'date',
        'approved_at' => 'datetime',
        'return_hidden' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Methods
    public function isOverdue()
    {
        if ($this->status === 'returned') {
            return false;
        }
        return Carbon::now()->gt($this->due_date);
    }

    public function getDaysOverdue()
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        return Carbon::now()->diffInDays($this->due_date);
    }

    public function getDaysBorrowed()
    {
        $endDate = $this->return_date ?? Carbon::now();
        return $this->loan_date->diffInDays($endDate);
    }

    // Scope untuk query
    public function scopeBorrowed($query)
    {
        return $query->where('status', 'borrowed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['borrowed', 'overdue']);
    }

    public function scopeRequests($query)
    {
        return $query->where('status', 'pending');
    }
}