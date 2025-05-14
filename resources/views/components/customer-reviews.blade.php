    <div
    id="reviewsModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden flex items-center justify-center"
    x-data="{
        currentReview: 0,
        nextReview() {
            this.currentReview = (this.currentReview + 1) % this.reviews.length;
        },
        prevReview() {
            this.currentReview = (this.currentReview - 1 + this.reviews.length) % this.reviews.length;
        }
    }"
>
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    <!-- Modal panel - Expanded width for better side spacing -->
    <div class="relative mx-auto bg-[#C7D1B9] rounded-lg shadow-xl transform transition-all w-full max-w-md sm:max-w-sm md:max-w-2xl lg:max-w-2xl xl:max-w-3xl my-8">
        <!-- Close button -->
        <button
            onclick="document.getElementById('reviewsModal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 z-10"
        >
            <i class="w-6 h-6" data-lucide="x"></i>
        </button>

        <!-- Modal content -->
        <div class="p-6 md:p-8">
            <h2 class="text-2xl md:text-3xl font-semibold text-center text-airbnb-darkest mb-4">Customer Reviews</h2>

            <!-- Property info -->
            <div class="text-center mb-6">
                <h3 class="text-xl font-semibold text-airbnb-darkest"> <span class="font-normal text-sm">({{ $property['location'] }})</span></h3>
            </div>

            <!-- Review carousel with expanded side spacing -->
            <div class="flex items-center">
                <!-- Previous button with larger click area -->
                <button
                    @click="prevReview()"
                    class="flex-shrink-0 bg-none bg-opacity-50 rounded-full p-2 mr-4 hover:bg-opacity-70 transition-colors"
                >
                    <i class="w-8 h-8 text-airbnb-darkest" data-lucide="circle-arrow-left"></i>
                </button>

                <!-- Review content with responsive adjustments -->
                <div class="flex-grow flex flex-col md:flex-row items-center md:items-start gap-6 py-4 px-2 sm:px-4">
                    <!-- Profile image with responsive sizing -->
                    <div class="flex-shrink-0 w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 lg:w-40 lg:h-40 rounded-full overflow-hidden border-2 border-airbnb-darkest">
                        <img
                            x-bind:src="asset(reviews[currentReview].image)"
                            class="w-full h-full object-cover"
                            alt="Property view"
                        >
                    </div>

                    <!-- Review details with improved spacing -->
                    <div class="flex-grow text-center md:text-left">
                        <!-- Rating with better alignment -->
                        <div class="flex flex-col items-left md:items-start mb-3">
                            <div class="flex items-center gap-1.5">
                                <div class="flex">
                                    <template x-for="i in 5">
                                        <i class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-400"
                                           x-bind:class="{ 'fill-yellow-400': i <= reviews[currentReview].rating }"
                                           data-lucide="star"></i>
                                    </template>
                                </div>
                                <span class="ml-2 text-lg sm:text-xl font-semibold leading-none"
                                      x-text="reviews[currentReview].rating.toFixed(1)"></span>
                            </div>
                        </div>

                        <!-- Review text with responsive sizing -->
                        <p class="text-airbnb-darkest text-base sm:text-lg mb-4 leading-relaxed" x-text="reviews[currentReview].text"></p>

                        <!-- Reviewer name and date with better spacing -->
                        <div class="mt-4 space-y-1">
                            <p class="font-semibold text-airbnb-darkest text-lg sm:text-xl" x-text="reviews[currentReview].reviewer"></p>
                            <p class="text-airbnb-dark text-sm sm:text-base" x-text="reviews[currentReview].date"></p>
                        </div>
                    </div>
                </div>

                <!-- Next button with larger click area -->
                <button
                    @click="nextReview()"
                    class="flex-shrink-0 bg-none bg-opacity-50 rounded-full p-2 ml-4 hover:bg-opacity-70 transition-colors"
                >
                    <i class="w-8 h-8 text-airbnb-darkest" data-lucide="circle-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
