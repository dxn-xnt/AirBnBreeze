@extends('layouts.app')

@section('content')
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-light gap-2">
        <!-- Amenities Form -->
        <form id="amenitiesForm" action="{{ route('property.storeAmenities') }}" method="POST">
            @csrf
            <div class="px-[8%]">
                <div class="flex justify-between mb-3">
                    <h2 class="text-left text-3xl font-extrabold text-gray-900">
                        Listing Editor
                    </h2>
                    <div class="flex gap-3">
                        <a href="{{ url()->previous() }}" class="min-w-[150px] inline-flex justify-center py-2 px-4 border-[1px] border-airbnb-dark shadow-sm text-lg font-medium rounded-full text-airbnb-dark bg-airbnb-light hover:text-airbnb-darkest hover:border-airbnb-darkest focus:outline-none focus:ring-airbnb-light">
                            Back
                        </a>
                        <button type="submit" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:text-airbnb-light hover:border-airbnb-dark focus:outline-none focus:ring-airbnb-dark">
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
                <!-- Basic Amenities (BA) -->
                <div>
                    <h3 class="text-xl font-medium text-gray-900 mb-4">Identify basic amenities</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-5">
                        @foreach($amenities->get('BA', []) as $amenity)
                            <label class="block cursor-pointer relative group">
                                <input
                                    type="checkbox"
                                    name="amenities[]"
                                    value="{{ $amenity->amn_id }}"
                                    class="absolute opacity-0 w-0 h-0 peer"
                                    {{ in_array($amenity->amn_id, old('amenities', $propertyAmenities->pluck('amn_id')->toArray() ?? [])) ? 'checked' : '' }}
                                >
                                <div class="flex items-center gap-3 py-2 px-6 rounded-lg whitespace-nowrap text-lg justify-start transition-all duration-200 border border-airbnb-dark text-airbnb-dark peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light hover:bg-airbnb-light hover:border-airbnb-dark group-hover:shadow-sm">
                                    <i
                                        class="h-7 w-7 transition-colors duration-200 text-airbnb-dark peer-checked:text-airbnb-light"
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
                            <label class="block cursor-pointer relative group">
                                <input
                                    type="checkbox"
                                    name="amenities[]"
                                    value="{{ $amenity->amn_id }}"
                                    class="absolute opacity-0 w-0 h-0 peer"
                                    {{ in_array($amenity->amn_id, old('amenities', $propertyAmenities->pluck('amn_id')->toArray() ?? [])) ? 'checked' : '' }}
                                >
                                <div class="flex items-center gap-3 py-2 px-6 rounded-lg whitespace-nowrap text-lg justify-start transition-all duration-200 border border-airbnb-dark text-airbnb-dark peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light hover:bg-airbnb-light hover:border-airbnb-dark group-hover:shadow-sm">
                                    <i
                                        class="h-7 w-7 transition-colors duration-200 text-airbnb-dark peer-checked:text-airbnb-light"
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
                            <label class="block cursor-pointer relative group">
                                <input
                                    type="checkbox"
                                    name="amenities[]"
                                    value="{{ $amenity->amn_id }}"
                                    class="absolute opacity-0 w-0 h-0 peer"
                                    {{ in_array($amenity->amn_id, old('amenities', $propertyAmenities->pluck('amn_id')->toArray() ?? [])) ? 'checked' : '' }}
                                >
                                <div class="flex items-center gap-3 py-2 px-6 rounded-lg whitespace-nowrap text-lg justify-start transition-all duration-200 border border-airbnb-dark text-airbnb-dark peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light hover:bg-airbnb-light hover:border-airbnb-dark group-hover:shadow-sm">
                                    <i
                                        class="h-7 w-7 transition-colors duration-200 text-airbnb-dark peer-checked:text-airbnb-light"
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
        </form>
    </div>

    <script>
        // Add custom amenities dynamically
        function addCustomAmenity() {
            const input = document.getElementById('custom_amenity');
            const value = input.value.trim();

            if (!value) return;

            // Create a hidden input for the custom amenity
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'custom_amenities[]';
            hiddenInput.value = value;

            // Create a label for the custom amenity
            const div = document.createElement('div');
            div.className = 'amenity-item block px-4 py-2 border rounded-md text-sm font-medium text-center cursor-pointer bg-green-100 border-green-300 text-green-800 hover:bg-gray-50';
            div.innerHTML = `${value} <button type="button" onclick="removeCustomAmenity(this)" class="ml-2 text-red-600">Remove</button>`;

            // Append elements to the DOM
            document.getElementById('custom_amenities_list').appendChild(div);
            document.getElementById('custom_amenities_list').appendChild(hiddenInput);

            // Clear the input field
            input.value = '';
        }

        // Remove custom amenities
        function removeCustomAmenity(button) {
            const parentDiv = button.parentElement;
            const hiddenInput = parentDiv.nextElementSibling;

            // Remove the label and hidden input
            parentDiv.remove();
            hiddenInput.remove();
        }
    </script>
@endsection
