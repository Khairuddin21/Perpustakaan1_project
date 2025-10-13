<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Make loan_date and due_date nullable
        DB::statement('ALTER TABLE loans MODIFY loan_date DATE NULL');
        DB::statement('ALTER TABLE loans MODIFY due_date DATE NULL');
        
        // Expand status enum to include pending and rejected, set default to pending
        DB::statement("ALTER TABLE loans MODIFY status ENUM('pending','borrowed','returned','overdue','rejected') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Revert status enum back to original and default borrowed
        DB::statement("ALTER TABLE loans MODIFY status ENUM('borrowed','returned','overdue') NOT NULL DEFAULT 'borrowed'");
        
        // Make loan_date and due_date NOT NULL again (set a fallback for existing nulls)
        DB::statement("UPDATE loans SET loan_date = COALESCE(loan_date, CURDATE()), due_date = COALESCE(due_date, CURDATE())");
        DB::statement('ALTER TABLE loans MODIFY loan_date DATE NOT NULL');
        DB::statement('ALTER TABLE loans MODIFY due_date DATE NOT NULL');
    }
};