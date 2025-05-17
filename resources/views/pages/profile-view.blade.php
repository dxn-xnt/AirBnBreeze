@extends('layouts.app')

@section('content')
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-lightest gap-2">

        <!-- Profile Info -->
        <div class=" m-auto max-w-screen-lg">
            <h1 class="text-[1.5rem] sm:text-[1.75rem] font-semibold text-airbnb-darkest mb-2">
                About {{ $user->user_fname }} {{ $user->user_lname }}
            </h1>
            <div class="flex gap-10 w-full py-6 px-8 border border-airbnb-darkest rounded-xl">
                <div class="flex flex-col items-center gap-4">
                    <!-- Profile Picture -->
                    <img class="w-52 h-52 rounded-full object-cover border border-airbnb-darkest"
                         src="{{ $user->user_profile ? asset('storage/' . $user->user_profile) : asset('images/default-profile.jpg') }}"
                         alt="Profile Picture">
                    <a href="{{ route('owner.edit', $user->user_id) }}"
                       class="text-airbnb-darkest text-sm  border border-airbnb-darkest hover:shadow-md mb-4 px-8 rounded-full">
                        Edit Profile
                    </a>
                </div>

                <div class="w-full space-y-6">
                    <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Column 1 -->
                        <div class="space-y-6 ">
                            <div class="w-full">
                                <p class="text-airbnb-dark text-sm italic">Name</p>
                                <p class="text-airbnb-darkest text-lg font-semibold">{{ $user->user_fname }} {{ $user->user_lname }}</p>
                            </div>

                            <div class="w-full">
                                <p class="text-airbnb-dark text-sm italic">Email</p>
                                <p class="text-airbnb-darkest text-lg font-semibold">{{ $user->user_email }}</p>
                            </div>
                        </div>

                        <!-- Column 2 -->
                        <div class="space-y-6">
                            <div class="w-full">
                                <p class="text-airbnb-dark text-sm italic">Phone Number</p>
                                <p class="text-airbnb-darkest text-lg font-semibold">{{ $user->user_contact_number }}</p>
                            </div>

                            <div class="w-full">
                                <p class="text-airbnb-dark text-sm italic">Joined Since</p>
                                <p class="text-airbnb-darkest text-lg font-semibold">
                                    {{ \Carbon\Carbon::parse($user->user_date_created)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-airbnb-dark text-sm italic">About</p>
                        <p class="text-airbnb-darkest text-md font-regular">
                            I was a girl in the village doin' alright then I became a princess overnight Now I gotta figure out how to do it right, so much to learn and see Up in the castle with my new family, in a school that's just for royalty A whole enchanted world is waiting for me, I'm so excited to be
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Properties -->
        <div class=" m-auto max-w-screen-lg mt-8">
            <h1 class="text-[1.5rem] sm:text-[1.75rem] font-semibold text-airbnb-darkest mb-2">
                {{ $user->user_fname }} {{ $user->user_lname }}'s Properties
            </h1>
            <!-- Listings Section - Optimized 3-column max -->
            <div class="w-full ">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 sm:gap-x-8 lg:gap-x-9 gap-y-8 sm:gap-y-10 lg:gap-y-12 mb-8 mx-auto">
                    @foreach($properties as $property)
                        <x-property-card :property="$property" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
