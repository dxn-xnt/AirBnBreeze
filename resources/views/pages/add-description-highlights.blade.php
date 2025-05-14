@extends('layouts.app')

@section('content')
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-light gap-2">
        <!-- Highlights Form -->
        <form id="highlightsForm" action="{{ route('property.storeDescription') }}" method="POST">
            @csrf
            <div class="px-[8%]">
                <div>
                    <h2 class="text-left text-3xl font-extrabold text-gray-900">
                        Step 2: Add highlights
                    </h2>
                </div>

                <div class="flex justify-start gap-2 pt-5">
                    <div class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Description</div>
                    <div class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Amenities</div>
                    <div class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Pictures</div>
                </div>
            </div>

            <div class="m-auto w-full max-w-screen-md px-8 py-4">

                <!-- Title Section -->
                <div class="mb-6">
                    <label for="property_title" class="block text-xl font-medium text-gray-700 mb-1">Add title to your property</label>
                    <div class="mt-1">
                        <input type="text" id="property_title" name="prop_title"
                               class="w-full px-3 py-2 border border-airbnb-darkest bg-airbnb-light rounded-lg shadow-sm focus:outline-none text-md"
                               placeholder="Beautiful beachfront villa with pool"
                               value="{{ old('prop_title') }}">
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
                                      placeholder="Describe what makes your property special...">{{ old('prop_description') }}</textarea>
                        @error('prop_description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- Navigation Buttons -->
            <div class="relative flex justify-between pt-[7%] px-[8%]">
                <a href="{{ route('property.step3') }}" class="min-w-[150px] inline-flex justify-center py-2 px-4 border-[1px] border-airbnb-dark shadow-sm text-lg font-medium rounded-full text-airbnb-dark bg-airbnb-light hover:bg-airbnb-dark hover:text-airbnb-light focus:outline-none focus:ring-airbnb-light">
                    Back
                </a>
                <button type="submit" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-light hover:text-airbnb-darkest hover:border-airbnb-darkest focus:outline-none focus:ring-airbnb-dark">
                    Next
                </button>
            </div>
        </form>
    </div>
@endsection
