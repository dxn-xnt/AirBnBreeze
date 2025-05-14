@extends('layouts.app')

@section('title', 'Request Booking')

@section('content')
<x-layout.bookings-header />

<div class="min-h-screen bg-[#E3EED4] pt-[4rem] md:pt-[7.5rem] pb-[1.5rem] sm:pb-[2rem] px-[1rem] sm:px-[1.5rem] md:px-[2rem] lg:px-[4rem] xl:px-[8rem]">
    <div class="max-w-[1750px] mx-auto">
        <!-- Back Button and Title -->
        <div class="flex items-center gap-[0.75rem] mb-[1rem] sm:mb-[1.25rem]">
            <a href="{{ route('property.show', $property['id']) }}" class="bg-[#375534] text-white rounded-full p-[0.5rem] hover:bg-opacity-90 flex items-center justify-center">
                <i class="w-[1.25rem] sm:w-[1.5rem] h-[1.25rem] sm:h-[1.5rem]" data-lucide="arrow-left"></i>
            </a>
            <h1 class="text-[1.5rem] sm:text-[1.75rem] font-semibold text-[#375534]">Request Booking</h1>
        </div>

        <!-- Property Preview -->
        <div class="flex flex-col sm:flex-row mb-[1rem] sm:mb-[1.25rem] bg-airbnb-light p-[1rem] sm:p-[1.5rem] rounded-xl shadow-sm">
            <img src="{{ asset($property['images']['main']) }}" alt="{{ $property['name'] }}" class="w-full sm:w-[180px] md:w-[240px] h-[120px] sm:h-[150px] object-cover rounded-xl sm:mr-[1rem] md:mr-[1.5rem] mb-[1rem] sm:mb-0">

            <div class="w-full">
                <div class="text-[0.75rem] text-[#375534] mb-[0.25rem]">Property Name</div>
                <div class="text-[1rem] sm:text-[1.125rem] md:text-[1.25rem] font-semibold text-[#375534]">Limosnero's Private House</div>

                <div class="grid grid-cols-2 gap-x-[1rem] gap-y-[0.5rem] mt-[0.75rem]">
                    <div>
                        <div class="text-[0.75rem] text-[#375534] mb-[0.25rem]">Location</div>
                        <div class="text-[0.875rem] sm:text-[1rem] md:text-[1.125rem] text-[#375534]">Minglanilla, Cebu</div>
                    </div>
                    <div>
                        <div class="text-[0.75rem] text-[#375534] mb-[0.25rem]">Cost per night</div>
                        <div class="text-[0.875rem] sm:text-[1rem] md:text-[1.125rem] text-[#375534]">₱ 1900</div>
                    </div>
                    <div>
                        <div class="text-[0.75rem] text-[#375534] mb-[0.25rem]">Ratings</div>
                        <div class="flex items-center">
                            <span class="text-yellow-400">★</span>
                            <span class="text-[0.875rem] sm:text-[1rem] md:text-[1.125rem] text-[#375534] ml-[0.25rem]">4.9</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Details Form -->
        <div class="bg-airbnb-light p-[1rem] sm:p-[1.5rem] pb-2 rounded-xl border border-[#375534] border-opacity-20 shadow-sm">
            <h2 class="text-[1rem] sm:text-[1.125rem] md:text-[1.25rem] font-semibold text-[#375534] mb-[1rem] sm:mb-[1.25rem]">Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-[1rem] sm:gap-[1.5rem] mb-[1.5rem] sm:mb-[2rem]">
                <!-- Guests -->
                <div class="w-full">
                    <div class="text-[0.75rem] sm:text-[0.875rem] text-[#375534] mb-[0.25rem]">Guests</div>
                    <div class="text-[0.875rem] sm:text-[1rem] text-[#375534] mb-[0.5rem] " id="guestSummary">2 adult, 1 child</div>

                    <div class="relative">
                        <div class="relative max-w-xs">
                            <!-- Dropdown trigger -->
                            <button
                                type="button"
                                class="w-full flex justify-between items-center bg-airbnb-light border border-[#375534] border-opacity-30 rounded-md py-[0.5rem] px-[0.75rem] text-[#375534] focus:outline-none text-[0.75rem] sm:text-[0.875rem]"
                                id="guestDropdownTrigger"
                                aria-expanded="false"
                                aria-haspopup="true"
                            >
                                <div class="text-[0.875rem] text-[#375534]" id="guestTotal">3 guests</div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Dropdown content -->
                            <div
                                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg py-4 px-4 hidden"
                                id="guestDropdown"
                            >
                                <div class="mb-4">
                                    <h3 class="font-medium text-gray-700 text-center">3 Guests</h3>
                                    <p class="text-xs text-gray-500 text-center">Maximum of 3 guests, not including infants.</p>
                                </div>

                                <div class="space-y-4">
                                    <!-- Adults -->
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-medium">Adults</h4>
                                            <p class="text-xs text-gray-500">Ages 13+</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="decrement-adults w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 disabled:opacity-50" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <span class="w-6 text-center" id="adultsCount">2</span>
                                            <button type="button" class="increment-adults w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Children -->
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-medium">Children</h4>
                                            <p class="text-xs text-gray-500">Ages 2-12</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="decrement-children w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 disabled:opacity-50" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <span class="w-6 text-center" id="childrenCount">1</span>
                                            <button type="button" class="increment-children w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Infants -->
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-medium">Infants</h4>
                                            <p class="text-xs text-gray-500">Under 2</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="decrement-infants w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 disabled:opacity-50" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <span class="w-6 text-center" id="infantsCount">0</span>
                                            <button type="button" class="increment-infants w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schedule -->
                <div>
                    <div class="text-[0.75rem] sm:text-[0.875rem] text-[#375534] mb-[0.25rem]">Schedule</div>
                    <div class="text-[0.875rem] sm:text-[1rem] text-[#375534] mb-[0.5rem]" id="dateRangeDisplay">April 24 - May 5</div>

                    <div class="flex gap-[0.5rem]">
                        <div class="relative flex-1">
                            <input
                                type="date"
                                id="startDate"
                                value="05/05/25"
                                min="<?php echo date('Y-m-d'); ?>"
                                class="w-full bg-airbnb-light border border-[#375534] border-opacity-30 rounded-md py-[0.5rem] px-[0.75rem] text-[#375534] focus:outline-none text-[0.75rem] sm:text-[0.875rem]"
                            >
                        </div>
                        <div class="relative flex-1">
                            <input
                                type="date"
                                id="endDate"
                                value="05/05/25"
                                min="<?php echo date('Y-m-d'); ?>"
                                class="w-full bg-airbnb-light border border-[#375534] border-opacity-30 rounded-md py-[0.5rem] px-[0.75rem] text-[#375534] focus:outline-none text-[0.75rem] sm:text-[0.875rem]"
                            >
                        </div>
                    </div>
                </div>

                <!-- Costs -->
                <div class="mt-[1rem] md:mt-0">
                    <div class="text-[0.75rem] sm:text-[0.875rem] text-[#375534] mb-[0.25rem]">Costs</div>
                    <div class="flex justify-between">
                        <div class="text-[0.875rem] sm:text-[1rem] text-[#375534]">₱ 1900 x 10</div>
                        <div class="text-[0.875rem] sm:text-[1rem] text-[#375534]">₱ 19000.00</div>
                    </div>
                    <div class="flex justify-between text-[0.75rem] sm:text-[0.875rem]">
                        <div class="text-[#375534] opacity-80">First booking discount (10%)</div>
                        <div class="text-[#375534]">₱ 1900.00</div>
                    </div>
                    <div class="flex justify-between mt-[0.5rem] border-t pt-[0.5rem] font-semibold">
                        <div class="text-[#375534] text-[0.75rem] sm:text-[0.875rem]">Total:</div>
                        <div class="text-[#375534] text-[0.75rem] sm:text-[0.875rem]">₱ 17100.00</div>
                    </div>
                </div>
            </div>

            <!-- Notes to Owner -->
            <div class="mb-[1.5rem] sm:mb-[2rem]">
                <div class="text-[0.75rem] sm:text-[0.875rem] text-[#375534] mb-[0.25rem]">Notes to the owner</div>
                <textarea
                    id="notes_textarea"
                    class="w-full h-[5rem] border border-[#375534] border-opacity-30 rounded-md py-[0.5rem] px-[0.75rem] text-[#375534] bg-airbnb-light focus:outline-none text-[0.75rem] sm:text-[0.875rem]"
                    placeholder="Your message"
                ></textarea>
            </div>

            <!-- Cancellation Policy -->
            <div class="text-[0.75rem] sm:text-[0.875rem] text-[#375534] m-1">
                Cancellation fees may apply for cancelling the reservation after request has been approved.
                <a
                    href="#"
                    onclick="document.getElementById('cancellationPolicyModal').classList.remove('hidden'); return false;"
                    class="text-[#375534] underline hover:text-opacity-80"
                >
                    View cancellation policy
                </a>
            </div>
        </div>
        <!-- Final Warning -->
        <div class="text-right text-[0.75rem] sm:text-[0.875rem] text-[#375534] mb-[1.5rem] sm:mb-[2rem] mt-3">
            Ensure all details are correct before booking. Cancellations may be subject to fees depending on timing.
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row justify-end gap-[0.75rem]">
            <a href="{{ route('bookings.cancel-request', $property['id']) }}" class="border border-[#375534] text-[#375534] bg-transparent py-[0.5rem] px-[1.5rem] sm:px-[2.5rem] rounded-full hover:bg-gray-100 text-center text-[0.75rem] sm:text-[0.875rem]">
                CANCEL
            </a>
            <form action="{{ route('bookings.process', $property['id']) }}" method="POST" class="w-full sm:w-auto">
                @csrf
                <input type="hidden" name="guest_count" value="3">
                <input type="hidden" name="start_date" value="05/05/25">
                <input type="hidden" name="end_date" value="05/15/25">
                <input type="hidden" name="total_cost" value="17100.00">
                <input type="hidden" name="notes" id="booking_notes" value="">
                <button type="submit" class="w-full bg-[#375534] text-white py-[0.5rem] px-[1.5rem] sm:px-[2.5rem] rounded-full hover:bg-opacity-90 text-[0.75rem] sm:text-[0.875rem]">
                    REQUEST
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('notes_textarea');
    const notesInput = document.getElementById('booking_notes');

    if (textarea && notesInput) {
        textarea.addEventListener('input', function() {
            notesInput.value = this.value;
        });
    }
});

    // GUEST COUNT SCRIPT
    document.addEventListener('DOMContentLoaded', function() {
    const dropdownTrigger = document.getElementById('guestDropdownTrigger');
    const dropdown = document.getElementById('guestDropdown');
    const guestSummary = document.getElementById('guestSummary');
    const guestTotal = document.getElementById('guestTotal');
    const adultsCountEl = document.getElementById('adultsCount');
    const childrenCountEl = document.getElementById('childrenCount');
    const infantsCountEl = document.getElementById('infantsCount');

    let adults = parseInt(adultsCountEl.textContent);
    let children = parseInt(childrenCountEl.textContent);
    let infants = parseInt(infantsCountEl.textContent);
    const MAX_GUESTS = 3;

    // Toggle dropdown
    dropdownTrigger.addEventListener('click', function() {
    const isExpanded = this.getAttribute('aria-expanded') === 'true';
    this.setAttribute('aria-expanded', !isExpanded);
    dropdown.classList.toggle('hidden');
});

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
    if (!dropdownTrigger.contains(event.target) && !dropdown.contains(event.target)) {
    dropdownTrigger.setAttribute('aria-expanded', 'false');
    dropdown.classList.add('hidden');
}
});

    function updateCounts() {
    adultsCountEl.textContent = adults;
    childrenCountEl.textContent = children;
    infantsCountEl.textContent = infants;

    // Update summary text
    let summary = [];
    if (adults > 0) summary.push(`${adults} ${adults === 1 ? 'adult' : 'adults'}`);
    if (children > 0) summary.push(`${children} ${children === 1 ? 'child' : 'children'}`);
    guestSummary.textContent = summary.join(', ') || 'Add guests';

    // Update button states
    document.querySelector('.decrement-adults').disabled = adults <= 1;
    document.querySelector('.decrement-children').disabled = children <= 0;
    document.querySelector('.decrement-infants').disabled = infants <= 0;

    const total = adults + children;
    guestTotal.textContent = total + ' Guests' || 'Guests';
    document.querySelector('.increment-adults').disabled = total >= MAX_GUESTS;
    document.querySelector('.increment-children').disabled = total >= MAX_GUESTS;
}

    // Adults controls
    dropdown.querySelector('.increment-adults').addEventListener('click', (e) => {
    e.stopPropagation();
    if (adults + children < MAX_GUESTS) {
    adults++;
    updateCounts();
}
});

    dropdown.querySelector('.decrement-adults').addEventListener('click', (e) => {
    e.stopPropagation();
    if (adults > 1) {
    adults--;
    updateCounts();
}
});

    // Children controls
    dropdown.querySelector('.increment-children').addEventListener('click', (e) => {
    e.stopPropagation();
    if (adults + children < MAX_GUESTS) {
    children++;
    updateCounts();
}
});

    dropdown.querySelector('.decrement-children').addEventListener('click', (e) => {
    e.stopPropagation();
    if (children > 0) {
    children--;
    updateCounts();
}
});

    // Infants controls
    dropdown.querySelector('.increment-infants').addEventListener('click', (e) => {
    e.stopPropagation();
    infants++;
    updateCounts();
});

    dropdown.querySelector('.decrement-infants').addEventListener('click', (e) => {
    e.stopPropagation();
    if (infants > 0) {
    infants--;
    updateCounts();
}
});

    // Initialize
    updateCounts();
});

// DATE RANGE DISPLAY
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const dateRangeDisplay = document.getElementById('dateRangeDisplay');

    // Function to format date as "Month Day"
    function formatDateDisplay(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { month: 'long', day: 'numeric' });
    }

    // Function to update the date range display
    function updateDateRangeDisplay() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;

        if (startDate && endDate) {
            const formattedStart = formatDateDisplay(startDate);
            const formattedEnd = formatDateDisplay(endDate);
            dateRangeDisplay.textContent = `${formattedStart} - ${formattedEnd}`;
        }
    }

    // Set initial values from inputs
    updateDateRangeDisplay();

    // Add event listeners
    startDateInput.addEventListener('change', function() {
        // Ensure end date is not before start date
        if (endDateInput.value && new Date(this.value) > new Date(endDateInput.value)) {
            endDateInput.value = this.value;
        }
        endDateInput.min = this.value;
        updateDateRangeDisplay();
    });

    endDateInput.addEventListener('change', function() {
        // Ensure end date is not before start date
        if (new Date(this.value) < new Date(startDateInput.value)) {
            this.value = startDateInput.value;
        }
        updateDateRangeDisplay();
    });
});

</script>

@include('components.view-cancellationPolicy')

@endsection
