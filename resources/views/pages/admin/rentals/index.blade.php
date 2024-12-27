@extends('layouts.admin.main')
@section('title', 'Admin Rentals')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Peminjaman</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="">Dashboard</a>
                </div>
                <div class="breadcrumb-item">Peminjaman</div>
            </div>
        </div>

        <a href="{{ route('admin.rentals.create') }}" class="btn btn-icon icon-left btn-primary mb-3">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-md">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kendaraan</th>
                            <th>Nama Peminjam</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = ($rentals->currentPage() - 1) * $rentals->perPage() + 1; @endphp
                        @foreach ($rentals as $rental)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $rental->vehicle->nama_kendaraan }}</td>
                            <td>{{ $rental->nama_peminjam }}</td>
                            <td>{{ $rental->tanggal_peminjaman }}</td>
                            <td>{{ $rental->tanggal_pengembalian }}</td>
                            <td>{{ ucfirst($rental->status) }}</td>
                            <td>
                                <a href="{{ route('admin.rentals.detail', $rental->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('admin.rentals.edit', $rental->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('admin.rentals.delete', $rental->id) }}" class="btn btn-danger btn-sm" data-confirm-delete="true">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="card-body">
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mb-3">
                {{ $rentals->links('pagination::bootstrap-4') }}
            </div>

            <!-- Tombol Halaman Berikutnya di bawah tabel -->
            @if ($rentals->hasMorePages())
            <div class="d-flex justify-content-center">
                <a href="{{ $rentals->nextPageUrl() }}" class="btn btn-primary">Halaman Berikutnya</a>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection
