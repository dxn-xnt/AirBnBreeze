@extends('layouts.app')

@section('content')
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-light gap-2">
        <!-- Amenities Form -->
        <form id="amenitiesForm" action="{{ route('property.update.amenities', ['property' => $property->prop_id]) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Hidden field to determine which button was clicked -->
            <input type="hidden" name="form_action" id="form_action" value="">

            <div class="px-[8%]">
                <div class="flex justify-between mb-3">
                    <h2 class="text-left text-3xl font-extrabold text-gray-900">
                        Listing Editor
                    </h2>
                    <div class="flex gap-3">
                        <a href="{{ route('host.listing') }}" class="min-w-[150px] inline-flex justify-center py-2 px-4 border-[1px] border-airbnb-dark shadow-sm text-lg font-medium rounded-full text-airbnb-dark bg-airbnb-light hover:text-airbnb-darkest hover:border-airbnb-darkest focus:outline-none focus:ring-airbnb-light">
                            Back
                        </a>
                        <button type="submit" name="save_and_exit" onclick="setFormAction('save_and_exit')" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:text-airbnb-light hover:border-airbnb-dark focus:outline-none focus:ring-airbnb-dark">
                            Save & Exit
                        </button>
                    </div>
                </div>

                <div class="flex justify-start gap-3 pt-5">
                    <a href="{{ route('property.edit.type', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Property Type</a>
                    <a href="{{ route('property.edit.location', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Location</a>
                    <a href="{{ route('property.edit.capacity', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Capacity</a>
                    <a href="{{ route('property.edit.description', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Description</a>
                    <a href="{{ route('property.edit.amenities', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Amenities</a>
                    <a href="{{ route('property.edit.pictures', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Pictures</a>
                    <a href="{{ route('property.edit.price', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Price</a>
                    <a href="{{ route('property.edit.rules', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">House Rules</a>
                </div>
            </div>

            <div class="m-auto w-full max-w-screen-md p-8">
                @php
                    // Get amenities from draft or fallback to DB
                    $draftData = session()->get('property_draft', []);
                    $amenitiesFromDraft = $draftData['amenities'] ?? null;

                    // Determine selected amenity IDs
                    if ($amenitiesFromDraft && is_array($amenitiesFromDraft)) {
                        $selectedAmenities = $amenitiesFromDraft;
                    } else {
                        // Fallback to property amenities from DB
                        $selectedAmenities = old('amenities', $propertyAmenities);
                    }
                @endphp

                    <!-- Basic Amenities (BA) -->
                <div>
                    <h3 class="text-xl font-medium text-gray-900 mb-4">Identify basic amenities</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-5">
                        @foreach($amenities->get('BA', []) as $amenity)
                            <label
                                class="block cursor-pointer relative group"
                                x-data="{ isChecked: {{ in_array($amenity->amn_id, $selectedAmenities) ? 'true' : 'false' }} }"
                            >
                                <input
                                    type="checkbox"
                                    name="amenities[]"
                                    value="{{ $amenity->amn_id }}"
                                    class="absolute opacity-0 w-0 h-0 peer"
                                    {{ in_array($amenity->amn_id, $selectedAmenities) ? 'checked' : '' }}
                                    @change="isChecked = $event.target.checked"
                                >
                                <div class="flex items-center gap-3 py-2 px-6 rounded-lg whitespace-nowrap text-lg justify-start transition-all duration-200 border border-airbnb-dark text-airbnb-dark peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light hover:bg-airbnb-light hover:border-airbnb-dark group-hover:shadow-sm">
                                    <i
                                        class="h-7 w-7 transition-colors duration-200"
                                        :class="isChecked ? 'text-airbnb-light' : 'text-airbnb-dark'"
                                        data-lucide="{{ $amenity->amn_icon }}"
                                    ></i>
                                    <span class="text-center w-full font-medium">{{ $amenity->amn_name }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Standout Amenities (SA) -->
                <div>
                    <h3 class="text-xl font-medium text-gray-900 mb-4">Identify standout amenities</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-5">
                        @foreach($amenities->get('SA', []) as $amenity)
                            <label
                                class="block cursor-pointer relative group"
                                x-data="{ isChecked: {{ in_array($amenity->amn_id, $selectedAmenities) ? 'true' : 'false' }} }"
                            >
                                <input
                                    type="checkbox"
                                    name="amenities[]"
                                    value="{{ $amenity->amn_id }}"
                                    class="absolute opacity-0 w-0 h-0 peer"
                                    {{ in_array($amenity->amn_id, $selectedAmenities) ? 'checked' : '' }}
                                    @change="isChecked = $event.target.checked"
                                >
                                <div class="flex items-center gap-3 py-2 px-6 rounded-lg whitespace-nowrap text-lg justify-start transition-all duration-200 border border-airbnb-dark text-airbnb-dark peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light hover:bg-airbnb-light hover:border-airbnb-dark group-hover:shadow-sm">
                                    <i
                                        class="h-7 w-7 transition-colors duration-200"
                                        :class="isChecked ? 'text-airbnb-light' : 'text-airbnb-dark'"
                                        data-lucide="{{ $amenity->amn_icon }}"
                                    ></i>
                                    <span class="text-center w-full font-medium">{{ $amenity->amn_name }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Safety Items (SI) -->
                <div>
                    <h3 class="text-xl font-medium text-gray-900 mb-4">Identify safety items</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-5">
                        @foreach($amenities->get('SI', []) as $amenity)
                            <label
                                class="block cursor-pointer relative group"
                                x-data="{ isChecked: {{ in_array($amenity->amn_id, $selectedAmenities) ? 'true' : 'false' }} }"
                            >
                                <input
                                    type="checkbox"
                                    name="amenities[]"
                                    value="{{ $amenity->amn_id }}"
                                    class="absolute opacity-0 w-0 h-0 peer"
                                    {{ in_array($amenity->amn_id, $selectedAmenities) ? 'checked' : '' }}
                                    @change="isChecked = $event.target.checked"
                                >
                                <div class="flex items-center gap-3 py-2 px-6 rounded-lg whitespace-nowrap text-lg justify-start transition-all duration-200 border border-airbnb-dark text-airbnb-dark peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light hover:bg-airbnb-light hover:border-airbnb-dark group-hover:shadow-sm">
                                    <i
                                        class="h-7 w-7 transition-colors duration-200"
                                        :class="isChecked ? 'text-airbnb-light' : 'text-airbnb-dark'"
                                        data-lucide="{{ $amenity->amn_icon }}"
                                    ></i>
                                    <span class="text-center w-full font-medium">{{ $amenity->amn_name }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                <!-- General Error Message -->
                @if($errors->any())
                    <div class="mt-2 text-sm text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="flex gap-3 mt-6 max-w-screen-xl justify-end">
                <button type="submit" name="save_draft" onclick="setFormAction('save_draft')" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:text-airbnb-light hover:border-airbnb-dark focus:outline-none focus:ring-airbnb-dark">
                    Save
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Set which form action was triggered
            function setFormAction(action) {
                document.getElementById('form_action').value = action;
            }

            // Handle form submission with AJAX
            document.getElementById('amenitiesForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const action = formData.get('form_action');

                // Determine the endpoint based on action
                const endpoint = action === 'save_and_exit'
                    ? "{{ route('property.save.all.updates', ['property' => $property->prop_id]) }}"
                    : form.action;

                fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (action === 'save_and_exit') {
                                // Redirect to property page or listings page
                                window.location.href = data.redirect || "{{ route('host.listing') }}";
                            } else {
                                // Show success message for draft save
                                const event = new CustomEvent('show-toast', {
                                    detail: {
                                        message: 'Amenities changes saved to draft',
                                        type: 'success'
                                    }
                                });
                                document.dispatchEvent(event);
                            }
                        } else {
                            // Show error message
                            const event = new CustomEvent('show-toast', {
                                detail: {
                                    message: data.message || 'Error saving changes',
                                    type: 'error'
                                }
                            });
                            document.dispatchEvent(event);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const event = new CustomEvent('show-toast', {
                            detail: {
                                message: 'An error occurred while saving',
                                type: 'error'
                            }
                        });
                        document.dispatchEvent(event);
                    });
            });
        </script>
    @endpush
@endsection
