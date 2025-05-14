<div
    id="cancellationModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    x-data="{
        booking: {
            propertyName: 'Limosnero\'s Private House',
            guests: '2 adult, 1 child',
            schedule: 'April 24 - 30, 2025',
            cost: '₱ 17100.00',
            reason: ''
        }
    }"
>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-black bg-opacity-75"></div>
        </div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-[#E3EED4] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
            <!-- Close button -->
            <button type="button"
                onclick="document.getElementById('cancellationModal').classList.add('hidden')"
                class="absolute top-4 right-4 text-gray-600 hover:text-gray-900"
            >
                <i class="w-6 h-6" data-lucide="x"></i>
            </button>
            
            <!-- Modal content -->
            <div class="p-6 md:p-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-center text-airbnb-darkest mb-6">Cancellation Notice</h2>
                
                <!-- Booking info -->
                <div class="space-y-6">
                    <!-- Booked -->
                    <div class="flex items-start">
                        <div class="w-1/3 sm:w-1/4 font-semibold text-airbnb-darkest">Booked</div>
                        <div class="flex-1 text-airbnb-darkest" x-text="booking.propertyName"></div>
                    </div>
                    
                    <!-- Guests -->
                    <div class="flex items-start">
                        <div class="w-1/3 sm:w-1/4 font-semibold text-airbnb-darkest">Guests</div>
                        <div class="flex-1 text-airbnb-darkest" x-text="booking.guests"></div>
                    </div>
                    
                    <!-- Schedule -->
                    <div class="flex items-start">
                        <div class="w-1/3 sm:w-1/4 font-semibold text-airbnb-darkest">Schedule</div>
                        <div class="flex-1 text-airbnb-darkest" x-text="booking.schedule"></div>
                    </div>
                    
                    <!-- Costs -->
                    <div class="flex items-start">
                        <div class="w-1/3 sm:w-1/4 font-semibold text-airbnb-darkest">Costs</div>
                        <div class="flex-1 text-airbnb-darkest" x-text="booking.cost"></div>
                    </div>
                    
                    <!-- Reason -->
                    <div class="flex flex-col">
                        <label for="reason" class="font-semibold text-airbnb-darkest mb-2">Reason</label>
                        <textarea 
                            id="reason"
                            x-model="booking.reason"
                            class="w-full p-3 border border-airbnb-darkest rounded-lg focus:ring-2 focus:ring-airbnb-dark focus:border-transparent bg-airbnb-light"
                            rows="4"
                            placeholder="Please enter your reason for cancellation..."
                        ></textarea>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="mt-8 text-center">
                    <button type="button"
                        onclick="document.getElementById('cancellationModal').classList.add('hidden'); alert('Cancellation submitted successfully!');"
                        class="inline-block bg-[#375534] text-[#E3EED4] py-3 px-8 rounded-full text-sm font-medium hover:bg-opacity-90 transition-colors"
                    >
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
