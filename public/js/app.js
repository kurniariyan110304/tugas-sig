$(document).ready(function () {
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
    $(document).on('click', function (event) {
        if ($(window).width() <= 992) {
            if (!$(event.target).closest('.sidebar, .mobile-menu-btn').length) {
                closeSidebar();
            }
        }
    });

    // Close sidebar on escape key
    $(document).on('keydown', function (event) {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });

    // Auto-dismiss alerts
    $('[data-auto-dismiss]').each(function () {
        const delay = $(this).data('auto-dismiss');
        setTimeout(() => {
            $(this).alert('close');
        }, delay);
    });

    // Show loading spinner on page transitions
    $(document).on('click', 'a', function (e) {
        const href = $(this).attr('href');
        const isExternal = href.startsWith('http') || href.startsWith('//');
        const isAnchor = href.startsWith('#');
        const isSamePage = href === window.location.pathname;

        if (!isExternal && !isAnchor && !isSamePage) {
            loadingSpinner.addClass('active');
        }
    });

    // Hide loading spinner when page is loaded
    $(window).on('load', function () {
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
    $(window).resize(function () {
        adjustContentPadding();

        // Close sidebar when switching to desktop
        if ($(window).width() > 992) {
            closeSidebar();
        }
    });

    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function (e) {
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

let map;
let markers = [];

document.addEventListener('DOMContentLoaded', function () {
    initMap();
    loadFacilities();

    document.getElementById('typeFilter').addEventListener('change', function () {
        loadFacilities(this.value);
    });

    document.getElementById('refreshMap').addEventListener('click', function () {
        loadFacilities(document.getElementById('typeFilter').value);
    });
});

function initMap() {
    map = L.map('map').setView([-6.402484, 106.794236], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);
}

function loadFacilities(type = 'all') {
    document.getElementById('mapLoading').style.display = 'flex';

    const url = type === 'all' ?
        '/api/facilities' :
        `/api/facilities?type=${type}`;

    fetch(url)
        .then(res => res.json())
        .then(data => {
            clearMarkers();
            data.forEach(f => addMarker(f));
        })
        .finally(() => {
            document.getElementById('mapLoading').style.display = 'none';
        });
}

function addMarker(f) {
    if (!f?.latitude || !f?.longitude) return;

    const popupContent = `
        <div style="min-width:200px">
            <h6 style="margin:0 0 6px;font-weight:600">
                ${f.name ?? 'Tanpa Nama'}
            </h6>

            <div style="font-size:13px;line-height:1.4">
                <div><strong>Jenis:</strong> ${f.type ?? '-'}</div>
                <div><strong>Alamat:</strong> ${f.address ?? '-'}</div>
            </div>
        </div>
    `;

    const marker = L.marker([f.latitude, f.longitude])
        .addTo(map)
        .bindPopup(popupContent);

    markers.push(marker);
}


function clearMarkers() {
    markers.forEach(m => map.removeLayer(m));
    markers = [];
}
