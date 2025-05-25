@extends('layouts.app')
@section('title', 'Request Booking')
@section('content')
    <div class="min-h-screen bg-[#E3EED4] pt-[4rem] md:pt-[7.5rem] pb-[1.5rem] sm:pb-[2rem] px-[1rem] sm:px-[1.5rem] md:px-[2rem] lg:px-[4rem] xl:px-[8rem]">
        <div class="max-w-[1750px] mx-auto">
            <!-- Back Button -->
            <div class="flex items-center gap-[0.75rem] mb-[1rem] sm:mb-[1.25rem]">
                <a href="{{ route('property.show', $property->prop_id) }}" class="bg-[#375534] text-white rounded-full p-[0.5rem] hover:bg-opacity-90 flex items-center justify-center">
                    <i data-lucide="arrow-left" class="w-[1.25rem] h-[1.25rem]"></i>
                </a>
                <h1 class="text-[1.5rem] sm:text-[1.75rem] font-semibold text-[#375534]">Request Booking</h1>
            </div>

            <!-- Property Preview -->
            <div class="flex flex-col sm:flex-row mb-[1rem] sm:mb-[1.25rem] bg-airbnb-light p-[1rem] sm:p-[1.5rem] rounded-xl shadow-sm">
                <!-- Property Image -->
                <img
                    src="{{ $property->images->first() ? asset('storage/' . $property->images->first()->img_url) : asset('images/default-property.jpg') }}"
                    alt="{{ $property->prop_title }}"
                    class="w-full sm:w-[180px] md:w-[240px] h-[120px] sm:h-[150px] object-cover rounded-xl sm:mr-[1rem] md:mr-[1.5rem] mb-[1rem] sm:mb-0"
                >
                <!-- Property Details -->
                <div class="w-full">
                    <div class="text-[0.75rem] text-[#375534] mb-[0.25rem]">Property Name</div>
                    <div class="text-[1rem] sm:text-[1.125rem] md:text-[1.25rem] font-semibold text-[#375534]">{{ $property->prop_title }}</div>
                    <div class="grid grid-cols-2 gap-x-[1rem] gap-y-[0.5rem] mt-[0.75rem]">
                        <div>
                            <div class="text-[0.75rem] text-[#375534] mb-[0.25rem]">Location</div>
                            <div class="text-[0.875rem] sm:text-[1rem] md:text-[1.125rem] text-[#375534]">{{ $property->prop_address }}</div>
                        </div>
                        <div>
                            <div class="text-[0.75rem] text-[#375534] mb-[0.25rem]">Cost per night</div>
                            <div class="text-[0.875rem] sm:text-[1rem] md:text-[1.125rem] text-[#375534]">₱{{ number_format($property->prop_price_per_night, 2) }}</div>
                        </div>
                        <div>
                            <div class="text-[0.75rem] text-[#375534] mb-[0.25rem]">Ratings</div>
                            <div class="flex items-center">
                                <span class="text-yellow-400">★</span>
                                <span class="text-[0.875rem] sm:text-[1rem] md:text-[1.125rem] text-[#375534] ml-[0.25rem]">{{ $property->rating ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Details Form -->
            <div class="bg-airbnb-light p-[1rem] sm:p-[1.5rem] pb-2 rounded-xl border border-[#375534] border-opacity-20 shadow-sm">
                <h2 class="text-[1rem] sm:text-[1.125rem] md:text-[1.25rem] font-semibold text-[#375534] mb-[1rem] sm:mb-[1.25rem]">Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-[1rem] sm:gap-[1.5rem] mb-[1.5rem] sm:mb-[2rem]">
                    <!-- Guests Section -->
                    <div class="w-full">
                        <div class="text-[0.75rem] sm:text-[0.875rem] text-[#375534] mb-[0.25rem]">Guests</div>
                        <div class="text-[0.875rem] sm:text-[1rem] text-[#375534] mb-[0.5rem]" id="guestSummary">Add guests</div>
                        <div class="relative max-w-xs">
                            <button
                                type="button"
                                class="w-full flex justify-between items-center bg-airbnb-light border border-[#375534] border-opacity-30 rounded-md py-[0.5rem] px-[0.75rem] text-[#375534] focus:outline-none text-[0.75rem] sm:text-[0.875rem]"
                                id="guestDropdownTrigger"
                                aria-expanded="false"
                                aria-haspopup="true"
                            >
                                <div class="text-[0.875rem] text-[#375534]" id="guestTotal">0 guests</div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg py-4 px-4 hidden" id="guestDropdown">
                                <div class="mb-4">
                                    <h3 class="font-medium text-gray-700 text-center" id="guestTotalCount">0 Guests</h3>
                                    <p class="text-xs text-gray-500 text-center">Maximum of {{ $property->prop_max_guest }} guests</p>
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
                                            <span class="w-6 text-center" id="adultsCount">0</span>
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
                                            <p class="text-xs text-gray-500">Ages 2–12</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="decrement-children w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 disabled:opacity-50" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <span class="w-6 text-center" id="childrenCount">0</span>
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

                    <!-- Schedule -->
                    <div>
                        <div class="text-[0.75rem] sm:text-[0.875rem] text-[#375534] mb-[0.25rem]">Schedule</div>
                        <div class="text-[0.875rem] sm:text-[1rem] text-[#375534] mb-[0.5rem]" id="dateRangeDisplay">April 24 - May 5</div>
                        <div class="flex gap-[0.5rem]">
                            <div class="relative flex-1">
                                <input type="date" id="startDate"
                                       value="{{ old('start_date', now()->format('Y-m-d')) }}"
                                       min="{{ now()->format('Y-m-d') }}"
                                       class="w-full bg-airbnb-light border border-[#375534] border-opacity-30 rounded-md py-[0.5rem] px-[0.75rem] text-[#375534] focus:outline-none text-[0.75rem] sm:text-[0.875rem]"
                                >
                            </div>
                            <div class="relative flex-1">
                                <input type="date" id="endDate"
                                       value="{{ old('end_date', now()->addDays(7)->format('Y-m-d')) }}"
                                       min="{{ now()->format('Y-m-d') }}"
                                       class="w-full bg-airbnb-light border border-[#375534] border-opacity-30 rounded-md py-[0.5rem] px-[0.75rem] text-[#375534] focus:outline-none text-[0.75rem] sm:text-[0.875rem]"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Costs -->
                    <div class="mt-[1rem] md:mt-0">
                        <div class="text-[0.75rem] sm:text-[0.875rem] text-[#375534] mb-[0.25rem]">Costs</div>
                        <div class="flex justify-between">
                            <div class="text-[0.875rem] sm:text-[1rem] text-[#375534]" id="nightlyCost">₱{{ number_format($property->prop_price_per_night, 2) }} x 10</div>
                            <div class="text-[0.875rem] sm:text-[1rem] text-[#375534]" id="totalCost">₱{{ number_format($property->prop_price_per_night * 10, 2) }}</div>
                        </div>
                        <div class="flex justify-between mt-[0.5rem] border-t pt-[0.5rem] font-semibold">
                            <div class="text-[#375534] text-[0.75rem] sm:text-[0.875rem]">Total:</div>
                            <div class="text-[#375534] text-[0.75rem] sm:text-[0.875rem]" id="finalTotal">₱{{ number_format(($property->prop_price_per_night * 10) - ($property->prop_price_per_night * 10 * 0.1), 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Notes to Owner -->
                <div class="mb-[1.5rem] sm:mb-[2rem]">
                    <label for="notes_textarea" class="block text-sm font-medium text-[#375534] mb-1">Notes to the owner</label>
                    <textarea id="notes_textarea" rows="4"
                              class="w-full h-[5rem] border border-[#375534] border-opacity-30 rounded-md py-[0.5rem] px-[0.75rem] text-[#375534] bg-airbnb-light focus:outline-none text-[0.75rem] sm:text-[0.875rem]"
                              placeholder="Your message">{{ old('notes') }}</textarea>
                </div>

                <!-- Cancellation Policy -->
                <div class="text-[0.75rem] sm:text-[0.875rem] text-[#375534] m-1">
                    Cancellation fees may apply after approval.
                    <a href="#" onclick="document.getElementById('cancellationPolicyModal').classList.remove('hidden'); return false;"
                       class="text-[#375534] underline hover:text-opacity-80">View policy</a>
                </div>
            </div>

            <!-- Final Warning -->
            <div class="text-right text-[0.75rem] sm:text-[0.875rem] text-[#375534] mb-[1.5rem] sm:mb-[2rem] mt-3">
                Ensure all details are correct before booking. Fees may apply for cancellations.
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-[0.75rem]">
                <a href="{{ route('bookings.cancel-request', $property->prop_id) }}" class="border border-[#375534] text-[#375534] bg-transparent py-[0.5rem] px-[1.5rem] sm:px-[2.5rem] rounded-full hover:bg-gray-100 text-center text-[0.75rem] sm:text-[0.875rem]">
                    CANCEL
                </a>
                <form action="{{ route('bookings.process', $property->prop_id) }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <input type="hidden" name="start_date" id="start_date_input" value="{{ old('start_date', now()->format('Y-m-d')) }}">
                    <input type="hidden" name="end_date" id="end_date_input" value="{{ old('end_date', now()->addDays(7)->format('Y-m-d')) }}">
                    <input type="hidden" name="total_cost" id="total_cost_input" value="{{ ($property->prop_price_per_night * 10) - ($property->prop_price_per_night * 10 * 0.1) }}">
                    <input type="hidden" name="notes" id="booking_notes" value="{{ old('notes') }}">

                    <!-- ADD THESE TWO FIELDS -->
                    <input type="hidden" name="book_adult_count" id="book_adult_count" value="2">
                    <input type="hidden" name="book_child_count" id="book_child_count" value="0">

                    <button type="submit" class="w-full bg-[#375534] text-white py-[0.5rem] px-[1.5rem] sm:px-[2.5rem] rounded-full hover:bg-opacity-90 text-[0.75rem] sm:text-[0.875rem]">
                        REQUEST
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const UNAVAILABLE_DATES = @json($unavailableDates);
    </script>
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownTrigger = document.getElementById('guestDropdownTrigger');
            const dropdown = document.getElementById('guestDropdown');
            const guestSummary = document.getElementById('guestSummary');
            const guestTotal = document.getElementById('guestTotal');
            const guestTotalCount = document.getElementById('guestTotalCount');
            const adultsCountEl = document.getElementById('adultsCount');
            const childrenCountEl = document.getElementById('childrenCount');
            const infantsCountEl = document.getElementById('infantsCount');
            let adults = parseInt(adultsCountEl.textContent);
            let children = parseInt(childrenCountEl.textContent);
            let infants = parseInt(infantsCountEl.textContent);
            const MAX_GUESTS = parseInt('{{ $property->prop_max_guest }}');

            // Set initial guest values dynamically
            if (MAX_GUESTS === 1) {
                adults = 1;
                children = 0;
            } else if (MAX_GUESTS === 2) {
                adults = 2;
                children = 0;
            } else {
                adults = 2;
                children = 1;
            }

            function updateCounts() {
                adultsCountEl.textContent = adults;
                childrenCountEl.textContent = children;
                infantsCountEl.textContent = infants;
                let summary = [];
                if (adults > 0) summary.push(`${adults} ${adults === 1 ? 'adult' : 'adults'}`);
                if (children > 0) summary.push(`${children} ${children === 1 ? 'child' : 'children'}`);
                guestSummary.textContent = summary.join(', ') || 'Add guests';
                const totalGuests = adults + children;
                guestTotal.textContent = `${totalGuests} guest${totalGuests !== 1 ? 's' : ''}`;
                guestTotalCount.textContent = `${totalGuests} Guests`;
                document.querySelector('.decrement-adults').disabled = adults <= 1;
                document.querySelector('.decrement-children').disabled = children <= 0;
                document.querySelector('.decrement-infants').disabled = infants <= 0;
                document.querySelector('.increment-adults').disabled = totalGuests >= MAX_GUESTS;
                document.querySelector('.increment-children').disabled = totalGuests >= MAX_GUESTS;
            }

            function updateHiddenInputs() {
                document.getElementById('guest_count').value = adults + children;
                document.getElementById('book_adult_count').value = adults;
                document.getElementById('book_child_count').value = children;
            }

// Inside increment/decrement buttons
            document.querySelector('.increment-adults').addEventListener('click', () => {
                if ((adults + children) < MAX_GUESTS) {
                    adults++;
                    updateCounts();
                    updateHiddenInputs();
                }
            });

            // Toggle Dropdown
            dropdownTrigger.addEventListener('click', function () {
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

            // Increment/Decrement logic
            document.querySelector('.increment-adults').addEventListener('click', () => {
                if ((adults + children) < MAX_GUESTS) {
                    adults++;
                    updateCounts();
                    updateHiddenInputs();
                }
            });
            document.querySelector('.decrement-adults').addEventListener('click', () => {
                if (adults > 1) {
                    adults--;
                    updateCounts();
                    updateHiddenInputs();
                }
            });
            document.querySelector('.increment-children').addEventListener('click', () => {
                if ((adults + children) < MAX_GUESTS) {
                    children++;
                    updateCounts();
                    updateHiddenInputs();
                }
            });
            document.querySelector('.decrement-children').addEventListener('click', () => {
                if (children > 0) {
                    children--;
                    updateCounts();
                    updateHiddenInputs();
                }
            });
            document.querySelector('.increment-infants').addEventListener('click', () => {
                infants++;
                updateCounts();
            });
            document.querySelector('.decrement-infants').addEventListener('click', () => {
                if (infants > 0) {
                    infants--;
                    updateCounts();
                }
            });

            updateCounts();

            // DATE AND COST CALCULATION
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const dateRangeDisplay = document.getElementById('dateRangeDisplay');
            const nightlyRate = parseFloat("{{ $property->prop_price_per_night }}");
            const nightlyCostDisplay = document.getElementById('nightlyCost');
            const totalCostDisplay = document.getElementById('totalCost');
            const finalTotalDisplay = document.getElementById('finalTotal');
            const startInput = document.getElementById('start_date_input');
            const endInput = document.getElementById('end_date_input');
            const totalCostInput = document.getElementById('total_cost_input');

            function calculateNights(start, end) {
                const startD = new Date(start);
                const endD = new Date(end);
                const diffTime = Math.abs(endD - startD);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                return diffDays;
            }

            function formatDateDisplay(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', { month: 'long', day: 'numeric' });
            }

            function updateDateRangeDisplay() {
                const start = startDateInput.value;
                const end = endDateInput.value;
                if (start && end) {
                    const formattedStart = formatDateDisplay(start);
                    const formattedEnd = formatDateDisplay(end);
                    dateRangeDisplay.textContent = `${formattedStart} – ${formattedEnd}`;
                }
            }

            function updateCosts() {
                const start = startDateInput.value;
                const end = endDateInput.value;
                if (!start || !end) return;
                const nights = calculateNights(start, end);
                const total = nightlyRate * nights;
                const final = total;
                nightlyCostDisplay.textContent = `₱${nightlyRate.toFixed(2)} x ${nights}`;
                totalCostDisplay.textContent = `₱${total.toFixed(2)}`;
                finalTotalDisplay.textContent = `₱${final.toFixed(2)}`;
                startInput.value = start;
                endInput.value = end;
                totalCostInput.value = final.toFixed(2);
            }

            function isDateUnavailable(dateStr) {
                const selectedDate = new Date(dateStr);
                selectedDate.setHours(0, 0, 0, 0);

                return UNAVAILABLE_DATES.some(range => {
                    const start = new Date(range.start);
                    const end = new Date(range.end);
                    start.setHours(0, 0, 0, 0);
                    end.setHours(0, 0, 0, 0);

                    return selectedDate >= start && selectedDate <= end;
                });
            }

            function validateSelectedDates() {
                const start = startDateInput.value;
                const end = endDateInput.value;

                if (isDateUnavailable(start)) {
                    alert("The check-in date is unavailable.");
                    startDateInput.focus();
                    return false;
                }

                if (isDateUnavailable(end)) {
                    alert("The check-out date is unavailable.");
                    endDateInput.focus();
                    return false;
                }

                return true;
            }

// Add event listener to the form submit
            document.querySelector('form').addEventListener('submit', function (e) {
                if (!validateSelectedDates()) {
                    e.preventDefault(); // Prevent submission
                }
            });

// Disable past and unavailable dates
            startDateInput.setAttribute('min', '{{ now()->format('Y-m-d') }}');
            endDateInput.setAttribute('min', '{{ now()->format('Y-m-d') }}');

            startDateInput.addEventListener('change', function () {
                if (isDateUnavailable(this.value)) {
                    alert("Selected check-in date is unavailable.");
                    this.value = '';
                    return;
                }
                if (this.value && endDateInput.value && this.value > endDateInput.value) {
                    endDateInput.value = this.value;
                }
                endDateInput.min = this.value;
                updateDateRangeDisplay();
                updateCosts();
            });

            endDateInput.addEventListener('change', function () {
                if (isDateUnavailable(this.value)) {
                    alert("Selected check-out date is unavailable.");
                    this.value = '';
                    return;
                }
                if (this.value && startDateInput.value && this.value < startDateInput.value) {
                    this.value = startDateInput.value;
                }
                updateDateRangeDisplay();
                updateCosts();
            });

            updateDateRangeDisplay();
            updateCosts();

            // NOTES TO OWNER SYNC
            const textarea = document.getElementById('notes_textarea');
            const notesInput = document.getElementById('booking_notes');
            if (textarea && notesInput) {
                textarea.addEventListener('input', function () {
                    notesInput.value = this.value;
                });
            }

            // Add missing hidden inputs to form
            const form = document.querySelector('form[action="{{ route('bookings.process', $property->prop_id) }}"]');
            if (form) {
                let bookAdultInput = document.getElementById('book_adult_count');
                if (!bookAdultInput) {
                    bookAdultInput = document.createElement('input');
                    bookAdultInput.type = 'hidden';
                    bookAdultInput.name = 'book_adult_count';
                    bookAdultInput.id = 'book_adult_count';
                    bookAdultInput.value = adults;
                    form.appendChild(bookAdultInput);
                }

                let bookChildInput = document.getElementById('book_child_count');
                if (!bookChildInput) {
                    bookChildInput = document.createElement('input');
                    bookChildInput.type = 'hidden';
                    bookChildInput.name = 'book_child_count';
                    bookChildInput.id = 'book_child_count';
                    bookChildInput.value = children;
                    form.appendChild(bookChildInput);
                }

                form.addEventListener('submit', function () {
                    bookAdultInput.value = adults;
                    bookChildInput.value = children;
                });
            }

            function showUnavailableMessage(isUnavailable) {
                const messageDiv = document.getElementById('availabilityMessage');
                if (isUnavailable) {
                    messageDiv.textContent = 'The selected dates are already booked.';
                    messageDiv.classList.add('text-red-500');
                } else {
                    messageDiv.textContent = '';
                    messageDiv.classList.remove('text-red-500');
                }
            }

            startDatePicker.onChange = function(selectedDates, dateStr, instance) {
                const isUnavailable = isDateUnavailable(dateStr);
                showUnavailableMessage(isUnavailable);
            };

            endDatePicker.onChange = function(selectedDates, dateStr, instance) {
                const isUnavailable = isDateUnavailable(dateStr);
                showUnavailableMessage(isUnavailable);
            };
        });
    </script>

    @include('components.view-cancellationPolicy')
@endsection
