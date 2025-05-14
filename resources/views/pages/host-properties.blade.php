<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AirBnBreeze - Properties</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#2c5b2d',
                        'primary-light': '#f0f4e8',
                        'selected-day': '#e8f0e9',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4e8;
        }
    </style>
</head>
<body>
<header class="bg-primary text-white py-3">
    <div class="container mx-auto flex justify-between items-center px-4">
        <div class="flex items-center">
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/air-logo.png') }}" alt="Logo" class="h-7 w-auto mr-2" />
                <span class="text-xl font-semibold">AirBnBreeze</span>
            </a>
        </div>
            <nav class="flex space-x-7">
                <a href="index.html" class="font-medium text-white/90">Calendar</a>
                <a href="properties.html" class="font-semibold underline">Properties</a>
                <a href="#" class="font-medium text-white/90">Bookings</a>
            </nav>
            <div class="flex items-center">
                <button class="mr-4 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
                <div class="relative">
                    <button class="bg-[#3b6e3c] rounded-full p-1 w-8 h-8 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="min-h-screen bg-[#E3EED4]">
  <div class="container mx-auto p-4">
    <!-- Title and Search Side-by-Side -->
    <div class="flex items-center space-x-6 mb-6">
      <h1 class="text-2xl font-semibold text-primary">Properties</h1>

      <div class="relative w-full max-w-2xl">
        <div class="relative flex items-center bg-transparent border border-gray-300 rounded-md">
          <div class="absolute left-3 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          <input 
            type="text" 
            placeholder="Search properties by title or location" 
            class="w-full py-2 pl-10 pr-4 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none"
          >
        </div>
      </div>
                <button class="ml-4 bg-white p-2 rounded-md shadow-sm hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            </div>

    <!-- Properties Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 max-w-5xl mx-auto">
  
  <!-- Property Card -->
  <div class="w-full max-w-sm">
    <!-- Image Container -->
    <div class="bg-white rounded-lg overflow-hidden shadow-sm aspect-square">
      <img src="{{ asset('images/house1.png') }}" alt="Limosnero's Private House" class="w-full h-full object-cover">
    </div>

    <!-- Text aligned with image width -->
    <div class="mt-2">
      <h3 class="font-semibold text-gray-800 text-base">Limosnero's Private House</h3>
      <p class="text-sm text-gray-600 mb-1">Minglanilla, Cebu</p>
      <a href="#" class="text-primary text-xs font-medium hover:underline">view contact details</a>
    </div>
  </div>

  <!-- Another Property Card -->
  <div class="w-full max-w-sm">
    <div class="bg-white rounded-lg overflow-hidden shadow-sm aspect-square">
      <img src="{{ asset('images/house1.png') }}" alt="Camella Homes" class="w-full h-full object-cover">
    </div>
    <div class="mt-2">
      <h3 class="font-semibold text-gray-800 text-base">Camella Homes</h3>
      <p class="text-sm text-gray-600 mb-1">Talisay, Cebu</p>
      <a href="#" class="text-primary text-xs font-medium hover:underline">view contact details</a>
    </div>
  </div>
</div>
    </main>

    <script>
        // You can add Alpine.js functionality here if needed
    </script>
</body>
</html>
