@extends('layouts.app')

@section('content')
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-lightest gap-2">
        <form id="priceForm" action="{{ route('property.update.price', ['property' => $property->prop_id]) }}" method="POST">
            @csrf
            @method('PUT')
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
                        <button type="submit"
                                onclick="setFormAction('save_and_exit')"
                                class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:text-airbnb-light hover:border-airbnb-dark focus:outline-none focus:ring-airbnb-dark">
                            Save & Exit
                        </button>
                    </div>
                </div>

                <div class="flex justify-start gap-3 pt-5">
                    <a href="{{ route('property.edit.type', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Property Type</a>
                    <a href="{{ route('property.edit.location', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Location</a>
                    <a href="{{ route('property.edit.capacity', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Capacity</a>
                    <a href="{{ route('property.edit.description', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Description</a>
                    <a href="{{ route('property.edit.amenities', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Amenities</a>
                    <a href="{{ route('property.edit.pictures', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Pictures</a>
                    <a href="{{ route('property.edit.price', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Price</a>
                    <a href="{{ route('property.edit.rules', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">House Rules</a>
                </div>
            </div>

            <div class="m-auto w-full max-w-screen-sm px-8">
                <div class="px-6 py-8">
                    <p class="text-xl text-airbnb-darkest mb-2 ml-24">Set price for the property</p>

                    <div class="flex-col bg-airbnb-lightest justify-items-center">
                        <div class="py-1 px-1 flex align-bottom items-end">
                            <span class="text-airbnb-darkest text-[2rem] align-bottom pb-5">₱</span>
                            <input type="text"
                                   name="prop_price_per_night"
                                   id="price"
                                   value="{{ number_format((int)old('prop_price_per_night', session('property_draft.price.prop_price_per_night', $property->prop_price_per_night ?? 0)), 0, '', '') }}"
                                   class="text-[5rem] max-w-[300px] h-21 align-bottom font-semibold text-center bg-airbnb-light appearance-none focus:outline-none"
                                   min="1"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, ''); formatPriceInput(this);">
                        </div>
                        <span class="text-airbnb-dark text-md">rate per night</span>
                    </div>

                    @error('prop_price_per_night')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="flex gap-3 mt-6 max-w-screen-xl justify-end">
                <button type="submit"
                        onclick="setFormAction('save_draft')"
                        class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:text-airbnb-light hover:border-airbnb-dark focus:outline-none focus:ring-airbnb-dark">
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

            function formatPriceInput(input) {
                // Remove non-numeric characters
                let value = input.value.replace(/[^0-9]/g, '');

                // Format with commas
                if (value.length > 0) {
                    value = parseInt(value).toLocaleString('en-US', {
                        maximumFractionDigits: 0
                    });
                }

                // Update input value (cursor position preserved)
                const start = input.selectionStart;
                const end = input.selectionEnd;
                input.value = value;
                input.setSelectionRange(start, end);
            }

            document.getElementById('priceForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const action = formData.get('form_action');

                // Remove commas from price before submitting
                const priceInput = document.getElementById('price');
                priceInput.value = priceInput.value.replace(/,/g, '');

                // Determine endpoint based on action
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
                                window.location.href = data.redirect || "{{ route('host.listing') }}";
                            } else {
                                // Show success message
                                const event = new CustomEvent('show-toast', {
                                    detail: {
                                        message: 'Price saved to draft',
                                        type: 'success'
                                    }
                                });
                                document.dispatchEvent(event);
                            }
                        } else {
                            // Show error message
                            const event = new CustomEvent('show-toast', {
                                detail: {
                                    message: data.message || 'Error saving price',
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

            // Format price on page load
            document.addEventListener('DOMContentLoaded', function() {
                const priceInput = document.getElementById('price');
                formatPriceInput(priceInput);
            });
        </script>
    @endpush
@endsection
