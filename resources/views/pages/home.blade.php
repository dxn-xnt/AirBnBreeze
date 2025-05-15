@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Home Section -->
    <div class="h-[50vh] sm:h-[65vh] md:h-[85vh] w-full overflow-hidden relative mt-8 md:mt-[39px] max-w-[px] mx-auto">
        <img src="{{ asset('assets/images/airbnbreeze-bg.jpg') }}" alt="AirBnBreeze"
             class="h-full w-full object-cover object-center block">
    </div>

    <!-- Main Content -->
    <div class="relative w-full mt-[-50px] sm:mt-[-75px] md:mt-[-100px]">
        <!-- Search Section -->
        <section class="mb-5 relative z-10 w-full px-4 sm:px-6 lg:px-8">
            <x-search-bar />
        </section>

        <!-- Filters Section -->
        <section class="relative mb-8 md:mb-10 z-[5] w-full">
            <div class="flex justify-center custom-green-gradient py-20 sm:py-24 md:pt-[6.5rem] md:pb-[1.3rem] shadow-md mt-[-60px] sm:mt-[-75px] md:mt-[-90px] w-full relative z-10">
                <div class="flex gap-4 sm:gap-6 md:gap-8 justify-start sm:justify-center max-w-[1750px] mx-auto w-full px-4 sm:px-6 md:px-8 overflow-x-auto scrollbar-hide">
                    <x-filter-button icon="warehouse" text="House" />
                    <x-filter-button icon="building-2" text="Apartment" />
                    <x-filter-button icon="home" text="Tiny Home" />
                    <x-filter-button icon="coffee" text="Bed & Breakfast" />
                    <x-filter-button icon="tent" text="Cabin" />
                    <x-filter-button icon="tent-tree" text="Tent" />
                    <x-filter-button icon="caravan" text="Camper Van" />
                    <x-filter-button icon="sliders-horizontal" />
                </div>
            </div>
        </section>

        <!-- Listings Section - Optimized 3-column max -->
        <section class="w-full px-4 sm:px-6 md:px-8 lg:px-16 xl:px-32">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 sm:gap-x-8 lg:gap-x-9 gap-y-8 sm:gap-y-10 lg:gap-y-12 mb-8 max-w-[1750px] mx-auto">
                @foreach($properties as $property)
                    <x-property-card :property="$property" />
                @endforeach
            </div>
        </section>

        <!-- Explore More Section -->
        <div class="text-center py-4 pb-6 md:pb-8 max-w-[1200px] mx-auto px-4 sm:px-6">
            <p class="mb-3 text-gray-600 italic text-sm sm:text-base">Continue explore related airbnbs?</p>
            <button class="bg-airbnb-darkest text-airbnb-light py-2 px-5 sm:py-2.5 sm:px-6 border-none rounded-3xl cursor-pointer text-sm sm:text-base hover:bg-opacity-90 active:scale-95 transition-all duration-200 ease-out">
                Show More
            </button>
        </div>
    </div>

    <!-- Footer Section - Directly Inserted -->
    <footer class="bg-airbnb-dark text-airbnb-light py-4 sm:py-5 px-4 sm:px-6 md:px-8 w-full">
        <div class="flex flex-col sm:flex-row justify-between items-center max-w-[1750px] mx-auto gap-4 sm:gap-0">
            <!-- Footer Logo -->
            <div class="flex items-center gap-2 sm:mr-0">
                <img src="{{ asset('assets/images/air-logo.png') }}" alt="AirBnBreeze Logo" class="h-8 w-8 sm:h-[50px] sm:w-[50px] border border-airbnb-light rounded-full object-cover">
                <span class="font-righteous text-xl sm:text-[28px] text-airbnb-light">AirBnBreeze</span>
            </div>

            <!-- Footer Links -->
            <div class="flex flex-wrap items-center justify-center sm:justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                <a href="{{ route('about') }}" class="text-airbnb-light hover:underline text-sm sm:text-base">About Us</a>
                <span class="text-airbnb-light text-sm hidden sm:inline">•</span>
                <a href="#" class="text-airbnb-light hover:underline text-sm sm:text-base">Browse</a>
                <span class="text-airbnb-light text-sm hidden sm:inline">•</span>
                <a href="#" class="text-airbnb-light hover:underline text-sm sm:text-base">AirBnB Your Home</a>
            </div>

            <!-- Social Links -->
            <div class="flex gap-4 sm:ml-0">
                <a href="#" class="text-airbnb-light hover:text-white">
                    <i class="w-5 h-5 sm:w-6 sm:h-6" data-lucide="facebook"></i>
                </a>
                <a href="#" class="text-airbnb-light hover:text-white">
                    <i class="w-5 h-5 sm:w-6 sm:h-6" data-lucide="github"></i>
                </a>
                <a href="#" class="text-airbnb-light hover:text-white">
                    <i class="w-5 h-5 sm:w-6 sm:h-6" data-lucide="instagram"></i>
                </a>
            </div>
        </div>
    </footer>
@endsection

@push('styles')
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .custom-green-gradient {
            background-image: linear-gradient(to bottom, rgba(55, 85, 52, 0.1) 0%, #375534 40%);
        }

        @media (max-width: 640px) {
            .filter-scroll-container {
                padding-bottom: 8px;
            }
        }
    </style>
@endpush
