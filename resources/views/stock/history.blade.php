<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <!-- Page Title -->
                <h1 class="text-4xl font-extrabold text-main-dark italic mb-1">Stock Addition History</h1>

                <!-- Search Icon and Bar -->
                <div class="px-2 relative">
                    <button
                        id="toggle-search-icon"
                        class="text-main-dark hover:text-main-light transition text-2xl"
                    >
                        <i class="fas fa-search"></i>
                    </button>

                    <form id="search-bar" action="{{ route('stock.history') }}" method="GET"
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
                            placeholder="Search stock additions..."
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
        </div>

        <!-- Search Results Message -->
        @if(request('search'))
            <div class="mt-4 mb-8 ml-1 flex items-center space-x-2">
                <p class="text-main-dark">
                    Showing results for: <strong>{{ request('search') }}</strong>
                </p>
                <a href="{{ route('stock.history') }}"
                   class="text-accent-dark hover:text-accent-light underline transition duration-200">
                    Clear Search
                </a>
            </div>
        @endif

        <!-- Batch Entries -->
        @foreach($stockAdditions as $batchId => $batchEntries)
            <div x-data="{ open: false }" class="mb-6 border rounded-lg shadow-lg overflow-hidden">
                <!-- Batch Summary -->
                <div class="p-4 bg-gradient-to-r from-main-light to-main-dark flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-white">Batch ID: {{ $batchId }}</p>
                        <p class="text-sm text-white opacity-75">Added by: {{ $batchEntries->first()->user->name }} | Date: {{ $batchEntries->first()->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                    <button @click="open = !open" class="text-white hover:text-main-light focus:outline-none">
                        <span x-show="!open">View Details</span>
                        <span x-show="open">Hide Details</span>
                    </button>
                </div>

                <!-- Expandable Batch Details -->
                <div x-show="open" class="p-4 bg-white border-t">
                    <table class="min-w-full table-auto text-sm">
                        <thead>
                        <tr class="text-gray-700 uppercase bg-gray-100">
                            <th class="px-6 py-3 text-left">Product</th>
                            <th class="px-6 py-3 text-left">Initial Amount</th>
                            <th class="px-6 py-3 text-left">Quantity Added</th>
                            <th class="px-6 py-3 text-left">Final Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($batchEntries as $entry)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 border-t">{{ $entry->product->name }}</td>
                                <td class="px-6 py-4 border-t">{{ $entry->initial_amount }}</td>
                                <td class="px-6 py-4 border-t">+{{ $entry->quantity_added }}</td>
                                <td class="px-6 py-4 border-t">{{ $entry->final_amount }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
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
