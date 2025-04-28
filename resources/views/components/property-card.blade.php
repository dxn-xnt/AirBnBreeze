@props(['property'])

<div class="card">
    @if($property['is_favorite'])
        <div class="absolute top-4 left-4 bg-airbnb-light py-1 px-3 rounded-xl text-xs font-semibold z-10">Guest Favorite</div>
    @endif
    
    <button class="absolute top-4 right-4 bg-transparent border-none text-white text-2xl cursor-pointer z-10 filter drop-shadow-md">
        <i data-lucide="heart"></i>
    </button>
    
    <a href="{{ route('property.show', $property['id']) }}" class="block">
        <img src="{{ asset($property['image']) }}" alt="{{ $property['name'] }}" class="w-full h-[290px] object-cover">
        
        <div class="p-4">
            <h3 class="text-base font-bold mb-1">{{ $property['name'] }}</h3>
            <p class="text-airbnb-darkest text-sm mb-2">{{ $property['location'] }}</p>
            <div class="flex justify-between items-center mt-2">
                <p class="text-sm">
                    <span class="font-normal">₱</span> 
                    <strong>{{ $property['price'] }}</strong> / night
                </p>
                <div class="flex items-center gap-1 bg-airbnb-darkest text-airbnb-light px-2 py-[0.15rem] rounded-xl text-xs font-semibold">
                    <i data-lucide="star" class="w-3 h-3 text-gold fill-gold"></i> 
                    {{ $property['rating'] }}
                </div>
            </div>
        </div>
    </a>
</div>