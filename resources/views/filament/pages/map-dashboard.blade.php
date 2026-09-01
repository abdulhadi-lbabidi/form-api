<div>
    <div class="space-y-6 w-full">
        {{-- قسم الخريطة --}}
        {{-- <x-filament::section class="w-full">
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

            <div wire:ignore x-data="{
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

                    this.map = L.map('map-dashboard-container').setView([36.2021, 37.1343], 13);

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
                                    fillColor: '#93c5fd',
                                    fillOpacity: 0.3,
                                    weight: 2
                                }).addTo(this.map);

                                polygon.on('mouseover', function() {
                                    this.setStyle({ fillOpacity: 0.5, weight: 3 });
                                });
                                polygon.on('mouseout', function() {
                                    this.setStyle({ fillOpacity: 0.3, weight: 2 });
                                });

                                polygon.on('click', () => {
                                    $wire.selectCity(loc.name);

                                    setTimeout(() => {
                                        document.getElementById('city-results-section')
                                            ?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                    }, 150);
                                });

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
                                                                                                                                                                                                                <div style='margin-top: 6px; font-size: 11px; color: #6b7280; text-align: center;'>انقر لعرض الكروت في الأسفل</div>
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
            }" x-init="initMap()" class="w-full">
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                <div id="map-dashboard-container" class="w-full"
                    style="height: 500px; border-radius: 8px; z-index: 10;">
                </div>
            </div>
        </x-filament::section> --}}




        {{-- قسم الخريطة --}}
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

            <div wire:ignore x-data="{
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
                    let mapContainer = document.getElementById('map-dashboard-container');
            
                    this.map = L.map('map-dashboard-container').setView([36.2021, 37.1343], 13);
            
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(this.map);
            
                    // ===== زر التكبير Fullscreen =====
                    let FullscreenControl = L.Control.extend({
                        options: { position: 'topleft' },
            
                        onAdd: function(map) {
                            let container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
                            let button = L.DomUtil.create('a', '', container);
                            button.href = '#';
                            button.title = 'ملء الشاشة';
                            button.innerHTML = '⛶';
                            button.style.fontSize = '18px';
                            button.style.fontWeight = 'bold';
                            button.style.display = 'flex';
                            button.style.alignItems = 'center';
                            button.style.justifyContent = 'center';
                            button.style.width = '30px';
                            button.style.height = '30px';
                            button.style.backgroundColor = '#ffffff';
            
                            L.DomEvent.disableClickPropagation(container);
            
                            L.DomEvent.on(button, 'click', function(e) {
                                L.DomEvent.stop(e);
            
                                if (!document.fullscreenElement) {
                                    mapContainer.requestFullscreen().catch(err => {
                                        console.error('تعذر تفعيل ملء الشاشة:', err);
                                    });
                                } else {
                                    document.exitFullscreen();
                                }
                            });
            
                            return container;
                        }
                    });
            
                    this.map.addControl(new FullscreenControl());
            
                    // حل مشكلة العودة للوضع الطبيعي وتحديث المقاسات بدقة
                    document.addEventListener('fullscreenchange', () => {
                        if (document.fullscreenElement === mapContainer) {
                            mapContainer.style.height = '100vh';
                            mapContainer.style.width = '100vw';
                        } else {
                            mapContainer.style.height = '500px';
                            mapContainer.style.width = '100%';
                        }
            
                        // إعادة ضبط حجم الخريطة على دفعات لضمان عمل الـ Render بشكل صحيح
                        setTimeout(() => {
                            if (this.map) {
                                this.map.invalidateSize(true);
                            }
                        }, 100);
            
                        setTimeout(() => {
                            if (this.map) {
                                this.map.invalidateSize(true);
                            }
                        }, 300);
                    });
                    // ===== نهاية زر ملء الشاشة =====
            
                    let bounds = L.latLngBounds();
                    let hasLocations = false;
            
                    if (locations && locations.length > 0) {
                        locations.forEach(loc => {
                            if (loc.coordinates && loc.coordinates.length > 0) {
            
                                let polygon = L.polygon(loc.coordinates, {
                                    color: '#3b82f6',
                                    fillColor: '#93c5fd',
                                    fillOpacity: 0.3,
                                    weight: 2
                                }).addTo(this.map);
            
                                polygon.on('mouseover', function() {
                                    this.setStyle({ fillOpacity: 0.5, weight: 3 });
                                });
                                polygon.on('mouseout', function() {
                                    this.setStyle({ fillOpacity: 0.3, weight: 2 });
                                });
            
                                polygon.on('click', () => {
                                    $wire.selectCity(loc.name);
            
                                    setTimeout(() => {
                                        document.getElementById('city-results-section')
                                            ?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                    }, 150);
                                });
            
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
                                                                                    <div style='margin-top: 6px; font-size: 11px; color: #6b7280; text-align: center;'>انقر لعرض الكروت في الأسفل</div>
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
            }" x-init="initMap()" class="w-full">
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                <div id="map-dashboard-container" class="w-full"
                    style="height: 500px; border-radius: 8px; z-index: 10;">
                </div>
            </div>
        </x-filament::section>



        {{-- قسم الكروت والتفاصيل --}}
        <div id="city-results-section" class="mt-6 space-y-8 w-full relative">

            {{-- مؤشر تحميل --}}
            <div wire:loading wire:target="selectCity, loadMoreWorkers, loadMoreCompanies, loadMoreKadrs"
                class="absolute inset-0 z-20 flex items-center justify-center bg-white/70 dark:bg-gray-900/70 rounded-2xl backdrop-blur-sm">
                <div class="flex items-center gap-3 text-primary-600 font-semibold">
                    <svg class="animate-spin h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    جاري تحميل البيانات...
                </div>
            </div>

            @if ($selectedCity)
                {{-- شريط الإحصائيات --}}
                <div class="rounded-2xl overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700">
                    <div
                        class="bg-gradient-to-l from-primary-600 to-primary-500 px-6 py-4 text-white flex items-center justify-between flex-wrap gap-3">
                        <div class="flex items-center gap-2 text-xl font-bold">
                            📍 {{ $selectedCity }}
                        </div>
                        <div class="flex gap-3 flex-wrap text-sm font-semibold">
                            <span class="bg-white/20 rounded-full px-3 py-1">🏢 {{ $cityCounts['companies'] }}
                                شركة</span>
                            <span class="bg-white/20 rounded-full px-3 py-1">👥 {{ $cityCounts['workers'] }} عامل</span>
                            <span class="bg-white/20 rounded-full px-3 py-1">👨‍💼 {{ $cityCounts['kadrs'] }}
                                كادر</span>
                        </div>
                    </div>
                </div>

                @php
                    $sections = [
                        [
                            'title' => 'قسم العمال',
                            'items' => $this->workers,
                            'count' => $cityCounts['workers'],
                            'action' => 'loadMoreWorkers',
                            'color' => 'purple',
                            'borderClass' => 'border-t-purple-500',
                            'avatarBg' => 'bg-purple-100 dark:bg-purple-900/40',
                            'avatarText' => 'text-purple-700 dark:text-purple-300',
                            'badgeBg' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300',
                            'icon' => '👥',
                            'empty' => 'لا يوجد عمال في هذه المنطقة.',
                        ],
                        [
                            'title' => 'قسم الشركات',
                            'items' => $this->companies,
                            'count' => $cityCounts['companies'],
                            'action' => 'loadMoreCompanies',
                            'color' => 'blue',
                            'borderClass' => 'border-t-blue-500',
                            'avatarBg' => 'bg-blue-100 dark:bg-blue-900/40',
                            'avatarText' => 'text-blue-700 dark:text-blue-300',
                            'badgeBg' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                            'icon' => '🏢',
                            'empty' => 'لا توجد شركات في هذه المنطقة.',
                        ],
                        [
                            'title' => 'قسم الكوادر',
                            'items' => $this->kadrs,
                            'count' => $cityCounts['kadrs'],
                            'action' => 'loadMoreKadrs',
                            'color' => 'emerald',
                            'borderClass' => 'border-t-emerald-500',
                            'avatarBg' => 'bg-emerald-100 dark:bg-emerald-900/40',
                            'avatarText' => 'text-emerald-700 dark:text-emerald-300',
                            'badgeBg' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                            'icon' => '👨‍💼',
                            'empty' => 'لا توجد كوادر في هذه المنطقة.',
                        ],
                    ];
                @endphp

                @foreach ($sections as $section)
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-{{ $section['color'] }}-600 flex items-center gap-2">
                            <span>{{ $section['icon'] }}</span> {{ $section['title'] }}
                            <span class="text-xs font-normal {{ $section['badgeBg'] }} rounded-full px-2 py-0.5">
                                {{ $section['count'] }}
                            </span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 w-full">
                            @forelse($section['items'] as $item)
                                <div
                                    class="group bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 {{ $section['borderClass'] }} rounded-2xl p-5 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition duration-200 flex flex-col justify-between">
                                    <div class="space-y-2 text-right" dir="rtl">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-9 h-9 shrink-0 rounded-full {{ $section['avatarBg'] }} flex items-center justify-center {{ $section['avatarText'] }} font-bold text-sm">
                                                {{ mb_substr($item->full_name ?? ($item->company_name ?? ($item->name ?? '?')), 0, 1) }}
                                            </div>
                                            <div class="font-bold text-sm text-gray-900 dark:text-white truncate flex-1"
                                                title="{{ $item->full_name ?? ($item->company_name ?? $item->name) }}">
                                                {{ $item->full_name ?? ($item->company_name ?? $item->name) }}
                                            </div>
                                        </div>

                                        <div
                                            class="text-xs text-gray-500 dark:text-gray-400 space-y-1 pt-1 border-t border-gray-100 dark:border-gray-800">
                                            @if (isset($item->primary_profession))
                                                <div>💼 {{ $item->primary_profession ?? 'غير محدد' }}</div>
                                            @endif
                                            @if (isset($item->business_type))
                                                <div>💼 {{ $item->business_type ?? 'غير محدد' }}</div>
                                            @endif
                                            @if (isset($item->number_of_person))
                                                <div>👥 {{ $item->number_of_person ?? 'غير متوفر' }} شخص</div>
                                            @endif
                                            <div class="flex items-center gap-1">
                                                📞 <span dir="ltr"
                                                    class="font-mono text-gray-700 dark:text-gray-300">
                                                    {{ $item->phone_whatsapp ?? ($item->phone_number ?? ($item->phone ?? 'غير متوفر')) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="col-span-full text-gray-400 text-sm bg-white dark:bg-gray-900 p-4 rounded-xl text-center border border-dashed border-gray-300 dark:border-gray-700">
                                    {{ $section['empty'] }}
                                </div>
                            @endforelse
                        </div>

                        {{-- زر عرض المزيد إذا كان هناك عناصر متبقية --}}
                        @if ($section['items']->count() < $section['count'])
                            <div class="flex justify-center pt-4 w-full">
                                <button type="button" wire:click="{{ $section['action'] }}"
                                    class="px-6 py-2.5 bg-primary-600 hover:bg-primary-500 text-white dark:bg-primary-600 dark:hover:bg-primary-500 rounded-xl text-sm font-semibold transition shadow-md flex items-center gap-2 cursor-pointer">
                                    <span>عرض المزيد</span>
                                    <span class="bg-white/25 px-2 py-0.5 rounded-lg text-xs">
                                        المتبقي {{ $section['count'] - $section['items']->count() }}
                                    </span>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div
                    class="text-center text-gray-400 py-10 bg-white dark:bg-gray-900 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700">
                    🗺️ الرجاء النقر على أي منطقة أو مضلع في الخريطة لعرض تفاصيل الشركات والعمال والكوادر الخاصة بها.
                </div>
            @endif
        </div>
    </div>
</div>
