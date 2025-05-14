@extends('layouts.app')

@section('title', 'Help Center')

@section('content')
<div class="bg-[#E3EED4] min-h-screen pt-[4rem] md:pt-[7.5rem]">
    <div class="max-w-[1750px] mx-auto px-[1rem] sm:px-[1.5rem] md:px-[2rem] lg:px-[4rem] xl:px-[8rem] py-8">
        <!-- Help Center Page -->
        <div>
            <h1 class="text-[1.5rem] sm:text-[1.75rem] font-semibold text-airbnb-darkest mb-[1.5rem] sm:mb-[2rem]">
                FAQ
            </h1>
            
            <!-- FAQ Item -->
            <div class="mb-[1.5rem] sm:mb-[2rem]">
                <h2 class="text-[1.125rem] sm:text-[1.25rem] font-semibold text-airbnb-darkest mb-[0.5rem] sm:mb-[0.75rem]">
                    How to cancel a booking?
                </h2>
                <p class="text-airbnb-dark text-[1rem] sm:text-[1.125rem]">
                    Go to your Reservations, click on the booking, and select 'Cancel'. Review cancellation policy before confirming.
                </p>
            </div>
            
            <!-- FAQ Item -->
            <div class="mb-[1.5rem] sm:mb-[2rem]">
                <h2 class="text-[1.125rem] sm:text-[1.25rem] font-semibold text-airbnb-darkest mb-[0.5rem] sm:mb-[0.75rem]">
                    How to become a host?
                </h2>
                <p class="text-airbnb-dark text-[1rem] sm:text-[1.125rem]">
                    Click "airbnb your house" in the menu, fill out your property details, and submit for approval.
                </p>
            </div>
            
            <!-- FAQ Item -->
            <div class="mb-[1.5rem] sm:mb-[2rem]">
                <h2 class="text-[1.125rem] sm:text-[1.25rem] font-semibold text-airbnb-darkest mb-[0.5rem] sm:mb-[0.75rem]">
                    How to reset password?
                </h2>
                <p class="text-airbnb-dark text-[1rem] sm:text-[1.125rem]">
                    Go to the login screen, click "Forgot Password", and follow the instructions sent to your email.
                </p>
            </div>
            
            <!-- Contact Support -->
            <div class="mt-[1.5rem] sm:mt-[5rem] text-center">
                <p class="text-airbnb-dark text-[1rem] sm:text-[1.125rem] mb-[1rem] sm:mb-[1.25rem]">Having a hard time?</p>
                <a href="#" class="inline-block bg-[#375534] text-[#E3EED4] py-2 px-8 sm:py-2.5 sm:px-10 rounded-full hover:bg-opacity-90 transition-colors text-[1rem] sm:text-[1.125rem]">
                    Contact Support
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
