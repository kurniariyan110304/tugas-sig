<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GIS Fasilitas Umum')</title>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin=""/>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Responsive Navbar & Sidebar CSS -->
    <style>
        :root {
            --primary: #4e73df;
            --primary-dark: #224abe;
            --sidebar-width: 250px;
            --topbar-height: 70px;
            --transition-speed: 0.3s;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        /* Main Wrapper */
        #app-wrapper {
            display: flex;
            min-height: 100vh;
            background: #f8f9fc;
            position: relative;
        }
        
        /* Mobile Top Navigation */
        .mobile-nav {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1050;
            padding: 0 15px;
            align-items: center;
            justify-content: space-between;
        }
        
        @media (max-width: 992px) {
            .mobile-nav {
                display: flex;
            }
        }
        
        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .mobile-brand-icon {
            color: var(--primary);
            font-size: 1.5rem;
        }
        
        .mobile-brand-text {
            font-weight: 600;
            color: #2e59d9;
            font-size: 1.1rem;
        }
        
        .mobile-menu-btn {
            background: none;
            border: none;
            font-size: 1.3rem;
            color: #5a5c69;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .mobile-menu-btn:hover {
            background: #f8f9fc;
        }
        
        /* Sidebar - Desktop */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1040;
            transition: transform var(--transition-speed) ease;
            overflow-y: auto;
            box-shadow: 3px 0 15px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }
        
        /* Sidebar - Mobile State */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                top: 60px;
                bottom: 0;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
        }
        
        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1039;
            transition: opacity var(--transition-speed) ease;
        }
        
        .sidebar-overlay.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        /* Sidebar Content */
        .sidebar-content {
            flex: 1;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        /* Sidebar Brand */
        .sidebar-brand {
            text-align: center;
            padding: 0 20px 25px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .sidebar-brand-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }
        
        .sidebar-brand-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .sidebar-brand-subtitle {
            font-size: 0.85rem;
            opacity: 0.7;
        }
        
        /* Sidebar Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 0 15px;
        }
        
        .sidebar-nav .nav-item {
            margin-bottom: 5px;
        }
        
        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            text-decoration: none;
            gap: 12px;
        }
        
        .sidebar-nav .nav-link i {
            width: 22px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        .sidebar-nav .nav-link span {
            flex: 1;
            font-size: 0.95rem;
        }
        
        .sidebar-nav .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
        }
        
        .sidebar-nav .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.2);
            font-weight: 600;
        }
        
        /* Sidebar Footer */
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            font-size: 0.8rem;
            opacity: 0.7;
        }
        
        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left var(--transition-speed) ease;
        }
        
        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
                padding-top: 60px;
            }
        }
        
        /* Content Container */
        .content-container {
            padding: 25px;
        }
        
        @media (max-width: 768px) {
            .content-container {
                padding: 20px 15px;
            }
        }
        
        /* Alerts Responsive */
        .alert {
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border: none;
            border-left: 4px solid;
        }
        
        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
            border-left-color: #0f5132;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #842029;
            border-left-color: #842029;
        }
        
        .alert-dismissible .btn-close {
            padding: 1rem;
        }
        
        /* Footer Responsive */
        .main-footer {
            background: white;
            padding: 20px 0;
            border-top: 1px solid #e3e6f0;
            margin-top: auto;
        }
        
        .footer-content {
            text-align: center;
            color: #6e707e;
            font-size: 0.9rem;
        }
        
        /* Loading Spinner */
        .loading-spinner {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.9);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        
        .loading-spinner.active {
            display: flex;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideInLeft {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        
        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }
        
        /* Print Styles */
        @media print {
            .sidebar, .mobile-nav, .main-footer, .no-print {
                display: none !important;
            }
            
            .main-content {
                margin-left: 0 !important;
                padding-top: 0 !important;
            }
        }
        
        /* Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Mobile Top Navigation -->
    <nav class="mobile-nav">
        <div class="mobile-brand">
            <i class="fas fa-map-marked-alt mobile-brand-icon"></i>
            <span class="mobile-brand-text">GIS Fasilitas</span>
        </div>
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>
    </nav>
    
    <!-- Sidebar Overlay (Mobile Only) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-content">
            <!-- Brand Logo & Title -->
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h4 class="sidebar-brand-title">GIS Fasilitas</h4>
                <div class="sidebar-brand-subtitle">Sistem Informasi Geografis</div>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-map"></i>
                            <span>Peta Fasilitas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('facilities/create') ? 'active' : '' }}" href="{{ route('facilities.create') }}">
                            <i class="fas fa-plus-circle"></i>
                            <span>Tambah Fasilitas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('facilities') && !Request::is('/') ? 'active' : '' }}" href="{{ route('facilities.index') }}">
                            <i class="fas fa-list"></i>
                            <span>Daftar Fasilitas</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="sidebar-footer">
                <small>&copy; {{ date('Y') }} GIS App v1.0</small>
            </div>
        </div>
    </aside>
    
    <!-- Main Content Wrapper -->
    <div id="app-wrapper">
        <!-- Loading Spinner -->
        <div class="loading-spinner" id="loadingSpinner">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <main class="main-content" id="mainContent">
            <div class="content-container">
                <!-- Auto-close alerts after 5 seconds -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" data-auto-dismiss="5000">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-3 fa-lg"></i>
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-circle me-3 fa-lg mt-1"></i>
                        <div>
                            <strong>Terjadi kesalahan!</strong>
                            <ul class="mb-0 mt-2 ps-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                @yield('content')
            </div>
            
            <!-- Main Footer -->
            <footer class="main-footer">
                <div class="container-fluid">
                    <div class="footer-content">
                        <p class="mb-1">
                            &copy; {{ date('Y') }} GIS Fasilitas Umum - Kelompok Tugas GIS
                        </p>
                        <p class="mb-0">
                            <small>Program Studi Sistem Informasi – STT Terpadu Nurul Fikri</small>
                        </p>
                    </div>
                </div>
            </footer>
        </main>
    </div>
    
    <!-- JavaScript Libraries -->
    <!-- Bootstrap 5 Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- Responsive Navigation Script -->
    <script>
    $(document).ready(function() {
        // Elements
        const mobileMenuBtn = $('#mobileMenuBtn');
        const sidebar = $('#sidebar');
        const sidebarOverlay = $('#sidebarOverlay');
        const mainContent = $('#mainContent');
        const loadingSpinner = $('#loadingSpinner');
        
        // Toggle sidebar on mobile
        function toggleSidebar() {
            sidebar.toggleClass('show');
            sidebarOverlay.toggleClass('show');
            
            // Prevent body scroll when sidebar is open
            if (sidebar.hasClass('show')) {
                $('body').css('overflow', 'hidden');
            } else {
                $('body').css('overflow', 'auto');
            }
        }
        
        // Close sidebar when clicking overlay
        function closeSidebar() {
            sidebar.removeClass('show');
            sidebarOverlay.removeClass('show');
            $('body').css('overflow', 'auto');
        }
        
        // Event Listeners
        mobileMenuBtn.click(toggleSidebar);
        sidebarOverlay.click(closeSidebar);
        
        // Close sidebar when clicking outside on mobile
        $(document).on('click', function(event) {
            if ($(window).width() <= 992) {
                if (!$(event.target).closest('.sidebar, .mobile-menu-btn').length) {
                    closeSidebar();
                }
            }
        });
        
        // Close sidebar on escape key
        $(document).on('keydown', function(event) {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });
        
        // Auto-dismiss alerts
        $('[data-auto-dismiss]').each(function() {
            const delay = $(this).data('auto-dismiss');
            setTimeout(() => {
                $(this).alert('close');
            }, delay);
        });
        
        // Show loading spinner on page transitions
        $(document).on('click', 'a', function(e) {
            const href = $(this).attr('href');
            const isExternal = href.startsWith('http') || href.startsWith('//');
            const isAnchor = href.startsWith('#');
            const isSamePage = href === window.location.pathname;
            
            if (!isExternal && !isAnchor && !isSamePage) {
                loadingSpinner.addClass('active');
            }
        });
        
        // Hide loading spinner when page is loaded
        $(window).on('load', function() {
            loadingSpinner.removeClass('active');
        });
        
        // Adjust content padding based on device
        function adjustContentPadding() {
            if ($(window).width() <= 992) {
                mainContent.css('padding-top', '60px');
            } else {
                mainContent.css('padding-top', '0');
            }
        }
        
        // Initial adjustment
        adjustContentPadding();
        
        // Adjust on resize
        $(window).resize(function() {
            adjustContentPadding();
            
            // Close sidebar when switching to desktop
            if ($(window).width() > 992) {
                closeSidebar();
            }
        });
        
        // Smooth scroll for anchor links
        $('a[href^="#"]').on('click', function(e) {
            if (this.hash !== '') {
                e.preventDefault();
                
                const hash = this.hash;
                $('html, body').animate({
                    scrollTop: $(hash).offset().top - 20
                }, 300);
            }
        });
        
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>
    
    @stack('scripts')
</body>
</html>