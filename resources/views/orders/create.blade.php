<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <h1 class="text-4xl font-extrabold text-main-dark italic mb-1">Create New Order</h1>
            </div>
            <a href="{{ route('orders.index') }}"
               class="bg-main-light text-white px-6 py-2 rounded-full shadow-sm hover:bg-main-dark75 transition duration-300 ease-in-out">
                View Orders
            </a>
        </div>

        <!-- Order Form -->
        <div class="mt-8 py-6 rounded-lg">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <!-- Customer Selection -->
                <div class="mb-6">
                    <label for="customer_id" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">Select Customer</label>
                    <select name="customer_id" id="customer_id" class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                    border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light" required>
                        <option value="" disabled selected>-- Select Customer --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Employee Selection -->
                <div class="mb-6">
                    <label for="employee_id" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">Employee</label>
                    <input type="text" value="{{ auth()->user()->name }}" class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                    border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light" readonly>
                    <input type="hidden" name="employee_id" value="{{ auth()->user()->id }}">
                </div>




                <!-- Product List -->
                <div class="mb-6">
                    <div class="flex justify-between bg-gradient-to-l from-main-light75 to-main-dark75 items-center p-2 rounded-lg">
                        <label for="products" class="block  text-white pl-3 py-1 rounded-t-lg font-semibold">Products</label>
                        <button type="button" id="add-product-btn" class="bg-white text-main-dark text-sm px-4 py-1 rounded-full shadow-sm hover:bg-main-verylight transition duration-300 ease-in-out">
                            + Add Product
                        </button>
                    </div>

                    <div>
                        <div class="flex items-start bg-gradient-to-l from-accent-light to-accent-dark gap-0 mt-2 py-1 rounded-lg ">
                            <div class="flex-[5]">
                                <label class="block text-sm font-semibold text-white mb-1 pl-5">Product Name</label>
                            </div>

                            <div class="flex-[2] text-center ">
                                <label  class="block text-sm font-semibold text-white mb-1">Unit Price</label>
                            </div>

                            <div class="flex-[1] text-center">
                                <label  class="block text-sm font-semibold text-white mb-1">Discount (%)</label>
                            </div>

                            <div class="flex-[2] text-center">
                                <label class="block text-sm font-semibold text-white mb-1">Discounted Price</label>
                            </div>

                            <div class="flex-[1] text-center">
                                <label class="block text-sm font-semibold text-white mb-1">Quantity</label>
                            </div>

                            <div class="flex-[2] text-center">
                                <label class="block text-sm font-semibold text-white mb-1">Item Total</label>
                            </div>

                            <div class="flex-[1] text-center">
                                <label class="block text-sm font-semibold text-white mb-1">Action</label>
                            </div>
                        </div>
                    </div>


                    <div id="products-list">
                        <!-- Dynamic product rows will be added here -->
                    </div>
                </div>

                <!-- Total Amount -->
                <div class="mb-6">
                    <label for="total" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">Total Amount</label>
                    <input type="text" name="total" id="total" readonly class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                    border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light">
                </div>

                <!-- Payment Method -->
                <div class="mb-6">
                    <label for="payment_method" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                    border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light">
                        <option value="Cash">Cash</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-main-light text-white  px-6 py-2 rounded-full shadow-md hover:bg-main-dark75 transition duration-300 ease-in-out mt-5">
                        Create Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Hidden template for dynamic product rows --}}
    <script id="product-row-template" type="text/template">
        <div class="order-item flex items-start gap-0 my-1 p-0 rounded-lg">
            <!-- Product (flex-grow for 3-column width) -->
            <div class="flex-[5]  ">

                <select name="product_ids[]" class="form-select w-full pl-5 product-select text-main-dark p-2 rounded-l-lg border-none  bg-white bg-opacity-90">
                    <option value="">-- Select Product --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}">
                            {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Unit Price -->
            <div class="flex-[2] text-center">

                <input type="text" name="prices[]" class="form-input text-main-dark w-full price text-right pr-4 p-2 border-none  bg-white bg-opacity-70" readonly>
            </div>

            <!-- Discount -->
            <div class="flex-[1] text-center">

                <input type="text" name="discounts[]" class="form-input text-main-dark w-full discount text-center p-2 border-none  bg-white bg-opacity-90" min="0" max="100" value="0" step="1" required
                       oninput="this.value = Math.max(0, Math.min(100, parseInt(this.value) || 0));">
            </div>

            <!-- Discounted Price -->
            <div class="flex-[2] text-center">

                <input type="text" name="discounted_prices[]" class="form-input text-main-dark w-full discounted-price  text-right pr-4 p-2 border-none  bg-white bg-opacity-70" readonly>
            </div>

            <!-- Quantity -->
            <div class="flex-[1] text-center">

                <input type="text" name="quantities[]" class="form-input text-main-dark w-full quantity text-center p-2 border-none  bg-white bg-opacity-90" min="1" value="1" required>
            </div>

            <!-- Item Total -->
            <div class="flex-[2] text-center">

                <input type="text" name="item_totals[]" class="form-input text-main-dark w-full item-total  text-right pr-4 p-2 border-none  bg-white bg-opacity-70" readonly>
            </div>

            <!-- Action -->
            <div class="flex-[1] bg-white bg-opacity-70 rounded-r-lg text-center">

                <button type="button" class="remove-product-btn btn  text-red-500 mx-2 px-4 my-1 py-1 rounded-full shadow-sm hover:text-red-400 transition duration-300 ease-in-out">
                    Remove
                </button>

            </div>
        </div>

    </script>


    <script>
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.order-item').forEach(function(item) {
                const itemTotal = parseFloat(item.querySelector('.item-total').value) || 0;
                total += itemTotal;
            });
            document.getElementById('total').value = total.toFixed(2);
        }

        function updateItemTotal(item) {
            const price = parseFloat(item.querySelector('.price').value) || 0;
            const discount = parseFloat(item.querySelector('.discount').value) || 0;
            const quantity = parseFloat(item.querySelector('.quantity').value) || 1;

            // Calculate the disconuted price
            const discountedPrice = price - (price * (discount / 100));
            // Set the discounted price in the corresponding input field
            item.querySelector('.discounted-price').value = discountedPrice.toFixed(2);

            // Calculate the item total (after discount)
            const itemTotal = discountedPrice * quantity;
            item.querySelector('.item-total').value = itemTotal.toFixed(2);

            // Recalculate the overall total
            calculateTotal();
        }

        function updatePrice(item) {
            const selectedProduct = item.querySelector('.product-select option:checked');
            const price = selectedProduct ? parseFloat(selectedProduct.getAttribute('data-price')) : 0;
            item.querySelector('.price').value = price.toFixed(2);
            updateItemTotal(item);
        }

        function checkStockQuantity(item) {
            const selectedProduct = item.querySelector('.product-select option:checked');
            const stockQuantity = parseInt(selectedProduct.getAttribute('data-stock')) || 0;
            const enteredQuantity = parseInt(item.querySelector('.quantity').value) || 0;

            if (enteredQuantity > stockQuantity) {
                alert('The entered quantity exceeds available stock.');
                item.querySelector('.quantity').value = stockQuantity; // Set quantity to maximum available stock
            }
        }

        // Add new product row on button click
        document.getElementById('add-product-btn').addEventListener('click', function() {
            let template = document.getElementById('product-row-template').innerHTML;
            document.getElementById('products-list').insertAdjacentHTML('beforeend', template);
            updateProductOptions();
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                const orderItem = e.target.closest('.order-item');
                updatePrice(orderItem); // Update the price for the newly selected product
                updateProductOptions(); // Update the options to reflect selected products and stock status
            }
        });

        // Update options when a product is removed
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-product-btn')) {
                e.target.closest('.order-item').remove();
                calculateTotal();
            }
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity') || e.target.classList.contains('discount')) {
                const orderItem = e.target.closest('.order-item');
                updateItemTotal(orderItem); // Recalculate the item total when quantity or discount changes
            }
        });

        // Ensuring product options dont repeat for multiple rows
        function updateProductOptions() {
            const selectedProductIds = [];
            document.querySelectorAll('.product-select').forEach(function(select) {
                const selectedValue = select.value;
                select.querySelectorAll('option').forEach(function(option) {
                    option.disabled = selectedProductIds.includes(option.value);
                });
                selectedProductIds.push(selectedValue);
            });
        }
    </script>
</x-app-layout>
