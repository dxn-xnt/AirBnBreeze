@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="flex items-center justify-center h-screen">
        <div x-data="{ form: 'login' }"
             class="bg-[#DCE5D2] p-6 rounded-xl shadow-md w-full max-w-sm text-sm text-[#3B4F39] font-medium mx-auto">
            <!-- LOGIN FORM -->
            <div x-show="form === 'login'">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold mb-4">Log in to <span class="font-bold">AirBnBreeze</span></h2>
                    <button class="text-xl font-bold">&times;</button>
                </div>

                <form>
                    <input type="text" placeholder="Phone Number"
                           class="w-full px-4 py-2 mb-3 rounded-md border border-[#3B4F39] bg-[#DCE5D2] text-[#3B4F39] placeholder-[#3B4F39] focus:outline-none">
                    <input type="password" placeholder="Password"
                           class="w-full px-4 py-2 mb-3 rounded-md border border-[#3B4F39] bg-[#DCE5D2] text-[#3B4F39] placeholder-[#3B4F39] focus:outline-none">

                    <button class="bg-[#3B4F39] text-white w-full py-2 rounded-md font-semibold">LOG IN</button>
                </form>

                <div class="flex justify-end mt-1 text-xs underline cursor-pointer" @click="form = 'forgot'">Forgot
                    password?</div>

                <div class="flex items-center justify-center my-2 text-xs text-gray-600">
                    <span class="border-t border-gray-400 w-full"></span>
                    <span class="px-2">or</span>
                    <span class="border-t border-gray-400 w-full"></span>
                </div>

                <div class="text-center">
                    <p class="text-xs mb-1">Don't have an account?</p>
                    <button @click="form = 'signup'"
                            class="w-full border border-[#3B4F39] py-2 rounded-md font-semibold text-[#3B4F39]">SIGN UP</button>
                </div>
            </div>

            <!-- FORGOT PASSWORD FORM -->
            <div x-show="form === 'forgot'">
                <h2 class="text-lg font-semibold mb-4">Reset your password</h2>

                <form>
                    <input type="text" placeholder="Phone Number"
                           class="w-full px-4 py-2 mb-3 rounded-md border border-[#3B4F39] bg-[#DCE5D2] text-[#3B4F39] placeholder-[#3B4F39] focus:outline-none">
                    <button class="bg-[#3B4F39] text-white w-full py-2 rounded-md font-semibold">SEND CODE</button>
                </form>

                <div class="flex items-center justify-center my-2 text-xs text-gray-600">
                    <span class="border-t border-gray-400 w-full"></span>
                    <span class="px-2">or</span>
                    <span class="border-t border-gray-400 w-full"></span>
                </div>

                <div class="text-center space-y-2">
                    <button @click="form = 'login'"
                            class="w-full border border-[#3B4F39] py-2 rounded-md font-semibold text-[#3B4F39]">Back to LOG
                        IN</button>
                    <button @click="form = 'signup'"
                            class="w-full border border-[#3B4F39] py-2 rounded-md font-semibold text-[#3B4F39]">Go to SIGN
                        UP</button>
                </div>
            </div>
        </div>
    </div>

@endsection
