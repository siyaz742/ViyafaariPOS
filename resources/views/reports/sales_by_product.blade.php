<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <h1 class="text-4xl font-extrabold text-main-dark italic mb-1">Sales Report by Product</h1>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('reports.salesByProduct') }}" class="mt-8 py-6 rounded-lg flex gap-4 flex-wrap items-end">
            <!-- Product Filter -->
            <div>
                <label for="product_id" class="block bg-accent-dark85 text-sm rounded-t-lg text-white text-center font-semibold">Product</label>
                <select name="product_id" id="product_id" class="text-center px-2 py-1 w-44 mt-0 bg-white bg-opacity-90 border-none text-sm rounded-b-lg text-main-dark focus:ring-1 focus:ring-main-light75 transition">
                    <option value="">All Products</option>
                    @foreach(\App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Range Filter -->
            <div>
                <label for="start_date" class="block bg-accent-dark85 text-sm rounded-t-lg text-white text-center font-semibold">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="text-center px-2 py-1 w-44 mt-0 bg-white bg-opacity-90 border-none text-sm rounded-b-lg text-main-dark focus:ring-1 focus:ring-main-light75 transition">
            </div>
            <div>
                <label for="end_date" class="block bg-accent-dark85 text-sm rounded-t-lg text-white text-center font-semibold">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="text-center px-2 py-1 w-44 mt-0 bg-white bg-opacity-90 border-none text-sm rounded-b-lg text-main-dark focus:ring-1 focus:ring-main-light75 transition">
            </div>

            <!-- Discount Filter -->
            <div>
                <label for="discount_threshold" class="block bg-accent-dark85 text-sm rounded-t-lg text-white text-center font-semibold">Discount Threshold</label>
                <input type="text" name="discount_threshold" id="discount_threshold" value="{{ request('discount_threshold') }}" min="0" max="100" class="text-center px-2 py-1 w-44 mt-0 bg-white bg-opacity-90 border-none text-sm rounded-b-lg text-main-dark focus:ring-1 focus:ring-main-light75 transition" placeholder="Enter discount value"
                       oninput="this.value = Math.max(0, Math.min(100, parseInt(this.value) || 0));" >
            </div>
            <div>
                <label for="discount_type" class="block bg-accent-dark85 text-sm rounded-t-lg text-white text-center font-semibold">Discount Type</label>
                <select name="discount_type" id="discount_type" class="text-center px-2 py-1 w-44 mt-0 bg-white bg-opacity-90 border-none text-sm rounded-b-lg text-main-dark focus:ring-1 focus:ring-main-light75 transition">
                    <option value="above" {{ request('discount_type') == 'above' ? 'selected' : '' }}>Above</option>
                    <option value="below" {{ request('discount_type') == 'below' ? 'selected' : '' }}>Below</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex items-end">
                <button type="submit" class="border-accent-dark85 border-2 bg-white bg-opacity-60 text-accent-dark font-semibold text-center px-10 py-1 mb-0.5 mx-4 rounded-full shadow-sm hover:bg-accent-dark85 hover:border-accent-dark hover:text-white transition">Filter</button>
            </div>

            <!-- Export Button -->
            <div class="ml-auto flex items-end">
                <a href="{{ route('reports.export.sales_by_product', request()->all()) }}" class="border-excel-green border-2 bg-white bg-opacity-60 text-excel-green font-semibold px-10 py-1 mb-0.5 rounded-full shadow-sm hover:bg-excel-green hover:text-white transition duration-300 ease-in-out">
                    <i class="fas fa-file-excel mr-2 excel-icon"></i> Export to Excel
                </a>
            </div>
        </form>

        <!-- Sales Report Table -->
        <table class="min-w-full border-separate border-spacing-0 rounded-lg overflow-hidden">
            <thead class="bg-gradient-to-l from-main-light to-main-dark text-left text-white text-sm uppercase">
            <tr>
                <th class="px-4 py-2">Order ID</th>
                <th class="px-4 py-2">Product</th>
                <th class="px-4 py-2">Unit Price</th>
                <th class="px-4 py-2">Discount</th>
                <th class="px-4 py-2">Discounted Price</th>
                <th class="px-4 py-2">Quantity</th>
                <th class="px-4 py-2">Total</th>
            </tr>
            </thead>
            <tbody class="bg-white bg-opacity-70 text-main-dark">
            @forelse($salesDataByProduct as $data)
                <tr>
                    <td class="border border-main-light40 px-4 py-2">{{ $data->order_id }}</td>
                    <td class="border border-main-light40 px-4 py-2">{{ $data->product->name }}</td>
                    <td class="border border-main-light40 px-4 py-2">${{ $data->item_sale_price }}</td>
                    <td class="border border-main-light40 px-4 py-2">{{ $data->discount }}%</td>
                    <td class="border border-main-light40 px-4 py-2">
                        ${{ number_format($data->item_sale_price * (1 - $data->discount / 100), 2) }}
                    </td>
                    <td class="border border-main-light40 px-4 py-2">{{ $data->quantity }}</td>
                    <td class="border border-main-light40 px-4 py-2">
                        ${{ number_format($data->item_total, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-2 text-center text-main-dark">No records found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
