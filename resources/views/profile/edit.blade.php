<x-app-layout>
    <div class="container mx-auto px-6 py-8">

        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <h1 class="text-4xl font-extrabold text-main-dark italic mb-1">{{ __('Profile Settings') }}</h1>
            </div>
        </div>

{{--        <!-- Profile Information Section -->--}}
{{--        <div class="mt-8 py-6 rounded-lg">--}}
{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="w-full">--}}
{{--                    @include('profile.partials.update-profile-information-form')--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- Change Password Section -->
        <div class="mt-8 py-6 rounded-lg">
            <div class="">
                <div class="w-full">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

{{--        <!-- Delete User Section -->--}}
{{--        <div class="mt-8 py-6 rounded-lg">--}}
{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="w-full">--}}
{{--                    @include('profile.partials.delete-user-form')--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

    </div>
</x-app-layout>


