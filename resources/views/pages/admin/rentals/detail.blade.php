@extends('layouts.admin.main')
@section('title', 'Detail Peminjaman')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Peminjaman</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item">
                    <a href="{{ route('admin.rentals.index') }}">Peminjaman</a>
                </div>
                <div class="breadcrumb-item">Detail Peminjaman</div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <a href="{{ route('admin.rentals.index') }}" class="btn btn-icon icon-left btn-warning mb-3">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <!-- Card Detail Peminjaman -->
        <div class="card">
            <div class="card-header">
                <h4>Informasi Peminjaman</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Informasi Kendaraan & Peminjaman -->
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="width: 50%;">Nama Kendaraan:</th>
                                    <td>{{ $rental->vehicle->nama_kendaraan }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Peminjam:</th>
                                    <td>{{ $rental->nama_peminjam }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Peminjaman:</th>
                                    <td>{{ \Carbon\Carbon::parse($rental->tanggal_peminjaman)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pengembalian:</th>
                                    <td>{{ \Carbon\Carbon::parse($rental->tanggal_pengembalian)->format('d-m-Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Status & Catatan -->
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="width: 50%;">Status Kendaraan:</th>
                                    <td>
                                        <span class="badge badge-{{ $rental->status == 'Tersedia' ? 'success' : 'danger' }}">
                                            {{ ucfirst($rental->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Tambahan (Jika Diperlukan) -->
        @if($rental->vehicle->image && file_exists(public_path('images/vehicles/' . $rental->vehicle->image)))
        <div class="card mt-4">
            <div class="card-header">
                <h4>Gambar Kendaraan</h4>
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('images/vehicles/' . $rental->vehicle->image) }}" alt="{{ $rental->vehicle->nama_kendaraan }}" class="img-fluid rounded" style="max-width: 300px;">
            </div>
        </div>
        @endif
    </section>
</div>
@endsection
