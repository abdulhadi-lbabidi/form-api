<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
        state: $wire.entangle('{{ $getStatePath() }}'),
        loading: false,
        errorMessage: '',
        successMessage: '',
    
        getLocation() {
            if (!('geolocation' in navigator)) {
                this.errorMessage = 'متصفحك لا يدعم خاصية تحديد الموقع الجغرافي.';
                return;
            }
    
            this.loading = true;
            this.errorMessage = '';
            this.successMessage = 'جاري طلب إذن الوصول...';
    
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
    
                    this.state = { lat: lat, lng: lng };
                    this.loading = false;
                    this.successMessage = 'تم تحديد الموقع بنجاح!';
                },
                (error) => {
                    this.loading = false;
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            this.errorMessage = 'تم رفض الوصول للموقع من المتصفح.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            this.errorMessage = 'معلومات الموقع غير متوفرة.';
                            break;
                        case error.TIMEOUT:
                            this.errorMessage = 'انتهت مهلة طلب الموقع.';
                            break;
                        default:
                            this.errorMessage = 'حدث خطأ غير معروف.';
                            break;
                    }
                }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        }
    }" class="space-y-2">

        <!-- صندوق تحكم صغير ومنسق -->
        <div
            class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 p-3 bg-gray-50 dark:bg-white/5 rounded-lg border border-gray-200 dark:border-white/10">

            <!-- زر جلب الموقع باستخدام مكونات Filament -->
            <x-filament::button type="button" color="primary" size="sm" x-on:click="getLocation()"
                x-bind:disabled="loading">
                <span x-show="!loading">تحديد موقعي الحالي (GPS)</span>
                <span x-show="loading">جاري التحديد...</span>
            </x-filament::button>

            <!-- زر حذف الموقع إذا وجد -->
            <button type="button" x-show="state && state.lat" x-on:click="state = null; successMessage = ''"
                class="text-xs text-danger-600 hover:underline">
                إزالة الإحداثيات
            </button>
        </div>

        <!-- رسائل الحالة -->
        <div>
            <p x-text="successMessage" x-show="successMessage" class="text-xs text-success-600 font-medium"></p>
            <p x-text="errorMessage" x-show="errorMessage" class="text-xs text-danger-600 font-medium"></p>
        </div>

        <!-- عرض الإحداثيات ورابط الخريطة بشكل مرتب جداً وصغير -->
        <div x-show="state && state.lat && state.lng"
            class="flex items-center justify-between p-2.5 bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-white/10 text-xs">
            <div class="flex items-center gap-3 font-mono text-gray-600 dark:text-gray-300">
                <div>Lat: <span class="font-semibold text-gray-900 dark:text-white"
                        x-text="state?.lat ? Number(state.lat).toFixed(5) : ''"></span></div>
                <div>Lng: <span class="font-semibold text-gray-900 dark:text-white"
                        x-text="state?.lng ? Number(state.lng).toFixed(5) : ''"></span></div>
            </div>

            <a x-bind:href="`https://www.google.com/maps?q=${state?.lat},${state?.lng}`" target="_blank"
                class="text-primary-600 dark:text-primary-400 hover:underline font-medium inline-flex items-center gap-1">
                <span>فتح الخريطة</span>
            </a>
        </div>

    </div>
</x-dynamic-component>
