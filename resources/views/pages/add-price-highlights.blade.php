@extends('layouts.app')

@section('content')
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-lightest gap-2">
        <form id="priceForm" action="{{ route('property.storePriceAndSave') }}" method="POST">
            @csrf

            <div class="px-[8%]">
                <div>
                    <h2 class="text-left text-3xl font-extrabold text-gray-900">
                        Step 3: Set your price
                    </h2>
                </div>

                <div class="flex justify-start gap-2 pt-5">
                    <div class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Price</div>
                </div>
            </div>

            <div class="m-auto w-full max-w-screen-sm px-8">
                <div class="px-6 py-6">
                    <p class="text-xl text-airbnb-darkest mb-2 ml-24">Set price for the property</p>

                    <div class="flex-col bg-airbnb-lightest justify-items-center">
                        <div class="py-1 px-1 flex align-bottom items-end">
                            <span class="text-airbnb-darkest text-[2rem] align-bottom pb-5">₱</span>
                            <input type="number" name="prop_price_per_night" id="price"
                                   value="{{ old('prop_price_per_night', session('property_data.prop_price_per_night', 0)) }}"
                                   class="text-[5rem] max-w-[300px] h-21 align-bottom font-semibold text-center bg-airbnb-light appearance-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none focus:outline-none"
                                   min="1"
                                   step="1">
                        </div>
                        <span class="text-airbnb-dark text-md">rate per night</span>
                    </div>

                    <!-- Validation Error for Price -->
                    @error('prop_price_per_night')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

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

                </div>
            </div>
            <!-- Navigation Buttons -->
            <div class="relative flex justify-between px-[8%] pt-[170px]">
                <a href="{{ route('property.step6') }}" class="min-w-[150px] inline-flex justify-center py-2 px-4 border-[1px] border-airbnb-dark shadow-sm text-lg font-medium rounded-full text-airbnb-dark bg-airbnb-light hover:bg-airbnb-dark hover:text-airbnb-light focus:outline-none focus:ring-airbnb-light">
                    Back
                </a>
                <button type="submit" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-light hover:text-airbnb-darkest hover:border-airbnb-darkest focus:outline-none focus:ring-airbnb-dark">
                    Finish
                </button>
            </div>
        </form>
    </div>

@endsection
