<div
    id="contactModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden flex items-center justify-center"
    x-data="{
        host: {{ json_encode($property['host'] ?? []) }},
        contactDetails: {
            number: '8-700',
            email: 'dionesia@gmail.com',
            preferredContact: 'Email'
        }
    }"
>
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    <!-- Modal panel - Matched height and improved responsiveness -->
    <div class="relative mx-auto bg-[#C7D1B9] rounded-lg shadow-xl transform transition-all w-full max-w-xs sm:max-w-sm md:max-w-sm lg:max-w-sm my-8">
        <!-- Close button -->
        <button
            onclick="document.getElementById('contactModal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 z-10"
        >
            <i class="w-6 h-6" data-lucide="x"></i>
        </button>
        
        <!-- Modal content -->
        <div class="p-6 md:p-8">
            <h2 class="text-2xl md:text-3xl font-semibold text-center text-airbnb-darkest mb-6">Contact Details</h2>
            
            <!-- Contact info with improved responsive layout -->
            <div class="space-y-6 px-2 sm:px-4">
                <!-- Name -->
                <div class="flex flex-col sm:flex-row items-start gap-2 sm:gap-4">
                    <div class="w-full sm:w-1/4 font-semibold text-airbnb-darkest text-lg sm:text-base">Name</div>
                    <div class="flex-1 text-airbnb-darkest text-lg sm:text-base" x-text="host.name"></div>
                </div>
                
                <!-- Number -->
                <div class="flex flex-col sm:flex-row items-start gap-2 sm:gap-4">
                    <div class="w-full sm:w-1/4 font-semibold text-airbnb-darkest text-lg sm:text-base">Number</div>
                    <div class="flex-1 text-airbnb-darkest text-lg sm:text-base" x-text="contactDetails.number"></div>
                </div>
                
                <!-- Email -->
                <div class="flex flex-col sm:flex-row items-start gap-2 sm:gap-4">
                    <div class="w-full sm:w-1/4 font-semibold text-airbnb-darkest text-lg sm:text-base">Email</div>
                    <div class="flex-1 text-airbnb-darkest text-lg sm:text-base" x-text="contactDetails.email"></div>
                </div>
            </div>

            <!-- Contact Button with responsive sizing -->
            <div class="mt-8 text-center">
                <template x-if="contactDetails.preferredContact === 'Email'">
                    <a 
                        x-bind:href="'mailto:' + contactDetails.email"
                        class="inline-block bg-airbnb-darkest text-airbnb-light py-3 px-6 sm:px-8 rounded-full text-base sm:text-sm font-medium hover:bg-opacity-90 transition-colors"
                    >
                        Send Email
                    </a>
                </template>
                <template x-if="contactDetails.preferredContact === 'Phone'">
                    <a 
                        x-bind:href="'tel:' + contactDetails.number.replace(/-/g, '')"
                        class="inline-block bg-airbnb-darkest text-airbnb-light py-3 px-6 sm:px-8 rounded-full text-base sm:text-sm font-medium hover:bg-opacity-90 transition-colors"
                    >
                        Call Now
                    </a>
                </template>
            </div>
        </div>
    </div>
</div>
