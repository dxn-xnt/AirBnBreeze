@props(['type'])
<label class="relative block cursor-pointer group" x-data="{ isChecked: false }">
    <input
        type="radio"
        name="prop_type"
        value="{{ is_array($type) ? $type['type_name'] : $type->type_name }}"
        class="absolute opacity-0 w-0 h-0 peer"
        data-value="{{ is_array($type) ? $type['type_name'] : $type->type_name }}"
        {{ old('prop_type') == (is_array($type) ? $type['type_name'] : $type->type_name) ? 'checked' : '' }}
        @change="isChecked = $event.target.checked"
    >

    <div class="flex items-center gap-3 py-2 px-6 rounded-lg whitespace-nowrap text-lg justify-start transition-all duration-200 border border-airbnb-darkest text-airbnb-darkest peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light hover:bg-airbnb-light hover:border-airbnb-dark group-hover:shadow-sm">
        <i
            class="h-8 w-8 transition-colors duration-200"
            data-lucide="{{ is_array($type) ? $type['icon_name'] : $type->icon_name }}"
            :class="isChecked ? 'text-airbnb-light' : 'text-airbnb-dark'"
        ></i>
        <span class="text-center w-full font-medium">
            {{ is_array($type) ? $type['type_name'] : $type->type_name }}
        </span>
    </div>
</label>
