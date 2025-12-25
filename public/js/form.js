$(document).ready(function () {

    const DEFAULT_LAT = window.mapConfig.lat;
    const DEFAULT_LNG = window.mapConfig.lng;

    /* ================= MAP INIT ================= */
    const locationMap = L.map('locationPickerMap')
        .setView([DEFAULT_LAT, DEFAULT_LNG], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 19
    }).addTo(locationMap);



    const marker = L.marker([DEFAULT_LAT, DEFAULT_LNG], {
        draggable: true,
    }).addTo(locationMap);

    function updateCoordinates(lat, lng) {
        $('#latitude').val(lat.toFixed(6));
        $('#longitude').val(lng.toFixed(6));
        marker.setLatLng([lat, lng]);
        locationMap.panTo([lat, lng], { animate: true });
    }

    marker.on('dragend', function () {
        const pos = marker.getLatLng();
        updateCoordinates(pos.lat, pos.lng);
    });

    locationMap.on('click', function (e) {
        updateCoordinates(e.latlng.lat, e.latlng.lng);
    });

    $('#latitude, #longitude').on('input', function () {
        const lat = parseFloat($('#latitude').val());
        const lng = parseFloat($('#longitude').val());
        if (!isNaN(lat) && !isNaN(lng)) {
            updateCoordinates(lat, lng);
        }
    });

    $('#resetForm').on('click', function () {
        $('#facilityForm')[0].reset();
        updateCoordinates(DEFAULT_LAT, DEFAULT_LNG);
    });

    updateCoordinates(DEFAULT_LAT, DEFAULT_LNG);
    setTimeout(() => locationMap.invalidateSize(), 100);

});
