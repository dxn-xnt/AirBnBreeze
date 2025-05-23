@extends('layouts.app')

@section('title', 'Completed Bookings')

@section('content')
    <div class="min-h-screen bg-airbnb-light pt-[4rem] md:pt-[7.5rem] pb-[1.5rem] sm:pb-[2rem] px-[1rem] sm:px-[1.5rem] md:px-[2rem] lg:px-[4rem] xl:px-[8rem]">
        <!-- Title and Search Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <h1 class="text-2xl sm:text-2.5xl font-semibold text-airbnb-darkest">Booking Requests</h1>
        </div>

        <!-- Filter Tabs -->
        <div class="flex space-x-2 mb-4 overflow-x-auto">
            <a href="{{ route('host.bookings.pending') }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Pending</a>
            <a href="{{ route('host.bookings.accepted') }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Accepted</a>
            <a href="{{ route('host.bookings.ongoing') }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Ongoing</a>
            <a href="{{ route('host.bookings.completed') }}" class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Completed</a>
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
                                        {{ $booking->book_adult_count }} adults,
                                        {{ $booking->book_child_count }} children
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-airbnb-darkest italic">Schedule</div>
                                    <div class="font-medium">
                                        {{ \Carbon\Carbon::parse($booking->book_check_in)->format('M j') }} -
                                        {{ \Carbon\Carbon::parse($booking->book_check_out)->format('M j, Y') }}
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
                                <button class="text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:shadow-md py-[1px] px-4 rounded-full view-review-btn"
                                        data-booking-id="{{ $booking->id }}">
                                    View Customer Review
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="text-gray-500">No completed bookings found</div>
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

    <!-- Review Modal -->
    <div id="reviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Customer Review</h3>
            <div id="review-content" class="space-y-2">
                <!-- Review content will be loaded here -->
            </div>
            <button id="closeReviewModal" class="mt-4 px-4 py-2 bg-airbnb-dark text-white rounded-md">Close</button>
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

            // Review Modal
            const reviewBtns = document.querySelectorAll('.view-review-btn');
            const reviewModal = document.getElementById('reviewModal');
            const reviewContent = document.getElementById('review-content');
            const closeReviewModal = document.getElementById('closeReviewModal');

            reviewBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const bookingId = this.dataset.bookingId;

                    // Fetch review data
                    fetch(`/bookings/${bookingId}/review`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.review) {
                                reviewContent.innerHTML = `
                                    <div class="font-medium">Rating: ${data.review.rating}/5</div>
                                    <div class="text-gray-700">${data.review.comment || 'No comment provided'}</div>
                                `;
                            } else {
                                reviewContent.innerHTML = '<div class="text-gray-500">No review available</div>';
                            }
                            reviewModal.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            reviewContent.innerHTML = '<div class="text-gray-500">Error loading review</div>';
                            reviewModal.classList.remove('hidden');
                        });
                });
            });

            closeReviewModal.addEventListener('click', function() {
                reviewModal.classList.add('hidden');
            });
        });
    </script>
@endsection
