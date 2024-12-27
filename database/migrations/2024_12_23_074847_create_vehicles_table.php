<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kendaraan');
            $table->enum('jenis_kendaraan', ['motor', 'mobil']);
            $table->string('image')->nullable(); // Menambahkan kolom untuk menyimpan nama file gambar
            $table->enum('status', ['tersedia', 'dipinjam'])->default('tersedia'); // Menambahkan kolom status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};