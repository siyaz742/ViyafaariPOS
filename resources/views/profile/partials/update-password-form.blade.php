<section>
    <header class="mb-6">
        <h2 class=" inline-block text-lg font-semibold text-main-dark75">
            {{ __('Update Password') }}
        </h2>

        <p class=" mt-1 text-sm text-main-dark75">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>
    <form method="post" action="{{ route('password.update') }}" class="mt-0">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                    border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light mb-6" autocomplete="current-password" />
            @if ($errors->updatePassword->has('current_password'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                    border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light mb-6" autocomplete="new-password" />
            @if ($errors->updatePassword->has('password'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                    border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light mb-6" autocomplete="new-password" />
            @if ($errors->updatePassword->has('password_confirmation'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-main-light text-white px-6 py-2 rounded-full shadow-md hover:bg-main-dark75 transition duration-300 ease-in-out mt-5">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
