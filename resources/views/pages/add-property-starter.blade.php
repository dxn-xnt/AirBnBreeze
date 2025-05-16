@extends('layouts.app')

@section('title', 'Property Creation')

@section('content')
    <!-- Save & Cancel Button -->
   <div></div>

    <!-- Main Content -->
    <div class="relative w-full h-full mt-40 mb-10 bg-airbnb-light gap-2">
        <div class="px-[8%]">
            <div>
                <h2 class="text-center text-4xl font-extrabold text-gray-900">
                    Add your property with these easy steps
                </h2>
            </div>

        </div>

        <div class="m-auto w-full max-w-screen-md px-8 text-center">
            <div class="px-6 py-6">
                <div class="py-5">
                    <h2 class="text-2xl font-extrabold text-gray-900">
                        Step 1: Identify your property
                    </h2>
                    <p>Share some basic info, like where it is and how many guests can stay.</p>
                </div>
                <div class="py-5">
                    <h2 class="text-2xl font-extrabold text-gray-900">
                        Step 2: Add highlights
                    </h2>
                    <p>Add 5 or more photos plus a title and description</p>
                </div>
                <div class="py-5">
                    <h2 class="text-2xl font-extrabold text-gray-900">
                        Step 3: Set price
                    </h2>
                    <p>Choose a starting price, then publish your listing.</p>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="relative flex justify-between px-[8%] pt-20">
            <a href="{{ url()->previous() }}" class="min-w-[150px] inline-flex justify-center py-2 px-4 border-[1px] border-airbnb-dark shadow-sm text-lg font-medium rounded-full text-airbnb-dark bg-airbnb-light hover:bg-airbnb-dark hover:text-airbnb-light focus:outline-none focus:ring-airbnb-light">
                Cancel
            </a>
            <a href="{{ route('property.create') }}" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-light hover:text-airbnb-darkest hover:border-airbnb-darkest focus:outline-none focus:ring-airbnb-dark">
                Start
            </a>
        </div>
    </div>
@endsection
