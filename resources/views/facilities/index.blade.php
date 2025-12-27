@extends('layouts.app')

@section('title', 'Dashboard Peta Fasilitas Umum')

@section('content')
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="header-title ">
            <img src="{{ asset('svg/logo.svg') }}" alt="Logo Fasilitas Umum" class="me-3" width="50">
            Peta Fasilitas Umum
        </h1>

        <div class="d-flex align-items-center gap-2">
            <div class="header-actions">
                <select id="typeFilter" class="form-select">
                    <option value="all">Semua</option>
                    @foreach ($facilityTypes as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            @if (!Auth::check())
                <a href="{{ route('login') }}" class="btn btn-login">Login</a>
            @endif
        </div>


    </div>

    <!-- Map Section -->
    <div class="map-responsive-container">
        <div id="map"></div>

        <div id="mapLoading" class="loading-overlay" style="display: none;">
            <div class="spinner-border text-primary" role="status">
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
