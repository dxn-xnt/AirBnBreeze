@props(['icon', 'name'])

<div class="flex items-center gap-2.5 text-base">
    <i class="w-5 h-5" data-lucide="{{ $icon }}"></i>
    <span>{{ $name }}</span>
</div>