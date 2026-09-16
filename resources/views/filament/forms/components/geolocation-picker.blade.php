<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
        state: $wire.entangle('{{ $getStatePath() }}'),
        loading: false,
        errorMsg: null,
        getLocation() {
            this.loading = true;
            this.errorMsg = null;
    
            if (!navigator.geolocation) {
                this.errorMsg = 'المتصفح لا يدعم تحديد الموقع الجغرافي';
                this.loading = false;
                return;
            }
    
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    this.state = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    this.loading = false;
                },
                (err) => {
                    this.errorMsg = 'تعذر الحصول على الموقع: ' + err.message;
                    this.loading = false;
                }, { enableHighAccuracy: true, timeout: 10000 }
            );
        }
    }" class="flex flex-col gap-2">
        <button type="button" x-on:click="getLocation()" :disabled="loading"
            class="fi-btn fi-btn-size-md fi-color-primary fi-btn-color-primary inline-flex items-center justify-center gap-1 rounded-lg px-3 py-2 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-500 disabled:opacity-70">
            <span x-show="!loading">📍 تحديد الموقع الحالي</span>
            <span x-show="loading" x-cloak>جاري تحديد الموقع...</span>
        </button>

        <p x-show="state && state.lat" x-text="state ? ('Lat: ' + state.lat + ' , Lng: ' + state.lng) : ''"
            class="text-sm text-gray-500 dark:text-gray-400"></p>

        <p x-show="errorMsg" x-text="errorMsg" x-cloak class="text-sm text-danger-600"></p>
    </div>
</x-dynamic-component>
