@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4">
        <!-- Profile Info -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="flex items-center space-x-4">
                <!-- Profile Picture -->
                <img class="w-24 h-24 rounded-full object-cover"
                     src="{{ $user->user_profile ? asset('storage/' . $user->user_profile) : asset('images/default-profile.jpg') }}"
                     alt="Profile Picture">

                <div>
                    <h2 class="text-2xl font-semibold">{{ $user->user_fname }} {{ $user->user_lname }}</h2>
                    <p class="text-gray-500">{{ $user->user_email }}</p>
                    <p class="text-gray-500">Phone: {{ $user->user_contact_number }}</p>
                    <p class="text-gray-500">Member since: {{ \Carbon\Carbon::parse($user->user_date_created)->format('M d, Y') }}</p>
                    <p class="text-gray-500">Account Type: {{ $user->user_is_host ? 'Host' : 'Guest' }}</p>
                </div>

                <div class="ml-auto">
                    <a href="{{ route('owner.edit', $user->user_id) }}"
                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
