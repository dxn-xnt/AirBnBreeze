@extends('layouts.app')

@section('title', 'Property Creation')

@section('content')
    <!-- Main Content -->
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-lightest gap-2">
        <form id="propertyForm" action="{{ route('property.store.type') }}" method="POST">
            @csrf
            <div class="px-[8%]">
                <div>
                    <h2 class="text-left text-3xl font-extrabold text-gray-900">
                        Step 1: Identify your property
                    </h2>
                </div>


                <!-- General Error Message -->
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex justify-start gap-2 pt-5">
                    <div class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Property Type</div>
                    <div class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Location</div>
                    <div class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Capacity</div>
                </div>
            </div>

            <div class="m-auto w-full max-w-screen-lg px-8">
                <div class="bg-transparent py-8 px-4 sm:px-10 max-w-[1750px] mx-auto">
                    <!-- Property Type Selection -->

                        <div>
                            <label class="block text-xl font-medium text-airbnb-darkest mb-2">Property type</label>
                            <div class="grid grid-cols-3 gap-3" id="propertyTypeGrid">
                                @foreach($types as $type)
                                    <x-option-item
                                        :type="$type"
                                        data-value="{{ $type->type_name }}"
                                    />
                                @endforeach
                            </div>
                            @error('prop_type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <!-- Custom JS Error Message -->
                            <p id="selectionError" class="hidden mt-2 text-sm text-red-600">Please select a property type.</p>
                        </div>
                        <!-- Hidden Input -->
                        <input type="hidden" name="prop_type" id="selectedPropType" value="">
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="relative flex justify-between px-[8%] pt-[9%] pb-10">
                <a href="{{ route('home') }}" class="min-w-[150px] inline-flex justify-center py-2 px-4 border-[1px] border-airbnb-dark shadow-sm text-lg font-medium rounded-full text-airbnb-dark bg-airbnb-light hover:bg-airbnb-dark hover:text-airbnb-light focus:outline-none focus:ring-airbnb-light">
                    Back
                </a>
                <button type="submit" form="propertyForm" id="nextButton" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-light hover:text-airbnb-darkest hover:border-airbnb-darkest focus:outline-none focus:ring-airbnb-dark">
                    Next
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const options = document.querySelectorAll('[data-value]');
                const nextButton = document.getElementById('nextButton');
                const selectionError = document.getElementById('selectionError');
                const hiddenInput = document.getElementById('selectedPropType');

                let activeOption = null;

                // Handle option click
                options.forEach(option => {
                    option.addEventListener('click', () => {
                        const value = option.getAttribute('data-value');

                        // Deselect previously selected
                        if (activeOption && activeOption !== option) {
                            activeOption.classList.remove('selected-option');
                        }

                        // Toggle selection
                        if (activeOption === option) {
                            option.classList.remove('selected-option');
                            hiddenInput.value = ''; // Clear the hidden input
                            activeOption = null;
                        } else {
                            option.classList.add('selected-option');
                            hiddenInput.value = value; // Update the hidden input
                            activeOption = option;
                            selectionError.classList.add('hidden'); // Hide error message
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
