<x-app-layout>
    <div class="container mx-auto px-6 py-8">

        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <h1 class="text-4xl font-extrabold text-main-dark italic mb-1">Add New Product</h1>
            </div>
            <a href="{{ route('products.index') }}"
               class="bg-main-light text-white px-6 py-2 rounded-full shadow-sm hover:bg-main-dark75 transition duration-300 ease-in-out">
                Back to Products
            </a>
        </div>

        <!-- Create Form -->
        <div class="mt-8 py-6 rounded-lg">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <!-- Form Fields -->
                @php
                    $fields = [
                        ['name' => 'name', 'label' => 'Product Name', 'type' => 'text', 'required' => true],
                        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
                        ['name' => 'price', 'label' => 'Price', 'type' => 'text', 'required' => true],
                        ['name' => 'stock_quantity', 'label' => 'Stock Quantity', 'type' => 'text', 'required' => true],
                    ];
                @endphp

                @foreach($fields as $field)
                    <div class="mb-6">
                        <label for="{{ $field['name'] }}" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">
                            {{ $field['label'] }}
                        </label>
                        @if($field['type'] == 'textarea')
                            <textarea
                                id="{{ $field['name'] }}"
                                name="{{ $field['name'] }}"
                                class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                        border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light"
                                {{ $field['required'] ? 'required' : '' }}
                                maxlength="120">
                                {{ old($field['name']) }}
                            </textarea>
                        @else
                            <input
                                type="{{ $field['type'] }}"
                                id="{{ $field['name'] }}"
                                name="{{ $field['name'] }}"
                                value="{{ old($field['name']) }}"
                                step="{{ $field['step'] ?? '' }}"
                                class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                        border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light"
                                {{ $field['required'] ? 'required' : '' }}
                            >
                        @endif
                    </div>
                @endforeach

                <!-- Vendor Selection -->
                <div class="mb-6">
                    <label for="vendor_id" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">Vendor</label>
                    <select
                        name="vendor_id"
                        id="vendor_id"
                        class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                               border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light"
                        required>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-main-light text-white px-6 py-2 rounded-full shadow-md hover:bg-main-dark75 transition duration-300 ease-in-out mt-5">
                        Save Product
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
