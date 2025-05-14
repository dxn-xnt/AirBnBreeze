{{-- resources/views/properties/step1-address.blade.php --}}
@extends('layouts.app')

@section('content')
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header -->
            <header class="bg-indigo-700 text-white p-6">
                <h1 class="text-2xl font-bold">Booking Management</h1>
                <p class="text-indigo-100">View and manage all booking requests</p>
            </header>

            <!-- Tabs -->
            <div class="flex border-b">
                <button class="tab px-6 py-4 text-gray-600 hover:bg-gray-100 transition font-medium" data-tab="pending">
                    Pending
                </button>
                <button class="tab px-6 py-4 text-white bg-indigo-600 transition font-semibold" data-tab="completed">
                    Completed
                </button>
                <button class="tab px-6 py-4 text-gray-600 hover:bg-gray-100 transition font-medium" data-tab="notifications">
                    Notifications
                    <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">3</span>
                </button>
            </div>

            <!-- Search and Filter Bar -->
            <div class="p-4 border-b bg-gray-50">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" id="searchInput" placeholder="Search by house name or booker..." 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="flex gap-2">
                        <button id="searchBtn" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search
                        </button>
                        <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Completed Bookings Tab -->
            <div id="completed" class="tab-content active">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Completed Bookings
                    </h2>

                    <!-- Booking Cards -->
                    <div class="grid gap-6">
                        <!-- Booking Card 1 -->
                        <div class="booking-card bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
                            <div class="md:flex">
                                <!-- Left Side - Booker Info -->
                                <div class="md:w-1/3 p-6 border-r border-gray-200 bg-gray-50">
                                    <div class="mb-4">
                                        <h3 class="text-lg font-semibold text-gray-800">Booker Information</h3>
                                        <p class="text-gray-600 mt-1">Donegalia Pascualo</p>
                                    </div>
                                    <button class="view-contact-btn px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition flex items-center w-full justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        View Contact Details
                                    </button>
                                </div>

                                <!-- Right Side - Booking Details -->
                                <div class="md:w-2/3 p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-xl font-bold text-gray-900">Limesenro's Private House</h3>
                                        <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">Completed</span>
                                    </div>

                                    <div class="grid md:grid-cols-3 gap-6">
                                        <!-- Guests -->
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Guests</h4>
                                            <p class="mt-1 text-gray-800">2 Adults, 1 Child</p>
                                        </div>

                                        <!-- Schedule -->
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Schedule</h4>
                                            <p class="mt-1 text-gray-800">April 24 - 30, 2025</p>
                                            <p class="text-sm text-gray-500">6 nights</p>
                                        </div>

                                        <!-- Costs -->
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Costs</h4>
                                            <p class="mt-1 text-gray-800">$1,250.00</p>
                                            <p class="text-sm text-gray-500">Paid via Credit Card</p>
                                        </div>
                                    </div>

                                    <div class="mt-6 pt-4 border-t border-gray-200">
                                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Additional Notes</h4>
                                        <p class="text-gray-600">Guest requested early check-in at 1 PM if possible.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Card 2 -->
                        <div class="booking-card bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
                            <div class="md:flex">
                                <!-- Left Side - Booker Info -->
                                <div class="md:w-1/3 p-6 border-r border-gray-200 bg-gray-50">
                                    <div class="mb-4">
                                        <h3 class="text-lg font-semibold text-gray-800">Booker Information</h3>
                                        <p class="text-gray-600 mt-1">John Smith</p>
                                    </div>
                                    <button class="view-contact-btn px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition flex items-center w-full justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        View Contact Details
                                    </button>
                                </div>

                                <!-- Right Side - Booking Details -->
                                <div class="md:w-2/3 p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-xl font-bold text-gray-900">Mountain View Cabin</h3>
                                        <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">Completed</span>
                                    </div>

                                    <div class="grid md:grid-cols-3 gap-6">
                                        <!-- Guests -->
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Guests</h4>
                                            <p class="mt-1 text-gray-800">4 Adults</p>
                                        </div>

                                        <!-- Schedule -->
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Schedule</h4>
                                            <p class="mt-1 text-gray-800">May 5 - 10, 2025</p>
                                            <p class="text-sm text-gray-500">5 nights</p>
                                        </div>

                                        <!-- Costs -->
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Costs</h4>
                                            <p class="mt-1 text-gray-800">$1,800.00</p>
                                            <p class="text-sm text-gray-500">Paid via PayPal</p>
                                        </div>
                                    </div>

                                    <div class="mt-6 pt-4 border-t border-gray-200">
                                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Additional Notes</h4>
                                        <p class="text-gray-600">Bringing two small dogs (approved).</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Bookings Tab (hidden) -->
            <div id="pending" class="tab-content p-6 hidden">
                <h2 class="text-xl font-semibold mb-6">Pending Bookings</h2>
                <!-- Pending bookings content would go here -->
            </div>

            <!-- Notifications Tab (hidden) -->
            <div id="notifications" class="tab-content p-6 hidden">
                <h2 class="text-xl font-semibold mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    Notifications
                </h2>
                
                <!-- Notification Items -->
                <div class="space-y-4">
                    <div class="p-4 border border-blue-200 rounded-lg bg-blue-50">
                        <div class="flex justify-between">
                            <h3 class="font-medium text-blue-800">New Booking Request</h3>
                            <span class="text-sm text-blue-600">2 hours ago</span>
                        </div>
                        <p class="mt-1 text-blue-700">John Doe has requested to book "Beachfront Villa" for June 15-20, 2025.</p>
                    </div>
                    
                    <div class="p-4 border border-yellow-200 rounded-lg bg-yellow-50">
                        <div class="flex justify-between">
                            <h3 class="font-medium text-yellow-800">Payment Pending</h3>
                            <span class="text-sm text-yellow-600">1 day ago</span>
                        </div>
                        <p class="mt-1 text-yellow-700">Booking #24567 is awaiting payment confirmation.</p>
                    </div>
                    
                    <div class="p-4 border border-green-200 rounded-lg bg-green-50">
                        <div class="flex justify-between">
                            <h3 class="font-medium text-green-800">Booking Completed</h3>
                            <span class="text-sm text-green-600">3 days ago</span>
                        </div>
                        <p class="mt-1 text-green-700">The booking for "Lakeside Cottage" has been successfully completed.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Details Modal -->
    <div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Contact Details</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Full Name</h4>
                    <p class="mt-1 text-gray-800" id="modal-name">Donegalia Pascualo</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Email</h4>
                    <p class="mt-1 text-gray-800" id="modal-email">donegalia@example.com</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Phone</h4>
                    <p class="mt-1 text-gray-800" id="modal-phone">+1 (555) 123-4567</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Address</h4>
                    <p class="mt-1 text-gray-800" id="modal-address">123 Main St, Anytown, USA</p>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end">
                <button id="closeModalBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab').forEach(t => {
                    t.classList.remove('bg-indigo-600', 'text-white', 'font-semibold');
                    t.classList.add('text-gray-600', 'hover:bg-gray-100');
                });
                document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
                
                // Add active class to clicked tab
                tab.classList.add('bg-indigo-600', 'text-white', 'font-semibold');
                tab.classList.remove('text-gray-600', 'hover:bg-gray-100');
                
                // Show corresponding content
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });

        // Search functionality
        document.getElementById('searchBtn').addEventListener('click', searchBookings);
        document.getElementById('searchInput').addEventListener('keyup', (e) => {
            if (e.key === 'Enter') searchBookings();
        });

        function searchBookings() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('.booking-card').forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? 'block' : 'none';
            });
        }

        // Contact details modal functionality
        document.querySelectorAll('.view-contact-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // In a real app, you would fetch this data from the server or have it in data attributes
                const card = this.closest('.booking-card');
                const bookerName = card.querySelector('p.text-gray-600').textContent;
                
                // Set modal content (in a real app, this would come from your database)
                document.getElementById('modal-name').textContent = bookerName;
                document.getElementById('modal-email').textContent = bookerName.toLowerCase().replace(' ', '.') + '@example.com';
                document.getElementById('modal-phone').textContent = '+1 (555) ' + Math.floor(100 + Math.random() * 900) + '-' + Math.floor(1000 + Math.random() * 9000);
                document.getElementById('modal-address').textContent = '123 ' + bookerName.split(' ')[0] + ' St, Anytown, USA';
                
                // Show modal
                document.getElementById('contactModal').classList.remove('hidden');
            });
        });

        // Close modal
        document.getElementById('closeModal').addEventListener('click', closeModal);
        document.getElementById('closeModalBtn').addEventListener('click', closeModal);

        function closeModal() {
            document.getElementById('contactModal').classList.add('hidden');
        }
    </script>
@endsection