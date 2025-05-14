@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<x-layout.bookings-header />

<div class="bg-[#E3EED4] min-h-screen pt-[4rem] md:pt-[7.5rem] pb-[1.5rem] sm:pb-[2rem]">
    <div class="max-w-[1750px] mx-auto px-[1rem] sm:px-[1.5rem] md:px-[2rem] lg:px-[4rem] xl:px-[8rem]">
        <!-- Showing all notifications text and Mark all as read button -->
        <div class="flex justify-between items-center mb-[1rem] sm:mb-[1.25rem]">
            <div class="text-[0.75rem] sm:text-[0.875rem] text-airbnb-darkest font-montserrat">
                Showing all notifications
            </div>
            <div class="flex gap-[0.5rem]">
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="border border-airbnb-darkest text-airbnb-darkest bg-white py-[0.375rem] px-[0.75rem] rounded-full text-[0.75rem] sm:text-[0.875rem] hover:bg-airbnb-dark hover:text-airbnb-light hover:border-airbnb-dark transition-colors duration-200 font-montserrat">                        
                        Mark all as read
                    </button>
                </form>
            </div>
        </div>
       
        <!-- Notification List -->
        <div class="space-y-[0.75rem]">
            <!-- First notification - Limosnero's Private House (white background) -->
            <div class="flex items-center bg-white border border-gray-200 p-[1rem] rounded-xl shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer font-montserrat">
                <img src="{{ asset('assets/images/MD.png') }}" alt="User" class="w-[3rem] h-[3rem] rounded-full mr-[1rem]">
                <div class="flex-1">
                    <div class="font-semibold text-[0.875rem] sm:text-[1rem] text-airbnb-darkest">Limosnero's Private House</div>
                    <div class="text-[0.75rem] sm:text-[0.875rem] text-airbnb-darkest">Donesla Pacquio</div>
                    <div class="text-[0.625rem] sm:text-[0.75rem] text-airbnb-dark mt-[0.25rem]">New booking request</div>
                </div>
                <div class="text-[0.625rem] sm:text-[0.75rem] text-airbnb-dark">9:41 AM</div>
                <form action="{{ route('notifications.delete', 1) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="ml-[1rem] text-airbnb-dark hover:text-airbnb-darkest">
                        <i class="w-[1.25rem] h-[1.25rem]" data-lucide="x"></i>
                    </button>
                </form>
            </div>
            
            <!-- Second notification - Cancelled Booking (white background) -->
            <div class="flex items-center bg-white border border-gray-200 p-[1rem] rounded-xl shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer font-montserrat">
                <img src="{{ asset('assets/images/MD.png') }}" alt="User" class="w-[3rem] h-[3rem] rounded-full mr-[1rem]">
                <div class="flex-1">
                    <div class="font-semibold text-[0.875rem] sm:text-[1rem] text-airbnb-darkest">Cancelled Booking for Limosnero's Private House</div>
                    <div class="text-[0.75rem] sm:text-[0.875rem] text-airbnb-darkest">Donesla Pacquio</div>
                    <div class="text-[0.625rem] sm:text-[0.75rem] text-airbnb-dark mt-[0.25rem]">Booking was cancelled</div>
                </div>
                <div class="text-[0.625rem] sm:text-[0.75rem] text-airbnb-dark">Yesterday</div>
                <form action="{{ route('notifications.delete', 2) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="ml-[1rem] text-airbnb-dark hover:text-airbnb-darkest">
                        <i class="w-[1.25rem] h-[1.25rem]" data-lucide="x"></i>
                    </button>
                </form>
            </div>
            
            <!-- Third notification - Completed Booking (green background) -->
            <div class="flex items-center bg-white border border-gray-200 p-[1rem] rounded-xl shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer font-montserrat">
                <img src="{{ asset('assets/images/MD.png') }}" alt="User" class="w-[3rem] h-[3rem] rounded-full mr-[1rem]">
                <div class="flex-1">
                    <div class="font-semibold text-[0.875rem] sm:text-[1rem] text-airbnb-darkest">Completed Booking for Limosnero's Private House</div>
                    <div class="text-[0.75rem] sm:text-[0.875rem] text-airbnb-darkest">Donesla Pacquio</div>
                    <div class="text-[0.625rem] sm:text-[0.75rem] text-airbnb-dark mt-[0.25rem]">Booking completed successfully</div>
                </div>
                <div class="text-[0.625rem] sm:text-[0.75rem] text-airbnb-dark">2 days ago</div>
                <form action="{{ route('notifications.delete', 3) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="ml-[1rem] text-airbnb-dark hover:text-airbnb-darkest">
                        <i class="w-[1.25rem] h-[1.25rem]" data-lucide="x"></i>
                    </button>
                </form>
            </div>

            <!-- Older Notifications Section -->
            <div class="pt-[1rem] mt-[1rem]">
                <h3 class="text-[0.75rem] sm:text-[0.875rem] font-semibold text-airbnb-darkest mb-[0.75rem]">Older Notifications</h3>
                
                <!-- First older notification -->
                <div class="flex items-center bg-[#E3EED4] bg-opacity-50 p-[1rem] rounded-xl mb-[0.75rem] hover:shadow-md transition-all duration-200 cursor-pointer font-montserrat">
                    <img src="{{ asset('assets/images/MD.png') }}" alt="User" class="w-[3rem] h-[3rem] rounded-full mr-[0.75rem]">
                    <div class="flex-1">
                        <div class="font-semibold text-[0.875rem] sm:text-[1rem] text-airbnb-darkest">New Review for Limosnero's Private House</div>
                        <div class="text-[0.75rem] sm:text-[0.875rem] text-airbnb-darkest">Donesla Pacquio</div>
                    </div>
                    <div class="text-[0.625rem] sm:text-[0.75rem] text-airbnb-dark">1 week ago</div>
                    <form action="{{ route('notifications.delete', 4) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ml-[1rem] text-airbnb-dark hover:text-airbnb-darkest">
                            <i class="w-[1.25rem] h-[1.25rem]" data-lucide="x"></i>
                        </button>
                    </form>
                </div>
                
                <!-- Second older notification -->
                <div class="flex items-center bg-[#E3EED4] bg-opacity-50 p-[1rem] rounded-xl mb-[0.75rem] hover:shadow-md transition-all duration-200 cursor-pointer font-montserrat">
                    <img src="{{ asset('assets/images/MD.png') }}" alt="User" class="w-[3rem] h-[3rem] rounded-full mr-[0.75rem]">
                    <div class="flex-1">
                        <div class="font-semibold text-[0.875rem] sm:text-[1rem] text-airbnb-darkest">New Review for Limosnero's Private House</div>
                        <div class="text-[0.75rem] sm:text-[0.875rem] text-airbnb-darkest">Donesla Pacquio</div>
                    </div>
                    <div class="text-[0.625rem] sm:text-[0.75rem] text-airbnb-dark">2 weeks ago</div>
                    <form action="{{ route('notifications.delete', 5) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ml-[1rem] text-airbnb-dark hover:text-airbnb-darkest">
                            <i class="w-[1.25rem] h-[1.25rem]" data-lucide="x"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
