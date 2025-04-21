<x-app-layout>
    <div class="grid grid-cols-2 gap-4">
    <!-- Left Part -->
    <div>
        <div class="container mx-auto px-6 py-8">
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center space-x-2">
                    <h1 class="text-4xl font-extrabold text-main-dark italic mb-1">Order Receipt</h1>
                </div>
            </div>
        </div>

        <div class="p-4">
            <div class="ml-auto flex items-end mb-6">
                <a href="" class="border-pdf-red border-2 bg-white bg-opacity-60 text-pdf-red font-semibold px-10 py-1 mb-0.5 rounded-full shadow-sm hover:bg-pdf-red hover:text-white  transition duration-300 ease-in-out">
                    <i class="fas fa-file-pdf mr-2"></i> Export to PDF
                </a>
            </div>

            <div class="mb-4">
                <label class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">
                    Document Type
                </label>
                <select
                    id="invoiceType"
                    onchange="updateInvoiceType()"
                    class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                        border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light"
                >
                    <option value="INVOICE">Invoice</option>
                    <option value="TAX INVOICE">Tax Invoice</option>
                    <option value="SALES RECEIPT">Sales Receipt</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">
                    Add Note
                </label>
                <textarea
                    type="text"
                    id="inputBox"
                    placeholder="Type something here..."
                    class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                        border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light"
                    oninput="updateDisplay()"
                ></textarea>
            </div>
        </div>


    </div>



    <div>

        <!-- The Document Start -->
        <div class="bg-white mt-2  w-[634px] h-[898px] mx-auto">
            <div class="container mx-auto p-4 bg-white border rounded max-w-2xl">
                <!-- Header Section -->
                <div class="flex justify-between mb-4">
                    <!-- Store Details (Left) -->
                    <div>
                        <div class="inline-block mr-2">
                            <img src="{{ asset('storage/images/SampleCompany.png') }}" class="w-20 h-auto">
                        </div>


                        <div class="inline-block">
                            <h1 class="text-base font-bold">Sample Store</h1>
                            <p class="text-xs">Address: Majeedhee Magu, M. Sample House</p>
                            <p class="text-xs">City: Malé, Maldives</p>
                            <p class="text-xs">Phone: 3322261</p>
                            <p class="text-xs">TIN: 1234560GST501</p>
                        </div>
                    </div>
                    <!-- Invoice Details (Right) -->
                    <div class="text-right">
                        <table class="text-sm">
                            <tr>
                                <td class="px-1"><strong>Invoice No.:</strong></td>
                                <td class="text-left px-1">{{ date('Y', strtotime($order->invoice_date)) . '/' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr>
                                <td class="px-1"><strong>Date:</strong></td>
                                <td class="text-left px-1">{{ $order->invoice_date }}</td>
                            </tr>
                            <tr>
                                <td class="px-1"><strong>Time:</strong></td>
                                <td class="text-left px-1">{{ $order->invoice_time }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Title Section -->
                <h2 id="headerText" class="text-center text-base font-bold mb-6 mt-10">INVOICE</h2>


                <!-- Customer Details -->
                <div class="mb-4">
                    <h3 class="text-sm font-semibold mb-2">Bill to:</h3>
                    <div class="grid grid-cols-8  text-xs">
                        <p class="col-span-1"><strong>Name:</strong></p>
                        <p class="col-span-7">{{ $order->customer->name }}</p>

                        <p class="col-span-1"><strong>Email:</strong></p>
                        <p class="col-span-7">{{ $order->customer->email }}</p>

                        <p class="col-span-1"><strong>Phone:</strong></p>
                        <p class="col-span-7">{{ $order->customer->phone }}</p>

                        <p class="col-span-1"><strong>Address:</strong></p>
                        <p class="col-span-7">{{ $order->customer->address }}</p>

                        <p class="col-span-1"><strong>TIN:</strong></p>
                        <p class="col-span-7">{{ $order->customer->tin ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="mb-4">
                    <h3 class="text-sm font-semibold mt-6 mb-2">Order Items:</h3>
                    <table class="table-auto w-full text-xs border-collapse border border-gray-300">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-1 py-1">#</th>
                            <th class="border border-gray-300 px-1 py-1 text-left">Item</th>
                            <th class="border border-gray-300 px-1 py-1 text-left">Description</th>
                            <th class="border border-gray-300 px-1 py-1">Unit Price</th>
                            <th class="border border-gray-300 px-1 py-1">Qty</th>
                            <th class="border border-gray-300 px-1 py-1">Discount</th>
                            <th class="border border-gray-300 px-1 py-1">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($order->orderItems as $index => $item)
                            <tr>
                                <td class="border border-gray-300 px-1 py-1 text-center">{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-1 py-1">{{ $item->product->name ?? 'N/A' }}</td>
                                <td class="border border-gray-300 px-1 py-1 ">{{ $item->product->description ?? 'No description' }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-right">{{ number_format($item->item_sale_price, 2) }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-center">{{ $item->quantity }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-right">{{ $item->discount ?? '0' }}%</td>
                                <td class="border border-gray-300 px-1 py-1 text-right">{{ number_format($item->item_total, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="displayBox" class=" bg-white border-none">
                    <h3 class="text-xs font-semibold">Note:</h3>
                    <p id="displayText" class="text-xs ml-4"></p>
                </div>

                <!-- Grand Total -->
                <div class="text-right text-xs">
                    {{--            <h3 class="text-sm font-semibold mb-2">Summary:</h3>--}}
                    {{--            <p><strong>Sub Total:</strong> ${{ number_format($order->total, 2) }}</p>--}}
                    {{--            <p><strong>GST (8%):</strong> ${{ number_format($order->total * 0.08, 2) }}</p>--}}
                    {{--            <p><strong>Plastic Bag Fee:</strong> $4.00</p>--}}
                    <p class="text-base "><strong>Invoice Total:</strong> {{ number_format($order->total + ($order->total * 0.08) + 4, 2) }}</p>
                </div>
            </div>
        </div>
        <!-- The Document End -->
    </div>
    </div>

    <script>
        function updateDisplay() {
            const inputBox = document.getElementById('inputBox');
            const displayText = document.getElementById('displayText');
            displayText.textContent = inputBox.value;
        }

        function updateInvoiceType() {
            const selectedValue = document.getElementById('invoiceType').value;
            document.getElementById('headerText').textContent = selectedValue;
        }
    </script>
</x-app-layout>




