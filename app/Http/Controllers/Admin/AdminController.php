<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Vehicle;
use App\Models\Rental;

class AdminController extends Controller
{
    // Menampilkan dashboard
    public function dashboard(Request $request)
    {
        // Ambil status dari request, default ke 'semua'
        $status = $request->input('status', 'semua');

        // Hitung total kendaraan berdasarkan status dan urutkan yang terbaru
        if ($status === 'tersedia') {
            $vehicles = Vehicle::where('status', 'tersedia')
                ->orderBy('created_at', 'desc') // Urutkan berdasarkan waktu input terbaru
                ->paginate(5);
        } elseif ($status === 'dipinjam') {
            $vehicles = Vehicle::where('status', 'dipinjam')
                ->orderBy('created_at', 'desc') // Urutkan berdasarkan waktu input terbaru
                ->paginate(5);
        } else {
            $vehicles = Vehicle::orderBy('created_at', 'desc') // Urutkan berdasarkan waktu input terbaru
                ->paginate(5);
        }

        // Hitung total kendaraan dan rental
        $total_vehicles = $vehicles->total();
        $total_rentals = Rental::count();
        $adminCount = Admin::count();

        // Kirim data ke view
        return view('pages.admin.dashboard', compact('adminCount', 'total_vehicles', 'total_rentals', 'status', 'vehicles'));
    }

    public function index()
    {
        $admins = Admin::all(); // Mengambil semua data admin
        return view('pages.admin.admin.index', compact('admins'));
    }

    // Menampilkan form untuk menambah admin baru
    public function create()
    {
        return view('pages.admin.admin.create');
    }

    // Menyimpan admin baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:6',
        ]);

        Admin::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Enkripsi password
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit admin
    public function edit($id)
    {
        $admin = Admin::findOrFail($id); // Ambil admin berdasarkan ID
        return view('pages.admin.admin.edit', compact('admin'));
    }

    // Memperbarui data admin di database
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id); // Ambil admin berdasarkan ID

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username,' . $id,
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];

        // Hanya update password jika diisi
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    // Menghapus admin
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id); // Ambil admin berdasarkan ID
        $admin->delete(); // Hapus admin

        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus.');
    }

    // Menampilkan detail admin
    public function show($id)
    {
        $admin = Admin::findOrFail($id); // Ambil admin berdasarkan ID
        return view('pages.admin.admin.detail', compact('admin'));
    }
}