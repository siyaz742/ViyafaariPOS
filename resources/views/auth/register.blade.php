<x-app-layout>
    <div class="container mx-auto px-6 py-8">

        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <h1 class="text-4xl font-extrabold text-main-dark italic mb-1">Create New User</h1>
            </div>
            <a href="{{ route('users.index') }}"
               class="bg-main-light text-white px-6 py-2 rounded-full shadow-sm hover:bg-main-dark75 transition duration-300 ease-in-out">
                Back to Users
            </a>
        </div>

        <!-- Registration Form -->
        <div class="mt-8 py-6">
            <form method="POST" action="{{ route('register') }}" class="mb-6">
                @csrf

                <!-- Form Fields -->
                @php
                    $fields = [
                        ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
                        ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
                        ['name' => 'role', 'label' => 'Role', 'type' => 'select', 'required' => true, 'options' => ['Admin', 'Owner', 'Manager', 'Cashier', 'Staff']],
                        ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'required' => true],
                        ['name' => 'password_confirmation', 'label' => 'Confirm Password', 'type' => 'password', 'required' => true],
                    ];
                @endphp

                @foreach($fields as $field)
                    <div class="mb-6">
                        <label for="{{ $field['name'] }}" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">
                            {{ $field['label'] }}
                        </label>
                        @if($field['type'] == 'select')
                            <select id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light" required>
                                <option value="" disabled {{ old($field['name']) ? '' : 'selected' }}>-- Select Role --</option>
                                @foreach($field['options'] as $option)
                                    <option value="{{ $option }}" {{ old($field['name']) == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                   class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light"
                                   value="{{ old($field['name']) }}" {{ $field['required'] ? 'required' : '' }} autocomplete="{{ $field['name'] }}">
                        @endif
                        <x-input-error :messages="$errors->get($field['name'])" class="mt-2" />
                    </div>
                @endforeach

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-main-light text-white px-6 py-2 rounded-full shadow-md hover:bg-main-dark75 transition duration-300 ease-in-out mt-5">
                        Save User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
