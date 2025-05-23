@extends('layouts.app')

@section('title', 'Property Bookings')

@section('content')
    <div class="min-h-screen bg-airbnb-light pt-[4rem] md:pt-[7.5rem] pb-[1.5rem] sm:pb-[2rem] px-[1rem] sm:px-[1.5rem] md:px-[2rem] lg:px-[4rem] xl:px-[8rem]">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <h1 class="text-2xl sm:text-2.5xl font-semibold text-airbnb-darkest">Booking Requests</h1>
        </div>

        <!-- Filter Tabs -->
        <div class="flex space-x-2 mb-4 overflow-x-auto">
            <a href="{{ route('host.bookings.pending') }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Pending</a>
            <a href="{{ route('host.bookings.accepted') }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Accepted</a>
            <a href="{{ route('host.bookings.ongoing') }}" class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Ongoing</a>
            <a href="{{ route('host.bookings.completed') }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Completed</a>
            <a href="{{ route('host.bookings.cancelled') }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Cancelled</a>
        </div>

        <!-- Booking Requests -->
        <div class="space-y-4">
            @forelse($bookings as $booking)
                <div class="bg-transparent border border-black rounded-lg p-5 shadow">
                    <div class="flex flex-col md:flex-row justify-between">
                        <!-- Booking Details -->
                        <div class="flex-1">
                            <div class="text-xs text-airbnb-darkest italic">Booking for</div>
                            <h2 class="text-lg font-semibold mb-3">{{ $booking->property->prop_title }}</h2>

                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <div>
                                    <div class="text-xs text-airbnb-darkest italic">Guests</div>
                                    <div class="font-medium">
                                        {{ $booking->book_adult_count }} {{ Str::plural('adult', $booking->book_adult_count) }},
                                        {{ $booking->book_child_count }} {{ Str::plural('child', $booking->book_child_count) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-airbnb-darkest italic">Schedule</div>
                                    <div class="font-medium">
                                        {{ \Carbon\Carbon::parse($booking->book_check_in)->format('M d') }} -
                                        {{ \Carbon\Carbon::parse($booking->book_check_out)->format('M d, Y') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-airbnb-darkest italic">Price</div>
                                    <div class="font-medium">₱{{ number_format($booking->book_total_price, 2) }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Booker Info & Actions -->
                        <div class="mt-4 md:mt-0 md:ml-4 flex flex-col items-end justify-between">
                            <div class="flex items-center mb-2">
                                <div class="mr-3 text-right">
                                    <div class="font-semibold">{{ $booking->user->user_fname }} {{ $booking->user->user_lname }}</div>
                                    <div class="text-xs text-airbnb-darkest italic">Booker Name</div>
                                </div>
                                <img src="{{ asset($booking->user->user_profile ? 'storage/'.$booking->user->user_profile : 'images/default-profile.png') }}"
                                     alt="User"
                                     class="h-10 w-10 rounded-full object-cover">
                            </div>

                            <button class="text-airbnb-darkest text-xs border border-airbnb-darkest hover:shadow-md mb-4 px-2 rounded-full contact-details-btn"
                                    data-email="{{ $booking->user->user_email }}"
                                    data-phone="{{ $booking->user->user_contact_number }}">
                                View Contact Details
                            </button>

                            <div class="flex space-x-2">
                                <button class="text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:shadow-md py-[1px] px-4 rounded-full cancel-booking-btn"
                                        data-booking-id="{{ $booking->book_id }}">
                                    Cancel Booking
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="text-gray-500">No accepted bookings found</div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Contact Details Modal -->
    <div id="contactModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Contact Details</h3>
            <div class="space-y-2">
                <div>
                    <span class="font-medium">Email:</span>
                    <span id="contact-email"></span>
                </div>
                <div>
                    <span class="font-medium">Phone:</span>
                    <span id="contact-phone"></span>
                </div>
            </div>
            <button id="closeModal" class="mt-4 px-4 py-2 bg-airbnb-dark text-white rounded-md">Close</button>
        </div>
    </div>

    <!-- Cancellation Modal -->
    <div id="cancellationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-airbnb-light p-6 rounded-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Cancel Booking</h3>
            <p class="mb-4">Are you sure you want to cancel this booking?</p>

            <!-- Reason for Cancellation -->
            <label for="cancelReason" class="block text-sm font-medium text-gray-700 mb-2">Reason (optional):</label>
            <textarea id="cancelReason"
                      class="w-full border border-gray-300 rounded-md p-2 mb-4"
                      rows="3"
                      placeholder="Enter a reason for cancellation"></textarea>

            <!-- Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button"
                        onclick="document.getElementById('cancellationModal').classList.add('hidden')"
                        class="px-4 py-2 border border-airbnb-darkest hover:border-airbnb-dark hover:text-airbnb-dark hover:shadow-md py-[1px] px-4 rounded">
                    Cancel
                </button>
                <button type="button"
                        id="confirmCancelBtn"
                        class="px-4 py-2 bg-airbnb-dark text-white rounded hover:bg-airbnb-darkest hover:shadow-md">
                    Confirm Cancel
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Contact Details Modal
            const contactBtns = document.querySelectorAll('.contact-details-btn');
            const contactModal = document.getElementById('contactModal');
            const contactEmail = document.getElementById('contact-email');
            const contactPhone = document.getElementById('contact-phone');
            const closeModal = document.getElementById('closeModal');

            contactBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    contactEmail.textContent = this.dataset.email;
                    contactPhone.textContent = this.dataset.phone || 'Not provided';
                    contactModal.classList.remove('hidden');
                });
            });

            closeModal.addEventListener('click', function () {
                contactModal.classList.add('hidden');
            });

            // Helper: Get CSRF Token
            function getCSRFToken() {
                return document.querySelector('meta[name="csrf-token"]')?.content;
            }

            // Cancel Booking Modal Logic
            const cancellationModal = document.getElementById('cancellationModal');
            const confirmCancelBtn = document.getElementById('confirmCancelBtn');
            let selectedButton = null;

            document.querySelectorAll('.cancel-booking-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    selectedButton = this;
                    cancellationModal.classList.remove('hidden');
                });
            });

            confirmCancelBtn.addEventListener('click', async () => {
                const bookingId = selectedButton.dataset.bookingId;
                const reason = document.getElementById('cancelReason').value.trim();

                if (!bookingId || isNaN(bookingId)) {
                    alert('Invalid booking ID');
                    console.error('Invalid booking ID:', bookingId);
                    return;
                }

                // Show loading state
                const originalText = selectedButton.innerHTML;
                selectedButton.disabled = true;
                selectedButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing';

                try {
                    const response = await fetch(`/host/bookings/${bookingId}/cancel`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': getCSRFToken(),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ reason })
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Failed to cancel booking');
                    }

                    const data = await response.json();

                    alert(data.message);

                    // Remove the booking card from the DOM
                    const card = selectedButton.closest('.bg-transparent.border');
                    if (card) {
                        card.remove();
                    }

                    // Optional redirect
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }

                } catch (error) {
                    console.error('Error cancelling booking:', error);
                    alert(error.message || 'An unknown error occurred.');
                }

                // Reset UI
                selectedButton.disabled = false;
                selectedButton.innerHTML = originalText;
                document.getElementById('cancelReason').value = '';
                cancellationModal.classList.add('hidden');
            });
        });
    </script>
@endsection
