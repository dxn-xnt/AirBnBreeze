@extends('layouts.app')

@section('content')
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-light gap-2">
        <form id="rulesForm" action="{{ route('property.create.rules', ['property' => $property->prop_id]) }}" method="POST">
            @csrf
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
                    <a href="{{ route('property.edit.price', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Price</a>
                    <a href="{{ route('property.edit.rules', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">House Rules</a>
                </div>
            </div>

            <div class="m-auto w-full max-w-screen-md p-8">
                @php
                    // Get draft data or fall back to existing property rules
                    $draftRules = session()->get('property_draft.rules', []);
                    $propertyRules = $property->rules ?? new \App\Models\PropertyRules();

                    // Helper function to get the right value
                    function getRuleValue($key, $draftRules, $propertyRules, $default = 0) {
                        // Map form field names to database column names
                        $fieldMap = [
                            'no_smoking' => 'rule_no_smoking',
                            'no_pets' => 'rule_no_pet',
                            'no_parties' => 'rule_no_events',
                            'check_in_time' => 'rule_check_in',
                            'check_out_time' => 'rule_check_out',
                            'has_security_camera' => 'rule_security_cam',
                            'has_carbon_monoxide_alarm' => 'rule_alarm',
                            'must_climb_stairs' => 'rule_stairs',
                            'has_cancellation_fee' => 'rule_cancellation',
                            'cancellation_rate' => 'rule_cancellation_rate'
                        ];

                        $dbKey = $fieldMap[$key] ?? $key;

                        // Special handling for time fields
                        if (in_array($key, ['check_in_time', 'check_out_time'])) {
                            $timeValue = $draftRules[$key] ?? $propertyRules->{$dbKey} ?? $default;
                            return is_string($timeValue) ? (int)substr($timeValue, 0, 2) : $timeValue;
                        }

                        return old($key, $draftRules[$key] ?? $propertyRules->{$dbKey} ?? $default);
                    }
                @endphp

                <div class="mb-8">
                    <h3 class="text-xl font-medium text-gray-900 mb-4">House Rules</h3>
                    <div class="flex-col gap-5 px-2">
                        <!-- No Smoking -->
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">No smoking</p>
                            <div class="flex gap-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="no_smoking" value="0" class="hidden peer"
                                        {{ getRuleValue('no_smoking', $draftRules, $propertyRules) == 0 ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="no_smoking" value="1" class="hidden peer"
                                        {{ getRuleValue('no_smoking', $draftRules, $propertyRules) == 1 ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- No Pets -->
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">No pets allowed</p>
                            <div class="flex gap-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="no_pets" value="0" class="hidden peer"
                                        {{ getRuleValue('no_pets', $draftRules, $propertyRules) == 0 ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="no_pets" value="1" class="hidden peer"
                                        {{ getRuleValue('no_pets', $draftRules, $propertyRules) == 1 ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- No Parties -->
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">No parties or events</p>
                            <div class="flex gap-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="no_parties" value="0" class="hidden peer"
                                        {{ getRuleValue('no_parties', $draftRules, $propertyRules) == 0 ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="no_parties" value="1" class="hidden peer"
                                        {{ getRuleValue('no_parties', $draftRules, $propertyRules) == 1 ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Check-in Time -->
                        <div class="flex items-center w-full py-2 gap-6">
                            <p class="whitespace-nowrap text-airbnb-darkest">Check-in time</p>
                            <select name="check_in_time" class="time-dropdown w-full p-2 border border-airbnb-darkest rounded-lg focus:ring-2 transition-all duration-200 appearance-none bg-airbnb-light bg-no-repeat bg-[right_1rem_center] pr-10">
                                @foreach(range(0, 23) as $hour)
                                    @php
                                        $timeValue = $hour;
                                        $timeDisplay = ($hour % 12 == 0 ? 12 : $hour % 12) . ':00 ' . ($hour < 12 ? 'AM' : 'PM');
                                        $selectedTime = getRuleValue('check_in_time', $draftRules, $propertyRules, 13);
                                    @endphp
                                    <option value="{{ $timeValue }}" {{ $timeValue == $selectedTime ? 'selected' : '' }}>
                                        {{ $timeDisplay }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Check-out Time -->
                        <div class="flex items-center w-full gap-3 py-2">
                            <p class="whitespace-nowrap text-airbnb-darkest">Check-out time</p>
                            <select name="check_out_time" class="time-dropdown w-full p-2 border border-airbnb-darkest rounded-lg transition-all duration-200 appearance-none bg-airbnb-light bg-no-repeat bg-[right_1rem_center] pr-10">
                                @foreach(range(0, 23) as $hour)
                                    @php
                                        $timeValue = $hour;
                                        $timeDisplay = ($hour % 12 == 0 ? 12 : $hour % 12) . ':00 ' . ($hour < 12 ? 'AM' : 'PM');
                                        $selectedTime = getRuleValue('check_out_time', $draftRules, $propertyRules, 12);
                                    @endphp
                                    <option value="{{ $timeValue }}" {{ $timeValue == $selectedTime ? 'selected' : '' }}>
                                        {{ $timeDisplay }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-xl font-medium text-gray-900 mb-4">Guest Safety</h3>
                    <div class="flex-col gap-5 px-2">
                        <!-- Security Camera -->
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">Security camera/recording device</p>
                            <div class="flex gap-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="has_security_camera" value="0" class="hidden peer"
                                        {{ getRuleValue('has_security_camera', $draftRules, $propertyRules) == 0 ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="has_security_camera" value="1" class="hidden peer"
                                        {{ getRuleValue('has_security_camera', $draftRules, $propertyRules) == 1 ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Carbon Monoxide Alarm -->
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">Carbon monoxide alarm</p>
                            <div class="flex gap-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="has_carbon_monoxide_alarm" value="0" class="hidden peer"
                                        {{ getRuleValue('has_carbon_monoxide_alarm', $draftRules, $propertyRules) == 0 ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="has_carbon_monoxide_alarm" value="1" class="hidden peer"
                                        {{ getRuleValue('has_carbon_monoxide_alarm', $draftRules, $propertyRules) == 1 ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Must Climb Stairs -->
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">Must climb stairs</p>
                            <div class="flex gap-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="must_climb_stairs" value="0" class="hidden peer"
                                        {{ getRuleValue('must_climb_stairs', $draftRules, $propertyRules) == 0 ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="must_climb_stairs" value="1" class="hidden peer"
                                        {{ getRuleValue('must_climb_stairs', $draftRules, $propertyRules) == 1 ? 'checked' : '' }}>
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
                    @php
                        $cancellationFee = getRuleValue('has_cancellation_fee', $draftRules, $propertyRules, 'no');
                        $cancellationRate = getRuleValue('cancellation_rate', $draftRules, $propertyRules, 10);
                    @endphp

                    <div x-data="{ cancellationFee: '{{ $cancellationFee }}' }" class="flex-col gap-5 px-2">
                        <!-- Cancellation Fee -->
                        <div class="flex items-center justify-between w-full border border-airbnb-light rounded-lg py-2">
                            <p class="text-airbnb-darkest">Cancellation Fee</p>
                            <div class="flex gap-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="has_cancellation_fee" value="no" class="hidden peer"
                                           x-model="cancellationFee"
                                        {{ $cancellationFee == 'no' ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="has_cancellation_fee" value="yes" class="hidden peer"
                                           x-model="cancellationFee"
                                        {{ $cancellationFee == 'yes' ? 'checked' : '' }}>
                                    <div class="p-2 border border-airbnb-dark rounded-full peer-checked:bg-airbnb-dark peer-checked:text-airbnb-light">
                                        <i data-lucide="check" class="h-5 w-5"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Cancellation Rate (Conditional) -->
                        <div x-show="cancellationFee === 'yes'" x-transition class="relative flex items-center w-full gap-3 py-2">
                            <p class="whitespace-nowrap text-airbnb-darkest">Cancellation Rate</p>
                            <select name="cancellation_rate" class="time-dropdown w-full p-2 border border-airbnb-darkest rounded-lg transition-all duration-200 appearance-none bg-airbnb-light bg-no-repeat bg-[right_1rem_center] pr-10">
                                <option value="10" {{ $cancellationRate == 10 ? 'selected' : '' }}>10%</option>
                                <option value="15" {{ $cancellationRate == 15 ? 'selected' : '' }}>15%</option>
                                <option value="20" {{ $cancellationRate == 20 ? 'selected' : '' }}>20%</option>
                                <option value="25" {{ $cancellationRate == 25 ? 'selected' : '' }}>25%</option>
                            </select>
                        </div>
                    </div>
                </div>

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
            <div class="flex gap-3 mt-6 max-w-screen-xl justify-end">
                <button type="submit"
                        onclick="setFormAction('save_draft')"
                        class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:text-airbnb-light hover:border-airbnb-dark focus:outline-none focus:ring-airbnb-dark">
                    Save
                </button>
            </div>
        </form>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @push('scripts')
        <script>
            function setFormAction(action) {
                document.getElementById('form_action').value = action;
            }

            document.getElementById('rulesForm')?.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;

                // Collect rule data from form fields
                let checkInTime = document.querySelector('[name="check_in_time"]')?.value || '';
                let checkOutTime = document.querySelector('[name="check_out_time"]')?.value || '';

                // Format numeric time to HH:MM:SS
                function formatTimeToHHMMSS(time) {
                    if (!time || isNaN(time)) return '12:00:00'; // fallback
                    return `${String(time).padStart(2, '0')}:00:00`;
                }

                const ruleData = {
                    check_in_time: formatTimeToHHMMSS(checkInTime),
                    check_out_time: formatTimeToHHMMSS(checkOutTime),
                    no_smoking: document.querySelector('[name="no_smoking"]')?.checked || false,
                    no_pets: document.querySelector('[name="no_pets"]')?.checked || false,
                    no_parties: document.querySelector('[name="no_parties"]')?.checked || false,
                    has_security_camera: document.querySelector('[name="has_security_camera"]')?.checked || false,
                    has_carbon_monoxide_alarm: document.querySelector('[name="has_carbon_monoxide_alarm"]')?.checked || false,
                    must_climb_stairs: document.querySelector('[name="must_climb_stairs"]')?.checked || false,
                    has_cancellation_fee: document.querySelector('[name="has_cancellation_fee"]')?.value || 'no',
                    cancellation_rate: document.querySelector('[name="cancellation_rate"]')?.value || ''
                };

                const action = document.getElementById('form_action')?.value;

                const url = "{{ route('property.save.all.updates', ['property' => $property->prop_id]) }}";

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        _action: action,
                        ...ruleData
                    })
                })
                    .then(response => {
                        // Only parse as JSON if content-type is JSON
                        const contentType = response.headers.get("content-type");

                        if (!contentType || !contentType.includes("application/json")) {
                            return response.text().then(text => {
                                console.error("❌ Non-JSON response received:", text);
                                alert("Server error. Check console for details.");
                                throw new Error("Server returned non-JSON response.");
                            });
                        }

                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect || "{{ route('host.listing') }}";
                        } else {
                            alert('Failed to save: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error("🚨 Fetch error:", error);
                        alert("An unexpected error occurred. Check console for details.");
                    });
            });
        </script>
    @endpush

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
