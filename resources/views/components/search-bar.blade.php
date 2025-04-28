<div class="relative z-10 w-full">
    <div class="flex bg-airbnb-light rounded-full py-2 px-3 shadow-[0_15px_10px_-10px_rgba(0,0,0,0.5)] justify-between items-center max-w-[1350px] mx-auto">
        <!-- Location -->
        <div class="px-4 border-r border-[#383131] flex-1">
            <label class="block text-sm mb-0.5 text-[#6e7672]">Place Location</label>
            <div class="flex items-center gap-2">
                <i class="w-7 h-7 text-airbnb-darkest" data-lucide="map-pin"></i>
                <input type="text" placeholder="Cebu City, Cebu" class="input-field text-xl font-medium">
            </div>
        </div>
        
        <!-- Arrival Date -->
        <div class="px-4 border-r border-[#383131] flex-1">
            <label class="block text-sm mb-0.5 text-[#6e7672]">Arrival Date</label>
            <div class="flex items-center gap-2">
                <i class="w-7 h-7 text-airbnb-darkest" data-lucide="calendar"></i>
                <input type="text" value="24/06/25" class="input-field text-xl font-semibold">
            </div>
        </div>
        
        <!-- Departure Date -->
        <div class="px-4 border-r border-[#383131] flex-1">
            <label class="block text-sm mb-0.5 text-[#6e7672]">Departure Date</label>
            <div class="flex items-center gap-2">
                <i class="w-7 h-7 text-airbnb-darkest" data-lucide="calendar"></i>
                <input type="text" value="24/06/25" class="input-field text-xl font-semibold">
            </div>
        </div>
        
        <!-- Room & Guests -->
        <div class="px-4 border-r border-[#383131] flex-1">
            <label class="block text-sm mb-0.5 text-[#6e7672]">Room & Guests</label>
            <div class="flex items-center gap-2">
                <i class="w-7 h-7 text-airbnb-darkest" data-lucide="door-open"></i>
                <input type="text" value="2" class="w-[30px] text-center bg-transparent border-none outline-none text-xl font-semibold mr-[10px]">
                <i class="w-7 h-7 text-airbnb-darkest" data-lucide="users"></i>
                <input type="text" value="5" class="w-[30px] text-center bg-transparent border-none outline-none text-xl font-semibold mr-[10px]">
            </div>
        </div>
        
        <!-- Search Button -->
        <button class="bg-airbnb-darkest text-airbnb-light border-none py-3 px-6 rounded-full text-lg font-medium cursor-pointer ml-[10px] min-w-[150px]">
            Search
        </button>
    </div>
</div>