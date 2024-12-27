@extends('layouts.admin.main')
@section('title', 'Admin Vehicles')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Kendaraan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item">Kendaraan</div>
            </div>
        </div>

        <a href="{{ route('admin.vehicles.create') }}" class="btn btn-icon icon-left btn-primary mb-3">
            <i class="fas fa-plus"></i> Tambah Kendaraan
        </a>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kendaraan</th>
                                <th>Jenis Kendaraan</th>
                                <th>Status</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = ($vehicles->currentPage() - 1) * $vehicles->perPage() + 1; @endphp
                            @forelse ($vehicles as $vehicle)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $vehicle->nama_kendaraan }}</td>
                                <td>{{ $vehicle->jenis_kendaraan }}</td>
                                <td>
                                    @php
                                        $latestRental = $vehicle->rentals->first();
                                        $status = $latestRental ? $latestRental->status : 'Tersedia';
                                    @endphp
                                    {{ ucfirst($status) }}
                                </td>
                                <td>
                                    @if ($vehicle->image && file_exists(public_path('images/vehicles/' . $vehicle->image)))
                                        <img src="{{ asset('images/vehicles/' . $vehicle->image) }}" alt="{{ $vehicle->nama_kendaraan }}" width="100">
                                    @else
                                        <span class="text-muted">Gambar tidak tersedia</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.vehicles.detail', $vehicle->id) }}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="{{ route('admin.vehicles.delete', $vehicle->id) }}" class="btn btn-danger btn-sm" data-confirm-delete="true">Hapus</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Data kendaraan tidak tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3 d-flex justify-content-center">
                    {{ $vehicles->links('pagination::bootstrap-4') }}
                </div>

                <!-- Tombol Halaman Berikutnya -->
                @if ($vehicles->hasMorePages())
                <div class="text-center mt-3">
                    <a href="{{ $vehicles->nextPageUrl() }}" class="btn btn-primary">Halaman Berikutnya</a>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
