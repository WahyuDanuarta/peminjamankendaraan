@extends('layouts.admin.main')
@section('title', 'Detail Kendaraan')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Kendaraan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item">
                    <a href="{{ route('admin.vehicles.index') }}">Kendaraan</a>
                </div>
                <div class="breadcrumb-item">Detail Kendaraan</div>
            </div>
        </div>

        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-icon icon-left btn-warning mb-3">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <!-- Bagian Kiri: Gambar -->
                    <div class="col-md-6 text-center">
                        @if ($vehicle->image && file_exists(public_path('images/vehicles/' . $vehicle->image)))
                            <img src="{{ asset('images/vehicles/' . $vehicle->image) }}" alt="{{ $vehicle->nama_kendaraan }}" class="img-fluid rounded" style="max-width: 100%; max-height: 350px;">
                        @else
                            <div class="text-muted">Gambar tidak tersedia</div>
                        @endif
                    </div>

                    <!-- Bagian Kanan: Detail Informasi -->
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="width: 40%;">Nama Kendaraan:</th>
                                    <td>{{ $vehicle->nama_kendaraan }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kendaraan:</th>
                                    <td>{{ $vehicle->jenis_kendaraan }}</td>
                                </tr>
                                <tr>
                                    <th>Status Kendaraan:</th>
                                    <td>
                                        @php
                                            $latestRental = $vehicle->rentals->first();
                                            $status = $latestRental ? ucfirst($latestRental->status) : 'Tersedia';
                                        @endphp
                                        <span class="badge badge-{{ $status === 'Tersedia' ? 'success' : 'danger' }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
