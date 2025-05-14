<div
    id="cancellationPolicyModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-black bg-opacity-75"></div>
        </div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-airbnb-light rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
            <!-- Close button -->
            <button
                onclick="document.getElementById('cancellationPolicyModal').classList.add('hidden')"
                class="absolute top-4 right-4 text-gray-600 hover:text-gray-900"
            >
                <i class="w-6 h-6" data-lucide="x"></i>
            </button>
            
            <!-- Modal content -->
            <div class="p-6 md:p-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-center text-airbnb-darkest mb-6">Cancellation Policy</h2>
                
                <div class="text-airbnb-darkest space-y-6">
                    <p class="text-lg">We understand that plans can change. Below is our cancellation policy to ensure fairness for both guests and the host:</p>
                    
                    <!-- Free Cancellation -->
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Free Cancellation</h3>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Guests may cancel for free up to 7 days before check-in.</li>
                            <li>A full refund will be issued, including service fees.</li>
                        </ul>
                    </div>
                    
                    <!-- Partial Refund -->
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Partial Refund</h3>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Cancellations made within 3 to 6 days before check-in will receive a 50% refund of the booking amount.</li>
                            <li>Service fees are non-refundable during this period.</li>
                        </ul>
                    </div>
                    
                    <!-- No refund -->
                    <div>
                        <h3 class="text-xl font-semibold mb-2">No refund</h3>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Cancellations made less than 3 days before check-in are non-refundable.</li>
                            <li>This also applies to no-shows.</li>
                        </ul>
                    </div>
                    
                    <!-- Additional Notes -->
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Additional Notes</h3>
                        <ul class="list-none pl-0 space-y-1">
                            <li class="flex items-start">
                                <span class="mr-2">*</span>
                                <span>Refunds will be processed within 5-7 business days.</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">*</span>
                                <span>Guests can contact the host directly for emergency cancellations or rescheduling.</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">*</span>
                                <span>If the host cancels the reservation, the guest will receive a full refund.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>