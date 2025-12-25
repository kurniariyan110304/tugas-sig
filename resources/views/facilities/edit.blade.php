@extends('layouts.app')

@section('title', 'Edit Fasilitas Baru')

@section('content')
    <div class="dashboard-header">
        <h1 class="header-title">
            <i class="fas fa-map-marked-alt me-2"></i>
            Edit Data Fasilitas Umum
        </h1>
    </div>

    <div class="row">
        <!-- Left Column - Form -->
        <div class="col-lg-12">
            <div class="form-card">
                <div class="form-header">
                    <h3>
                        <i class="fas fa-plus-circle"></i>
                        Edit Peta Fasilitas Umum {{ $facility->name }}
                    </h3>
                </div>

                <div class="form-body">
                    <!-- Map Container -->
                    <div id="locationPickerMap"></div>

                    <form action="{{ route('facilities.update', $facility) }}" method="POST" id="facilityForm">
                        @csrf
                        @method('PUT')

                        <!-- Location Coordinates -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-map-marker-alt"></i>
                                Koordinat Lokasi
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="latitude" class="form-label required-field">
                                        <i class="fas fa-globe-asia"></i>
                                        Latitude
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-arrow-up"></i>
                                        </span>
                                        <input type="number" step="any"
                                            class="form-control @error('latitude') is-invalid @enderror" id="latitude"
                                            name="latitude" value="{{ old('latitude', $facility->latitude) }}"
                                            placeholder="-6.402484" required>
                                    </div>
                                    @error('latitude')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="longitude" class="form-label required-field">
                                        <i class="fas fa-globe-asia"></i>
                                        Longitude
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-arrow-right"></i>
                                        </span>
                                        <input type="number" step="any"
                                            class="form-control @error('longitude') is-invalid @enderror" id="longitude"
                                            name="longitude" value="{{ old('longitude', $facility->longitude) }}"required>
                                    </div>
                                    @error('longitude')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-info-circle"></i>
                                Informasi Dasar Fasilitas
                            </h5>

                            <div class="mb-4">
                                <label for="name" class="form-label required-field">
                                    <i class="fas fa-building"></i>
                                    Nama Fasilitas
                                </label>
                                <input type="text"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $facility->name) }}"
                                    placeholder="Contoh: SMA Negeri 1 Depok" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="type" class="form-label required-field">
                                    <i class="fas fa-tag"></i>
                                    Jenis Fasilitas
                                </label>
                                <select class="form-select form-control-lg @error('type') is-invalid @enderror"
                                    id="type" name="type" required>
                                    <option value="">-- Pilih Jenis Fasilitas --</option>
                                    <option value="sekolah"
                                        {{ old('type', $facility->type) == 'sekolah' ? 'selected' : '' }}>
                                        🏫 Sekolah
                                    </option>
                                    <option value="rumah_sakit"
                                        {{ old('type', $facility->type) == 'rumah_sakit' ? 'selected' : '' }}>
                                        🏥 Rumah Sakit
                                    </option>
                                    <option value="puskesmas"
                                        {{ old('type', $facility->type) == 'puskesmas' ? 'selected' : '' }}>
                                        ⚕️ Puskesmas
                                    </option>
                                    <option value="tempat_ibadah"
                                        {{ old('type', $facility->type) == 'tempat_ibadah' ? 'selected' : '' }}>
                                        🕌 Tempat Ibadah
                                    </option>
                                    <option value="pasar" {{ old('type', $facility->type) == 'pasar' ? 'selected' : '' }}>
                                        🛒 Pasar
                                    </option>
                                    <option value="lainnya"
                                        {{ old('type', $facility->type) == 'lainnya' ? 'selected' : '' }}>
                                        📍 Lainnya
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="address" class="form-label">
                                    <i class="fas fa-map-pin"></i>
                                    Alamat Lengkap
                                </label>
                                <textarea class="form-control form-control-lg @error('address') is-invalid @enderror" id="address" name="address"
                                    rows="3" placeholder="Masukkan alamat secara lengkap">{{ old('address', $facility->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    Deskripsi
                                </label>
                                <textarea class="form-control form-control-lg @error('description') is-invalid @enderror" id="description"
                                    name="description" rows="4"
                                    placeholder="Masukkan informasi tambahan seperti jam operasional, fasilitas yang tersedia, kontak, dll.">{{ old('description', $facility->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons flex flex-row">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save me-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        window.mapConfig = {
            lat: {{ old('latitude', $facility->latitude) }},
            lng: {{ old('longitude', $facility->longitude) }}
        };
    </script>

    <script src="{{ asset('js/form.js') }}"></script>
@endpush
