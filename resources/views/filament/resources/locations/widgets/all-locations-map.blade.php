{{-- <x-filament::section class="w-full col-span-full">
    <x-slot name="heading">
        خريطة جميع المناطق والحدود الجغرافية
    </x-slot>

    <div x-data="{
        map: null,
        initMap() {
            if (typeof L === 'undefined') {
                let script = document.createElement('script');
                script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                script.onload = () => this.renderMap();
                document.head.appendChild(script);
            } else {
                this.renderMap();
            }
        },
        renderMap() {
            if (this.map) return;

            let locations = @js($locations);

            // إنشاء الخريطة
            this.map = L.map('all-locations-map').setView([36.2021, 37.1343], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(this.map);

            let bounds = L.latLngBounds();
            let hasLocations = false;

            if (locations && locations.length > 0) {
                locations.forEach(loc => {
                    if (loc.coordinates && loc.coordinates.length > 0) {
                        let polygon = L.polygon(loc.coordinates, {
                            color: '#3b82f6',
                            fillColor: '#60a5fa',
                            fillOpacity: 0.4,
                            weight: 2
                        }).addTo(this.map);

                        polygon.bindPopup(`<strong>${loc.name}</strong>`);
                        bounds.extend(polygon.getBounds());
                        hasLocations = true;
                    }
                });

                if (hasLocations) {
                    this.map.fitBounds(bounds);
                }
            }

            // تحديث حجم الخريطة لتتلاءم مع العرض الجديد بعد الرسم
            setTimeout(() => { this.map.invalidateSize(); }, 200);
        }
    }" x-init="setTimeout(() => initMap(), 300)" class="w-full col-span-full">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

        <!-- جعل الخريطة تأخذ العرض الكامل بنسبة 100% -->
        <div id="all-locations-map" style="height: 480px; width: 100%; border-radius: 8px; z-index: 10;"></div>
    </div>
</x-filament::section> --}}


<x-filament::section class="w-full">
    <x-slot name="heading">
        خريطة جميع المناطق والحدود الجغرافية
    </x-slot>

    <div x-data="{
        map: null,
    
        initMap() {
            if (typeof L === 'undefined') {
                let script = document.createElement('script');
                script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
    
                script.onload = () => this.renderMap();
    
                document.head.appendChild(script);
            } else {
                this.renderMap();
            }
        },
    
        renderMap() {
            if (this.map) return;
    
            let locations = @js($locations);
    
            this.map = L.map('all-locations-map')
                .setView([36.2021, 37.1343], 13);
    
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(this.map);
    
            let bounds = L.latLngBounds();
            let hasLocations = false;
    
            if (locations && locations.length > 0) {
                locations.forEach(loc => {
                    if (loc.coordinates && loc.coordinates.length > 0) {
    
                        let polygon = L.polygon(loc.coordinates, {
                            color: '#3b82f6',
                            fillColor: '#60a5fa',
                            fillOpacity: 0.4,
                            weight: 2
                        }).addTo(this.map);
    
                        polygon.bindPopup(`<strong>${loc.name}</strong>`);
    
                        bounds.extend(polygon.getBounds());
    
                        hasLocations = true;
                    }
                });
    
                if (hasLocations) {
                    this.map.fitBounds(bounds);
                }
            }
    
            setTimeout(() => {
                this.map.invalidateSize();
            }, 300);
        }
    }" x-init="setTimeout(() => initMap(), 300)" class="w-full">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

        <div id="all-locations-map" class="w-full" style="height: 480px; border-radius: 8px; z-index: 10;"></div>
    </div>
</x-filament::section>
