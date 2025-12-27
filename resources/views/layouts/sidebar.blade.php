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
                 <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                     <i class="fas fa-list"></i>
                     <span>Daftar Fasilitas</span>
                 </a>
             </li>
     
             {{-- Logout (hanya tampil kalau login) --}}
             @auth
             <li class="nav-item mt-3">
                 <form method="POST" action="{{ route('logout') }}">
                     @csrf
                     <button type="submit" class="nav-link btn btn-link text-left w-100">
                         <i class="fas fa-sign-out-alt"></i>
                         <span>Logout</span>
                     </button>
                 </form>
             </li>
             @endauth
     
             {{-- Login (kalau belum login) --}}
             @guest
             <li class="nav-item mt-3">
                 <a class="nav-link" href="{{ route('login') }}">
                     <i class="fas fa-sign-in-alt"></i>
                     <span>Logout</span>
                 </a>
             </li>
             @endguest
     
         </ul>
     </nav>
     

      <!-- Sidebar Footer -->
      <div class="sidebar-footer">
          <p class="mb-0">Riyan Kurnia</p>
          <p class="mb-0">Rivaldi Jaya Alkhana</p>
          <p class="mb-0">Zharifah Dzikra Purnomo</p>
      </div>
  </div>
</aside>