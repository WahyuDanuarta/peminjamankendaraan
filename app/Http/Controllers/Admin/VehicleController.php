<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vehicle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class VehicleController extends Controller
{
    // Menampilkan dashboard dengan total kendaraan
    public function dashboard()
    {
        $total_vehicles = Vehicle::count(); // Hitung total kendaraan

        return view('pages.admin.dashboard', compact('total_vehicles'));
    }

    // Menampilkan daftar kendaraan dengan pagination
    public function index(Request $request)
    {
        // Ambil semua kendaraan dan status peminjaman, urutkan berdasarkan created_at descending
        $vehicles = Vehicle::with(['rentals' => function($query) {
            $query->orderBy('created_at', 'desc'); // Mengambil rental terbaru
        }])
        ->orderBy('created_at', 'desc') // Urutkan kendaraan berdasarkan waktu pembuatan terbaru
        ->paginate(5); // Menampilkan 5 kendaraan per halaman

        confirmDelete('Hapus Data!', 'Apakah anda yakin ingin menghapus data ini?');
        return view('pages.admin.vehicles.index', compact('vehicles'));
    }

    // Menampilkan form untuk menambah kendaraan baru
    public function create()
    {
        return view('pages.admin.vehicles.create');
    }

    // Menyimpan kendaraan baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'jenis_kendaraan' => 'required|in:motor,mobil', // Validasi untuk jenis kendaraan
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ]);

        // Simpan kendaraan
        $vehicle = new Vehicle();
        $vehicle->nama_kendaraan = $request->nama_kendaraan;
        $vehicle->jenis_kendaraan = $request->jenis_kendaraan; // Simpan jenis kendaraan
        $vehicle->status = 'tersedia'; // Set status default
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/vehicles'), $imageName);
            $vehicle->image = $imageName; // Simpan nama file gambar ke database
        }
        $vehicle->save(); // Simpan data kendaraan ke database

        Alert::success('Berhasil!', 'Kendaraan berhasil ditambahkan.');
        return redirect()->route('admin.vehicles.index'); // Redirect ke halaman index kendaraan
    }

    // Menampilkan detail kendaraan
    public function detail(Vehicle $vehicle)
    {
        // Ambil status terakhir dari rentals
        $latestRental = $vehicle->rentals()->latest()->first();
        $status = $latestRental ? $latestRental->status : 'tersedia'; // Default ke 'tersedia' jika tidak ada rental

        return view('pages.admin.vehicles.detail', compact('vehicle', 'status'));
    }

    // Menampilkan form untuk mengedit kendaraan
    public function edit(Vehicle $vehicle)
    {
        return view('pages.admin.vehicles.edit', compact('vehicle'));
    }

    // Memperbarui data kendaraan yang sudah ada
    public function update(Request $request, Vehicle $vehicle)
    {
        // Validasi input
        $request->validate([
            'nama_kendaraan' => 'required|string',
            'jenis_kendaraan' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar tidak wajib
        ]);

        // Update data kendaraan
        $vehicle->nama_kendaraan = $request->nama_kendaraan;
        $vehicle->jenis_kendaraan = $request->jenis_kendaraan;

        // Cek apakah ada gambar baru yang diunggah
        if ($request->hasFile('image')) {
            // Path ke gambar lama
            $oldPath = public_path('images/' . $vehicle->image);
            
            // Cek apakah file gambar lama ada dan hapus
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }

            // Menyimpan gambar baru
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $vehicle->image = $imageName; // Simpan nama gambar baru
        }

        // Simpan perubahan
        $vehicle->save(); // Simpan perubahan data kendaraan ke database

        Alert::success('Berhasil!', 'Kendaraan berhasil diperbarui.'); // Tampilkan pesan sukses
        return redirect()->route('admin.vehicles.index'); // Redirect ke halaman index kendaraan
    }

    // Menghapus kendaraan dari database
    public function delete(Vehicle $vehicle)
    {
        // Path ke gambar kendaraan
        $oldPath = public_path('images/' . $vehicle->image);
        
        // Cek apakah file gambar ada dan hapus
        if (File::exists($oldPath)) {
            File::delete($oldPath); // Hapus gambar dari server
        }

        // Hapus kendaraan dari database
        $vehicle->delete();

        Alert::success('Berhasil!', 'Kendaraan berhasil dihapus'); // Tampilkan pesan sukses
        return redirect()->route('admin.vehicles.index'); // Redirect ke halaman index kendaraan
    }

    // Memfilter kendaraan berdasarkan status
    public function filter($status)
    {
        $vehicles = Vehicle::where('status', $status)->get(); // Ambil kendaraan berdasarkan status
        return view('pages.admin.vehicles.index', compact('vehicles')); // Tampilkan daftar kendaraan yang difilter
    }
}