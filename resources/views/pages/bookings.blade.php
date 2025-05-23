@extends('layouts.app')

@section('title', 'Your Bookings')

@section('content')
    <!-- Success Message Container -->
    @if(session('success'))
        <div class="fixed top-20 left-1/2 transform -translate-x-1/2 bg-airbnb-light-500 text-airbnb-darkest px-6 py-3 rounded-lg z-50 animate-fade-in-out">
            {{ session('success') }}
            <button class="ml-4" onclick="this.parentElement.remove()">×</button>
        </div>
    @endif

    <div class="bg-[#E3EED4] min-h-screen pt-[120px]">
        <div class="max-w-[1750px] mx-auto px-8 md:px-32">
            <!-- Bookings Title -->
            <h1 class="text-[32px] font-semibold text-airbnb-darkest mb-1">Bookings</h1>

            <!-- Booking Tabs -->
            <div class="flex gap-3 mb-4">
                <a href="{{ route('bookings.category', ['category' => 'upcoming']) }}"
                   class="{{ $category === 'upcoming' ? 'bg-airbnb-dark text-airbnb-light' : 'bg-airbnb-light text-airbnb-darkest border border-airbnb-darkest' }} p-2 rounded-lg">Upcoming</a>
                <a href="{{ route('bookings.category', ['category' => 'pending']) }}"
                   class="{{ $category === 'pending' ? 'bg-airbnb-dark text-airbnb-light' : 'bg-airbnb-light text-airbnb-darkest border border-airbnb-darkest' }} p-2 rounded-lg">Pending</a>
                <a href="{{ route('bookings.category', ['category' => 'ongoing']) }}"
                   class="{{ $category === 'ongoing' ? 'bg-airbnb-dark text-airbnb-light' : 'bg-airbnb-light text-airbnb-darkest border border-airbnb-darkest' }} p-2 rounded-lg">Ongoing</a>
                <a href="{{ route('bookings.category', ['category' => 'recent']) }}"
                   class="{{ $category === 'recent' ? 'bg-airbnb-dark text-airbnb-light' : 'bg-airbnb-light text-airbnb-darkest border border-airbnb-darkest' }} p-2 rounded-lg">Recent</a>
                <a href="{{ route('bookings.category', ['category' => 'cancelled']) }}"
                   class="{{ $category === 'cancelled' ? 'bg-airbnb-dark text-airbnb-light' : 'bg-airbnb-light text-airbnb-darkest border border-airbnb-darkest' }} p-2 rounded-lg">Cancelled</a>
            </div>

            <!-- Booking Cards -->
            <div class="space-y-5 mb-2">
                @forelse ($bookings as $booking)
                    <div class="bg-airbnb-light rounded-xl border border-airbnb-darkest overflow-hidden shadow-sm flex">
                        <!-- Property Image -->
                        <div class="w-[340px] h-[250px]">
                            @if ($booking->property && $booking->property->images->first())
                                <img src="{{ asset('storage/' . $booking->property->images->first()->img_url) }}"
                                     alt="{{ $booking->property->prop_title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('images/default-property.jpg') }}" alt="Default" class="w-full h-full object-cover">
                            @endif
                        </div>

                        <!-- Booking Details -->
                        <div class="flex flex-1 justify-between p-5">
                            <div class="flex flex-col">
                                <div class="text-xs text-gray-600 italic mb-none">Property Name</div>
                                <div class="text-lg font-semibold text-airbnb-darkest mb-1">
                                    {{ optional($booking->property)->prop_title ?? 'Property Not Available' }}
                                </div>

                                <div class="text-xs text-gray-600 italic mb-none">Schedule</div>
                                <div class="text-lg font-semibold text-airbnb-darkest mb-1">
                                    {{ \Carbon\Carbon::parse($booking->book_check_in)->format('M d') }}
                                    –
                                    {{ \Carbon\Carbon::parse($booking->book_check_out)->format('M d, Y') }}
                                </div>

                                <div class="text-xs text-gray-600 italic mb-none">Costs</div>
                                <div class="text-lg font-semibold text-airbnb-darkest mb-1">
                                    ₱{{ number_format($booking->book_total_price, 2) }}
                                </div>

                                <div class="text-xs text-gray-600 italic mb-none">Notes</div>
                                <div class="text-base font-medium text-airbnb-darkest">
                                    {{ $booking->book_notes ?? 'No notes' }}
                                </div>

                                <a href="{{ route('bookings.show', $booking->book_id) }}" class="text-xs text-airbnb-darkest italic underline mt-2">View details</a>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-2 ml-4">
                                @if($booking->book_status == 'pending' || $booking->book_status == 'upcoming')
                                    <!-- Optional Edit Button -->
                                    <button class="bg-[#E3EED4] text-airbnb-darkest border border-airbnb-darkest py-1.5 px-8 rounded-full text-sm hover:bg-[#d5e0c6]">
                                        Edit
                                    </button>

                                    <!-- Cancel Button (Replaced with Modal Trigger) -->
                                    <button type="button"
                                            class="bg-airbnb-dark text-airbnb-light py-1.5 px-4 rounded-full text-sm w-full hover:bg-opacity-90 cancel-user-booking-btn"
                                            data-booking-id="{{ $booking->book_id }}"
                                            data-upcoming="{{ $booking->book_status == 'upcoming' ? '1' : '0' }}">
                                        Cancel Booking
                                    </button>

                                    <!-- Hidden Form -->
                                    <form id="userCancelForm-{{ $booking->book_id }}" action="{{ route('bookings.cancel', $booking->book_id) }}" method="POST" class="hidden">
                                        @csrf
                                        <input type="hidden" name="reason" id="userCancelReasonInput-{{ $booking->book_id }}">
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="pt-8 text-center">
                        <p class="text-airbnb-darkest text-lg">No {{ $category }} bookings found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Explore More Section -->
            <div class="text-center py-4 pb-6 md:pb-8 max-w-[1200px] mx-auto px-4 sm:px-6">
                <p class="mb-3 text-gray-600 italic text-sm sm:text-base">Add more booking trips?</p>
                <a href="{{ route('home') }}" class="bg-airbnb-darkest text-airbnb-light py-2 px-5 sm:py-2.5 sm:px-6 border-none rounded-3xl cursor-pointer text-sm sm:text-base hover:bg-opacity-90 active:scale-95 transition-all duration-200 ease-out">
                    Browse
                </a>
            </div>
        </div>
    </div>

    <!-- User Cancellation Modal -->
    <div id="userCancellationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-airbnb-light p-6 rounded-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Cancel Booking</h3>
            <p class="mb-4" id="cancelMessage">Are you sure you want to cancel this booking?</p>

            <!-- Reason for Cancellation -->
            <label for="userCancelReason" class="block text-sm font-medium text-gray-700 mb-2">Reason (optional):</label>
            <textarea id="userCancelReason"
                      class="w-full border border-gray-300 rounded-md p-2 mb-4"
                      rows="3"
                      placeholder="Enter a reason for cancellation"></textarea>

            <!-- Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button"
                        onclick="document.getElementById('userCancellationModal').classList.add('hidden')"
                        class="px-4 py-2 border border-airbnb-darkest hover:border-airbnb-dark hover:text-airbnb-dark hover:shadow-md py-[1px] px-4 rounded">
                    Cancel
                </button>
                <button type="button"
                        id="confirmUserCancelBtn"
                        class="px-4 py-2 bg-airbnb-dark text-white rounded hover:bg-airbnb-darkest hover:shadow-md">
                    Confirm Cancel
                </button>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #E3EED4;
        }

        .animate-fade-in-out {
            animation: fade 0.5s ease-in-out forwards;
        }

        @keyframes fade {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('userCancellationModal');
            const confirmBtn = document.getElementById('confirmUserCancelBtn');
            const messageEl = document.getElementById('cancelMessage');
            const reasonInput = document.getElementById('userCancelReason');

            let selectedBookingId = null;

            // Show modal on click
            document.querySelectorAll('.cancel-user-booking-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    selectedBookingId = this.dataset.bookingId;
                    const isUpcoming = this.dataset.upcoming === '1';

                    // Update message dynamically
                    messageEl.textContent = isUpcoming
                        ? 'Are you sure you want to cancel this booking? Cancellation fees may apply.'
                        : 'Are you sure you want to cancel this booking?';

                    // Reset reason
                    reasonInput.value = '';
                    modal.classList.remove('hidden');
                });
            });

            // Close modal manually
            document.querySelector('#userCancellationModal button.bg-gray-300')?.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            // Submit cancellation
            confirmBtn.addEventListener('click', () => {
                if (!selectedBookingId) return;

                // Set reason in hidden input
                const reasonInputField = document.getElementById('userCancelReasonInput-' + selectedBookingId);
                const reason = reasonInput.value.trim();
                if (reasonInputField) {
                    reasonInputField.value = reason;
                }

                // Submit form
                const form = document.getElementById('userCancelForm-' + selectedBookingId);
                if (form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
