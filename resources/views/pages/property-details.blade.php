@extends('layouts.app')

@section('title', $data['title'])

@section('content')
    <div class="max-w-[1750px] mx-auto px-[1rem] sm:px-[1.5rem] md:px-[2rem] lg:px-[4rem] xl:px-[8rem] mt-[4rem] md:mt-[7.5rem]">
        <!-- Property Title -->
        <h1 class="text-[1.5rem] sm:text-[1.75rem] font-semibold text-airbnb-darkest mb-[1rem] sm:mb-[1.25rem]">
            {{ $data['title'] }}
        </h1>

        <!-- Image Gallery - Enhanced Responsiveness -->
        <div class="flex flex-col lg:flex-row mb-6 sm:mb-8 gap-3 sm:gap-4">
            <!-- Main Image (Left Column) -->
            <div class="flex-[1.5]">
                <img src="{{ asset('storage/' . $data['images']['main']) }}"
                     alt="{{ $data['title'] }}"
                     class="w-full h-[300px] sm:h-[350px] md:h-[400px] object-cover rounded-xl sm:rounded-2xl border border-airbnb-darkest shadow-md">
            </div>

            <!-- Gallery Images (Right Column) -->
            <div class="flex-1 grid grid-cols-2 gap-3 sm:gap-4">
                @foreach($data['images']['gallery'] as $key => $image)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $image) }}"
                             alt="Gallery view {{ $key + 1 }}"
                             class="w-full h-[140px] sm:h-[160px] md:h-[190px] object-cover rounded-xl sm:rounded-2xl border border-airbnb-darkest shadow-md">
                        @if($key === 3)
                            <span class="absolute bottom-2 sm:bottom-[10px] right-2 sm:right-[10px] bg-airbnb-light text-airbnb-darkest py-1 px-2 sm:px-2.5 rounded-xl sm:rounded-2xl text-xs font-semibold cursor-pointer">
                    Show All Photos
                </span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Property Info Row - Enhanced Responsiveness -->
        <div class="flex flex-col lg:flex-row justify-between items-start mb-6 sm:mb-8 gap-4 sm:gap-0">
            <div class="flex flex-col gap-1 sm:gap-1.5">
                <div class="text-lg sm:text-xl font-semibold text-airbnb-darkest">{{ $data['location'] }}</div>
                <div class="text-xs sm:text-sm text-airbnb-darkest mb-1 sm:mb-1.5">{{ $data['guests'] }} Guests · {{ $data['rooms'] }} Rooms · {{ $data['bathrooms'] }} Bathroom</div>

                <div class="flex items-center">
                    <div class="flex items-center">
                        <i class="w-3 sm:w-4 h-3 sm:h-4 text-gold fill-gold" data-lucide="star"></i>
                    </div>
                    <span class="font-semibold text-xs sm:text-sm ml-1 sm:ml-1.5 mr-1 sm:mr-1.5 text-airbnb-darkest">{{ $data['rating'] }} · </span>
                    <button
                        onclick="document.getElementById('reviewsModal').classList.remove('hidden')"
                        class="text-xs sm:text-sm text-airbnb-darkest underline italic cursor-pointer hover:text-airbnb-dark"
                    >
                        {{ $data['reviews'] }} Reviews
                    </button>
                </div>
            </div>

            <div class="w-full sm:w-auto mt-0 sm:mt-4 lg:mt-0">
                <form action="{{ route('bookings.book', ['id' => $data['id']]) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-airbnb-darkest text-airbnb-light border-none py-2 sm:py-3 px-6 sm:px-12 text-sm sm:text-base font-light rounded-2xl sm:rounded-3xl cursor-pointer hover:bg-opacity-90 w-full sm:w-auto">
                        Request Booking
                    </button>
                </form>
            </div>
        </div>

        <!-- Property Description -->
        <div class="text-[1rem] sm:text-[1.125rem] leading-relaxed text-airbnb-darkest mb-[1.5rem] sm:mb-[2rem]">
            <p>{{ $data['description'] }}</p>
        </div>

        <!-- Host Information with View Contact Details button -->
        <div class="flex items-center gap-3 sm:gap-4 mb-6 sm:mb-8">
            <img src="{{ asset($data['host']['image']) }}"
                 alt="{{ $data['host']['name'] }}"
                 class="w-16 sm:w-20 h-16 sm:h-20 rounded-full border border-airbnb-darkest object-cover">
            <div class="flex flex-col flex-1">
                <h3 class="text-sm sm:text-base font-semibold m-0 mb-0.5 text-airbnb-darkest">{{ $data['host']['name'] }}</h3>
                <p class="text-airbnb-dark text-xs sm:text-sm m-0 italic">{{ $data['host']['role'] }}</p>
            </div>
            <button
                onclick="document.getElementById('contactModal').classList.remove('hidden')"
                class="border border-airbnb-dark text-airbnb-darkest bg-transparent py-1.5 px-3 sm:px-10 rounded-full text-xs sm:text-sm hover:shadow-md transition-colors"
            >
                View Contact Details
            </button>
        </div>
    </div>

    <!-- Amenities Section - Enhanced Responsiveness -->
    <div class="relative w-screen left-[50%] right-[50%] -ml-[50vw] -mr-[50vw] bg-airbnb-dark mb-4 sm:mb-[18px] py-6 sm:py-8">
        <div class="w-full text-airbnb-light">
            <div class="max-w-[1750px] mx-auto px-4 sm:px-6 md:px-8 lg:px-16 xl:px-32">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 sm:mb-5 gap-3 sm:gap-0">
                    <h2 class="text-lg sm:text-[22px] font-semibold m-0">What this place offers</h2>
                    <button class="bg-transparent border border-airbnb-light text-airbnb-light py-1.5 sm:py-2 px-3 sm:px-4 rounded-2xl sm:rounded-3xl text-xs sm:text-sm hover:shadow-md cursor-pointer w-full sm:w-auto">
                        Show All Amenities
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-5">
                    @foreach($data['amenities'] as $amenity)
                        <x-amenity-item :icon="$amenity['icon']" :name="$amenity['name']" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Things to Know - Enhanced Responsiveness -->
    <div class="max-w-[1750px] mx-auto px-4 sm:px-6 md:px-8 lg:px-16 xl:px-32 py-4 sm:py-6 mb-8 sm:mb-12 bg-airbnb-light rounded-xl sm:rounded-2xl">
        <h2 class="text-lg sm:text-[22px] font-semibold mb-4 sm:mb-6 text-airbnb-darkest">Things to know</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
            <div>
                <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-airbnb-darkest">House rules</h3>
                <ul class="list-none p-0 m-0">
                    @foreach($data['rules'] as $rule)
                        <li class="text-xs sm:text-sm mb-2 sm:mb-3 text-airbnb-darkest relative pl-4 sm:pl-5 before:content-['•'] before:absolute before:left-0 before:text-airbnb-dark before:font-bold">
                            {{ $rule }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-airbnb-darkest">Safety & property</h3>
                <ul class="list-none p-0 m-0">
                    @foreach($data['safety'] as $item)
                        <li class="text-xs sm:text-sm mb-2 sm:mb-3 text-airbnb-darkest relative pl-4 sm:pl-5 before:content-['•'] before:absolute before:left-0 before:text-airbnb-dark before:font-bold">
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-airbnb-darkest">Cancellation policy</h3>
                <ul class="list-none p-0 m-0">
                    @foreach($data['cancellation'] as $item)
                        <li class="text-xs sm:text-sm mb-2 sm:mb-3 text-airbnb-darkest relative pl-4 sm:pl-5 before:content-['•'] before:absolute before:left-0 before:text-airbnb-dark before:font-bold">
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @include('components.customer-reviews', ['property' => $data])
    @include('components.view-ownerContact')

@endsection
