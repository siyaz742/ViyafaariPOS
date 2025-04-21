<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <h1 class="text-5xl font-extrabold text-main-dark italic mb-1">Orders</h1>
                <div class="px-2 relative">
                    <!-- Search Icon -->
                    <button id="toggle-search-icon" class="text-main-dark hover:text-main-light transition text-2xl">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Search Bar -->
                    <form id="search-bar" action="{{ route('orders.index') }}" method="GET"
                          class="hidden flex items-center space-x-4">
                        <button type="button" id="close-search-bar" class="text-main-dark hover:text-main-light transition text-2xl">
                            <i class="fas fa-times"></i>
                        </button>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search orders..."
                               class="px-4 py-2 mt-1 border border-main-dark rounded-full focus:ring-2 focus:ring-main-light transition">
                        <button type="submit"
                                class="bg-main-dark text-white px-4 py-2 mt-1 rounded-full shadow-sm hover:bg-main-light transition">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <!-- Create New Order Button -->
            <a href="{{ route('orders.create') }}"
               class="bg-main-light text-white px-6 py-2 rounded-full shadow-sm hover:bg-main-dark transition duration-300 ease-in-out">
                Create New Order
            </a>
        </div>

        <!-- Search Results Message -->
        @if(request('search'))
            <div class="mt-4 ml-1 flex items-center space-x-2">
                <p class="text-main-dark">
                    Showing results for: <strong>{{ request('search') }}</strong>
                </p>
                <a href="{{ route('orders.index') }}"
                   class="text-accent-dark hover:text-accent-light underline transition duration-200">
                    Clear Search
                </a>
            </div>
        @endif

        <!-- Table -->
        <div class="mt-8 overflow-hidden rounded-lg shadow-lg">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden bg-opacity-75">
                <thead class="bg-gradient-to-l from-main-light to-main-dark text-white text-sm uppercase">
                <tr>
                    @foreach ([
                        'id' => 'ID',
                        'invoice_date' => 'Date',
                        'invoice_time' => 'Time',
                        'customer.name' => 'Customer',
                        'employee.name' => 'Employee',
                        'payment_method' => 'Payment Method',
                        'total' => 'Total',
                            ] as $field => $label)
                        <th class="px-6 py-3 text-left">
                            @if ($field === 'customer.name' || $field === 'employee.name')
                                <!-- No sorting link for Customer and Employee (its currently bugged) -->
                                {{ $label }}
                            @else
                                <!-- Sorting link for other fields -->
                                <a href="{{ route('orders.index', array_merge(request()->all(), ['sort' => $field, 'direction' => ($sortField === $field && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}"
                                   class="hover:underline
                          {{ $sortField === $field ? 'text-accent-light85' : 'text-white' }}
                          transition duration-200">
                                    {{ $label }}
                                    @if ($sortField === $field)
                                        @if ($sortDirection === 'asc') ↑ @else ↓ @endif
                                    @endif
                                </a>
                            @endif
                        </th>
                    @endforeach

                    <th class="px-6 py-3">Actions</th>
                </tr>
                </thead>
                <tbody class="text-main-dark">
                @forelse ($orders as $order)
                    {{-- Main Order Row --}}
                    <tr class="hover:bg-accent-superlight transition cursor-pointer" onclick="toggleOrderItems({{ $order->id }})">
                        <td class="px-6 py-4">{{ $order->id }}</td>
                        <td class="px-6 py-4">{{ $order->invoice_date }}</td>
                        <td class="px-6 py-4">{{ $order->invoice_time }}</td>
                        <td class="px-6 py-4">{{ $order->customer?->name }}</td>
                        <td class="px-6 py-4">{{ $order->employee?->name }}</td>
                        <td class="px-6 py-4">{{ ucfirst($order->payment_method) }}</td>
                        <td class="px-6 py-4">{{ number_format($order->total, 2) }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('orders.show', $order) }}"
                               class="text-main-light hover:text-main-dark transition duration-200">
                                View
                            </a>
                        </td>
                    </tr>

                    {{-- Hidden Order Items Row --}}
                    <tr id="order-items-{{ $order->id }}" class="hidden bg-white bg-opacity-0">
                        <td colspan="8" class="pb-1">
                            @if ($order->orderItems->isEmpty())
                                <p class="text-main-dark">No items in this order.</p>
                            @else
                                <table class="min-w-full bg-white  rounded-lg overflow-hidden ">
                                    <thead class="bg-gradient-to-r from-accent-light to-accent-dark text-white text-sm uppercase">
                                    <tr>
                                        <th class="px-6 py-1 text-left w-4/12">Product</th>
                                        <th class="px-6 py-1 text-left w-2/12">Unit Price</th>
                                        <th class="px-6 py-1 text-left w-1/12">Discount</th>
                                        <th class="px-6 py-1 text-left w-2/12">Discounted Price</th>
                                        <th class="px-6 py-1 text-left w-1/12">Quantity</th>
                                        <th class="px-6 py-1 text-left w-2/12">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-main-dark">
                                    @foreach ($order->orderItems as $item)
                                        <tr class="hover:bg-main-verylight transition">
                                            <td class="border px-6 py-1 w-4/12">{{ $item->product?->name }}</td>
                                            <td class="border px-6 py-1 w-2/12">${{ number_format($item->item_sale_price, 2) }}</td>
                                            <td class="border px-6 py-1 w-1/12">{{ $item->discount }}%</td>
                                            <td class="border px-6 py-1 w-2/12">
                                                ${{ number_format($item->item_sale_price * (1 - $item->discount / 100), 2) }}
                                            </td>
                                            <td class="border px-6 py-1 w-1/12">{{ $item->quantity }}</td>
                                            <td class="border px-6 py-1 w-2/12">${{ number_format($item->item_total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-main-dark">
                            No orders found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleOrderItems(orderId) {
            const orderItemsRow = document.getElementById('order-items-' + orderId);
            orderItemsRow.classList.toggle('hidden');
        }
    </script>

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
