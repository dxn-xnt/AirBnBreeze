@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="flex items-center justify-center h-screen">
        <div x-data="{ form: 'login' }"
             class="bg-airbnb-light p-6 rounded-xl border-[1px] border-airbnb-darkest shadow-md w-full max-w-sm text-sm text-airbnb-darkest font-medium mx-auto">
            <!-- LOGIN FORM -->
            <div x-show="form === 'login'">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold mb-4">Log in to <span class="font-bold">AirBnBreeze</span></h2>
                    <button class="text-xl font-bold">&times;</button>
                </div>

                <form action="{{ route('user.login') }}" method="POST">
                    @csrf
                    <input type="text" name="user_email" placeholder="Email Address"
                           class="w-full px-4 py-2 mb-3 rounded-md border border-airbnb-darkest bg-airbnb-light text-airbnb-darkest placeholder-airbnb-dark focus:outline-none">
                    @if ($errors->has('user_email'))
                        <p class="text-red-500 text-xs">{{ $errors->first('user_email') }}</p>
                    @endif
                    <input type="password" name="user_password" placeholder="Password"
                           class="w-full px-4 py-2 mb-3 rounded-md border border-airbnb-darkest bg-airbnb-light text-airbnb-darkest placeholder-airbnb-dark focus:outline-none">
                    @if ($errors->has('user_password'))
                        <p class="text-red-500 text-xs">{{ $errors->first('user_password') }}</p>
                    @endif
                    <button class="bg-airbnb-dark text-airbnb-light w-full py-2 rounded-md font-semibold">LOG IN</button>
                </form>

                @if ($errors->any())
                    <script>
                        // Display error messages using SweetAlert
                        @foreach ($errors->all() as $error)
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: "{{ addslashes($error) }}",
                        });
                        @endforeach
                    </script>
                @endif

                @if (session('success'))
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        // Display success message using SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: "{{ addslashes(session('success')) }}",
                        });
                    </script>
                @endif


                <div class="flex justify-end mt-1 text-xs underline cursor-pointer" @click="form = 'forgot'">Forgot
                    password?</div>

                <div class="flex items-center justify-center my-2 text-xs text-airbnb-darkest">
                    <span class="border-t border-airbnb-dark w-full"></span>
                    <span class="px-2">or</span>
                    <span class="border-t border-airbnb-dark w-full"></span>
                </div>

                <div class="text-center">
                    <p class="text-xs mb-1">Don't have an account?</p>
                    <a href="{{ route('signup') }}"
                       class="block w-full border border-airbnb-darkest py-2 rounded-md font-semibold text-airbnb-darkest text-center">SIGN UP</a>
                </div>
            </div>

            <!-- FORGOT PASSWORD FORM -->
            <div x-show="form === 'forgot'">
                <h2 class="text-lg font-semibold mb-4">Reset your password</h2>

                <form>
                    <input type="text" placeholder="Phone Number"
                           class="w-full px-4 py-2 mb-3 rounded-sm border border-airbnb-darkest bg-airbnb-light text-airbnb-darkest placeholder-airbnb-dark focus:outline-none">
                    <button class="bg-airbnb-darkest text-airbnb-light w-full py-2 rounded-sm font-semibold">SEND CODE</button>
                </form>

                <div class="flex items-center justify-center my-2 text-xs text-airbnb-darkest">
                    <span class="border-t border-airbnb-dark w-full"></span>
                    <span class="px-2">or</span>
                    <span class="border-t border-airbnb-dark w-full"></span>
                </div>

                <div class="text-center space-y-2">
                    <button @click="form = 'login'"
                            class="w-full border border-airbnb-darkest py-2 rounded-sm font-semibold text-airbnb-darkest">Back to LOG
                        IN</button>
                    <button @click="form = 'signup'"
                            class="w-full border border-airbnb-darkest py-2 rounded-sm font-semibold text-airbnb-darkest">Go to SIGN
                        UP</button>
                </div>
            </div>
        </div>
    </div>

@endsection
