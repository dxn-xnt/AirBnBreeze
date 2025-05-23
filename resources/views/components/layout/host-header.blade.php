<header class="bg-airbnb-dark text-white py-3 px-4 sm:px-6 md:px-8 flex justify-between items-center fixed top-0 left-0 right-0 z-50 h-16 sm:h-20 w-full">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="flex items-center gap-2">
        <img src="{{ asset('assets/images/air-logo.png') }}" alt="AirBnBreeze Logo" class="h-8 w-8 sm:h-[50px] sm:w-[50px] border border-airbnb-light rounded-full object-cover">
        <span class="font-righteous text-xl sm:text-[28px] font-normal text-airbnb-light">AirBnBreeze</span>
    </a>

    <nav class="flex space-x-10">
        <!-- Properties Link -->
        <a href="{{ route('host.listing') }}"
           class="text-xl relative py-2 transition-all duration-300 text-airbnb-light
              {{ request()->is('host/listing*', 'host/property*')
                 ? 'font-semibold scale-110'
                 : 'font-regular' }}">
            Properties
        </a>

        <!-- Bookings Link -->
        <a href="{{ route('host.bookings.pending') }}"
           class="text-xl relative py-2 transition-all duration-300 text-airbnb-light
              {{ request()->is('host/bookings*')
                 ? 'font-semibold scale-110'
                 : 'font-regular' }}">
            Bookings
        </a>
    </nav>

    <!-- Right-side icons container -->
    <div class="flex items-center gap-4">
        <!-- Notification bell icon -->
        <a href="{{ route('notifications.index') }}" class="relative">
            <i class="w-[25px] h-[25px] text-airbnb-light" data-lucide="bell"></i>
            <!-- notification badge -->
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
        </a>
        <!-- Menu with Alpine.js -->
        <div x-data="{ open: false }" class="relative">
            <button
                @click="open = !open"
                @click.away="open = false"
                class="flex items-center gap-2 bg-airbnb-dark border border-airbnb-light rounded-full px-2 py-1 sm:px-[10px] sm:py-[5px] hover:bg-opacity-90 shadow-[0_6px_16px_-2px_rgba(0,0,0,0.3)]"
            >
                <i class="w-5 h-5 sm:w-[25px] sm:h-[25px] text-airbnb-light" data-lucide="menu"></i>
                <i class="w-5 h-5 sm:w-[25px] sm:h-[25px] text-airbnb-light" data-lucide="user-circle"></i>
            </button>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute top-10 sm:top-12 right-0 bg-airbnb-light text-airbnb-dark rounded-xl shadow-lg min-w-[180px] sm:min-w-[230px] p-2 z-10"
                style="display: none;"
            >
                @auth
                    <!-- Show when logged in -->
                    <div class="px-2 py-1 border-b border-gray-200">
                        <p class="font-medium">Hi, {{ auth()->user()->user_fname }}!</p>
                        @if(auth()->user()->user_is_host )
                            <p class="text-xs text-airbnb-darkest">Host Account</p>
                        @endif
                    </div>

                    <!-- Common user links -->
                    <a href="{{ route('bookings.index') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">My Bookings</a>
                    <a href="{{ route('favorites') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">Favorites</a>
                    <a href="{{ route('profile.view') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">Account</a>

                    <!-- User/Host specific links -->
                    @if(auth()->user()->user_is_host)
                        <!-- Host-specific menu items -->
                        <a href="{{ route('bookings.index') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">Manage Listing</a>
                        <a href="{{ route('host.bookings.pending') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">Host Bookings</a>
                        <a href="{{ route('home') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">Browse</a>
                    @else
                        <!-- Regular user menu items -->
                        <a href="{{ route('property.create') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">AirBnB your house</a>
                    @endif

                    <!-- Common links for all users -->
                    <div class="border-t border-gray-200">
                        <a href="{{ route('about') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">About us</a>
                        <a href="{{ route('help') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">Help Center</a>
                    </div>

                    <!-- Logout -->
                    <div class="border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">Log out</button>
                        </form>
                    </div>

                @else
                    <!-- Show when guest -->
                    <a href="{{ route('login') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">Log in</a>
                    <a href="{{ route('signup') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">Sign up</a>
                    <a href="{{ route('login') }}"
                       onclick="sessionStorage.setItem('property_creation_intent', true)"
                       class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">AirBnB your house</a>

                    <!-- Common links for all users -->
                    <div class="border-t border-gray-200">
                        <a href="{{ route('about') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">About us</a>
                        <a href="{{ route('help') }}" class="block py-[0.35rem] px-2 text-airbnb-darkest hover:bg-airbnb-light rounded font-medium">Help Center</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>
