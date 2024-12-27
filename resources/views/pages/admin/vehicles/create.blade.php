@extends('layouts.admin.main')
@section('title', 'Admin Tambah Kendaraan')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Kendaraan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item">
                    <a href="{{ route('admin.vehicles.index') }}">Kendaraan</a>
                </div>
                <div class="breadcrumb-item">Tambah Kendaraan</div>
            </div>
        </div>

        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-icon icon-left btn-warning">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <div class="card mt-4">
            <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Nama Kendaraan -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nama_kendaraan">Nama Kendaraan</label>
                                <input id="nama_kendaraan" type="text" class="form-control" name="nama_kendaraan" value="{{ old('nama_kendaraan') }}" required>
                                <div class="invalid-feedback">
                                    Kolom ini harus diisi!
                                </div>
                                @error('nama_kendaraan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenis Kendaraan -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="jenis_kendaraan">Jenis Kendaraan</label>
                                <select id="jenis_kendaraan" class="form-control" name="jenis_kendaraan" required>
                                    <option value="">Pilih Jenis Kendaraan</option>
                                    <option value="motor" {{ old('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>Motor</option>
                                    <option value="mobil" {{ old('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                                </select>
                                <div class="invalid-feedback">
                                    Kolom ini harus diisi!
                                </div>
                                @error('jenis_kendaraan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Kendaraan (Hidden Input) -->
                        <input type="hidden" name="status" value="tersedia"> <!-- Set status to 'tersedia' -->

                        <!-- Gambar Kendaraan -->
                        <div class="col-12">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" name="image" id="customFile" type="file" required>
                                    <label class="custom-file-label" for="customFile">Pilih Gambar</label>
                                </div>
                                <div class="invalid-feedback">
                                    Kolom ini harus diisi!
                                </div>
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Kendaraan
                </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection