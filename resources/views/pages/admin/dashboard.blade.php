@extends('layouts.admin.main')
@section('title', 'Dashboard')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <!-- Statistik -->
        <div class="row">
            <!-- Total Kendaraan -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Kendaraan</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_vehicles ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Rental -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Rental</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_rentals ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Kendaraan -->
        <div class="card mt-4">
            <div class="card-header">
                <h4>Filter Kendaraan</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <div class="form-group row">
                        <label for="status" class="col-md-2 col-form-label">Status Kendaraan:</label>
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                                <option value="semua" {{ $status == 'semua' ? 'selected' : '' }}>Semua</option>
                                <option value="tersedia" {{ $status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="dipinjam" {{ $status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Kendaraan -->
        <div class="card mt-4">
            <div class="card-header">
                <h4>Daftar Kendaraan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Kendaraan</th>
                                <th>Jenis Kendaraan</th>
                                <th>Status</th>
                                <th>Gambar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->nama_kendaraan }}</td>
                                    <td>{{ $vehicle->jenis_kendaraan }}</td>
                                    <td>
                                        <span class="badge badge-{{ $vehicle->status == 'tersedia' ? 'success' : 'danger' }}">
                                            {{ ucfirst($vehicle->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($vehicle->image && file_exists(public_path('images/vehicles/' . $vehicle->image)))
                                            <img src="{{ asset('images/vehicles/' . $vehicle->image) }}" alt="{{ $vehicle->nama_kendaraan }}" width="100">
                                        @else
                                            <img src="{{ asset('images/placeholder.png') }}" alt="Gambar tidak tersedia" width="100">
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="alert alert-warning">Tidak ada kendaraan ditemukan.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination Links -->
        <div class="card-body">
            <div class="d-flex justify-content-center">
                {{ $vehicles->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>
</div>
@endsection
