<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AirBnBreeze - Calendar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'primary': '#2c5b2d',
            'primary-light': '#dbe7ce',
            'background': '#f2f7ea',
            'card': '#ffffff',
            'highlight': '#d5e0cc'
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-primary-light min-h-screen">
  <!-- Header -->
  <header class="bg-primary text-white py-3 px-6 flex justify-between items-center">
    <div class="flex items-center space-x-2">
      <img src="/images/air-logo.png" alt="Logo" class="h-7" />
      <span class="text-xl font-semibold">AirBnBreeze</span>
    </div>
    <nav class="flex space-x-6">
      <a href="#" class="font-semibold border-b-2 border-white pb-1">Calendar</a>
      <a href="#" class="font-normal">Properties</a>
      <a href="#" class="font-normal">Bookings</a>
    </nav>
    <div class="flex items-center space-x-3">
      <button>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
      </button>
      <div class="bg-[#3b6e3c] rounded-full w-9 h-9 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
      </div>
    </div>
  </header>

  <!-- Main -->
  <main class="p-6 bg-[#E3EED4]">
    <h1 class="text-2xl font-semibold text-primary mb-4">Calendar</h1>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Calendar -->
      <div class="lg:col-span-2 bg-white rounded-xl p-4 shadow border">
        <div class="flex justify-between items-center mb-4 text-sm font-semibold">
          <span>June 2024</span>
          <div class="flex space-x-2">
            <button class="text-primary hover:text-black">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </button>
            <button class="text-primary hover:text-black">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
        </div>
        <div class="grid grid-cols-7 text-xs text-center font-medium text-gray-600 mb-2">
          <div>SUN</div><div>MON</div><div>TUE</div><div>WED</div><div>THU</div><div>FRI</div><div>SAT</div>
        </div>
        <div class="grid grid-cols-7 gap-1 text-sm">
          <!-- Hardcoded for June 2024 -->
          @php
            $daysInMonth = 30;
            $firstDayIndex = 6; // June 1, 2024 is Saturday (index 6 if Sunday is 0)
          @endphp

          @for ($i = 0; $i < $firstDayIndex; $i++)
            <div></div>
          @endfor

          @for ($day = 1; $day <= $daysInMonth; $day++)
            <div class="h-8 flex justify-center items-center {{ $day == 26 ? 'bg-highlight rounded-full text-primary font-semibold' : '' }}">
              {{ $day }}
            </div>
          @endfor
        </div>
      </div>

      <!-- Schedules -->
      <div class="bg-transparent border border-black rounded-xl p-4 shadow">
      <h2 class="flex items-center justify-center text-primary text-lg font-semibold mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
          Schedules
        </h2>

        @php
          $schedules = [
            ["name" => "Limosnero's Private House", "person" => "Donesia Pacquio", "time" => "4:00 PM - 6:00AM", "img" => "public\images\MD.png"],
            ["name" => "Basak Pardo Guest House", "person" => "Ballerina Cappucina", "time" => "5:00 PM - 7:00AM", "img" => "public\images\MD.png"],
            ["name" => "Camella Homes", "person" => "Camille Villar", "time" => "2:00 PM - 7:00AM", "img" => "public\images\MD.png"]
          ];
        @endphp

    <div class="space-y-3">
    @foreach ($schedules as $item)
    <div class="flex items-start space-x-3 p-2 rounded-lg hover:bg-highlight">
      <img 
        src="{{ asset('images/MD.png') }}" 
        class="w-10 h-10 rounded-full object-cover" 
        alt="{{ $item['person'] }}" 
      />
      <div>
        <p class="text-sm font-semibold text-primary">{{ $item['name'] }}</p>
        <p class="text-xs text-gray-700">{{ $item['person'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Date: June 26, 2024</p>
        <p class="text-xs text-gray-500">Time: {{ $item['time'] }}</p>
      </div>
    </div>
    @endforeach
    </div>
        <div class="text-center mt-4">
          <a href="#" class="text-primary text-sm font-medium hover:underline">View More</a>
        </div>
      </div>
    </div>
  </main>
</body>
</html>