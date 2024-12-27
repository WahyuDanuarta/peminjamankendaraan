@extends('layouts.admin.main')
@section('title', 'Admin Edit Kendaraan')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Kendaraan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item">
                    <a href="{{ route('admin.vehicles.index') }}">Kendaraan</a>
                </div>
                <div class="breadcrumb-item">Edit Kendaraan</div>
            </div>
        </div>

        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-icon icon-left btn-warning">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <div class="card mt-4">
            <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <!-- Nama Kendaraan -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nama_kendaraan">Nama Kendaraan</label>
                                <input id="nama_kendaraan" type="text" class="form-control" name="nama_kendaraan" value="{{ old('nama_kendaraan', $vehicle->nama_kendaraan) }}" required>
                                <div class="invalid-feedback">
                                    Kolom ini harus diisi!
                                </div>
                            </div>
                        </div>

                        <!-- Jenis Kendaraan (Dropdown) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="jenis_kendaraan">Jenis Kendaraan</label>
                                <select id="jenis_kendaraan" class="form-control" name="jenis_kendaraan" required>
                                    <option value="">Pilih Jenis Kendaraan</option>
                                    <option value="motor" {{ old('jenis_kendaraan', $vehicle->jenis_kendaraan) == 'motor' ? 'selected' : '' }}>Motor</option>
                                    <option value="mobil" {{ old('jenis_kendaraan', $vehicle->jenis_kendaraan) == 'mobil' ? 'selected' : '' }}>Mobil</option>
                                </select>
                                <div class="invalid-feedback">
                                    Kolom ini harus diisi!
                                </div>
                            </div>
                        </div>

                        <!-- Gambar Kendaraan -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="customFile">Gambar Kendaraan (Kosongkan jika tidak ingin mengubah)</label>
                                <div class="custom-file">
                                    <input class="custom-file-input" name="image" id="customFile" type="file">
                                    <label class="custom-file-label" for="customFile">Pilih Gambar</label>
                                </div>
                                <div class="invalid-feedback">
                                    Kolom ini harus diisi!
                                </div>
                            </div>
                        </div>

                        <!-- Menampilkan Gambar yang Ada -->
                        <div class="col-12">
                            <div class="form-group">
                                <label>Gambar Saat Ini</label><br>
                                @if ($vehicle->image && file_exists(public_path('images/vehicles/' . $vehicle->image)))
                                    <img src="{{ asset('images/vehicles/' . $vehicle->image) }}" alt="{{ $vehicle->nama_kendaraan }}" width="250">
                                @else
                                    <span class="text-muted">Gambar tidak tersedia</span>
                                @endif
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