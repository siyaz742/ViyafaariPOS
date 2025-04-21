<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <!-- Page Title -->
                <h1 class="text-5xl font-extrabold text-main-dark italic mb-1">Reports</h1>
            </div>
        </div>

        <!-- Reports List -->
        <div class="space-y-6">
            <!-- Total Sales Report -->
            <div x-data="{ open: false }" class="border rounded-lg shadow-lg overflow-hidden">
                <!-- Report Summary -->
                <div class="p-4 bg-gradient-to-r from-main-light to-main-dark flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-white">Total Sales Report</p>
                    </div>
                    <button @click="open = !open" class="text-white hover:text-main-light focus:outline-none">
                        <span x-show="!open">View Details</span>
                        <span x-show="open">Hide Details</span>
                    </button>
                </div>

                <!-- Expandable Report Details -->
                <div x-show="open" class="p-4 bg-white border-t">
                    <p class="text-gray-700">The Total Sales Report provides an overview of the overall sales performance for a specific period. This report aggregates all sales transactions and displays key metrics such as total revenue generated, the number of orders processed, and the average order value. The report can be filtered by date ranges, allowing users to focus on specific time frames for trend analysis or sales comparisons.</p>
                    <a href="{{ route('reports.sales') }}" class="text-blue-600 hover:text-blue-800">View Full Report</a>
                </div>
            </div>

            <!-- Sales Report by Product -->
            <div x-data="{ open: false }" class="border rounded-lg shadow-lg overflow-hidden">
                <!-- Report Summary -->
                <div class="p-4 bg-gradient-to-r from-main-light to-main-dark flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-white">Sales Report by Product</p>
                    </div>
                    <button @click="open = !open" class="text-white hover:text-main-light focus:outline-none">
                        <span x-show="!open">View Details</span>
                        <span x-show="open">Hide Details</span>
                    </button>
                </div>

                <!-- Expandable Report Details -->
                <div x-show="open" class="p-4 bg-white border-t">
                    <p class="text-gray-700">The Sales Report by Product highlights the sales performance of individual products within a specified period. This report includes details such as product names, quantities sold, revenue generated per product, and any applied discounts. It allows helps to identify top-performing items and underperforming products, allowing to make strategic inventory and marketing decisions. Filters like product categories or date ranges can be applied for more detailed analysis.</p>
                    <a href="{{ route('reports.salesByProduct') }}" class="text-blue-600 hover:text-blue-800">View Full Report</a>
                </div>
            </div>

            <!-- Room to add more reports in the future -->
        </div>
    </div>


</x-app-layout>
