@extends('layouts.app')

@section('title', 'Dashboard Peta Fasilitas Umum')

@section('content')
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="header-title ">
            <i class="fas fa-map-marked-alt me-2"></i>
            Peta Fasilitas Umum
        </h1>

        <div class="header-actions">
            <select id="typeFilter" class="form-select">
                <option value="all">Semua</option>
                @foreach ($facilityTypes as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Map Section -->
    <div class="card shadow border-0 mb-4">
        <div class="card-body p-0">
            <div class="map-responsive-container">
                <div id="map"></div>
                <div id="mapLoading" class="loading-overlay" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
