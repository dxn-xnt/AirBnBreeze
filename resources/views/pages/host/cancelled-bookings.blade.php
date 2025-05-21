@extends('layouts.app')

@section('title', 'Cancelled Bookings')

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
            <a href="{{ route('host.bookings.ongoing') }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Ongoing</a>
            <a href="{{ route('host.bookings.completed') }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Completed</a>
            <a href="{{ route('host.bookings.cancelled') }}" class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Cancelled</a>
        </div>

        <!-- Booking Requests -->
        <div class="space-y-6">
            @forelse($bookings as $booking)
                <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col md:flex-row justify-between">
                        <!-- Booking Details -->
                        <div class="flex-1">
                            <div class="text-xs text-gray-500 mb-1">Booking for</div>
                            <h2 class="text-xl font-semibold mb-4 text-airbnb-darkest">{{ $booking->property->prop_title }}</h2>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <div class="text-xs text-gray-500">Guests</div>
                                    <div class="font-medium">
                                        {{ $booking->book_adult_count }} adults,
                                        {{ $booking->book_child_count }} children
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Dates</div>
                                    <div class="font-medium">
                                        {{ \Carbon\Carbon::parse($booking->book_check_in)->format('M j') }} -
                                        {{ \Carbon\Carbon::parse($booking->book_check_out)->format('M j, Y') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Total Price</div>
                                    <div class="font-medium">₱{{ number_format($booking->book_total_price, 2) }}</div>
                                </div>
                            </div>

                            @if($booking->cancellation_reason)
                                <div>
                                    <div class="text-xs text-gray-500">Reason for cancellation</div>
                                    <div class="text-airbnb-darkest">{{ $booking->cancellation_reason }}</div>
                                </div>
                            @endif

                            @if($booking->cancelled_by === 'host')
                                <div class="mt-2">
                                    <div class="text-xs text-gray-500">Cancelled by</div>
                                    <div class="text-airbnb-darkest">You (Host)</div>
                                </div>
                            @elseif($booking->cancelled_by === 'guest')
                                <div class="mt-2">
                                    <div class="text-xs text-gray-500">Cancelled by</div>
                                    <div class="text-airbnb-darkest">Guest</div>
                                </div>
                            @endif
                        </div>

                        <!-- Booker Info & Actions -->
                        <div class="mt-4 md:mt-0 md:ml-4 flex flex-col items-end gap-2">
                            <div class="flex items-center">
                                <div class="mr-3 text-right">
                                    <div class="font-semibold">{{ $booking->user->user_fname }} {{ $booking->user->user_lname }}</div>
                                    <div class="text-xs text-gray-500">Booker</div>
                                </div>
                                <img src="{{ asset($booking->user->user_profile ? 'storage/'.$booking->user->user_profile : 'images/default-profile.png') }}"
                                     alt="User"
                                     class="h-10 w-10 rounded-full object-cover">
                            </div>

                            <button class="text-airbnb-darkest text-xs border border-airbnb-darkest hover:bg-gray-100 px-3 py-1 rounded-full transition-colors contact-details-btn"
                                    data-email="{{ $booking->user->user_email }}"
                                    data-phone="{{ $booking->user->user_contact_number }}">
                                View Contact Details
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="text-gray-500">No cancelled bookings found</div>
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
                    <span id="contact-email" class="ml-2"></span>
                </div>
                <div>
                    <span class="font-medium">Phone:</span>
                    <span id="contact-phone" class="ml-2"></span>
                </div>
            </div>
            <button id="closeModal" class="mt-4 px-4 py-2 bg-airbnb-dark text-white rounded-md hover:bg-airbnb-darker transition-colors">Close</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Contact Details Modal
            const contactBtns = document.querySelectorAll('.contact-details-btn');
            const contactModal = document.getElementById('contactModal');
            const contactEmail = document.getElementById('contact-email');
            const contactPhone = document.getElementById('contact-phone');
            const closeModal = document.getElementById('closeModal');

            contactBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    contactEmail.textContent = this.dataset.email;
                    contactPhone.textContent = this.dataset.phone || 'Not provided';
                    contactModal.classList.remove('hidden');
                });
            });

            closeModal.addEventListener('click', function() {
                contactModal.classList.add('hidden');
            });

            // Close modal when clicking outside
            contactModal.addEventListener('click', function(e) {
                if (e.target === contactModal) {
                    contactModal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
