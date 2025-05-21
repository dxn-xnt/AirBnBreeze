@props(['property'])

<div class="relative overflow-hidden transition-shadow duration-300 group" id="property-{{ $property->prop_id }}">
    <!-- X Button -->
    <button
        class="absolute top-2 right-2 bg-airbnb-dark rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-md z-10"
        onclick="deleteProperty({{ $property->prop_id }})"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-airbnb-light" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Property Content -->
    <a href="{{ route('property.edit.type', ['property' => $property->prop_id]) }}">
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

        <div class="p-3 md:p-4">
            <h3 class="text-sm md:text-base font-bold mb-1">{{ $property->prop_title }}</h3>
            <p class="text-airbnb-darkest text-xs md:text-sm mb-2">{{ $property->prop_address }}</p>
        </div>
    </a>
</div>

<script>
    function deleteProperty(propertyId) {
        if (confirm('Are you sure you want to delete this property?')) {
            fetch(`/host/listing/${propertyId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                        // Remove the property card from DOM
                        document.getElementById(`property-${propertyId}`).remove();

                        // Optional: Show success message
                        alert('Property deleted successfully');
                    } else {
                        throw new Error('Failed to delete property');
                    }
                })
                .catch(error => {
                    alert(error.message);
                });
        }
    }
</script>
