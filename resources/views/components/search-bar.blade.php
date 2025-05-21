<div class="w-full max-w-[1400px] mx-auto px-4 z-10 relative">
    <form id="searchForm" action="{{ route('property.search') }}" method="GET">
        <div style="filter: drop-shadow(0px 8px 10px rgba(0, 0, 0, 0.3));" class="overflow-visible">
            <div class="bg-airbnb-light flex items-center w-full rounded-full overflow-x-auto md:overflow-hidden min-w-[300px] md:min-w-[600px] scrollbar-hide">
                <!-- Place Location -->
                <div class="flex-shrink-0 flex-1 border-r border-gray-900 py-1 px-2 mx-3 my-2 min-h-[50px] min-w-[180px]">
                    <div class="text-sm text-[#6e7672] mb-1">Place Location</div>
                    <div class="flex items-center gap-1">
                        <i class="w-6 h-6 text-airbnb-dark" data-lucide="map-pin"></i>
                        <input
                            type="text"
                            name="location"
                            value="{{ session('search_results.params.location') ?? 'Cebu City' }}"
                            class="input-field text-xl font-medium text-airbnb-darkest"
                            required
                        >
                    </div>
                </div>

                <!-- Arrival Date -->
                <div class="flex-shrink-0 flex-1 border-r border-gray-900 py-1 px-2 min-h-[50px] min-w-[150px]">
                    <div class="text-sm text-[#6e7672] mb-1">Arrival Date</div>
                    <div class="flex items-center gap-2">
                        <input
                            type="date"
                            name="check_in"
                            class="input-field text-xl font-medium text-airbnb-darkest"
                            min="{{ date('Y-m-d') }}"
                            value="{{ session('search_results.params.check_in') ?? date('Y-m-d') }}"
                            required
                        >
                    </div>
                </div>

                <!-- Departure Date -->
                <div class="flex-shrink-0 flex-1 border-r border-gray-900 py-1 px-2 min-h-[50px] min-w-[150px]">
                    <div class="text-sm text-[#6e7672] mb-1">Departure Date</div>
                    <div class="flex items-center gap-2">
                        <input
                            type="date"
                            name="check_out"
                            class="input-field text-xl font-medium text-airbnb-darkest"
                            min="{{ date('Y-m-d') }}"
                            value="{{ session('search_results.params.check_out') ?? date('Y-m-d', strtotime('+1 day')) }}"
                            required
                        >
                    </div>
                </div>

                <!-- Room & Guest -->
                <div class="flex-shrink-0 flex-1 border-r border-gray-900 py-1 px-2 min-h-[50px] min-w-[150px]">
                    <div class="text-sm text-[#6e7672] mb-1">Room & Guest</div>
                    <div class="flex items-center gap-2">
                        <i class="w-6 h-6 text-housify-darkest" data-lucide="door-open"></i>
                        <input
                            type="number"
                            name="rooms"
                            value="{{ session('search_results.params.rooms') ?? '2' }}"
                            min="1"
                            class="number-input-hidden-arrows w-[30px] text-center bg-transparent border-none outline-none text-xl mr-[10px] font-medium">
                        <i class="w-6 h-6 text-housify-darkest" data-lucide="users"></i>
                        <input
                            type="number"
                            name="guests"
                            value="{{ session('search_results.params.guests') ?? '5' }}"
                            min="1"
                            class="number-input-hidden-arrows w-[30px] text-center bg-transparent border-none outline-none text-xl mr-[10px] font-medium">
                    </div>
                </div>

                <!-- Search Button -->
                <div class="flex-shrink-0 bg-airbnb-darkest flex items-center justify-center py-1 px-6 md:px-12 rounded-full mx-3 my-2 min-h-[50px]">
                    <button
                        type="submit"
                        class="text-airbnb-light text-base font-medium w-full h-full whitespace-nowrap"
                    >
                        Search
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('searchForm');

            // Set default check_out to tomorrow if not in session
            const checkIn = form.querySelector('input[name="check_in"]');
            const checkOut = form.querySelector('input[name="check_out"]');

            if (!checkOut.value) {
                const tomorrow = new Date(checkIn.value);
                tomorrow.setDate(tomorrow.getDate() + 1);
                checkOut.valueAsDate = tomorrow;
            }

            // Form validation
            form.addEventListener('submit', function(e) {
                if (new Date(checkOut.value) <= new Date(checkIn.value)) {
                    e.preventDefault();
                    alert('Departure date must be after arrival date');
                    return false;
                }
                return true;
            });

            // Update min check_out when check_in changes
            checkIn.addEventListener('change', function() {
                const minDate = new Date(this.value);
                minDate.setDate(minDate.getDate() + 1);
                checkOut.min = minDate.toISOString().split('T')[0];

                // Auto-update check_out if it's now invalid
                if (new Date(checkOut.value) <= new Date(this.value)) {
                    checkOut.valueAsDate = minDate;
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.5);
        }
        .number-input-hidden-arrows {
            -moz-appearance: textfield;
        }
        .number-input-hidden-arrows::-webkit-outer-spin-button,
        .number-input-hidden-arrows::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endpush
