<?php

// app/Models/Vehicle.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory; // Menggunakan trait HasFactory untuk mendukung pembuatan model menggunakan factory

    // Menentukan kolom yang dapat diisi secara massal
    protected $fillable = ['nama_kendaraan', 'jenis_kendaraan', 'image', 'status'];

    // Mendefinisikan relasi satu ke banyak dengan model Rental
    public function rentals()
    {
        return $this->hasMany(Rental::class); // Mengembalikan relasi ke model Rental
    }
}