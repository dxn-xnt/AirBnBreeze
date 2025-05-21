@extends('layouts.app')

@section('content')
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-light gap-2">
        <!-- Form -->
        <form id="capacityForm" action="{{ route('property.update.capacity', ['property' => $property->prop_id]) }}" method="POST">
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
                    <a href="{{ route('property.edit.capacity', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Capacity</a>
                    <a href="{{ route('property.edit.description', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Description</a>
                    <a href="{{ route('property.edit.amenities', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Amenities</a>
                    <a href="{{ route('property.edit.pictures', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Pictures</a>
                    <a href="{{ route('property.edit.price', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Price</a>
                    <a href="{{ route('property.edit.rules', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">House Rules</a>
                </div>
            </div>

            <div class="m-auto w-full max-w-screen-sm px-8">
                <!-- Capacity Configuration -->
                <div class="px-6 py-8 border-b border-gray-200">
                    <h3 class="text-xl font-medium text-gray-900 mb-4">Configure property capacity</h3>

                    @php
                        // Check for draft data first, then fall back to property data
                        $draftData = session()->get('property_draft', []);
                        $roomCount = $draftData['capacity']['prop_room_count'] ?? old('prop_room_count', $property->prop_room_count ?? 1);
                        $maxGuest = $draftData['capacity']['prop_max_guest'] ?? old('prop_max_guest', $property->prop_max_guest ?? 1);
                        $bathroomCount = $draftData['capacity']['prop_bathroom_count'] ?? old('prop_bathroom_count', $property->prop_bathroom_count ?? 1);
                    @endphp

                        <!-- Rooms Counter -->
                    <div class="flex items-center justify-between py-3">
                        <div>
                            <h4 class="text-md font-medium text-gray-700">Rooms</h4>
                        </div>
                        <div class="flex items-center">
                            <button type="button" onclick="updateValue('prop_room_count', -1)" class="counter-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <input type="number" name="prop_room_count" id="prop_room_count"
                                   value="{{ $roomCount }}"
                                   class="mx-4 text-xl font-semibold w-16 text-center bg-airbnb-light appearance-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none focus:outline-none"
                                   min="1" step="1">
                            <button type="button" onclick="updateValue('prop_room_count', 1)" class="counter-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        @error('prop_room_count')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Guests Counter -->
                    <div class="flex items-center justify-between py-3 border-t border-gray-200">
                        <div>
                            <h4 class="text-md font-medium text-gray-700">Guests</h4>
                        </div>
                        <div class="flex items-center">
                            <button type="button" onclick="updateValue('prop_max_guest', -1)" class="counter-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <input type="number" name="prop_max_guest" id="prop_max_guest"
                                   value="{{ $maxGuest }}"
                                   class="mx-4 text-xl font-semibold w-16 text-center bg-airbnb-light appearance-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none focus:outline-none"
                                   min="1" step="1">
                            <button type="button" onclick="updateValue('prop_max_guest', 1)" class="counter-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        @error('prop_max_guest')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bathrooms Counter -->
                    <div class="flex items-center justify-between py-3 border-t border-gray-200">
                        <div>
                            <h4 class="text-md font-medium text-gray-700">Bathrooms</h4>
                        </div>
                        <div class="flex items-center">
                            <button type="button" onclick="updateValue('prop_bathroom_count', -1)" class="counter-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <input type="number" name="prop_bathroom_count" id="prop_bathroom_count"
                                   value="{{ $bathroomCount }}"
                                   class="mx-4 text-xl font-semibold w-16 text-center bg-airbnb-light appearance-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none focus:outline-none"
                                   min="1" step="1">
                            <button type="button" onclick="updateValue('prop_bathroom_count', 1)" class="counter-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        @error('prop_bathroom_count')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
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
            // Increment or decrement input value
            function updateValue(id, change) {
                const input = document.getElementById(id);
                let value = parseInt(input.value) || 1; // Default to 1 if empty
                value += change;

                if (value < 1) {
                    value = 1; // Ensure minimum value is 1
                }

                input.value = value;
            }

            // Set which form action was triggered
            function setFormAction(action) {
                document.getElementById('form_action').value = action;
            }

            // Handle form submission with AJAX
            document.getElementById('capacityForm').addEventListener('submit', function(e) {
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
                                        message: 'Capacity changes saved to draft',
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
