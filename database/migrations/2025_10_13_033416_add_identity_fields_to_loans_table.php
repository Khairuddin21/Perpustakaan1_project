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
            $table->string('nisn', 20)->nullable()->after('notes')->comment('Nomor Induk Siswa Nasional');
            $table->string('nis', 20)->nullable()->after('nisn')->comment('Nomor Induk Siswa');
            $table->text('borrower_photo')->nullable()->after('nis')->comment('Base64 encoded photo of borrower');
            $table->text('qr_data')->nullable()->after('borrower_photo')->comment('QR code scan data');
            $table->enum('identification_method', ['qr_scan', 'manual_input'])->default('manual_input')->after('qr_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['nisn', 'nis', 'borrower_photo', 'qr_data', 'identification_method']);
        });
    }
};
