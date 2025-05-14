<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AirBnBreeze - Booking Management</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'airbnbreeze-green': {
                            DEFAULT: '#4a7c59',
                            'light': '#e5f0ea',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation Bar -->
<nav class="bg-airbnbreeze-green py-3 shadow-md">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center">
            <img src="images/air-logo.png" alt="AirBnBreeze Logo" class="h-8">
        </div>

        <div class="hidden md:flex space-x-10 text-white font-medium">
            <a href="#" class="hover:underline">Calendar</a>
            <a href="#" class="hover:underline">Properties</a>
            <a href="#" class="font-bold border-b-2 border-white pb-1">Bookings</a>
        </div>

        <div class="flex items-center space-x-4">
            <button class="text-white">
                <i class="fa-regular fa-bell text-xl"></i>
            </button>
            <div class="relative group">
                <button class="flex items-center bg-white bg-opacity-20 rounded-full py-1 px-2 text-white">
                    <i class="fa-solid fa-bars mr-2"></i>
                    <div class="h-8 w-8 rounded-full bg-cover bg-center" 
                         style="background-image: url('https://pixabay.com/get/g12097b7eb71b5a8d9775b2537eee6226875d24d43678e87b4797ac6aab4d687b9e8d675dc3c04b481e110f5d50f783036d8c642eefffbb580d9c43c23ee2de0b_1280.jpg')">
                    </div>
                </button>
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block z-10">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>
    <!-- Main Content -->
    <main class="p-6 bg-[#E3EED4]">
        <!-- Booking Requests Header -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Booking Requests</h1>
            <div class="relative">
                <input type="text" placeholder="Search requests..." 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-airbnbreeze-green focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex space-x-2 mb-6 overflow-x-auto">
            <button class="px-4 py-1 rounded-full bg-airbnbreeze-green text-white font-medium">Pending</button>
            <button class="px-4 py-1 rounded-full bg-gray-200 text-gray-700 font-medium hover:bg-gray-300">Accepted</button>
            <button class="px-4 py-1 rounded-full bg-gray-200 text-gray-700 font-medium hover:bg-gray-300">Completed</button>
            <button class="px-4 py-1 rounded-full bg-gray-200 text-gray-700 font-medium hover:bg-gray-300">Cancelled</button>
        </div>

        <!-- Booking Request Cards -->
<div class="space-y-4">
    <!-- Booking Request 1 -->
<div class="bg-transparent border border-black rounded-lg p-5 shadow">
    <div class="flex flex-col md:flex-row justify-between">
        <!-- Left Side: Booking Details -->
        <div class="flex-1">
            <div class="text-xs text-gray-500 mb-1">Booking for</div>
            <h2 class="text-lg font-bold mb-3">Limosnero's Private House</h2> <!-- Removed the border here -->

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <div class="text-xs text-gray-500">Guests</div>
                    <div class="font-medium">2 adult, 1 child</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Schedule</div>
                    <div class="font-medium">April 24 - 30, 2025</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Price</div>
                    <div class="font-medium">₱ 17100.00</div>
                </div>
            </div>

            <div>
                <div class="text-xs text-gray-500 mb-1">Message</div>
                <div class="text-gray-700">Can I request for extra mattress?</div>
            </div>
        </div>

        <!-- Right Side: Booker Info and Actions -->
        <div class="mt-4 md:mt-0 md:ml-4 flex flex-col items-end justify-between">
            <div class="flex items-center mb-2">
                <div class="mr-3 text-right">
                    <div class="font-bold">Donesia Pacquio</div>
                    <div class="text-xs text-gray-500">Booker Name</div>
                </div>
                <img src="{{ asset('images/MD.png') }}" alt="User Image" class="h-10 w-10 rounded-full object-cover" />
            </div>

            <button class="text-airbnbreeze-green text-sm mb-4 hover:underline">
                View Contact Details →
            </button>

            <div class="flex space-x-2">
                <button class="px-4 py-1 border border-gray-300 rounded hover:bg-gray-100 text-gray-700 transition">
                    Decline
                </button>
                <button class="px-4 py-1 bg-airbnbreeze-green text-white rounded hover:bg-opacity-90 transition">
                    Pre-Approve
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Booking Request 2 -->
<div class="bg-transparent border border-black rounded-lg p-5 shadow">
    <div class="flex flex-col md:flex-row justify-between">
        <!-- Left Side: Booking Details -->
        <div class="flex-1">
            <div class="text-xs text-gray-500 mb-1">Booking for</div>
            <h2 class="text-lg font-bold mb-3">Limosnero's Private House</h2> <!-- Removed the border here -->

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <div class="text-xs text-gray-500">Guests</div>
                    <div class="font-medium">2 adult, 1 child</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Schedule</div>
                    <div class="font-medium">April 24 - 30, 2025</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Price</div>
                    <div class="font-medium">₱ 17100.00</div>
                </div>
            </div>

            <div>
                <div class="text-xs text-gray-500 mb-1">Message</div>
                <div class="text-gray-700">Can I request for extra mattress?</div>
            </div>
        </div>

        <!-- Right Side: Booker Info and Actions -->
        <div class="mt-4 md:mt-0 md:ml-4 flex flex-col items-end justify-between">
            <div class="flex items-center mb-2">
                <div class="mr-3 text-right">
                    <div class="font-bold">Donesia Pacquio</div>
                    <div class="text-xs text-gray-500">Booker Name</div>
                </div>
                <img src="{{ asset('images/MD.png') }}" alt="User Image" class="h-10 w-10 rounded-full object-cover" />
            </div>

            <button class="text-airbnbreeze-green text-sm mb-4 hover:underline">
                View Contact Details →
            </button>

            <div class="flex space-x-2">
                <button class="px-4 py-1 border border-gray-300 rounded hover:bg-gray-100 text-gray-700 transition">
                    Decline
                </button>
                <button class="px-4 py-1 bg-airbnbreeze-green text-white rounded hover:bg-opacity-90 transition">
                    Pre-Approve
                </button>
            </div>
        </div>
    </div>
</div>
    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around py-3">
        <a href="#" class="flex flex-col items-center text-gray-500 hover:text-airbnbreeze-green">
            <i class="fas fa-calendar-alt text-lg"></i>
            <span class="text-xs mt-1">Calendar</span>
        </a>
        <a href="#" class="flex flex-col items-center text-gray-500 hover:text-airbnbreeze-green">
            <i class="fas fa-home text-lg"></i>
            <span class="text-xs mt-1">Properties</span>
        </a>
        <a href="#" class="flex flex-col items-center text-airbnbreeze-green">
            <i class="fas fa-book text-lg"></i>
            <span class="text-xs mt-1">Bookings</span>
        </a>
        <a href="#" class="flex flex-col items-center text-gray-500 hover:text-airbnbreeze-green">
            <i class="fas fa-user text-lg"></i>
            <span class="text-xs mt-1">Profile</span>
        </a>
    </nav>

    <script>
        // Simple JavaScript to handle filter tab selection
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.rounded-full');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => {
                        btn.classList.remove('bg-airbnbreeze-green', 'text-white');
                        btn.classList.add('bg-gray-200', 'text-gray-700');
                    });
                    
                    // Add active class to clicked button
                    this.classList.remove('bg-gray-200', 'text-gray-700');
                    this.classList.add('bg-airbnbreeze-green', 'text-white');
                });
            });
        });
    </script>
</body>
</html>
