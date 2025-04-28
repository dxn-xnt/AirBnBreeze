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
                <button class="bg-airbnb-dark text-airbnb-light py-1.5 px-5 rounded-xl text-sm font-medium">Upcoming</button>
                <button class="bg-airbnb-light text-airbnb-darkest py-1.5 px-5 rounded-xl border border-airbnb-darkest text-sm font-medium">Pending</button>
                <button class="bg-airbnb-light text-airbnb-darkest py-1.5 px-5 rounded-xl border border-airbnb-darkest text-sm font-medium">Recent</button>
                <button class="bg-airbnb-light text-airbnb-darkest py-1.5 px-5 rounded-xl border border-airbnb-darkest text-sm font-medium">Cancelled</button>
            </div>
            
            <!-- Booking Cards -->
            <div class="space-y-5 mb-2">
                @foreach($bookings as $booking)
                    <div class="bg-airbnb-light rounded-xl border border-airbnb-darkest overflow-hidden shadow-sm flex">
                        <!-- Property Image -->
                        <div class="w-[340px] h-[250px]">
                            <img src="{{ asset($booking['image']) }}" alt="{{ $booking['property_name'] }}" class="w-full h-full object-cover">
                        </div>
                        
                        <!-- Booking Details -->
                        <div class="flex flex-1 justify-between p-5">
                            <div class="flex flex-col">
                                <div class="text-xs text-gray-600 italic mb-none">Property Name</div>
                                <div class="text-lg font-semibold text-airbnb-darkest mb-1">{{ $booking['property_name'] }}</div>
                                
                                <div class="text-xs text-gray-600 italic mb-none">Schedule</div>
                                <div class="text-lg font-semibold text-airbnb-darkest mb-1">{{ $booking['schedule']['start_date'] }} - {{ $booking['schedule']['end_date'] }}</div>
                                
                                <div class="text-xs text-gray-600 italic mb-none">Costs</div>
                                <div class="text-lg font-semibold text-airbnb-darkest mb-1">₱ {{ $booking['cost'] }}</div>
                                
                                <div class="text-xs text-gray-600 italic mb-none">Notes</div>
                                <div class="text-base font-medium text-airbnb-darkest">{{ $booking['notes'] }}</div>
                                
                                <a href="{{ route('bookings.show', $booking['id']) }}" class="text-xs text-airbnb-darkest italic underline mt-2">View details</a>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-2 ml-4">
                                <button class="bg-[#E3EED4] text-airbnb-darkest border border-airbnb-darkest py-1.5 px-8 rounded-full text-sm hover:bg-[#d5e0c6]">Edit</button>
                                <form action="{{ route('bookings.cancel', $booking['id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-airbnb-dark text-airbnb-light py-1.5 px-4 rounded-full text-sm w-full hover:bg-opacity-90">Cancel Booking</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Add More Bookings -->
            <div class="text-center py-5">
                <p class="text-gray-600 italic mb-3">Add more booking trips?</p>
                <a href="{{ route('home') }}" class="inline-block bg-airbnb-darkest text-airbnb-light py-2 px-10 rounded-full hover:bg-opacity-90">Browse</a>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #E3EED4;
        }
    </style>
@endsection