<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GIS Fasilitas Umum')</title>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin=""/>
    
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS SBAdmin2 -->
    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fc;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        
        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            z-index: 1000;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            padding-top: 20px;
        }
        
        .sidebar-sticky {
            position: relative;
            height: 100%;
            padding: 20px 0;
        }
        
        .sidebar-brand {
            text-align: center;
            padding: 0 20px 30px 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .sidebar-brand-icon {
            font-size: 2.5rem;
            color: white;
            margin-bottom: 10px;
        }
        
        .sidebar-brand-text h4 {
            color: white;
            margin: 0;
            font-size: 1.5rem;
        }
        
        .sidebar-brand-text small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
        }
        
        .sidebar .nav {
            padding: 0 15px;
        }
        
        .sidebar .nav-item {
            margin-bottom: 5px;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 15px;
            border-radius: 5px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }
        
        .sidebar .nav-link i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
        }
        
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            text-decoration: none;
        }
        
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 600;
        }
        
        .sidebar-divider {
            border-color: rgba(255, 255, 255, 0.2);
            margin: 20px 0;
        }
        
        /* Main Content Styling */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background-color: #f8f9fc;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            #sidebarToggle {
                display: block !important;
            }
        }
        
        /* Topbar Styling */
        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid #e3e6f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .topbar h4 {
            color: #5a5c69;
            margin: 0;
            font-size: 1.5rem;
        }
        
        .topbar h4 i {
            color: #4e73df;
        }
        
        #sidebarToggle {
            background: none;
            border: none;
            color: #5a5c69;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        #sidebarToggle:hover {
            background-color: #f8f9fc;
        }
        
        /* Content Area */
        .content-area {
            padding: 30px;
        }
        
        /* Card Styling */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 20px 25px;
            border-radius: 10px 10px 0 0 !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .card-header h6 {
            margin: 0;
            color: #4e73df;
            font-weight: 600;
        }
        
        .card-body {
            padding: 25px;
        }
        
        /* Map Container - INI YANG PENTING! */
        #map {
            height: 500px !important;
            width: 100% !important;
            border-radius: 8px;
            z-index: 1;
            position: relative;
        }
        
        .leaflet-container {
            height: 100% !important;
            width: 100% !important;
            font-family: inherit;
        }
        
        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border-left: 4px solid #0f5132;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #842029;
            border-left: 4px solid #842029;
        }
        
        /* Footer */
        .footer {
            background: white;
            padding: 20px 30px;
            border-top: 1px solid #e3e6f0;
            margin-top: auto;
        }
        
        .footer p {
            margin: 0;
            color: #6e707e;
            text-align: center;
        }
        
        /* Badge Colors */
        .badge-school { background-color: #3498db; }
        .badge-hospital { background-color: #e74c3c; }
        .badge-health { background-color: #2ecc71; }
        .badge-worship { background-color: #9b59b6; }
        .badge-market { background-color: #f39c12; }
        .badge-other { background-color: #7f8c8d; }
        
        /* Utility Classes */
        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;
        }
        
        .rounded {
            border-radius: 8px !important;
        }
        
        /* Leaflet Popup Custom */
        .leaflet-popup-content {
            min-width: 250px;
        }
        
        .leaflet-popup-content-wrapper {
            border-radius: 8px;
        }
        
        /* Ensure proper layout */
        html, body {
            height: 100%;
        }
        
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-sticky">
                <div class="sidebar-brand">
                    <div class="sidebar-brand-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="sidebar-brand-text">
                        <h4>GIS Fasilitas</h4>
                        <small>Sistem Informasi Geografis</small>
                    </div>
                </div>
                
                <hr class="sidebar-divider">
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-fw fa-map"></i>
                            <span>Peta Fasilitas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('facilities/create') ? 'active' : '' }}" href="{{ route('facilities.create') }}">
                            <i class="fas fa-fw fa-plus-circle"></i>
                            <span>Tambah Fasilitas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('facilities') && !Request::is('/') ? 'active' : '' }}" href="{{ route('facilities.index') }}">
                            <i class="fas fa-fw fa-list"></i>
                            <span>Daftar Fasilitas</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            <div class="topbar">
                <button class="btn btn-link d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    Sistem Informasi Geografis Fasilitas Umum
                </h4>
            </div>

            <!-- Page Content -->
            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <strong>Terjadi kesalahan!</strong>
                        <ul class="mb-0 mt-2 pl-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>
                                &copy; {{ date('Y') }} GIS Fasilitas Umum - Kelompok Tugas GIS
                                <br>
                                <small class="text-muted">Program Studi Sistem Informasi – STT Terpadu Nurul Fikri</small>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV11vTlZBo="
            crossorigin=""></script>
    
    <script>
        // Toggle sidebar untuk mobile
        $(document).ready(function() {
            $('#sidebarToggle').click(function() {
                $('.sidebar').toggleClass('d-none');
                $('.main-content').toggleClass('ml-0');
            });
            
            // Auto close alerts setelah 5 detik
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
            
            // Fix map size setelah sidebar toggle
            $('#sidebarToggle').click(function() {
                setTimeout(function() {
                    if (window.map) {
                        window.map.invalidateSize();
                    }
                }, 300);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>