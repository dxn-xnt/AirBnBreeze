@props(['property'])

<div class="relative overflow-hidden transition-shadow duration-300">
    <!-- Property Content -->
    <a href="{{ route('property.edit.type', ['property' => $property->prop_id]) }}">
        <!-- Responsive Image -->
        @if($property->images->isNotEmpty())
            <img
                src="{{ $property->images->first() ? asset('storage/' . $property->images->first()->img_url) : asset('images/default-property.jpg') }}"
                alt="{{ $property->prop_title }}"
                class="w-full h-[200px] sm:h-[250px] md:h-[290px] object-cover rounded-xl shadow-md hover:shadow-lg"
            >
        @else
            <img
                src="{{ asset('assets/images/placeholder.jpg') }}"
                alt="No Image Available"
                class="w-full h-[200px] sm:h-[250px] md:h-[290px] object-cover"
            >
        @endif

        <!-- Responsive Content -->
        <div class="p-3 md:p-4">
            <h3 class="text-sm md:text-base font-bold mb-1">{{ $property->prop_title }}</h3>
            <p class="text-airbnb-darkest text-xs md:text-sm mb-2">{{ $property->prop_address }}</p>
        </div>
    </a>
</div>
