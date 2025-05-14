@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="bg-[#E3EED4] min-h-screen pt-[4rem] md:pt-[7.5rem]">
    <div class="max-w-[1750px] mx-auto px-[1rem] sm:px-[1.5rem] md:px-[2rem] lg:px-[4rem] xl:px-[8rem] py-8">
        <!-- About Us Page -->
        <div>
            <h1 class="text-[1.5rem] sm:text-[1.75rem] md:text-[2rem] lg:text-[2.5rem] font-semibold text-airbnb-darkest mb-[1rem] sm:mb-[1.25rem]">
                AirBnBreeze: A Smarter, Smoother Way to Book and Stay
            </h1>
            
            <p class="text-airbnb-dark text-[1rem] sm:text-[1.125rem] leading-relaxed mb-[1.5rem] sm:mb-[2rem]">
                AirBnBreeze is a student-built booking system for a single Airbnb property. We make 
                travel feel more personal and local by helping guests book rooms easily and giving
                hosts a simple way to manage their space. It's all about safe, easy, and friendly stays.
            </p>
            
            <h2 class="text-[1.25rem] sm:text-[1.5rem] font-semibold text-airbnb-darkest mb-[1rem] sm:mb-[1.25rem]">
                Vision and Mission
            </h2>
            
            <p class="text-airbnb-dark text-[1rem] sm:text-[1.125rem] leading-relaxed mb-[1rem] sm:mb-[1.25rem]">
                To create a trusted community where local hosts and travelers connect through safe,
                simple, and meaningful stays.
            </p>
            
            <p class="text-airbnb-dark text-[1rem] sm:text-[1.125rem] leading-relaxed mb-[1.5rem] sm:mb-[2rem]">
                Our mission is to empower local property owners by making hosting easy and
                accessible, while offering guests a comfortable and affordable way to explore new
                places—one stay at a time.
            </p>
            
            <h2 class="text-[1.25rem] sm:text-[1.5rem] font-semibold text-airbnb-darkest mb-[1rem] sm:mb-[1.25rem]">
                Contact Us
            </h2>
            
            <div class="flex flex-col space-y-3 sm:space-y-4 mb-[1.5rem] sm:mb-[2rem]">
                <div class="flex items-center gap-3">
                    <i class="w-5 h-5 sm:w-6 sm:h-6 text-airbnb-dark" data-lucide="facebook"></i>
                    <span class="text-airbnb-dark text-[1rem] sm:text-[1.125rem]">@airbnbreeze.fb.com</span>
                </div>
                
                <div class="flex items-center gap-3">
                    <i class="w-5 h-5 sm:w-6 sm:h-6 text-airbnb-dark" data-lucide="github"></i>
                    <span class="text-airbnb-dark text-[1rem] sm:text-[1.125rem]">@airbnbreeze.github.com</span>
                </div>
                
                <div class="flex items-center gap-3">
                    <i class="w-5 h-5 sm:w-6 sm:h-6 text-airbnb-dark" data-lucide="instagram"></i>
                    <span class="text-airbnb-dark text-[1rem] sm:text-[1.125rem]">@airbnbreeze.ig.com</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
