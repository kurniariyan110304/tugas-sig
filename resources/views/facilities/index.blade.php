@extends('layouts.app')

@section('title', 'Peta Fasilitas Umum')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-map mr-2"></i>Peta Fasilitas Umum
                </h6>
                <div class="d-flex align-items-center">
                    <select id="typeFilter" class="form-control form-control-sm mr-2" style="width: auto;">
                        <option value="all">Semua Fasilitas</option>
                        @foreach($facilityTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('facilities.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <!-- Container Peta - HARUS ada height! -->
                <div id="map" style="height: 500px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mt-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Fasilitas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $facilities->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-building fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Sekolah
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $facilities->where('type', 'sekolah')->count() }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-school fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Rumah Sakit
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $facilities->where('type', 'rumah_sakit')->count() }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hospital fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Tempat Ibadah
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $facilities->where('type', 'tempat_ibadah')->count() }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-place-of-worship fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Fasilitas -->
<div class="card shadow mt-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-list mr-2"></i>Daftar Fasilitas
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Koordinat</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facilities as $index => $facility)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $facility->name }}</td>
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
                            <span class="badge {{ $badgeColors[$facility->type] ?? 'badge-secondary' }}">
                                {{ $facility->type_label }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">{{ $facility->latitude }}, {{ $facility->longitude }}</small>
                        </td>
                        <td>{{ Str::limit($facility->address, 50) }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('facilities.edit', $facility) }}" 
                                   class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('facilities.destroy', $facility) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Hapus fasilitas ini?')"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                                <p>Belum ada data fasilitas</p>
                                <a href="{{ route('facilities.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus mr-1"></i> Tambah Fasilitas Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Pastikan map container visible */
    #map {
        min-height: 500px;
    }
    
    /* Custom leaflet styles */
    .leaflet-popup-content {
        padding: 10px;
    }
    
    .leaflet-popup-content h6 {
        color: #4e73df;
        margin-bottom: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    console.log('Document ready, initializing map...');
    
    // Inisialisasi peta
    var map = L.map('map').setView([-6.402484, 106.794236], 13);
    
    // Debug: Pastikan container ada
    var mapContainer = document.getElementById('map');
    if (!mapContainer) {
        console.error('Map container not found!');
        return;
    }
    
    console.log('Map container found:', mapContainer);
    
    // Tile layer dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    console.log('Tile layer added');
    
    // Simpan map ke window untuk akses global
    window.map = map;
    
    // Warna untuk setiap jenis fasilitas
    var typeColors = {
        'sekolah': '#3498db',
        'rumah_sakit': '#e74c3c',
        'puskesmas': '#2ecc71',
        'tempat_ibadah': '#9b59b6',
        'pasar': '#f39c12',
        'lainnya': '#7f8c8d'
    };
    
    // Buat custom icon
    function createIcon(type) {
        var color = typeColors[type] || '#7f8c8d';
        return L.divIcon({
            className: 'custom-marker',
            html: `<div style="
                background-color: ${color};
                width: 30px;
                height: 30px;
                border-radius: 50%;
                border: 3px solid white;
                box-shadow: 0 2px 5px rgba(0,0,0,0.3);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: bold;
                font-size: 14px;
                cursor: pointer;
            ">
                <i class="fas fa-${getIconName(type)}"></i>
            </div>`,
            iconSize: [36, 36],
            iconAnchor: [18, 36],
            popupAnchor: [0, -36]
        });
    }
    
    // Helper untuk icon name
    function getIconName(type) {
        var icons = {
            'sekolah': 'school',
            'rumah_sakit': 'hospital',
            'puskesmas': 'clinic-medical',
            'tempat_ibadah': 'place-of-worship',
            'pasar': 'shopping-cart',
            'lainnya': 'map-marker'
        };
        return icons[type] || 'map-marker';
    }
    
    // Helper untuk badge class
    function getBadgeClass(type) {
        var badges = {
            'sekolah': 'badge-primary',
            'rumah_sakit': 'badge-danger',
            'puskesmas': 'badge-success',
            'tempat_ibadah': 'badge-warning',
            'pasar': 'badge-info',
            'lainnya': 'badge-secondary'
        };
        return badges[type] || 'badge-secondary';
    }
    
    var markers = [];
    
    // Fungsi untuk menampilkan marker
    function addMarker(facility) {
        var marker = L.marker([facility.latitude, facility.longitude], {
            icon: createIcon(facility.type)
        }).addTo(map);
        
        // Popup content
        var popupContent = `
            <div style="min-width: 250px; padding: 10px;">
                <h6 style="color: #4e73df; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 8px;">
                    <i class="fas fa-${getIconName(facility.type)} mr-2"></i>
                    ${facility.name}
                </h6>
                <div style="margin-bottom: 8px;">
                    <strong>Jenis:</strong>
                    <span class="badge ${getBadgeClass(facility.type)} ml-2">
                        ${facility.type_label}
                    </span>
                </div>
                <div style="margin-bottom: 8px;">
                    <strong>Alamat:</strong><br>
                    <small>${facility.address || 'Tidak ada alamat'}</small>
                </div>
                <div style="margin-bottom: 12px;">
                    <strong>Koordinat:</strong><br>
                    <code style="font-size: 12px;">${facility.latitude.toFixed(6)}, ${facility.longitude.toFixed(6)}</code>
                </div>
                <div class="text-center">
                    <a href="/facilities/${facility.id}/edit" 
                       class="btn btn-warning btn-sm" 
                       style="margin-right: 5px;">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button onclick="deleteFacility(${facility.id})" 
                            class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        `;
        
        marker.bindPopup(popupContent);
        markers.push(marker);
        
        return marker;
    }
    
    // Load data fasilitas
    function loadFacilities(type = 'all') {
        // Clear existing markers
        markers.forEach(function(marker) {
            map.removeLayer(marker);
        });
        markers = [];
        
        // Get data from API
        var url = type === 'all' ? '/api/facilities' : '/api/facilities/' + type;
        
        console.log('Loading facilities from:', url);
        
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(facilities) {
                console.log('Facilities loaded:', facilities);
                
                // Add markers
                facilities.forEach(function(facility) {
                    addMarker(facility);
                });
                
                // Fit bounds if there are markers
                if (markers.length > 0) {
                    var group = new L.featureGroup(markers);
                    map.fitBounds(group.getBounds().pad(0.1));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading facilities:', error);
                alert('Gagal memuat data fasilitas');
            }
        });
    }
    
    // Event click pada peta
    var tempMarker = null;
    map.on('click', function(e) {
        // Remove previous temp marker
        if (tempMarker) {
            map.removeLayer(tempMarker);
        }
        
        // Add temporary marker
        tempMarker = L.marker(e.latlng, {
            icon: L.divIcon({
                html: `<div style="
                    background-color: #ff6b6b;
                    width: 24px;
                    height: 24px;
                    border-radius: 50%;
                    border: 3px solid white;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
                    animation: pulse 1.5s infinite;
                "></div>`,
                iconSize: [30, 30],
                iconAnchor: [15, 30]
            })
        }).addTo(map);
        
        // Popup untuk tambah fasilitas
        var popup = L.popup()
            .setLatLng(e.latlng)
            .setContent(`
                <div style="padding: 10px; text-align: center; min-width: 200px;">
                    <h6 style="margin-bottom: 10px;">Tambah Fasilitas Baru</h6>
                    <p style="margin-bottom: 15px; font-size: 12px;">
                        <strong>Koordinat:</strong><br>
                        ${e.latlng.lat.toFixed(6)}, ${e.latlng.lng.toFixed(6)}
                    </p>
                    <div>
                        <a href="/facilities/create?lat=${e.latlng.lat}&lng=${e.latlng.lng}" 
                           class="btn btn-primary btn-sm btn-block">
                            <i class="fas fa-plus mr-1"></i> Tambah Fasilitas
                        </a>
                        <button onclick="map.removeLayer(tempMarker); map.closePopup();" 
                                class="btn btn-secondary btn-sm btn-block mt-1">
                            <i class="fas fa-times mr-1"></i> Batal
                        </button>
                    </div>
                </div>
            `)
            .openOn(map);
    });
    
    // Filter change event
    $('#typeFilter').change(function() {
        loadFacilities($(this).val());
    });
    
    // Delete function
    window.deleteFacility = function(id) {
        if (confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')) {
            $.ajax({
                url: '/facilities/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    alert('Fasilitas berhasil dihapus!');
                    loadFacilities($('#typeFilter').val());
                },
                error: function(xhr) {
                    alert('Gagal menghapus fasilitas. Silakan coba lagi.');
                }
            });
        }
    };
    
    // Load initial data
    loadFacilities('all');
    
    // Fix map size after load
    setTimeout(function() {
        map.invalidateSize();
        console.log('Map size invalidated');
    }, 100);
    
    // Add CSS animation
    var style = document.createElement('style');
    style.textContent = `
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }
        .custom-marker:hover {
            transform: scale(1.1);
            transition: transform 0.2s;
        }
    `;
    document.head.appendChild(style);
});
</script>
@endpush