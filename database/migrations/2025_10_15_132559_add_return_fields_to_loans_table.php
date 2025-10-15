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
            $table->string('return_nis')->nullable()->after('identification_method');
            $table->string('return_borrower_name')->nullable()->after('return_nis');
            $table->text('return_notes')->nullable()->after('return_borrower_name');
            $table->timestamp('return_request_date')->nullable()->after('return_notes');
            $table->enum('return_condition', ['baik', 'rusak_ringan', 'rusak_berat'])->nullable()->after('return_request_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['return_nis', 'return_borrower_name', 'return_notes', 'return_request_date', 'return_condition']);
        });
    }
};
