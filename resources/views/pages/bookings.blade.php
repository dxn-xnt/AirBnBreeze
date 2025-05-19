@extends('layouts.app')

@section('title', 'Your Bookings')

@section('content')
    <x-layout.bookings-header />

    <!-- success message container -->
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
            <div class="flex gap-3 mb-8">
                <a href="{{ route('bookings.category', ['category' => 'upcoming']) }}"
                   class="{{ $category === 'upcoming' ? 'bg-airbnb-dark text-airbnb-light' : 'bg-airbnb-light text-airbnb-darkest border border-airbnb-darkest' }} py-1.5 px-5 rounded-xl text-sm font-medium">Upcoming</a>
                <a href="{{ route('bookings.category', ['category' => 'pending']) }}"
                   class="{{ $category === 'pending' ? 'bg-airbnb-dark text-airbnb-light' : 'bg-airbnb-light text-airbnb-darkest border border-airbnb-darkest' }} py-1.5 px-5 rounded-xl text-sm font-medium">Pending</a>
                <a href="{{ route('bookings.category', ['category' => 'recent']) }}"
                   class="{{ $category === 'recent' ? 'bg-airbnb-dark text-airbnb-light' : 'bg-airbnb-light text-airbnb-darkest border border-airbnb-darkest' }} py-1.5 px-5 rounded-xl text-sm font-medium">Recent</a>
                <a href="{{ route('bookings.category', ['category' => 'cancelled']) }}"
                   class="{{ $category === 'cancelled' ? 'bg-airbnb-dark text-airbnb-light' : 'bg-airbnb-light text-airbnb-darkest border border-airbnb-darkest' }} py-1.5 px-5 rounded-xl text-sm font-medium">Cancelled</a>
            </div>

            <!-- Category Title -->
            <h2 class="text-lg font-medium text-airbnb-darkest mb-4 capitalize">{{ $category }} Bookings</h2>

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

                                <div class="text-xs text-gray-600 italic mb-none">Status</div>
                                <div class="text-base font-medium text-airbnb-darkest">
                                    {{ ucfirst($booking->book_status) }}
                                </div>

                                <div class="text-xs text-gray-600 italic mb-none">Notes</div>
                                <div class="text-base font-medium text-airbnb-darkest">
                                    {{ $booking->book_notes ?? 'No notes' }}
                                </div>

                                <a href="{{ route('bookings.show', $booking->book_id) }}" class="text-xs text-airbnb-darkest italic underline mt-2">View details</a>
                            </div>

                            <!-- Action Buttons -->
                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-2 ml-4">
                                @if($booking->book_status == 'pending' || $booking->book_status == 'upcoming')
                                    <!-- Optional Edit Button -->
                                    <button class="bg-[#E3EED4] text-airbnb-darkest border border-airbnb-darkest py-1.5 px-8 rounded-full text-sm hover:bg-[#d5e0c6]">
                                        Edit
                                    </button>

                                    <!-- Cancel Button -->
                                    <form action="{{ route('bookings.cancel', $booking->book_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?{{ $booking->book_status == 'upcoming' ? ' Cancellation fees may apply.' : '' }}');">
                                        @csrf
                                        <button type="submit" class="bg-airbnb-dark text-airbnb-light py-1.5 px-4 rounded-full text-sm w-full hover:bg-opacity-90">
                                            Cancel Booking
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-airbnb-light rounded-xl border border-airbnb-darkest p-8 text-center">
                        <p class="text-airbnb-darkest text-lg">No {{ $category }} bookings found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Add More Bookings -->
            <div class="text-center mt-10">
                <p class="text-[0.75rem] text-[#375534] mb-[0.5rem]">Add more booking trips?</p>
                <a href="{{ route('home') }}" class="bg-airbnb-dark text-white py-2 px-10 rounded-full hover:bg-opacity-90">
                    Browse
                </a>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #E3EED4;
        }
    </style>
@endsection
