@extends('layouts.app')

@section('title', 'Property Listing')

@section('content')
        <div class="min-h-screen bg-airbnb-light pt-[4rem] md:pt-[7.5rem] pb-[1.5rem] sm:pb-[2rem] px-[1rem] sm:px-[1.5rem] md:px-[2rem] lg:px-[4rem] xl:px-[8rem]">
            <!-- Title and Search Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <h1 class="text-[1.5rem] sm:text-[1.75rem] font-semibold text-airbnb-darkest ">Properties</h1>

                <div class="flex flex-1 max-w-2xl">
                    <!-- Search Bar -->
                    <x-host-search-bar />

                    <!-- Add Property Button -->
                    <a href="{{ route('property.create.starter') }}" class="flex items-center justify-center bg-airbnb-light p-2 rounded-md shadow-sm hover:bg-airbnb-dark hover:text-airbnb-light border border-airbnb-darkest" aria-label="Add new property">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </a>
                </div>
            </div>

            <section class="w-full px-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 sm:gap-x-8 lg:gap-x-9 gap-y-8 sm:gap-y-10 lg:gap-y-12 mb-8 max-w-[1750px] mx-auto">
                    @foreach($properties as $property)
                        <x-host-property-card :property="$property" />
                    @endforeach
                </div>
            </section>
        </div>
@endsection
