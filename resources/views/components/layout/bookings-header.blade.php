<header class="bg-airbnb-dark text-white py-3 px-8 flex justify-between items-center fixed top-0 left-0 right-0 z-50 h-20 w-full">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="flex items-center gap-2">
        <img src="{{ asset('assets/images/air-logo.png') }}" alt="AirBnBreeze Logo" class="h-[50px] w-[50px] border border-airbnb-light rounded-full object-cover">
        <span class="font-righteous text-[28px] font-normal text-airbnb-light">AirBnBreeze</span>
    </a>
    
<!-- Search Bar and Filters -->
<div class="flex items-center max-w-5xl w-full justify-center">
    <!-- Search Input -->
    <div class="flex bg-airbnb-light rounded-full shadow-md items-center">
        <button class="flex items-center gap-1 bg-transparent py-1.5 px-4 rounded-full text-airbnb-darkest">
            <i class="w-5 h-5 mr-1" data-lucide="map-pin"></i>
            <span class="text-xl font-medium">Cebu City</span>
        </button>
        <div class="border-r border-gray-900 h-12 my-auto"></div>
        
        <button class="flex items-center gap-1 bg-transparent py-1.5 px-4 rounded-full text-airbnb-darkest">
            <i class="w-5 h-5 mr-1" data-lucide="calendar"></i>
            <span class="text-xl font-medium">24/06/25 - 30/06/25</span>
        </button>
        <div class="border-r border-gray-900 h-12 my-auto"></div>
        
        <button class="flex items-center bg-transparent py-1.5 px-4 rounded-full text-airbnb-darkest">
            <div class="flex items-center gap-1">
                <i class="w-5 h-5 mr-1" data-lucide="door-open"></i>
                <span class="text-xl font-medium">2</span>
            </div>
            <div class="flex items-center ml-5">
                <i class="w-5 h-5 mr-1" data-lucide="users"></i>
                <span class="text-xl font-medium"> 5</span>
            </div>
        </button>
        <div class="border-r border-gray-900 h-12 my-auto"></div>
        
        <button class="bg-airbnb-darkest text-airbnb-light p-2 rounded-full ml-2 mr-2">
            <i class="w-5 h-5" data-lucide="search"></i>
        </button>
    </div>
</div>

<!-- Right-side icons container -->
<div class="flex items-center gap-4">
    <!-- Bell Icon -->
    <div class="relative">
        <i class="w-[25px] h-[25px] text-airbnb-light" data-lucide="bell"></i>
        <!-- notification badge -->
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
    </div>

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
            <a href="{{ route('bookings.index') }}" class="block py-[0.35rem] px-2 text-gray-800 hover:bg-[#FBFFF6] rounded font-medium">Favorites</a>
            <a href="{{ route('bookings.index') }}" class="block py-[0.35rem] px-2 text-gray-800 hover:bg-[#FBFFF6] rounded font-medium">Messages</a>
            <a href="{{ route('bookings.index') }}" class="block py-[0.35rem] px-2 text-gray-800 hover:bg-[#FBFFF6] rounded font-medium">Account</a>
            <a href="{{ route('bookings.index') }}" class="block py-[0.35rem] px-2 text-gray-800 hover:bg-[#FBFFF6] rounded font-medium">Browse AirBnBs</a>
            <a href="{{ route('bookings.index') }}" class="block py-[0.35rem] px-2 text-gray-800 hover:bg-[#FBFFF6] rounded font-medium">About us</a>
            <a href="{{ route('bookings.index') }}" class="block py-[0.35rem] px-2 text-gray-800 hover:bg-[#FBFFF6] rounded font-medium">Help Center</a>
        </div>
    </div>
</header>