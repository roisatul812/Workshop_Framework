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
    Schema::create('kunjungans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('toko_id')->constrained('tokos');
        $table->foreignId('user_id')->constrained('users');
        $table->decimal('latitude_sales', 10, 7);
        $table->decimal('longitude_sales', 10, 7);
        $table->decimal('accuracy_sales', 8, 2);
        $table->decimal('jarak_meter', 8, 2);
        $table->enum('status', ['diterima', 'ditolak']);
        $table->integer('threshold')->default(300);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
