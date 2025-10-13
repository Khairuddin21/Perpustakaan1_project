<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->timestamp('request_date')->nullable()->after('due_date');
            $table->unsignedBigInteger('approved_by')->nullable()->after('request_date');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            
            // Add foreign key constraint for approved_by
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['request_date', 'approved_by', 'approved_at']);
        });
    }
};
