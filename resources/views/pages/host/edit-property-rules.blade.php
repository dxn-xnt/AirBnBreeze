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
                    <a href="{{ route('property.edit.amenities', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Amenities</a>
                    <a href="{{ route('property.edit.pictures', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Pictures</a>
                    <a href="{{ route('property.edit.price', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Price</a>
                    <a href="{{ route('property.edit.rules', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">House Rules</a>
                </div>
            </div>

            <div class="m-auto w-full max-w-screen-md p-8">
                <div class="mb-8">
                    <h3 class="text-xl font-medium text-gray-900 mb-4">House Rules</h3>
                    <div class="flex-col gap-5 px-2">
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">No smoking</p>
                            <div class="flex gap-6">
                                <!-- No Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="no-smoking" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>

                                <!-- Yes Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="no-smoking" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">No pets allowed</p>
                            <div class="flex gap-6">
                                <!-- No Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="no-pets" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>

                                <!-- Yes Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="no-pets" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">No parties or events</p>
                            <div class="flex gap-6">
                                <!-- No Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="no-event" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>

                                <!-- Yes Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="no-event" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center w-full py-2 gap-6">
                            <p class="whitespace-nowrap text-airbnb-darkest">Check-in time</p>
                            <select id="time-select" class="time-dropdown w-full p-2 border border-airbnb-darkest rounded-lg focus:ring-2 transition-all duration-200 appearance-none bg-airbnb-light bg-no-repeat bg-[right_1rem_center] pr-10">
                                <option value="0">12:00 AM</option>
                                <option value="1">1:00 AM</option>
                                <option value="2">2:00 AM</option>
                                <option value="3">3:00 AM</option>
                                <option value="4">4:00 AM</option>
                                <option value="5">5:00 AM</option>
                                <option value="6">6:00 AM</option>
                                <option value="7">7:00 AM</option>
                                <option value="8">8:00 AM</option>
                                <option value="9">9:00 AM</option>
                                <option value="10">10:00 AM</option>
                                <option value="11">11:00 AM</option>
                                <option value="12">12:00 PM</option>
                                <option value="13" selected>1:00 PM</option>
                                <option value="14">2:00 PM</option>
                                <option value="15">3:00 PM</option>
                                <option value="16">4:00 PM</option>
                            </select>
                        </div>
                        <div class="flex items-center w-full gap-3 py-2">
                            <p class="whitespace-nowrap text-airbnb-darkest">Check-out time</p>
                            <select id="time-select" class="time-dropdown w-full p-2 border border-airbnb-darkest rounded-lg transition-all duration-200 appearance-none bg-airbnb-light bg-no-repeat bg-[right_1rem_center] pr-10">
                                <option value="0">12:00 AM</option>
                                <option value="1">1:00 AM</option>
                                <option value="2">2:00 AM</option>
                                <option value="3">3:00 AM</option>
                                <option value="4">4:00 AM</option>
                                <option value="5">5:00 AM</option>
                                <option value="6">6:00 AM</option>
                                <option value="7">7:00 AM</option>
                                <option value="8">8:00 AM</option>
                                <option value="9">9:00 AM</option>
                                <option value="10">10:00 AM</option>
                                <option value="11">11:00 AM</option>
                                <option value="12" selected>12:00 PM</option>
                                <option value="13">1:00 PM</option>
                                <option value="14">2:00 PM</option>
                                <option value="15">3:00 PM</option>
                                <option value="16">4:00 PM</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-xl font-medium text-gray-900 mb-4">Guest Safety</h3>
                    <div class="flex-col gap-5 px-2">
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">Security camera/recording device</p>
                            <div class="flex gap-6">
                                <!-- No Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="security" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>

                                <!-- Yes Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="security" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">Carbon monoxide alarm</p>
                            <div class="flex gap-6">
                                <!-- No Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="alarm" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>

                                <!-- Yes Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="alarm" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">Must climb stairs</p>
                            <div class="flex gap-6">
                                <!-- No Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="stair" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>

                                <!-- Yes Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="star" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-xl font-medium text-gray-900 mb-4">Cancellation Policy</h3>
                    <div class="flex-col gap-5 px-2">
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">Cancellation Fee</p>
                            <div class="flex gap-6">
                                <!-- No Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="cancellation" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>

                                <!-- Yes Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="cancellation" class="hidden peer">
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
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
        document.addEventListener('alpine:init', () => {
            Alpine.data('radioGroup', () => ({
                selected: null
            }));
        });
    </script>
    <style>
        /* Custom scrollbar for the dropdown */
        .time-dropdown {
            scrollbar-width: thin;
            scrollbar-color: #375534 #E3EED4; /* Airbnb pink thumb on light gray track */
        }

        /* For Webkit browsers (Chrome, Safari) */
        .time-dropdown::-webkit-scrollbar {
            width: 8px;
        }

        .time-dropdown::-webkit-scrollbar-track {
            background: #E3EED4; /* Light gray track */
            border-radius: 4px;
        }

        .time-dropdown::-webkit-scrollbar-thumb {
            background-color: #375534; /* Airbnb pink */
            border-radius: 4px;
            border: 2px solid #E3EED4;
        }

        /* Limit dropdown height and enable scrolling */
        .time-dropdown option {
            padding: 8px 12px;
        }
    </style>
@endsection
