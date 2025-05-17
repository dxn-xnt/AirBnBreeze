@extends('layouts.app')

@section('title', 'Property Bookings')

@section('content')
    <div class="min-h-screen bg-airbnb-light pt-[4rem] md:pt-[7.5rem] pb-[1.5rem] sm:pb-[2rem] px-[1rem] sm:px-[1.5rem] md:px-[2rem] lg:px-[4rem] xl:px-[8rem]">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <h1 class="text-2xl sm:text-2.5xl font-semibold text-airbnb-darkest">Booking Requests</h1>
            <div class="flex flex-1 max-w-2xl">
                <x-host-search-bar />
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex space-x-2 mb-4 overflow-x-auto">
            <a href="{{ route('host.bookings.pending') }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Pending</a>
            <a href="{{ route('host.bookings.accepted') }}" class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Accepted</a>
            <a href="{{ route('host.bookings.completed') }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Completed</a>
            <a href="{{ route('host.bookings.cancelled') }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Cancelled</a>
        </div>

        <!-- Booking Requests -->
        <div class="space-y-4">
            <!-- Booking Card Component -->
            @foreach([1, 2] as $booking)
                <div class="bg-transparent border border-black rounded-lg p-5 shadow">
                    <div class="flex flex-col md:flex-row justify-between">
                        <!-- Booking Details -->
                        <div class="flex-1">
                            <div class="text-xs text-airbnb-darkest italic">Booking for</div>
                            <h2 class="text-lg font-semibold mb-3">Limosnero's Private House</h2>

                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <div>
                                    <div class="text-xs text-airbnb-darkest italic">Guests</div>
                                    <div class="font-medium">2 adults, 1 child</div>
                                </div>
                                <div>
                                    <div class="text-xs text-airbnb-darkest italic">Schedule</div>
                                    <div class="font-medium">April 24 - 30, 2025</div>
                                </div>
                                <div>
                                    <div class="text-xs text-airbnb-darkest italic">Price</div>
                                    <div class="font-medium">₱17,100.00</div>
                                </div>
                            </div>
                        </div>

                        <!-- Booker Info & Actions -->
                        <div class="mt-4 md:mt-0 md:ml-4 flex flex-col items-end justify-between">
                            <div class="flex items-center mb-2">
                                <div class="mr-3 text-right">
                                    <div class="font-semibold">Donesia Pacquio</div>
                                    <div class="text-xs text-airbnb-darkest italic">Booker Name</div>
                                </div>
                                <img src="{{ asset('images/MD.png') }}" alt="User" class="h-10 w-10 rounded-full object-cover">
                            </div>

                            <button class="text-airbnb-darkest text-xs  border border-airbnb-darkest hover:shadow-md mb-4 px-2 rounded-full">
                                View Contact Details
                            </button>

                            <div class="flex space-x-2">
                                <button class="text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:shadow-md py-[1px] px-4 rounded-full">Cancel Booking</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
