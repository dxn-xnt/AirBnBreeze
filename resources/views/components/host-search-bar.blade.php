<div class="w-full max-w-[1400px] mx-auto z-10 relative" x-data="{ expanded: false }">
    <!-- Collapsed Search Button -->
    <button
        x-show="!expanded"
        @click="expanded = true"
        class="absolute right-0 top-0 p-2 border border-airbnb-darkest rounded-md text-airbnb-darkest hover:bg-airbnb-dark hover:text-airbnb-light transition-all"
        aria-label="Open search"
    >
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </button>

    <!-- Expanded Search Bar -->
    <div
        x-show="expanded"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="relative flex-1"
    >
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-6 w-6 text-airbnb-darkest" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input
            type="text"
            placeholder="Search"
            class="w-full py-2 pl-10 pr-10 text-airbnb-darkest bg-airbnb-light border border-airbnb-darkest rounded-md focus:outline-none"
            aria-label="Search properties"
        >
        <!-- Close Button -->
        <button
            @click="expanded = false"
            class="absolute inset-y-0 right-0 pr-3 flex items-center text-airbnb-darkest hover:text-airbnb-darker"
            aria-label="Close search"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
