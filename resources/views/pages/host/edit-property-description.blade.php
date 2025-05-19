@extends('layouts.app')

@section('content')
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-light gap-2">
        <!-- Highlights Form -->
        <form id="highlightsForm" action="{{ route('property.update.description', ['property' => $property->prop_id]) }}" method="POST">
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
                        <button type="submit" name="save_and_exit" onclick="setFormAction('save_and_exit')" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:text-airbnb-light hover:border-airbnb-dark focus:outline-none focus:ring-airbnb-dark">
                            Save & Exit
                        </button>
                    </div>
                </div>

                <div class="flex justify-start gap-3 pt-5">
                    <a href="{{ route('property.edit.type', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Property Type</a>
                    <a href="{{ route('property.edit.location', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Location</a>
                    <a href="{{ route('property.edit.capacity', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Capacity</a>
                    <a href="{{ route('property.edit.description', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Description</a>
                    <a href="{{ route('property.edit.amenities', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Amenities</a>
                    <a href="{{ route('property.edit.pictures', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Pictures</a>
                    <a href="{{ route('property.edit.price', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Price</a>
                    <a href="{{ route('property.edit.rules', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">House Rules</a>
                </div>
            </div>

            <div class="m-auto w-full max-w-screen-md px-8 py-8">
                @php
                    // Check for draft data first, then fall back to property data
                    $draftData = session()->get('property_draft', []);
                    $title = $draftData['description']['prop_title'] ?? old('prop_title', $property->prop_title ?? '');
                    $description = $draftData['description']['prop_description'] ?? old('prop_description', $property->prop_description ?? '');
                @endphp

                    <!-- Title Section -->
                <div class="mb-6">
                    <label for="property_title" class="block text-xl font-medium text-gray-700 mb-1">Add title to your property</label>
                    <div class="mt-1">
                        <input type="text" id="property_title" name="prop_title"
                               class="w-full px-3 py-2 border border-airbnb-darkest bg-airbnb-light rounded-lg shadow-sm focus:outline-none text-md"
                               placeholder="Beautiful beachfront villa with pool"
                               value="{{ $title }}">
                        @error('prop_title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description Section -->
                <div class="mb-6">
                    <label for="property_description" class="block text-xl font-medium text-gray-700 mb-1">Add brief description</label>
                    <div class="mt-1">
                        <textarea id="property_description" name="prop_description" rows="4"
                                  class="w-full px-3 py-2 border border-airbnb-darkest bg-airbnb-light rounded-lg shadow-sm focus:outline-none text-md"
                                  placeholder="Describe what makes your property special...">{{ $description }}</textarea>
                        @error('prop_description')
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
            // Set which form action was triggered
            function setFormAction(action) {
                document.getElementById('form_action').value = action;
            }

            // Handle form submission with AJAX
            document.getElementById('highlightsForm').addEventListener('submit', function(e) {
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
                                        message: 'Description changes saved to draft',
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
