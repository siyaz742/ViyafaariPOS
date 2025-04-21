<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <!-- Title -->
                <h1 class="text-5xl font-extrabold text-main-dark italic mb-1">Products</h1>

                <!-- Search Icon -->
                <div class="px-2 relative">
                    <button
                        id="toggle-search-icon"
                        class="text-main-dark hover:text-main-light transition text-2xl"
                    >
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Search Bar -->
                    <form id="search-bar" action="{{ route('products.index') }}" method="GET"
                          class="hidden flex items-center space-x-4">
                        <button
                            type="button"
                            id="close-search-bar"
                            class="text-main-dark hover:text-main-light transition text-2xl"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search products..."
                            class="px-4 py-2 mt-1 border border-main-dark rounded-full text-main-dark focus:ring-2 focus:ring-main-light transition"
                        >
                        <button
                            type="submit"
                            class="bg-main-dark text-white px-4 py-2 mt-1 rounded-full shadow-sm hover:bg-main-light transition"
                        >
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <!-- Add New Product Button -->
            <a href="{{ route('products.create') }}"
               class="bg-main-light text-white px-6 py-2 rounded-full shadow-sm hover:bg-main-dark transition duration-300 ease-in-out">
                Add New Product
            </a>
        </div>

        <!-- Search Results Message -->
        @if(request('search'))
            <div class="mt-4 ml-1 flex items-center space-x-2">
                <p class="text-main-dark">
                    Showing results for: <strong>{{ request('search') }}</strong>
                </p>
                <a href="{{ route('products.index') }}"
                   class="text-accent-dark hover:text-accent-light underline transition duration-200">
                    Clear Search
                </a>
            </div>
        @endif

        <!-- Table -->
        <div class="mt-8 overflow-hidden rounded-lg shadow-lg">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden bg-opacity-75">
                <!-- Table Header -->
                <thead class="bg-gradient-to-l from-main-light to-main-dark text-white text-sm uppercase">
                <tr>
                    @foreach ([
                        'id' => 'ID',
                        'name' => 'Name',
                        'description' => 'Description',
                        'price' => 'Price',
                        'stock_quantity' => 'Stock Quantity',
                        'vendor_id' => 'Vendor'
                    ] as $field => $label)
                        <th class="px-6 py-3 text-left">
                            <a href="{{ route('products.index', array_merge(request()->all(), ['sort' => $field, 'direction' => ($sortField === $field && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}"
                               class="hover:underline
                                          {{ $sortField === $field ? 'text-accent-light85' : 'text-white' }}
                                          transition duration-200">
                                {{ $label }}
                                @if ($sortField === $field)
                                    @if ($sortDirection === 'asc') ↑ @else ↓ @endif
                                @endif
                            </a>
                        </th>
                    @endforeach
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="text-main-dark">
                @forelse ($products as $product)
                    @php
                        $trashedClass = $product->trashed() ? 'text-gray-400 bg-gray-100 bg-opacity-0' : '';
                    @endphp
                    <tr class="hover:bg-accent-superlight transition {{ $trashedClass }}">
                        <td class="px-6 py-4 {{ $trashedClass }}">{{ $product->id }}</td>
                        <td class="px-6 py-4 {{ $trashedClass }}">{{ $product->name }}</td>
                        <td class="px-6 py-4 {{ $trashedClass }}">{{ $product->description }}</td>
                        <td class="px-6 py-4 {{ $trashedClass }}">{{ $product->price }}</td>
                        <td class="px-6 py-4 {{ $trashedClass }}">{{ $product->stock_quantity }}</td>
                        <td class="px-6 py-4 {{ $trashedClass }}">
                            @if ($product->vendor)
                                <span class="{{ $product->vendor->trashed() ? 'text-gray-400 italic' : '' }}">
                                        {{ $product->vendor->name }}
                                    </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex space-x-4 justify-center items-center {{ $trashedClass }}">
                            <a href="{{ route('products.edit', $product) }}"
                               class="text-main-light hover:text-main-dark transition duration-200 {{ $trashedClass }}">
                                Edit
                            </a>
                            <form action="{{ $product->trashed() ? route('products.restore', $product->id) : route('products.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @if ($product->trashed())
                                    <button type="submit"
                                            class="text-green-600 hover:text-green-800 transition duration-200 {{ $trashedClass }}">
                                        Restore
                                    </button>
                                @else
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-800 transition duration-200 {{ $trashedClass }}">
                                        Delete
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-main-dark">
                            No products found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('toggle-search-icon').addEventListener('click', function () {
            document.getElementById('toggle-search-icon').classList.add('hidden');
            document.getElementById('search-bar').classList.remove('hidden');
        });

        document.getElementById('close-search-bar').addEventListener('click', function () {
            document.getElementById('search-bar').classList.add('hidden');
            document.getElementById('toggle-search-icon').classList.remove('hidden');
        });
    </script>
</x-app-layout>
