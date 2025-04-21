<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

        <div class="flex justify-center items-center">
            <a href="/">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-40 z-20">
            </a>
        </div>
        <div class="flex justify-center items-center space-x-2 mb-6">
            <h1 class="text-4xl font-extrabold text-outline italic mt-2 z-20">Viyafaari POS</h1>
        </div>


    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block  text-white pl-3 py-1 rounded-t-lg font-semibold text-sm">{{ __('Email') }}</label>
            <input id="email" class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                    border-gray-300 rounded-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            @error('email')
            <span class="mt-2 text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block  text-white pl-3 py-1 rounded-t-lg font-semibold text-sm">{{ __('Password') }}</label>
            <input id="password" class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                    border-gray-300 rounded-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light" type="password" name="password" required autocomplete="current-password" />
            @error('password')
            <span class="mt-2 text-red-600">{{ $message }}</span>
            @enderror
        </div>


        <div class="flex items-center justify-between pl-1 mt-6">
            <!-- Remember Me Checkbox -->
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="mt-1  border-2 border-gray-300 rounded-lg bg-white hover:border-main-dark75  hover:checked:bg-main-dark75 checked:bg-main-light checked:border-main-light focus:ring-2 focus:ring-main-light focus:ring-offset-2" name="remember">
                <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
            </label>


            <!-- Login Button -->

            <button class="bg-main-light text-white px-6 py-2 rounded-full shadow-sm hover:bg-main-dark75 transition duration-300 ease-in-out ml-3">
                {{ __('Log in') }}
            </button>
        </div>

{{--        <div class="flex items-center justify-end mt-4">--}}
{{--            @if (Route::has('password.request'))--}}
{{--                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">--}}
{{--                    {{ __('Forgot your password?') }}--}}
{{--                </a>--}}
{{--            @endif--}}
{{--        </div>--}}
    </form>
</x-guest-layout>
