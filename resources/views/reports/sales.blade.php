<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <h1 class="text-4xl font-extrabold text-main-dark italic mb-1">Sales Report</h1>
            </div>
        </div>
        <!-- Filter Form -->
        <form method="GET" action="{{ route('reports.sales') }}" class=" mt-8 py-6 rounded-lg flex gap-4 flex-wrap items-end">
            <!-- Date Range Filter -->
            <div>
                <label for="start_date" class="block bg-accent-dark85 text-sm rounded-t-lg text-white text-center font-semibold">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="text-center px-2 py-1 w-44 mt-0 bg-white bg-opacity-90 border-none text-sm  rounded-b-lg text-main-dark focus:ring-1 focus:ring-main-light75 transition">
            </div>
            <div>
                <label for="end_date" class="block bg-accent-dark85 text-sm rounded-t-lg text-white text-center font-semibold">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="text-center px-2 py-1 w-44 mt-0 bg-white bg-opacity-90 border-none text-sm  rounded-b-lg text-main-dark focus:ring-1 focus:ring-main-light75 transition">
            </div>

            <!-- Payment Method Filter -->
            <div>
                <label for="payment_method" class="block bg-accent-dark85 text-sm rounded-t-lg text-white text-center font-semibold">Payment Method</label>
                <select name="payment_method" id="payment_method" class="text-center px-2 py-1 w-44 mt-0 bg-white bg-opacity-90 border-none text-sm  rounded-b-lg text-main-dark focus:ring-1 focus:ring-main-light75 transition">
                    <option value="">All</option>
                    <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="card" {{ request('payment_method') === 'card' ? 'selected' : '' }}>Card</option>
                    <option value="bank transfer" {{ request('payment_method') === 'bank transfer' ? 'selected' : '' }}>Bank Transfer</option>
                </select>
            </div>

            <!-- Customer Filter -->
            <div>
                <label for="customer_id" class="block bg-accent-dark85 text-sm rounded-t-lg text-white text-center font-semibold">Customer</label>
                <select name="customer_id" id="customer_id" class="text-center px-2 py-1 w-44 mt-0 bg-white bg-opacity-90 border-none text-sm  rounded-b-lg text-main-dark focus:ring-1 focus:ring-main-light75 transition">
                    <option value="">All</option>
                    @foreach(\App\Models\Customer::all() as $customer)
                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Employee Filter -->
            <div>
                <label for="employee_id" class="block bg-accent-dark85 text-sm rounded-t-lg text-white text-center font-semibold">Employee</label>
                <select name="employee_id" id="employee_id" class="text-center px-2 py-1 w-44 mt-0 bg-white bg-opacity-90 border-none text-sm  rounded-b-lg text-main-dark focus:ring-1 focus:ring-main-light75 transition">
                    <option value="">All</option>
                    @foreach(\App\Models\User::where('role', '!=', 'Customer')->get() as $employee)
                        <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex items-end">
                <button type="submit" class="border-accent-dark85 border-2 bg-white bg-opacity-60 text-accent-dark font-semibold text-center px-10 py-1 mb-0.5 mx-4 rounded-full shadow-sm hover:bg-accent-dark85 hover:border-accent-dark hover:text-white transition">Filter</button>
            </div>

            <!-- Export Button -->
            <div class="ml-auto flex items-end">
                <a href="{{ route('reports.export.sales', request()->all()) }}" class="border-excel-green border-2 bg-white bg-opacity-60 text-excel-green font-semibold px-10 py-1 mb-0.5 rounded-full shadow-sm hover:bg-excel-green hover:text-white  transition duration-300 ease-in-out">
                    <i class="fas fa-file-excel mr-2 excel-icon"></i></i> Export to Excel
                </a>
            </div>

        </form>


        <!-- Sales Report Table -->
        <table class="min-w-full border-separate border-spacing-0 rounded-lg overflow-hidden">
            <thead class="bg-gradient-to-l from-main-light to-main-dark text-left text-white text-sm uppercase">
            <tr>
                <th class="px-4 py-2">Order ID</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Customer</th>
                <th class="px-4 py-2">Employee</th>
                <th class="px-4 py-2">Total</th>
                <th class="px-4 py-2">Payment Method</th>
            </tr>
            </thead>
            <tbody class="bg-white bg-opacity-70 text-main-dark overflow-hidden">
            @forelse($salesData as $sale)
                <tr>
                    <td class="border border-main-light40 px-4 py-2">{{ $sale->id }}</td>
                    <td class="border border-main-light40 px-4 py-2">{{ $sale->invoice_date }}</td>
                    <td class="border border-main-light40 px-4 py-2">{{ $sale->customer->name ?? 'N/A' }}</td>
                    <td class="border border-main-light40 px-4 py-2">{{ $sale->employee->name ?? 'N/A' }}</td>
                    <td class="border border-main-light40 px-4 py-2">${{ number_format($sale->total, 2) }}</td>
                    <td class="border border-main-light40 px-4 py-2">{{ ucfirst($sale->payment_method) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-2 text-center text-main-dark">No records found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
