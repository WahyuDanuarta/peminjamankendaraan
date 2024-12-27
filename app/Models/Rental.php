<?php

// app/Models/Rental.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory; // Menggunakan trait HasFactory untuk mendukung pembuatan model menggunakan factory

    // Menentukan kolom yang dapat diisi secara massal
    protected $fillable = ['vehicle_id', 'nama_peminjam', 'tanggal_peminjaman', 'tanggal_pengembalian', 'status'];

    // Mendefinisikan relasi banyak ke satu dengan model Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class); // Mengembalikan relasi ke model Vehicle
    }
}