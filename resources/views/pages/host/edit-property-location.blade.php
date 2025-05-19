@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-light gap-2">
        <!-- Form -->
        <form id="addressForm" action="{{ route('property.update.location', ['property' => $property->prop_id]) }}" method="POST">
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
                        <a href="{{ url()->previous() }}" class="min-w-[150px] inline-flex justify-center py-2 px-4 border-[1px] border-airbnb-dark shadow-sm text-lg font-medium rounded-full text-airbnb-dark bg-airbnb-light hover:text-airbnb-darkest hover:border-airbnb-darkest focus:outline-none focus:ring-airbnb-light">
                            Back
                        </a>
                        <button type="submit" name="save_and_exit" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:text-airbnb-light hover:border-airbnb-dark focus:outline-none focus:ring-airbnb-dark"
                                onclick="setFormAction('save_and_exit')">
                            Save & Exit
                        </button>
                    </div>
                </div>

                <div class="flex justify-start gap-3 pt-5">
                    <a href="{{ route('property.edit.type', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Property Type</a>
                    <a href="{{ route('property.edit.location', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Location</a>
                    <a href="{{ route('property.edit.capacity', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Capacity</a>
                    <a href="{{ route('property.edit.description', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Description</a>
                    <a href="{{ route('property.edit.amenities', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Amenities</a>
                    <a href="{{ route('property.edit.pictures', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Pictures</a>
                    <a href="{{ route('property.edit.price', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Price</a>
                    <a href="{{ route('property.edit.rules', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">House Rules</a>
                </div>
            </div>

            <div class="m-auto w-full max-w-screen-md px-8">
                <!-- Address Section -->
                <div class="bg-transparent py-8 px-4 sm:px-10 max-w-[1750px] mx-auto">
                    <h2 class="block text-xl font-medium text-airbnb-darkest mb-2">Add the address of the property</h2>

                    @php
                        // Check for draft data first, then fall back to property data
                        $draftLocation = session()->get('property_draft.location', []);
                        $addressParts = !empty($draftLocation)
                            ? [$draftLocation['street_address'], $draftLocation['city'], $draftLocation['province']]
                            : ($property->prop_address ? explode(', ', $property->prop_address) : []);
                        $street = old('street_address', $addressParts[0] ?? '');
                        $city = old('city', $addressParts[1] ?? '');
                        $province = old('province', $addressParts[2] ?? '');
                    @endphp

                        <!-- Street Address -->
                    <div class="mt-4">
                        <label for="street_address" class="block text-md font-medium text-gray-700">Street Address</label>
                        <input type="text" name="street_address" id="street_address" autocomplete="street-address"
                               class="mb-2 block w-full border border-airbnb-darkest bg-airbnb-light rounded-lg shadow-sm py-2 px-3 text-md focus:outline-none"
                               value="{{ $street }}">
                        @error('street_address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City/Municipality -->
                    <div class="my-4">
                        <label for="city" class="block text-md font-medium text-gray-700">City/Municipality</label>
                        <input type="text" name="city" id="city" autocomplete="address-level2"
                               class="mb-2 block w-full border border-airbnb-darkest bg-airbnb-light rounded-lg shadow-sm py-2 px-3 text-md focus:outline-none"
                               value="{{ $city }}">
                        @error('city')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Province -->
                    <div class="my-2">
                        <label for="province" class="block text-md font-medium text-gray-700">Province</label>
                        <input type="text" name="province" id="province" autocomplete="address-level1"
                               class="mb-2 block w-full border border-airbnb-darkest bg-airbnb-light rounded-lg shadow-sm py-2 px-3 text-md focus:outline-none"
                               value="{{ $province }}">
                        @error('province')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-6 max-w-screen-xl justify-end">
                <button type="submit" name="save_draft" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:text-airbnb-light hover:border-airbnb-dark focus:outline-none focus:ring-airbnb-dark"
                        onclick="setFormAction('save_draft')">
                    Save
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function setFormAction(action) {
                document.getElementById('form_action').value = action;
            }

            document.getElementById('addressForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const action = formData.get('form_action');

                // Determine the endpoint based on which button was clicked
                const endpoint = action === 'save_and_exit'
                    ? "{{ route('property.save.all.updates', ['property' => $property->prop_id]) }}"
                    : "{{ route('property.update.location', ['property' => $property->prop_id]) }}";

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
                                window.location.href = "{{ route('host.listing') }}";
                            } else {
                                // Show success message for draft save
                                const event = new CustomEvent('show-toast', {
                                    detail: {
                                        message: 'Location changes saved to draft',
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

@extends('layouts.app')
