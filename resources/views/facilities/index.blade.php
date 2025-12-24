@extends('layouts.app')

@section('title', 'Dashboard Peta Fasilitas Umum')

@push('styles')
<style>
    /* Map Container Responsive */
    .map-responsive-container {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 60%; /* Aspect ratio 16:10 */
        border-radius: 12px;
        overflow: hidden;
        background: #f8f9fc;
    }
    
    @media (max-width: 768px) {
        .map-responsive-container {
            padding-bottom: 75%; /* Aspect ratio 4:3 untuk tablet */
        }
    }
    
    @media (max-width: 576px) {
        .map-responsive-container {
            padding-bottom: 100%; /* Aspect ratio 1:1 untuk mobile */
        }
    }
    
    #map {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
    
    /* Header Responsive */
    .dashboard-header {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 25px;
    }
    
    @media (min-width: 768px) {
        .dashboard-header {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }
    
    .header-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2e59d9;
        display: flex;
        align-items: center;
        margin: 0;
    }
    
    @media (max-width: 576px) {
        .header-title {
            font-size: 1.3rem;
        }
    }
    
    .header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }
    
    /* Filter and Button Responsive */
    .filter-select {
        min-width: 160px;
    }
    
    @media (max-width: 576px) {
        .filter-select {
            min-width: 140px;
        }
    }
    
    .btn-responsive {
        padding: 8px 15px;
        font-size: 0.9rem;
        white-space: nowrap;
    }
    
    @media (max-width: 576px) {
        .btn-responsive {
            padding: 6px 12px;
            font-size: 0.85rem;
        }
    }
    
    /* Stats Cards Responsive */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 20px;
        margin: 25px 0;
    }
    
    @media (min-width: 576px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (min-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        border-left: 4px solid;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    
    .stat-card-primary { border-color: #4e73df; }
    .stat-card-success { border-color: #1cc88a; }
    .stat-card-danger { border-color: #e74a3b; }
    .stat-card-warning { border-color: #f6c23e; }
    
    .stat-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .stat-info h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
        color: #5a5c69;
    }
    
    @media (max-width: 576px) {
        .stat-info h3 {
            font-size: 1.5rem;
        }
    }
    
    .stat-info p {
        font-size: 0.9rem;
        color: #858796;
        margin: 5px 0 0;
        font-weight: 500;
    }
    
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.2;
    }
    
    /* Facilities Table Responsive */
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-top: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }
    
    .table-responsive {
        min-width: 800px;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            min-width: 100%;
        }
    }
    
    .facilities-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
    }
    
    .facilities-table thead {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    .facilities-table th {
        padding: 15px 20px;
        color: white;
        font-weight: 600;
        text-align: left;
        border: none;
    }
    
    .facilities-table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .facilities-table tbody tr:hover {
        background-color: #f8f9fe;
    }
    
    .facilities-table td {
        padding: 15px 20px;
        vertical-align: middle;
        border-top: 1px solid #e3e6f0;
    }
    
    /* Badge Responsive */
    .type-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        text-align: center;
        min-width: 80px;
    }
    
    .badge-primary { background: rgba(78, 115, 223, 0.1); color: #4e73df; border: 1px solid rgba(78, 115, 223, 0.2); }
    .badge-success { background: rgba(28, 200, 138, 0.1); color: #1cc88a; border: 1px solid rgba(28, 200, 138, 0.2); }
    .badge-danger { background: rgba(231, 74, 59, 0.1); color: #e74a3b; border: 1px solid rgba(231, 74, 59, 0.2); }
    .badge-warning { background: rgba(246, 194, 62, 0.1); color: #f6c23e; border: 1px solid rgba(246, 194, 62, 0.2); }
    .badge-info { background: rgba(54, 185, 204, 0.1); color: #36b9cc; border: 1px solid rgba(54, 185, 204, 0.2); }
    .badge-secondary { background: rgba(133, 135, 150, 0.1); color: #858796; border: 1px solid rgba(133, 135, 150, 0.2); }
    
    /* Action Buttons Responsive */
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap;
    }
    
    @media (max-width: 576px) {
        .action-buttons {
            flex-direction: column;
            gap: 5px;
        }
        
        .action-buttons .btn {
            width: 100%;
            justify-content: center;
        }
    }
    
    .btn-action {
        padding: 6px 12px;
        font-size: 0.85rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state-icon {
        font-size: 4rem;
        color: #e3e6f0;
        margin-bottom: 20px;
    }
    
    .empty-state-title {
        font-size: 1.5rem;
        color: #5a5c69;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .empty-state-description {
        color: #858796;
        margin-bottom: 25px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    
    /* Loading States */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        border-radius: 12px;
    }
    
    /* Map Popup Responsive */
    .leaflet-popup-content {
        max-width: 300px !important;
        min-width: 250px !important;
    }
    
    @media (max-width: 576px) {
        .leaflet-popup-content {
            max-width: 250px !important;
            min-width: 200px !important;
        }
    }
    
    /* Pagination Responsive */
    .pagination-container {
        display: flex;
        justify-content: center;
        padding: 20px 0;
    }
    
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
        gap: 5px;
    }
    
    /* Card Header Responsive */
    .card-header-responsive {
        padding: 20px;
    }
    
    @media (max-width: 576px) {
        .card-header-responsive {
            padding: 15px;
        }
    }
    
    /* Text Truncation for Mobile */
    .text-truncate-mobile {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    @media (min-width: 768px) {
        .text-truncate-mobile {
            max-width: none;
            white-space: normal;
        }
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
@endpush

@section('content')
<!-- Dashboard Header -->
<div class="dashboard-header">
    <div>
        <h1 class="header-title">
            <i class="fas fa-map-marked-alt me-2"></i>
            Dashboard Peta Fasilitas Umum
        </h1>
        <p class="text-muted mb-0">Monitor dan kelola semua fasilitas publik dalam satu dashboard</p>
    </div>
    
    <div class="header-actions">
        <select id="typeFilter" class="form-select filter-select">
            <option value="all">📍 Semua Fasilitas</option>
            @foreach($facilityTypes as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
        </select>
        
        <a href="{{ route('facilities.create') }}" class="btn btn-primary btn-responsive">
            <i class="fas fa-plus me-1"></i> Tambah Baru
        </a>
        
        <button class="btn btn-outline-secondary btn-responsive" id="refreshMap">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>
</div>

<!-- Map Section -->
<div class="card shadow border-0 mb-4">
    <div class="card-header card-header-responsive bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">
            <i class="fas fa-map me-2 text-primary"></i>
            Peta Interaktif
        </h5>
        <div class="text-muted small">
            <i class="fas fa-info-circle me-1"></i>
            Klik peta untuk menambah fasilitas baru
        </div>
    </div>
    <div class="card-body p-0">
        <div class="map-responsive-container">
            <div id="map"></div>
            <div id="mapLoading" class="loading-overlay" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading map...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card stat-card-primary">
        <div class="stat-content">
            <div class="stat-info">
                <h3>{{ $facilities->count() }}</h3>
                <p>Total Fasilitas</p>
            </div>
            <div class="stat-icon text-primary">
                <i class="fas fa-building"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card stat-card-success">
        <div class="stat-content">
            <div class="stat-info">
                <h3>{{ $facilities->where('type', 'sekolah')->count() }}</h3>
                <p>Sekolah</p>
            </div>
            <div class="stat-icon text-success">
                <i class="fas fa-school"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card stat-card-danger">
        <div class="stat-content">
            <div class="stat-info">
                <h3>{{ $facilities->where('type', 'rumah_sakit')->count() }}</h3>
                <p>Rumah Sakit</p>
            </div>
            <div class="stat-icon text-danger">
                <i class="fas fa-hospital"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card stat-card-warning">
        <div class="stat-content">
            <div class="stat-info">
                <h3>{{ $facilities->where('type', 'tempat_ibadah')->count() }}</h3>
                <p>Tempat Ibadah</p>
            </div>
            <div class="stat-icon text-warning">
                <i class="fas fa-place-of-worship"></i>
            </div>
        </div>
    </div>
</div>

<!-- Facilities Table -->
<div class="card shadow border-0 mt-4">
    <div class="card-header card-header-responsive bg-white">
        <h5 class="mb-0 fw-semibold">
            <i class="fas fa-list me-2 text-primary"></i>
            Daftar Fasilitas
            <span class="badge bg-primary ms-2">{{ $facilities->count() }}</span>
        </h5>
    </div>
    
    <div class="table-container">
        @if($facilities->count() > 0)
        <div class="table-responsive">
            <table class="facilities-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th width="120">Jenis</th>
                        <th width="180">Koordinat</th>
                        <th>Alamat</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($facilities as $index => $facility)
                    <tr>
                        <td class="fw-semibold">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-{{ $facility->type == 'sekolah' ? 'school' : ($facility->type == 'rumah_sakit' ? 'hospital' : ($facility->type == 'puskesmas' ? 'clinic-medical' : ($facility->type == 'tempat_ibadah' ? 'place-of-worship' : ($facility->type == 'pasar' ? 'shopping-cart' : 'map-marker')))) }} me-2 text-muted"></i>
                                <span class="text-truncate-mobile">{{ $facility->name }}</span>
                            </div>
                        </td>
                        <td>
                            @php
                                $badgeColors = [
                                    'sekolah' => 'badge-primary',
                                    'rumah_sakit' => 'badge-danger',
                                    'puskesmas' => 'badge-success',
                                    'tempat_ibadah' => 'badge-warning',
                                    'pasar' => 'badge-info',
                                    'lainnya' => 'badge-secondary'
                                ];
                            @endphp
                            <span class="type-badge {{ $badgeColors[$facility->type] ?? 'badge-secondary' }}">
                                {{ $facility->type_label }}
                            </span>
                        </td>
                        <td>
                            <div class="text-muted small">
                                <div><i class="fas fa-arrow-up me-1"></i> {{ number_format($facility->latitude, 6) }}</div>
                                <div><i class="fas fa-arrow-right me-1"></i> {{ number_format($facility->longitude, 6) }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate-mobile" title="{{ $facility->address }}">
                                {{ $facility->address ? Str::limit($facility->address, 50) : '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('facilities.edit', $facility) }}" 
                                   class="btn btn-warning btn-action" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                    <span class="d-none d-md-inline">Edit</span>
                                </a>
                                <form action="{{ route('facilities.destroy', $facility) }}" 
                                      method="POST" 
                                      class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-danger btn-action delete-btn"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                        <span class="d-none d-md-inline">Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <h3 class="empty-state-title">Belum Ada Fasilitas</h3>
            <p class="empty-state-description">
                Mulai dengan menambahkan fasilitas pertama Anda. Klik tombol "Tambah Baru" di atas 
                atau klik langsung pada peta untuk memilih lokasi.
            </p>
            <a href="{{ route('facilities.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i> Tambah Fasilitas Pertama
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Quick Stats -->
@if($facilities->count() > 0)
<div class="row mt-4">
    <div class="col-md-6 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">
                    <i class="fas fa-chart-pie me-2 text-info"></i>
                    Distribusi Jenis Fasilitas
                </h6>
                <div class="row">
                    @foreach($facilityTypes as $key => $label)
                    @php
                        $count = $facilities->where('type', $key)->count();
                        $percentage = $facilities->count() > 0 ? round(($count / $facilities->count()) * 100) : 0;
                    @endphp
                    @if($count > 0)
                    <div class="col-6 mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small">{{ $label }}</span>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-light text-dark me-2">{{ $count }}</span>
                                <span class="small text-muted">{{ $percentage }}%</span>
                            </div>
                        </div>
                        <div class="progress mt-1" style="height: 5px;">
                            <div class="progress-bar bg-{{ $key == 'sekolah' ? 'primary' : ($key == 'rumah_sakit' ? 'danger' : ($key == 'puskesmas' ? 'success' : ($key == 'tempat_ibadah' ? 'warning' : ($key == 'pasar' ? 'info' : 'secondary')))) }}" 
                                 role="progressbar" 
                                 style="width: {{ $percentage }}%">
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">
                    <i class="fas fa-history me-2 text-info"></i>
                    Aktivitas Terbaru
                </h6>
                <div class="list-group list-group-flush">
                    @foreach($facilities->sortByDesc('created_at')->take(3) as $recent)
                    <div class="list-group-item border-0 px-0 py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-semibold">{{ $recent->name }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $recent->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <span class="badge {{ $badgeColors[$recent->type] ?? 'badge-secondary' }}">
                                {{ $recent->type_label }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
@push('scripts')
<script>
$(document).ready(function() {
    // Data langsung dari PHP (tidak perlu API)
    var facilities = @json($facilities);
    
    console.log('Facilities from PHP:', facilities);
    
    // Inisialisasi peta
    var map = L.map('map').setView([-6.402484, 106.794236], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    
    // Tambahkan marker dari data PHP
    facilities.forEach(function(facility) {
        L.marker([facility.latitude, facility.longitude])
            .addTo(map)
            .bindPopup('<b>' + facility.name + '</b>');
    });
});
</script>
@endpush
</script>

<!-- SweetAlert2 for Beautiful Alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush