@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="h-[85vh] w-full overflow-hidden relative mt-[39px]">
        <img src="{{ asset('assets/images/airbnbreeze-bg.jpg') }}" alt="AirBnBreeze" class="h-full w-full object-cover object-center block">
    </div>

    <!-- Main Content -->
    <div class="relative w-full mt-[-100px]">
        <!-- Search Section -->
        <section class="mb-5 relative z-10 w-full">
            <x-search-bar />
        </section>

        <!-- Filters Section -->
        <section class="relative mb-10 z-5 w-full">
            <div class="flex justify-center custom-green-gradient py-26 pt-[6.5rem] pb-[1.3rem] shadow-md mt-[-90px] w-full">
                <div class="flex gap-8 justify-center max-w-[1750px] mx-auto w-full px-8 overflow-x-auto scrollbar-hide">
                    <x-filter-button icon="home" text="House" />
                    <x-filter-button icon="building-2" text="Apartment" />
                    <x-filter-button icon="home" text="Tiny Home" />
                    <x-filter-button icon="chef-hat" text="Bed & Breakfast" />
                    <x-filter-button icon="tent" text="Cabin" />
                    <x-filter-button icon="tent-tree" text="Tent" />
                    <x-filter-button icon="caravan" text="Camper Van" />
                    <x-filter-button icon="sliders-horizontal" />
                </div>
            </div>
        </section>

        <!-- Listings Section -->
        <section class="w-full px-8 md:px-32">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-9 gap-y-12 mb-8 max-w-[1750px] mx-auto">
                @foreach($properties as $property)
                    <x-property-card :property="$property" />
                @endforeach
            </div>
        </section>

        <!-- Explore More Section -->
        <div class="text-center py-1 pb-4 max-w-[1200px] mx-auto">
            <p class="mb-3 text-gray-600 italic">Continue explore related airbnbs?</p>
            <button class="bg-airbnb-darkest text-airbnb-light py-2.5 px-6 border-none rounded-3xl cursor-pointer">
                Show More
            </button>
        </div>
    </div>
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
</style>
@endpush