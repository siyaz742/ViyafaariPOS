<x-app-layout>
    <div class="container mx-auto px-6 py-8">

        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <h1 class="text-4xl font-extrabold text-main-dark italic mb-1">Add New Vendor</h1>
            </div>
            <a href="{{ route('vendors.index') }}"
               class="bg-main-light text-white px-6 py-2 rounded-full shadow-sm hover:bg-main-dark75 transition duration-300 ease-in-out">
                Back to Vendors
            </a>
        </div>

        <!-- Create Form -->
        <div class="mt-8 py-6 rounded-lg">
            <form action="{{ route('vendors.store') }}" method="POST">
                @csrf

                <!-- Form Fields -->
                @php
                    $fields = [
                        ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
                        ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
                        ['name' => 'phone', 'label' => 'Phone', 'type' => 'text', 'required' => true],
                        ['name' => 'address', 'label' => 'Address', 'type' => 'text', 'required' => true],
                    ];
                @endphp

                @foreach($fields as $field)
                    <div class="mb-6">
                        <label for="{{ $field['name'] }}" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">
                            {{ $field['label'] }}
                        </label>
                        <input
                            type="{{ $field['type'] }}"
                            id="{{ $field['name'] }}"
                            name="{{ $field['name'] }}"
                            value="{{ old($field['name']) }}"
                            class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                    border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light"
                            {{ $field['required'] ? 'required' : '' }}
                        >
                    </div>
                @endforeach

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-main-light text-white px-6 py-2 rounded-full shadow-md hover:bg-main-dark75 transition duration-300 ease-in-out mt-5">
                        Save Vendor
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
