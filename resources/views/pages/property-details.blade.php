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
                @php $maxGalleryPreviews = 5; @endphp

                @foreach($data['images']['gallery'] as $key => $image)
                    @if($key > 0 && $loop->iteration <= $maxGalleryPreviews)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $image) }}"
                                 alt="Gallery view {{ $key + 1 }}"
                                 class="w-full h-[140px] sm:h-[160px] md:h-[190px] object-cover rounded-xl sm:rounded-2xl border border-airbnb-darkest shadow-md">

                            @if($loop->iteration === $maxGalleryPreviews || $key === count($data['images']['gallery']) - 1)
                                <span id="showAllPhotosButton"
                                      onclick="openPhotoModal()"
                                      class="absolute bottom-2 sm:bottom-[10px] right-2 sm:right-[10px] bg-airbnb-light text-airbnb-darkest py-1 px-2 sm:px-2.5 rounded-xl sm:rounded-2xl text-xs font-semibold cursor-pointer">
                        Show All Photos
                    </span>
                            @endif
                        </div>
                    @endif
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

    <!-- Photo Modal with Enhanced Design -->
    <div id="photoModal" class="fixed inset-0 hidden bg-black bg-opacity-80 z-50 flex items-center justify-center">
        <!-- Close Button (X) at top right of screen, not modal -->
        <button id="closeModal" class="absolute top-6 right-6 text-white text-4xl font-light hover:text-gray-300 focus:outline-none z-[60]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Modal Container -->
        <div class="relative w-full h-full flex items-center justify-center">
            <!-- Navigation Arrows -->
            <button id="prevArrow" class="absolute left-4 md:left-10 z-[55] bg-airbnb-light hover:bg-opacity-70 text-airbnb-darkest p-3 rounded-full focus:outline-none transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button id="nextArrow" class="absolute right-4 md:right-10 z-[55] bg-airbnb-light hover:bg-opacity-70 text-airbnb-darkest    p-3 rounded-full focus:outline-none transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Image Container -->
            <div class="w-full max-w-7xl px-4">
                <div class="relative">
                    <!-- Carousel Images Container -->
                    <div id="carouselImagesContainer" class="w-full flex justify-center items-center overflow-hidden">
                        <div id="carouselImages" class="flex transition-transform duration-300">
                            @foreach($data['images']['gallery'] as $index => $image)
                                <div class="carousel-item w-full flex-shrink-0 px-4 flex items-center justify-center" data-index="{{ $index }}">
                                    <img
                                        src="{{ asset('storage/' . $image) }}"
                                        alt="Property Image {{ $index + 1 }}"
                                        class="max-h-[80vh] max-w-full object-cover rounded-xl sm:rounded-2xl border border-airbnb-darkest shadow-md">"
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indicator dots at bottom center of screen (no counter) -->
    <div class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-[60] flex flex-col items-center gap-3">
        <!-- Indicator Dots -->
        <div id="indicatorDots" class="flex gap-2 hidden">
            @foreach($data['images']['gallery'] as $index => $image)
                <button
                    class="w-2 h-2 rounded-full transition-all duration-200 dot-indicator"
                    data-index="{{ $index }}"
                    aria-label="Go to image {{ $index + 1 }}"
                ></button>
            @endforeach
        </div>
    </div>

    <!-- Scripts for the carousel -->
    <script>
        // DOM Elements
        const photoModal = document.getElementById('photoModal');
        const carouselImages = document.getElementById('carouselImages');
        const prevArrow = document.getElementById('prevArrow');
        const nextArrow = document.getElementById('nextArrow');
        const closeModalBtn = document.getElementById('closeModal');
        const carouselItems = document.querySelectorAll('.carousel-item');
        const dotIndicators = document.querySelectorAll('.dot-indicator');

        // State
        let currentIndex = 0;
        let totalImages = carouselItems.length;

        // Function to close the photo modal
        function closePhotoModal() {
            photoModal.classList.add('hidden');
            photoModal.classList.remove('flex');
            document.body.style.overflow = ''; // Restore scrolling

            // Hide the indicator dots
            const indicatorDots = document.getElementById('indicatorDots');
            indicatorDots.classList.add('hidden');
        }

        // Function to open the photo modal
        function openPhotoModal(startIndex = 0) {
            photoModal.classList.remove('hidden');
            photoModal.classList.add('flex');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
            setCurrentImage(startIndex);

            // Show the indicator dots
            const indicatorDots = document.getElementById('indicatorDots');
            indicatorDots.classList.remove('hidden');
        }

        // Update dot indicators
        function updateDotIndicators() {
            dotIndicators.forEach((dot, index) => {
                if (index === currentIndex) {
                    dot.classList.add('bg-white');
                    dot.classList.remove('bg-gray-500', 'opacity-50');
                } else {
                    dot.classList.add('bg-gray-500', 'opacity-50');
                    dot.classList.remove('bg-white');
                }
            });
        }

        // Set current image in the carousel
        function setCurrentImage(index) {
            currentIndex = index;
            updateCarouselPosition();
            updateArrowVisibility();
            updateDotIndicators();
        }

        // Update carousel position based on current index
        function updateCarouselPosition() {
            const translateX = -100 * currentIndex;
            carouselImages.style.transform = `translateX(${translateX}%)`;

            // Set all items to same width for smooth transition
            carouselItems.forEach(item => {
                item.style.width = '100%';
            });
        }

        // Update arrow visibility based on position
        function updateArrowVisibility() {
            prevArrow.style.visibility = currentIndex === 0 ? 'hidden' : 'visible';
            nextArrow.style.visibility = currentIndex === totalImages - 1 ? 'hidden' : 'visible';
        }

        // Previous image
        function showPrevImage() {
            if (currentIndex > 0) {
                setCurrentImage(currentIndex - 1);
            }
        }

        // Next image
        function showNextImage() {
            if (currentIndex < totalImages - 1) {
                setCurrentImage(currentIndex + 1);
            }
        }

        // Event Listeners
        closeModalBtn.addEventListener('click', closePhotoModal);
        prevArrow.addEventListener('click', showPrevImage);
        nextArrow.addEventListener('click', showNextImage);

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (photoModal.classList.contains('hidden')) return;

            if (e.key === 'Escape') closePhotoModal();
            if (e.key === 'ArrowLeft') showPrevImage();
            if (e.key === 'ArrowRight') showNextImage();
        });

        // Connect the "Show All Photos" button to the modal
        document.getElementById('showAllPhotosButton').addEventListener('click', function() {
            openPhotoModal(0); // Start from the first image
        });

        // Make individual gallery images clickable to open the modal
        document.querySelectorAll('.gallery-image').forEach((img, index) => {
            img.addEventListener('click', function() {
                openPhotoModal(index);
            });
        });

        // Connect dot indicators to navigation
        dotIndicators.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                setCurrentImage(index);
            });
        });

        // Initialize with first slide and update indicators
        updateArrowVisibility();
        updateDotIndicators();
    </script>

    @include('components.customer-reviews', ['property' => $data])
    @include('components.view-ownerContact')

@endsection
