@extends('layouts.admin.main')
@section('title', 'Edit Peminjaman')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Peminjaman</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item">
                    <a href="{{ route('admin.rentals.index') }}">Peminjaman</a>
                </div>
                <div class="breadcrumb-item">Edit Peminjaman</div>
            </div>
        </div>

        <a href="{{ route('admin.rentals.index') }}" class="btn btn-warning">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <div class="card mt-4">
            <form action="{{ route('admin.rentals.update', $rental->id) }}" method="POST" class="needs-validation" novalidate="">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <!-- Nama Kendaraan -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="vehicle_id">Nama Kendaraan</label>
                                <select id="vehicle_id" class="form-control" name="vehicle_id" required disabled>
                                    <option value="">Pilih Kendaraan</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ $vehicle->id == $rental->vehicle_id ? 'selected' : '' }}>
                                            {{ $vehicle->nama_kendaraan }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Kolom ini harus diisi!
                                </div>
                            </div>
                        </div>

                        <!-- Nama Peminjam -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nama_peminjam">Nama Peminjam</label>
                                <input id="nama_peminjam" type="text" class="form-control" name="nama_peminjam" value="{{ $rental->nama_peminjam }}" required>
                                <div class="invalid-feedback">
                                    Kolom ini harus diisi!
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal Peminjaman -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="tanggal_peminjaman">Tanggal Peminjaman</label>
                                <input id="tanggal_peminjaman" type="date" class="form-control" name="tanggal_peminjaman" value="{{ \Carbon\Carbon::parse($rental->tanggal_peminjaman)->format('Y-m-d') }}" required>
                                <div class="invalid-feedback">
                                    Kolom ini harus diisi!
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal Pengembalian -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                                <input id="tanggal_pengembalian" type="date" class="form-control" name="tanggal_pengembalian" value="{{ \Carbon\Carbon::parse($rental->tanggal_pengembalian)->format('Y-m-d') }}" required>
                                <div class="invalid-feedback">
                                    Kolom ini harus diisi!
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" class="form-control" name="status" required>
                                    <option value="tersedia" {{ $rental->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="dipinjam" {{ $rental->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                </select>
                                <div class="invalid-feedback">
                                    Kolom ini harus diisi!
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection