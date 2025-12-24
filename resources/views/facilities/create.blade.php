@extends('layouts.app')

@section('title', 'Tambah Fasilitas Baru')

@push('styles')
<style>
    /* Form Container */
    .form-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
    }
    
    .form-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 25px 30px;
        border-radius: 15px 15px 0 0;
    }
    
    .form-header h3 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .form-header h3 i {
        margin-right: 15px;
        font-size: 1.8rem;
    }
    
    .form-body {
        padding: 30px;
    }
    
    /* Section Styling */
    .form-section {
        background: #f8f9fe;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        border-left: 4px solid #4e73df;
        transition: all 0.3s ease;
    }
    
    .form-section:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .section-title {
        color: #2e59d9;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid rgba(78, 115, 223, 0.2);
        display: flex;
        align-items: center;
        font-size: 1.1rem;
    }
    
    .section-title i {
        margin-right: 10px;
        width: 30px;
        text-align: center;
        font-size: 1.2rem;
    }
    
    /* Form Controls */
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }
    
    .form-label i {
        margin-right: 8px;
        color: #6c757d;
    }
    
    .required-field::after {
        content: " *";
        color: #e74a3b;
    }
    
    .form-control, .form-select {
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 0.95rem;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .form-control-lg {
        font-size: 1.1rem;
        padding: 15px;
    }
    
    .input-group-text {
        background-color: #f8f9fc;
        border: 2px solid #e3e6f0;
        border-right: none;
        color: #6c757d;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    
    /* Map Container */
    .map-card {
        height: 100%;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        border: none;
    }
    
    .map-header {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        color: white;
        padding: 20px 25px;
        border-radius: 15px 15px 0 0;
    }
    
    .map-header h4 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .map-header h4 i {
        margin-right: 12px;
        font-size: 1.5rem;
    }
    
    #locationPickerMap {
        height: 400px;
        width: 100%;
        z-index: 1;
    }
    
    .map-instructions {
        background: #f8f9fe;
        padding: 20px;
        border-top: 1px solid #e3e6f0;
    }
    
    /* Location Preview */
    .location-preview-card {
        background: linear-gradient(135deg, #f8f9fe 0%, #e3e6f0 100%);
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
        border: 2px dashed #4e73df;
    }
    
    .coordinates-display {
        background: white;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e3e6f0;
        font-family: 'Courier New', monospace;
        font-size: 1.1rem;
        color: #2e59d9;
        text-align: center;
        margin: 15px 0;
    }
    
    /* Action Buttons */
    .action-buttons {
        padding: 25px;
        background: #f8f9fe;
        border-radius: 12px;
        margin-top: 30px;
        border-top: 1px solid #e3e6f0;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 1rem;
        border-radius: 8px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
    }
    
    .btn-secondary {
        background: #6c757d;
        border: none;
        padding: 12px 25px;
        font-weight: 600;
        border-radius: 8px;
    }
    
    .btn-outline-primary {
        border: 2px solid #4e73df;
        color: #4e73df;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    .btn-outline-primary:hover {
        background: #4e73df;
        color: white;
    }
    
    /* Alert Styling */
    .alert-container {
        border-radius: 12px;
        border: none;
        padding: 20px;
        margin-bottom: 25px;
    }
    
    .alert-info {
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        color: white;
        border-left: 5px solid #1c7d8a;
    }
    
    /* Helper Text */
    .form-text {
        color: #6c757d;
        font-size: 0.875rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
    }
    
    .form-text i {
        margin-right: 6px;
    }
    
    /* Type Badges Preview */
    .type-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    
    .type-badge {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
    }
    
    .type-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .type-badge.active {
        border: 2px solid #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.2);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-body, .action-buttons {
            padding: 20px;
        }
        
        .form-section {
            padding: 20px;
        }
        
        .form-header, .map-header {
            padding: 20px;
        }
        
        #locationPickerMap {
            height: 300px;
        }
    }
</style>
@endpush

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: #f8f9fc; padding: 15px; border-radius: 10px;">
                <li class="breadcrumb-item">
                    <a href="{{ route('facilities.index') }}" class="text-decoration-none">
                        <i class="fas fa-home text-primary"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-plus-circle text-warning"></i> Tambah Fasilitas Baru
                </li>
            </ol>
        </nav>
    </div>
</div>

@if($errors->any())
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger alert-container">
            <div class="d-flex">
                <div class="mr-3">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
                <div>
                    <h5 class="font-weight-bold mb-2">
                        <i class="fas fa-times-circle mr-1"></i>
                        Terdapat Kesalahan
                    </h5>
                    <ul class="mb-0 pl-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <!-- Left Column - Form -->
    <div class="col-lg-7 mb-4">
        <div class="form-card">
            <div class="form-header">
                <h3>
                    <i class="fas fa-plus-circle"></i>
                    Form Tambah Fasilitas Baru
                </h3>
                <p class="mb-0 mt-2 opacity-75">Lengkapi semua data berikut untuk menambahkan fasilitas baru ke sistem</p>
            </div>
            
            <div class="form-body">
                <form action="{{ route('facilities.store') }}" method="POST" id="facilityForm">
                    @csrf
                    
                    <!-- Section 1: Basic Information -->
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
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Contoh: SMA Negeri 1 Depok"
                                   required>
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="form-text">
                                <i class="fas fa-lightbulb"></i>
                                Masukkan nama lengkap fasilitas yang jelas dan mudah dikenali
                            </small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="type" class="form-label required-field">
                                <i class="fas fa-tag"></i>
                                Jenis Fasilitas
                            </label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" 
                                    name="type" 
                                    required>
                                <option value="">-- Pilih Jenis Fasilitas --</option>
                                <option value="sekolah" {{ old('type') == 'sekolah' ? 'selected' : '' }}>
                                    🏫 Sekolah
                                </option>
                                <option value="rumah_sakit" {{ old('type') == 'rumah_sakit' ? 'selected' : '' }}>
                                    🏥 Rumah Sakit
                                </option>
                                <option value="puskesmas" {{ old('type') == 'puskesmas' ? 'selected' : '' }}>
                                    ⚕️ Puskesmas
                                </option>
                                <option value="tempat_ibadah" {{ old('type') == 'tempat_ibadah' ? 'selected' : '' }}>
                                    🕌 Tempat Ibadah
                                </option>
                                <option value="pasar" {{ old('type') == 'pasar' ? 'selected' : '' }}>
                                    🛒 Pasar
                                </option>
                                <option value="lainnya" {{ old('type') == 'lainnya' ? 'selected' : '' }}>
                                    📍 Lainnya
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                            
                            <!-- Type Preview -->
                            <div class="type-preview mt-3">
                                <span class="type-badge badge-primary" data-type="sekolah">🏫 Sekolah</span>
                                <span class="type-badge badge-danger" data-type="rumah_sakit">🏥 Rumah Sakit</span>
                                <span class="type-badge badge-success" data-type="puskesmas">⚕️ Puskesmas</span>
                                <span class="type-badge badge-warning" data-type="tempat_ibadah">🕌 Tempat Ibadah</span>
                                <span class="type-badge badge-info" data-type="pasar">🛒 Pasar</span>
                                <span class="type-badge badge-secondary" data-type="lainnya">📍 Lainnya</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Section 2: Location Coordinates -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="fas fa-map-marker-alt"></i>
                            Koordinat Lokasi
                        </h5>
                        
                        <div class="alert alert-info mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle fa-2x mr-3"></i>
                                <div>
                                    <strong class="d-block">Panduan Pengisian</strong>
                                    Klik pada peta di sebelah kanan untuk memilih koordinat secara otomatis, 
                                    atau masukkan manual di bawah ini
                                </div>
                            </div>
                        </div>
                        
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
                                    <input type="number" 
                                           step="any" 
                                           class="form-control @error('latitude') is-invalid @enderror" 
                                           id="latitude" 
                                           name="latitude" 
                                           value="{{ old('latitude', request('lat')) }}" 
                                           placeholder="-6.402484"
                                           required>
                                </div>
                                @error('latitude')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text">
                                    <i class="fas fa-ruler-vertical"></i>
                                    Garis lintang (-90° sampai 90°)
                                </small>
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
                                    <input type="number" 
                                           step="any" 
                                           class="form-control @error('longitude') is-invalid @enderror" 
                                           id="longitude" 
                                           name="longitude" 
                                           value="{{ old('longitude', request('lng')) }}" 
                                           placeholder="106.794236"
                                           required>
                                </div>
                                @error('longitude')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text">
                                    <i class="fas fa-ruler-horizontal"></i>
                                    Garis bujur (-180° sampai 180°)
                                </small>
                            </div>
                        </div>
                        
                        <!-- Location Preview -->
                        <div class="location-preview-card">
                            <h6 class="font-weight-bold mb-3">
                                <i class="fas fa-eye text-primary mr-2"></i>
                                Pratinjau Koordinat
                            </h6>
                            <div id="coordinatePreview" class="coordinates-display">
                                @if(old('latitude') && old('longitude'))
                                    {{ old('latitude') }}, {{ old('longitude') }}
                                @elseif(request('lat') && request('lng'))
                                    {{ request('lat') }}, {{ request('lng') }}
                                @else
                                    <span class="text-muted">Belum dipilih</span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="useCurrentLocation">
                                    <i class="fas fa-location-arrow mr-2"></i>
                                    Gunakan Lokasi Saat Ini
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Section 3: Additional Details -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="fas fa-file-alt"></i>
                            Detail Tambahan
                        </h5>
                        
                        <div class="mb-4">
                            <label for="address" class="form-label">
                                <i class="fas fa-map-pin"></i>
                                Alamat Lengkap
                            </label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="3" 
                                      placeholder="Masukkan alamat lengkap fasilitas (jalan, nomor, RT/RW, kelurahan, kecamatan, kota)">{{ old('address') }}</textarea>
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
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Masukkan informasi tambahan seperti jam operasional, fasilitas yang tersedia, kontak, dll.">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <div class="row">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <button type="button" class="btn btn-outline-secondary w-100" id="resetForm">
                                    <i class="fas fa-redo mr-2"></i>
                                    Reset Form
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn-submit w-100">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Fasilitas
                                </button>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('facilities.index') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali ke Dashboard Peta
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Right Column - Map -->
    <div class="col-lg-5 mb-4">
        <!-- Map Card -->
        <div class="map-card">
            <div class="map-header">
                <h4>
                    <i class="fas fa-map"></i>
                    Pilih Lokasi di Peta
                </h4>
                <p class="mb-0 mt-1 opacity-75">Pilih lokasi dengan mengklik atau menyeret marker</p>
            </div>
            
            <!-- Map Container -->
            <div id="locationPickerMap"></div>
            
            <!-- Map Instructions -->
            <div class="map-instructions">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="d-flex align-items-start">
                            <div class="mr-3 text-primary">
                                <i class="fas fa-mouse-pointer fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Klik Peta</h6>
                                <p class="mb-0 small">Klik pada peta untuk menetapkan lokasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="mr-3 text-success">
                                <i class="fas fa-arrows-alt fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Seret Marker</h6>
                                <p class="mb-0 small">Seret marker merah ke lokasi yang diinginkan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Help Card -->
        {{-- <div class="form-card mt-4">
            <div class="form-body">
                <h5 class="section-title mb-4">
                    <i class="fas fa-question-circle"></i>
                    Panduan Koordinat
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="badge badge-primary p-2 mr-2">Latitude</div>
                            <i class="fas fa-arrow-up text-primary"></i>
                        </div>
                        <p class="small mb-0">
                            Menunjukkan posisi utara/selatan. Nilai negatif untuk lokasi di selatan khatulistiwa.
                        </p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="badge badge-success p-2 mr-2">Longitude</div>
                            <i class="fas fa-arrow-right text-success"></i>
                        </div>
                        <p class="small mb-0">
                            Menunjukkan posisi timur/barat. Nilai positif untuk lokasi di timur Greenwich.
                        </p>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-3">
                    <div class="d-flex">
                        <i class="fas fa-lightbulb mr-3 fa-lg"></i>
                        <div>
                            <strong>Tips Akurasi:</strong> 
                            Zoom in peta terlebih dahulu sebelum memilih lokasi untuk mendapatkan koordinat yang lebih akurat.
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Default coordinates (Depok, Indonesia)
    const DEFAULT_LAT = {{ old('latitude', request('lat', -6.402484)) }};
    const DEFAULT_LNG = {{ old('longitude', request('lng', 106.794236)) }};
    
    // Initialize map
    const locationMap = L.map('locationPickerMap').setView([DEFAULT_LAT, DEFAULT_LNG], 14);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(locationMap);
    
    // Create custom icon for marker
    const redIcon = L.divIcon({
        html: `<div style="
            background: #e74a3b;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        "><i class="fas fa-map-marker-alt"></i></div>`,
        iconSize: [46, 46],
        iconAnchor: [23, 46],
        popupAnchor: [0, -46]
    });
    
    // Create draggable marker
    const marker = L.marker([DEFAULT_LAT, DEFAULT_LNG], {
        draggable: true,
        icon: redIcon,
        autoPan: true
    }).addTo(locationMap);
    
    // Add popup to marker
    marker.bindPopup(`
        <div style="text-align: center; padding: 10px;">
            <h6 style="margin-bottom: 8px; color: #2e59d9;">
                <i class="fas fa-map-marker-alt mr-1"></i>Marker Lokasi
            </h6>
            <p style="margin: 0; font-size: 12px;">
                Seret saya ke lokasi yang diinginkan
            </p>
        </div>
    `);
    
    // Update form fields and preview
    function updateCoordinates(lat, lng) {
        // Update form inputs
        $('#latitude').val(lat.toFixed(6));
        $('#longitude').val(lng.toFixed(6));
        
        // Update preview
        $('#coordinatePreview').html(`
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-crosshairs text-primary mr-2"></i>
                    <strong>Lat:</strong> ${lat.toFixed(6)}
                </div>
                <div>
                    <i class="fas fa-crosshairs text-success mr-2"></i>
                    <strong>Lng:</strong> ${lng.toFixed(6)}
                </div>
            </div>
        `);
        
        // Update marker position
        marker.setLatLng([lat, lng]);
        
        // Pan map to marker with animation
        locationMap.panTo([lat, lng], {
            animate: true,
            duration: 0.5
        });
    }
    
    // Event when marker is dragged
    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        updateCoordinates(position.lat, position.lng);
        showToast('success', 'Lokasi berhasil dipindahkan!');
    });
    
    // Event when map is clicked
    locationMap.on('click', function(e) {
        updateCoordinates(e.latlng.lat, e.latlng.lng);
        showToast('info', 'Lokasi berhasil dipilih!');
    });
    
    // Event when coordinates are manually entered
    $('#latitude, #longitude').on('change input', function() {
        const lat = parseFloat($('#latitude').val());
        const lng = parseFloat($('#longitude').val());
        
        if (!isNaN(lat) && !isNaN(lng)) {
            marker.setLatLng([lat, lng]);
            locationMap.panTo([lat, lng]);
            
            // Update preview
            $('#coordinatePreview').html(`
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-crosshairs text-primary mr-2"></i>
                        <strong>Lat:</strong> ${lat.toFixed(6)}
                    </div>
                    <div>
                        <i class="fas fa-crosshairs text-success mr-2"></i>
                        <strong>Lng:</strong> ${lng.toFixed(6)}
                    </div>
                </div>
            `);
        }
    });
    
    // Type badge selection
    $('.type-badge').click(function() {
        const selectedType = $(this).data('type');
        
        // Update select
        $('#type').val(selectedType);
        
        // Update badge active state
        $('.type-badge').removeClass('active');
        $(this).addClass('active');
        
        showToast('info', `Jenis fasilitas dipilih: ${$(this).text()}`);
    });
    
    // Use current location button
    $('#useCurrentLocation').click(function() {
        if (navigator.geolocation) {
            const $btn = $(this);
            const originalText = $btn.html();
            
            $btn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Mendeteksi lokasi...');
            $btn.prop('disabled', true);
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    updateCoordinates(lat, lng);
                    
                    $btn.html(originalText);
                    $btn.prop('disabled', false);
                    
                    showToast('success', 'Lokasi saat ini berhasil dideteksi!', 3000);
                },
                function(error) {
                    let message = 'Gagal mendeteksi lokasi. ';
                    
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            message += 'Izin lokasi ditolak.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            message += 'Informasi lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            message += 'Permintaan lokasi timeout.';
                            break;
                        default:
                            message += 'Terjadi kesalahan.';
                    }
                    
                    $btn.html(originalText);
                    $btn.prop('disabled', false);
                    
                    showToast('danger', message, 5000);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            showToast('warning', 'Browser Anda tidak mendukung fitur geolocation.', 3000);
        }
    });
    
    // Reset form button
    $('#resetForm').click(function() {
        Swal.fire({
            title: 'Reset Form?',
            text: 'Semua data yang telah diisi akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4e73df',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Reset',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#facilityForm')[0].reset();
                updateCoordinates(DEFAULT_LAT, DEFAULT_LNG);
                $('.type-badge').removeClass('active');
                
                showToast('info', 'Form berhasil direset.', 2000);
            }
        });
    });
    
    // Form validation before submit
    $('#facilityForm').submit(function(e) {
        // Validate coordinates
        const lat = parseFloat($('#latitude').val());
        const lng = parseFloat($('#longitude').val());
        
        if (isNaN(lat) || lat < -90 || lat > 90) {
            e.preventDefault();
            showToast('danger', 'Latitude tidak valid. Harus antara -90 sampai 90.');
            $('#latitude').focus();
            return false;
        }
        
        if (isNaN(lng) || lng < -180 || lng > 180) {
            e.preventDefault();
            showToast('danger', 'Longitude tidak valid. Harus antara -180 sampai 180.');
            $('#longitude').focus();
            return false;
        }
        
        // Show loading
        const $submitBtn = $('button[type="submit"]');
        const originalText = $submitBtn.html();
        
        $submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');
        $submitBtn.prop('disabled', true);
        
        // Allow form to submit
        return true;
    });
    
    // Initialize with current values
    updateCoordinates(DEFAULT_LAT, DEFAULT_LNG);
    
    // Set active type badge if exists
    const currentType = $('#type').val();
    if (currentType) {
        $(`.type-badge[data-type="${currentType}"]`).addClass('active');
    }
    
    // Fix map size after load
    setTimeout(() => locationMap.invalidateSize(), 100);
    
    // Helper function to show toast notifications
    function showToast(type, message, duration = 3000) {
        // Remove existing toasts
        $('.custom-toast').remove();
        
        // Define colors and icons
        const config = {
            success: { bg: '#1cc88a', icon: 'check-circle' },
            danger: { bg: '#e74a3b', icon: 'exclamation-circle' },
            warning: { bg: '#f6c23e', icon: 'exclamation-triangle' },
            info: { bg: '#36b9cc', icon: 'info-circle' }
        };
        
        const { bg, icon } = config[type] || config.info;
        
        // Create toast element
        const toast = $(`
            <div class="custom-toast" style="
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                background: ${bg};
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                display: flex;
                align-items: center;
                animation: slideIn 0.3s ease;
                max-width: 400px;
            ">
                <i class="fas fa-${icon} fa-lg mr-3"></i>
                <div>
                    <strong>${message}</strong>
                </div>
            </div>
        `);
        
        // Add to body
        $('body').append(toast);
        
        // Auto remove
        setTimeout(() => {
            toast.fadeOut(300, () => toast.remove());
        }, duration);
    }
    
    // Add CSS animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .type-badge {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .type-badge:hover {
            transform: translateY(-3px) scale(1.05);
        }
        
        .type-badge.active {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(78, 115, 223, 0); }
            100% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0); }
        }
    `;
    document.head.appendChild(style);
});
</script>

<!-- Include SweetAlert2 for better alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush