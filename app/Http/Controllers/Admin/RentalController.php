<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rental;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RentalController extends Controller
{
    // Menampilkan daftar peminjaman dengan pagination
    public function index(Request $request)
    {
        // Ambil data rental dengan pengurutan berdasarkan tanggal peminjaman terbaru
        $rentals = Rental::with('vehicle')
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal peminjaman terbaru
            ->paginate(5); // Paginate dengan 5 data per halaman

        // Kirim data rentals ke view
        confirmDelete('Hapus Data!', 'Apakah anda yakin ingin menghapus data ini?');
        return view('pages.admin.rentals.index', compact('rentals'));
    }

    // Menampilkan form untuk menambah peminjaman baru
    public function create()
    {
        // Ambil kendaraan yang tersedia
        $vehicles = Vehicle::whereDoesntHave('rentals', function ($query) {
            $query->where('status', 'dipinjam'); // Ambil kendaraan yang tidak sedang dipinjam
        })->get();
        
        return view('pages.admin.rentals.create', compact('vehicles'));
    }
    
    // Menyimpan peminjaman baru ke database
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id', // Pastikan kendaraan yang dipilih ada
            'nama_peminjam' => 'required|string', // Nama peminjam harus diisi
            'tanggal_peminjaman' => 'required|date', // Tanggal peminjaman harus diisi
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman', // Tanggal pengembalian harus valid
        ], [
            'vehicle_id.required' => 'Kendaraan harus dipilih.',
            'vehicle_id.exists' => 'Kendaraan yang dipilih tidak valid.',
            'nama_peminjam.required' => 'Nama peminjam harus diisi.',
            'tanggal_peminjaman.required' => 'Tanggal peminjaman harus diisi.',
            'tanggal_pengembalian.required' => 'Tanggal pengembalian harus diisi.',
            'tanggal_pengembalian.after_or_equal' => 'Tanggal pengembalian harus sama dengan atau setelah tanggal peminjaman.',
        ]);

        // Jika validasi berhasil, simpan peminjaman
        $rental = Rental::create($request->all());

        // Update status kendaraan menjadi 'dipinjam'
        $vehicle = Vehicle::find($request->vehicle_id);
        $vehicle->update(['status' => 'dipinjam']); // Ubah status kendaraan

        Alert::success('Berhasil!', 'Peminjaman berhasil ditambahkan.');
        return redirect()->route('admin.rentals.index'); // Redirect ke halaman daftar peminjaman
    }

    // Menampilkan detail peminjaman
    public function detail(Rental $rental)
    {
        return view('pages.admin.rentals.detail', compact('rental')); // Tampilkan detail peminjaman
    }

    // Menampilkan form untuk mengedit peminjaman
    // Menampilkan form untuk mengedit peminjaman
public function edit(Rental $rental)
{
    $vehicles = Vehicle::all(); // Ambil semua kendaraan
    return view('pages.admin.rentals.edit', compact('rental', 'vehicles')); // Tampilkan form edit
}

// Memperbarui data peminjaman yang sudah ada
public function update(Request $request, Rental $rental)
{
    // Validasi input dari form
    $request->validate([
        'nama_peminjam' => 'required|string', // Nama peminjam harus diisi
        'tanggal_peminjaman' => 'required|date', // Tanggal peminjaman harus diisi
        'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman', // Tanggal pengembalian harus valid
        'status' => 'required|in:tersedia,dipinjam', // Status harus valid
    ]);

    // Simpan data rental dengan data baru
    $rental->update($request->except('vehicle_id')); // Mengabaikan vehicle_id agar tidak diubah

    // Ambil data kendaraan yang dipinjam
    $currentVehicle = Vehicle::find($rental->vehicle_id);

    // Perbarui status kendaraan
    if ($request->status === 'dipinjam') {
        $currentVehicle->update(['status' => 'dipinjam']); // Ubah status kendaraan menjadi dipinjam
    } else {
        $currentVehicle->update(['status' => 'tersedia']); // Ubah status kendaraan menjadi tersedia
    }

    Alert::success('Berhasil!', 'Peminjaman berhasil diperbarui.'); // Tampilkan pesan sukses
    return redirect()->route('admin.rentals.index'); // Redirect ke halaman daftar peminjaman
}

    // Menghapus peminjaman dari database
    public function delete(Rental $rental)
    {
        // Ambil kendaraan yang terkait dengan peminjaman
        $vehicle = Vehicle::find($rental->vehicle_id);

        // Hapus peminjaman dari database
        $rental->delete();

        // Perbarui status kendaraan menjadi 'tersedia'
        if ($vehicle) {
            $vehicle->update(['status' => 'tersedia']);
        }

        // Tampilkan pesan sukses
        Alert::success('Berhasil!', 'Peminjaman berhasil dihapus dan status kendaraan diperbarui menjadi tersedia.');
        
        // Redirect ke halaman daftar peminjaman
        return redirect()->route('admin.rentals.index'); // Kembali ke daftar peminjaman
    }
}