{{-- resources/views/properties/step1-address.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto max-w-7xl p-4">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <header class="bg-gray-800 text-white p-6 text-center">
                <h1 class="text-2xl font-bold">Booking Requests</h1>
            </header>

            <!-- Tabs -->
            <div class="flex bg-gray-700">
                <button class="tab px-6 py-4 text-white hover:bg-gray-600 transition" data-tab="pending">
                    Pending
                </button>
                <button class="tab px-6 py-4 text-white hover:bg-gray-600 transition" data-tab="completed">
                    Completed
                </button>
                <button class="tab px-6 py-4 text-white hover:bg-gray-600 transition font-semibold bg-red-500" data-tab="cancelled">
                    Cancelled
                </button>
                <button class="tab px-6 py-4 text-white hover:bg-gray-600 transition" data-tab="notifications">
                    Notifications
                </button>
            </div>

            <!-- Search Bar -->
            <div class="p-4 border-b">
                <div class="flex gap-2">
                    <input type="text" id="searchInput" placeholder="Search bookings..." 
                           class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <button id="searchBtn" class="px-6 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition">
                        Search
                    </button>
                </div>
            </div>

            <!-- Cancelled Bookings Tab -->
            <div id="cancelled" class="tab-content p-6 active">
                <h2 class="text-xl font-semibold mb-4">Cancelled Bookings</h2>
                
                <!-- Booking Card 1 -->
                <div class="booking-card grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 p-4 border rounded-lg shadow-sm hover:shadow-md transition bg-red-50">
                    <!-- Left Column - Booker Info -->
                    <div class="border-r pr-4">
                        <div class="mb-4">
                            <h3 class="font-bold text-gray-700">Booked By:</h3>
                            <p class="text-gray-900 font-medium">Domain Pacquio</p>
                        </div>
                        <button class="view-contact-btn px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
                            View Contact Details
                        </button>
                        <!-- Contact Details (hidden by default) -->
                        <div class="contact-details mt-3 hidden bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm"><span class="font-medium">Email:</span> domain.p@example.com</p>
                            <p class="text-sm"><span class="font-medium">Phone:</span> +1 (555) 123-4567</p>
                        </div>
                    </div>

                    <!-- Middle Column - Booking Details -->
                    <div class="border-r pr-4">
                        <div class="mb-3">
                            <h3 class="font-bold text-gray-700">Property:</h3>
                            <p class="text-gray-900 font-medium">Limosnero's Private House</p>
                        </div>
                        <div class="mb-3">
                            <h3 class="font-bold text-gray-700">Guests:</h3>
                            <p class="text-gray-900">2 adults, 1 child</p>
                        </div>
                        <div class="mb-3">
                            <h3 class="font-bold text-gray-700">Schedule:</h3>
                            <div class="flex items-center text-gray-900">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>April 24 - 30, 2025 (6 nights)</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-700">Cancellation Reason:</h3>
                            <p class="text-gray-900 italic">"Personal matters with the host"</p>
                        </div>
                    </div>

                    <!-- Right Column - Payment Info -->
                    <div>
                        <div class="mb-3">
                            <h3 class="font-bold text-gray-700">Total Cost:</h3>
                            <p class="text-2xl font-bold text-gray-600 line-through">P7,000.00</p>
                        </div>
                        <div class="mb-3">
                            <h3 class="font-bold text-gray-700">Refund Status:</h3>
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Processing</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-700">Booking Status:</h3>
                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Cancelled</span>
                        </div>
                    </div>
                </div>

                <!-- Booking Card 2 -->
                <div class="booking-card grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 p-4 border rounded-lg shadow-sm hover:shadow-md transition bg-red-50">
                    <!-- Left Column - Booker Info -->
                    <div class="border-r pr-4">
                        <div class="mb-4">
                            <h3 class="font-bold text-gray-700">Booked By:</h3>
                            <p class="text-gray-900 font-medium">Maria Gonzales</p>
                        </div>
                        <button class="view-contact-btn px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
                            View Contact Details
                        </button>
                        <!-- Contact Details (hidden by default) -->
                        <div class="contact-details mt-3 hidden bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm"><span class="font-medium">Email:</span> maria.g@example.com</p>
                            <p class="text-sm"><span class="font-medium">Phone:</span> +1 (555) 987-6543</p>
                        </div>
                    </div>

                    <!-- Middle Column - Booking Details -->
                    <div class="border-r pr-4">
                        <div class="mb-3">
                            <h3 class="font-bold text-gray-700">Property:</h3>
                            <p class="text-gray-900 font-medium">Beachfront Villa</p>
                        </div>
                        <div class="mb-3">
                            <h3 class="font-bold text-gray-700">Guests:</h3>
                            <p class="text-gray-900">4 adults, 2 children</p>
                        </div>
                        <div class="mb-3">
                            <h3 class="font-bold text-gray-700">Schedule:</h3>
                            <div class="flex items-center text-gray-900">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>May 15 - 22, 2025 (7 nights)</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-700">Cancellation Reason:</h3>
                            <p class="text-gray-900 italic">"Change of travel plans"</p>
                        </div>
                    </div>

                    <!-- Right Column - Payment Info -->
                    <div>
                        <div class="mb-3">
                            <h3 class="font-bold text-gray-700">Total Cost:</h3>
                            <p class="text-2xl font-bold text-gray-600 line-through">$2,450.00</p>
                        </div>
                        <div class="mb-3">
                            <h3 class="font-bold text-gray-700">Refund Status:</h3>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Completed</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-700">Booking Status:</h3>
                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Cancelled</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Tabs (hidden by default) -->
            <div id="pending" class="tab-content p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Pending Bookings</h2>
                <!-- Pending bookings would go here -->
            </div>

            <div id="completed" class="tab-content p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Completed Bookings</h2>
                <!-- Completed bookings would go here -->
            </div>

            <div id="notifications" class="tab-content p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Notifications</h2>
                <!-- Notifications would go here -->
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab').forEach(t => {
                    t.classList.remove('bg-teal-500', 'bg-red-500', 'font-semibold');
                    t.classList.add('hover:bg-gray-600');
                });
                document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
                
                // Add active class to clicked tab
                if (tab.getAttribute('data-tab') === 'cancelled') {
                    tab.classList.add('bg-red-500');
                } else {
                    tab.classList.add('bg-teal-500');
                }
                tab.classList.add('font-semibold');
                
                // Show corresponding content
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });

        // Search functionality
        document.getElementById('searchBtn').addEventListener('click', () => {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('.booking-card').forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        });

        // Allow search on Enter key
        document.getElementById('searchInput').addEventListener('keyup', (e) => {
            if (e.key === 'Enter') {
                document.getElementById('searchBtn').click();
            }
        });

        // Toggle contact details
        document.querySelectorAll('.view-contact-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const details = this.nextElementSibling;
                details.classList.toggle('hidden');
                this.textContent = details.classList.contains('hidden') ? 'View Contact Details' : 'Hide Contact Details';
            });
        });
    </script>
@endsection