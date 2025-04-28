@props(['icon', 'text' => null])

@if($text)
    <button {{ $attributes->merge(['class' => 'flex items-center gap-2 bg-transparent border border-airbnb-light text-airbnb-light py-2 px-6 rounded-full whitespace-nowrap text-lg cursor-pointer justify-start']) }}>
        <i class="filter-icon" data-lucide="{{ $icon }}"></i>
        <span class="text-center w-full">{{ $text }}</span>
    </button>
@else
    <button {{ $attributes->merge(['class' => 'p-2 w-[38px] h-[38px] flex items-center justify-center bg-transparent border border-airbnb-light text-airbnb-light rounded-full cursor-pointer']) }}>
        <i data-lucide="{{ $icon }}"></i>
    </button>
@endif