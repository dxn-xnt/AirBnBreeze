@extends('layouts.app')

@section('title', $property['name'])

@section('content')
    <div class="max-w-[1750px] mx-auto px-8 md:px-32 mt-[120px]">
        <!-- Property Title -->
        <h1 class="text-[28px] font-semibold text-airbnb-darkest mb-5">{{ $property['name'] }}</h1>

        <!-- Image Gallery -->
        <div class="flex flex-col lg:flex-row mb-5 gap-4">
            <div class="flex-[1.5]">
                <img src="{{ asset($property['images']['main']) }}"
                     alt="Main view"
                     class="w-full h-[400px] object-cover rounded-2xl border border-airbnb-darkest shadow-md">
            </div>
            <div class="flex-1 flex flex-col gap-4">
                <div class="flex gap-4 h-1/2">
                    @foreach(array_slice($property['images']['gallery'], 0, 2) as $image)
                        <img src="{{ asset($image) }}"
                             alt="View"
                             class="w-full h-[190px] object-cover rounded-2xl border border-airbnb-darkest shadow-md">
                    @endforeach
                </div>
                <div class="flex gap-4 h-1/2">
                    <img src="{{ asset($property['images']['gallery'][2]) }}"
                         alt="View"
                         class="w-full h-[190px] object-cover rounded-2xl border border-airbnb-darkest shadow-md">
                    <div class="relative w-full">
                        <img src="{{ asset($property['images']['gallery'][3]) }}"
                             alt="View"
                             class="w-full h-[190px] object-cover rounded-2xl border border-airbnb-darkest shadow-md">
                        <span class="absolute bottom-[10px] right-[10px] bg-airbnb-light text-airbnb-darkest py-1 px-2.5 rounded-2xl text-xs font-semibold cursor-pointer">
                            Show All Photos
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Property Info Row -->
        <div class="flex flex-col lg:flex-row justify-between items-start mb-5">
            <div class="flex flex-col gap-1.5">
                <div class="text-xl font-semibold text-airbnb-darkest">{{ $property['location'] }}</div>
                <div class="text-sm text-airbnb-darkest mb-1.5">{{ $property['guests'] }} Guests · {{ $property['rooms'] }} Rooms · {{ $property['bathrooms'] }} Bathroom</div>
                <div class="flex items-center">
                    <div class="flex items-center">
                        <i class="w-4 h-4 text-gold fill-gold" data-lucide="star"></i>
                    </div>
                    <span class="font-semibold text-sm ml-1.5 mr-1.5 text-airbnb-darkest">{{ $property['rating'] }} · </span>
                    <span class="text-sm text-airbnb-darkest underline italic">{{ $property['reviews'] }} Reviews</span>
                </div>
            </div>

            <div class="mt-4 lg:mt-0">
                <form action="{{ route('bookings.book', $property['id']) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-airbnb-darkest text-airbnb-light border-none py-3 px-12 text-base font-light rounded-3xl cursor-pointer hover:bg-opacity-90">
                        Book Now
                    </button>
                </form>
            </div>
        </div>

        <!-- Property Description -->
        <div class="text-lg leading-relaxed text-airbnb-darkest mb-8">
            <p>{{ $property['description'] }}</p>
        </div>

        <!-- Host Information -->
        <div class="flex items-center gap-4 mb-8">
            <img src="{{ asset($property['host']['image']) }}"
                 alt="{{ $property['host']['name'] }}"
                 class="w-20 h-20 rounded-full border border-airbnb-darkest object-cover">
            <div>
                <h3 class="text-base font-semibold m-0 mb-0.5 text-airbnb-darkest">{{ $property['host']['name'] }}</h3>
                <p class="text-airbnb-dark text-sm m-0 italic">{{ $property['host']['role'] }}</p>
            </div>
        </div>
    </div>

    <!-- Amenities Section -->
    <div class="relative w-screen left-[50%] right-[50%] -ml-[50vw] -mr-[50vw] bg-airbnb-dark mb-[18px] py-8">
        <div class="w-full text-airbnb-light">
            <div class="max-w-[1750px] mx-auto px-8 md:px-32">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-5">
                    <h2 class="text-[22px] font-semibold m-0">What this place offers</h2>
                    <button class="bg-transparent border border-airbnb-light text-airbnb-light py-2 px-4 rounded-3xl text-sm cursor-pointer mt-3 md:mt-0 w-full md:w-auto">
                        Show All Amenities
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($property['amenities'] as $amenity)
                        <x-amenity-item :icon="$amenity['icon']" :name="$amenity['name']" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Things to Know -->
    <div class="max-w-[1750px] mx-auto px-8 md:px-32 py-6 mb-12 bg-airbnb-light rounded-2xl">
        <h2 class="text-[22px] font-semibold mb-6 text-airbnb-darkest">Things to know</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-semibold mb-4 text-airbnb-darkest">House rules</h3>
                <ul class="list-none p-0 m-0">
                    @foreach($property['rules'] as $rule)
                        <li class="text-sm mb-3 text-airbnb-darkest relative pl-5 before:content-['•'] before:absolute before:left-0 before:text-airbnb-dark before:font-bold">
                            {{ $rule }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 text-airbnb-darkest">Safety & property</h3>
                <ul class="list-none p-0 m-0">
                    @foreach($property['safety'] as $item)
                        <li class="text-sm mb-3 text-airbnb-darkest relative pl-5 before:content-['•'] before:absolute before:left-0 before:text-airbnb-dark before:font-bold">
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 text-airbnb-darkest">Cancellation policy</h3>
                <ul class="list-none p-0 m-0">
                    @foreach($property['cancellation'] as $item)
                        <li class="text-sm mb-3 text-airbnb-darkest relative pl-5 before:content-['•'] before:absolute before:left-0 before:text-airbnb-dark before:font-bold">
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
