<x-filament::section class="w-full">
    <x-slot name="heading">
        <div class="flex justify-between items-center w-full">
            <span>خريطة توزيع الشركات والعمال والكوادر والحدود الجغرافية</span>
            <div class="flex gap-4 text-xs font-semibold">
                <span class="flex items-center gap-1">
                    <span class="w-3 h-3 rounded-full inline-block bg-blue-600"></span> الشركات
                </span>
                <span class="flex items-center gap-1">
                    <span class="w-3 h-3 rounded-full inline-block bg-purple-600"></span> العمال
                </span>
                <span class="flex items-center gap-1">
                    <span class="w-3 h-3 rounded-full inline-block bg-emerald-600"></span> الكوادر
                </span>
            </div>
        </div>
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
    
                        // رسم حدود المنطقة الجغرافية
                        let polygon = L.polygon(loc.coordinates, {
                            color: '#3b82f6',
                            fillColor: '#93c5fd',
                            fillOpacity: 0.3,
                            weight: 2
                        }).addTo(this.map);
    
                        // تجهيز محتوى النافذة المنبثقة (Popup) مع تفاصيل الشركات والعمال والكوادر
                        let popupContent = `
                                        <div style='font-family: Cairo, sans-serif; text-align: right; direction: rtl; max-width: 220px;'>
                                            <strong style='font-size: 14px; color: #1e3a8a;'>${loc.name}</strong>
                                            <hr style='margin: 5px 0;'>
                                            <div style='color: #2563eb; font-weight: bold; margin-bottom: 4px;'>
                                                🏢 الشركات (${loc.companies_count})
                                            </div>
                                            <div style='color: #7c3aed; font-weight: bold; margin-bottom: 4px;'>
                                                👥 العمال (${loc.workers_count})
                                            </div>
                                            <div style='color: #059669; font-weight: bold; margin-bottom: 4px;'>
                                                👨‍💼 الكوادر (${loc.kadrs_count})
                                            </div>
                                        </div>
                                    `;
    
                        polygon.bindPopup(popupContent);
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

        <div id="all-locations-map" class="w-full" style="height: 500px; border-radius: 8px; z-index: 10;"></div>
    </div>
</x-filament::section>
