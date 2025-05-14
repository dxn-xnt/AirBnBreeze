@props([
    'icon', 
    'text' => null,
    'active' => false
])

@php
    // Shared base styles
    $baseClasses = 'flex items-center justify-center cursor-pointer transition-colors duration-200 ease-in-out';
    
    // Active state: light bg, dark text/border
    $activeClasses = 'bg-airbnb-light text-airbnb-darkest border-airbnb-darkest font-medium';
    
    // Inactive state with hover effects
    $inactiveClasses = 'bg-transparent border border-airbnb-light text-airbnb-light hover:bg-airbnb-light hover:text-airbnb-darkest hover:border-airbnb-darkest hover:font-medium';
    
    // Text button styles (responsive)
    $textButtonClasses = 'gap-2 py-2 px-4 md:px-6 rounded-full whitespace-nowrap text-base md:text-lg';
    
    // Icon-only button styles (responsive)
    $iconButtonClasses = 'p-2 w-9 h-9 md:w-10 md:h-10 rounded-full';
@endphp

@if($text)
    <button {{ $attributes->merge([
        'class' => "$baseClasses $textButtonClasses " . ($active ? $activeClasses : $inactiveClasses)
    ]) }}>
        <i class="filter-icon w-5 h-5 md:w-6 md:h-6 hover:text-airbnb-darkest" data-lucide="{{ $icon }}" @if($active) style="color: #0F2A1D;" @endif></i>
        <span class="text-center w-full">{{ $text }}</span>
    </button>
@else
    <button {{ $attributes->merge([
        'class' => "$baseClasses $iconButtonClasses " . ($active ? $activeClasses : $inactiveClasses)
    ]) }}>
        <i class="w-4 h-4 md:w-5 md:h-5 hover:text-airbnb-darkest" data-lucide="{{ $icon }}" @if($active) style="color: #0F2A1D;" @endif></i>
    </button>
@endif