@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
<header class="bg-airbnb-dark text-white py-3 px-8 flex justify-between items-center fixed top-0 left-0 right-0 z-50 h-20 w-full">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="flex items-center gap-2">
        <img src="{{ asset('assets/images/air-logo.png') }}" alt="AirBnBreeze Logo" class="h-[50px] w-[50px] border border-airbnb-light rounded-full object-cover">
        <span class="font-righteous text-[28px] font-normal text-airbnb-light">AirBnBreeze</span>
    </a>
   
    <!-- Right-side icons container -->
    <div class="flex items-center gap-4">
        <!-- Notification bell icon -->
        <a href="{{ route('notifications.index') }}" class="relative">
            <i class="w-[25px] h-[25px] text-airbnb-light" data-lucide="bell"></i>
            <!-- notification badge -->
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
        </a>

        <!-- Menu with Alpine.js -->
        <div class="relative" x-data="{ open: false }">
            <button
                @click="open = !open"
                @click.away="open = false"
                class="flex items-center gap-2 bg-airbnb-dark border border-airbnb-light rounded-full px-[10px] py-[5px] hover:bg-opacity-90 shadow-[0_6px_16px_-2px_rgba(0,0,0,0.3)]"
            >
                <i class="w-[25px] h-[25px] text-airbnb-light" data-lucide="menu"></i>
                <i class="w-[25px] h-[25px] text-airbnb-light" data-lucide="user-circle"></i>
            </button>
           
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute top-12 right-0 bg-airbnb-light text-airbnb-dark rounded-xl shadow-lg min-w-[230px] p-2 z-10"
                style="display: none;"
            >
                <a href="{{ route('bookings.index') }}" class="block py-[0.35rem] px-2 text-gray-800 hover:bg-[#FBFFF6] rounded font-medium">Bookings</a>
                <a href="{{ route('favorites') }}" class="block py-[0.35rem] px-2 text-gray-800 hover:bg-[#FBFFF6] rounded font-medium">Favorites</a>
                <a href="{{ route('bookings.index') }}" class="block py-[0.35rem] px-2 text-gray-800 hover:bg-[#FBFFF6] rounded font-medium">Account</a>
                <a href="{{ route('bookings.index') }}" class="block py-[0.35rem] px-2 text-gray-800 hover:bg-[#FBFFF6] rounded font-medium">AirBnB your house</a>
                <a href="{{ route('about') }}" class="block py-[0.35rem] px-2 text-gray-800 hover:bg-[#FBFFF6] rounded font-medium">About us</a>
                <a href="{{ route('help') }}" class="block py-[0.35rem] px-2 text-gray-800 hover:bg-[#FBFFF6] rounded font-medium">Help Center</a>
            </div>
        </div>
    </div>
</header>

<div class="bg-[#E3EED4] min-h-screen pt-[4rem] md:pt-[7.5rem] pb-[2rem]">
    <div class="max-w-[1750px] mx-auto px-[1rem] sm:px-[1.5rem] md:px-[2rem] lg:px-[4rem] xl:px-[8rem]">
        <!-- Favorites Title -->
        <h1 class="text-[1.5rem] sm:text-[1.75rem] font-semibold text-airbnb-darkest mb-[1rem] sm:mb-[1.25rem]">My Favorites</h1>
        
        <!-- Property Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mb-[1.5rem] sm:mb-[2rem]">
            <!-- Property Card 1 -->
            <div class="card relative rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 font-montserrat">
                <!-- Remove Button -->
                <button type="button" class="absolute top-3 right-3 bg-airbnb-light hover:bg-[#d4e0c5] text-airbnb-darkest py-1 px-3 rounded-lg text-xs font-medium transition-colors z-10">
                    Remove
                </button>
                
                <!-- Property Content -->
                <a href="#" class="block">
                    <!-- Property Image -->
                    <img src="{{ asset('assets/images/HOUSE (1).png') }}" alt="Limosnero's Private House" class="w-full h-[200px] object-cover">
                    
                    <!-- Property Details -->
                    <div class="p-3 sm:p-4">
                        <h3 class="text-sm sm:text-base font-bold mb-1">Limosnero's Private House</h3>
                        <p class="text-airbnb-darkest text-xs sm:text-sm mb-2">Minglanilla, Cebu</p>
                        
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-xs sm:text-sm">
                                <span class="font-normal">₱</span> 
                                <strong>1800</strong> / night
                            </p>
                            
                            <!-- Rating Badge -->
                            <div class="flex items-center gap-1 bg-airbnb-darkest text-airbnb-light px-2 py-1 rounded-lg text-xs sm:text-sm font-semibold">
                                <i data-lucide="star" class="w-3 h-3 text-gold fill-gold"></i> 
                                4.7
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Property Card 2 -->
            <div class="card relative rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 font-montserrat">
                <!-- Remove Button -->
                <button type="button" class="absolute top-3 right-3 bg-airbnb-light hover:bg-[#d4e0c5] text-airbnb-darkest py-1 px-3 rounded-lg text-xs font-medium transition-colors z-10">
                    Remove
                </button>
                
                <!-- Property Content -->
                <a href="#" class="block">
                    <!-- Property Image -->
                    <img src="{{ asset('assets/images/HOUSE (2).png') }}" alt="Limosnero's Private House" class="w-full h-[200px] object-cover">
                    
                    <!-- Property Details -->
                    <div class="p-3 sm:p-4">
                        <h3 class="text-sm sm:text-base font-bold mb-1">Limosnero's Private House</h3>
                        <p class="text-airbnb-darkest text-xs sm:text-sm mb-2">Minglanilla, Cebu</p>
                        
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-xs sm:text-sm">
                                <span class="font-normal">₱</span> 
                                <strong>1900</strong> / night
                            </p>
                            
                            <!-- Rating Badge -->
                            <div class="flex items-center gap-1 bg-airbnb-darkest text-airbnb-light px-2 py-1 rounded-lg text-xs sm:text-sm font-semibold">
                                <i data-lucide="star" class="w-3 h-3 text-gold fill-gold"></i> 
                                4.8
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Property Card 3 -->
            <div class="card relative rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 font-montserrat">
                <!-- Remove Button -->
                <button type="button" class="absolute top-3 right-3 bg-airbnb-light hover:bg-[#d4e0c5] text-airbnb-darkest py-1 px-3 rounded-lg text-xs font-medium transition-colors z-10">
                    Remove
                </button>
                
                <!-- Property Content -->
                <a href="#" class="block">
                    <!-- Property Image -->
                    <img src="{{ asset('assets/images/HOUSE (3).png') }}" alt="Limosnero's Private House" class="w-full h-[200px] object-cover">
                    
                    <!-- Property Details -->
                    <div class="p-3 sm:p-4">
                        <h3 class="text-sm sm:text-base font-bold mb-1">Limosnero's Private House</h3>
                        <p class="text-airbnb-darkest text-xs sm:text-sm mb-2">Minglanilla, Cebu</p>
                        
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-xs sm:text-sm">
                                <span class="font-normal">₱</span> 
                                <strong>1900</strong> / night
                            </p>
                            
                            <!-- Rating Badge -->
                            <div class="flex items-center gap-1 bg-airbnb-darkest text-airbnb-light px-2 py-1 rounded-lg text-xs sm:text-sm font-semibold">
                                <i data-lucide="star" class="w-3 h-3 text-gold fill-gold"></i> 
                                4.9
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Add More Favorites -->
        <div class="text-center py-[1.5rem] sm:py-[2rem]">
            <p class="text-airbnb-darkest italic mb-[1rem] sm:mb-[1.25rem]">Add more favorites?</p>
            <a href="{{ route('home') }}" class="inline-block bg-[#375534] text-[#E3EED4] py-2 px-8 sm:py-2.5 sm:px-10 rounded-full hover:bg-opacity-90 transition-colors">
                Browse
            </a>
        </div>
    </div>
</div>

@endsection
