<div x-data="{ coordinates: @js($getState()) }">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div id="map-{{ $getRecord()->id }}" style="height: 400px; width: 100%; border-radius: 8px; z-index: 1;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                let coords = @js($getRecord()->coordinates);
                if (!coords || coords.length === 0) return;

                let map = L.map('map-{{ $getRecord()->id }}').setView(coords[0], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                let polygon = L.polygon(coords, {
                    color: '#3b82f6',
                    fillColor: '#60a5fa',
                    fillOpacity: 0.4
                }).addTo(map);

                map.fitBounds(polygon.getBounds());
            }, 300);
        });
    </script>
</div>
