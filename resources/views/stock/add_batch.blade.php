<x-app-layout>
    <div class="container mx-auto px-6 py-8">

        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-4xl font-extrabold text-main-dark italic mb-1">Add Stock to Inventory</h1>
        </div>

        <div class="mt-8 py-6">
            <form action="{{ route('stock.storeBatchStockAddition') }}" method="POST" class="">
                @csrf

                <!-- Stock Addition Table -->
                <div class="overflow-x-auto shadow-md rounded-lg bg-white bg-opacity-70">
                    <table class="min-w-full" id="stock-addition-table">
                        <thead class="bg-gradient-to-l from-main-light to-main-dark text-white">
                        <tr>
                            <th class="px-6 py-2 text-left text-sm font-medium">Product</th>
                            <th class="px-6 py-2 text-center text-sm font-medium">Current Stock</th>
                            <th class="px-6 py-2 text-center text-sm font-medium">Quantity to Add</th>
                            <th class="px-6 py-2 text-center text-sm font-medium">Final Stock</th>
                            <th class="px-6 py-2 text-center text-sm font-medium ">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Initial Row for adding a product -->
                        <tr class="">
                            <td class="px-5 py-1">
                                <select name="products[0][id]" class="w-full bg-white bg-opacity-0 p-1 text-main-dark rounded border-none  focus:border-none focus:outline-none focus:ring-0 focus:ring-main-light " required onchange="updateCurrentStock(this); updateDropdownOptions()">
                                    <option value="">-- Select Product --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-stock="{{ $product->stock_quantity }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-0 py-1 text-main-dark  current-stock text-center">0</td>
                            <td class="px-0 py-1 text-main-dark  text-center">
                                <input type="text" name="products[0][quantity_added]" min="1" placeholder="0" required class="w-1/3 bg-white bg-opacity-0 p-1 text-green-600 rounded border text-center border-none focus:border-none focus:outline-none focus:ring-0 focus:ring-main-light" oninput="updateFinalStock(this)">
                            </td>
                            <td class="px-0 py-1 text-main-dark  final-stock text-center">0</td>
                            <td class="px-0 py-1 text-main-dark  text-center">
                                <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700">Remove</button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>

                <!-- Buttons to Add Row and Submit -->
                <div class="flex items-center justify-between mt-6">
                    <button type="button" onclick="addRow()" class="bg-main-dark text-white px-6 py-2 rounded-full shadow-md hover:bg-main-light transition duration-300 ease-in-out">
                        Add Another Product
                    </button>
                    <button type="submit" class="bg-main-light text-white px-6 py-2 rounded-full shadow-md hover:bg-main-dark transition duration-300 ease-in-out mt-5">
                        Submit Stock Additions
                    </button>
                </div>
            </form>
        </div>
    </div>




<script>
        let rowIndex = 1;

        function addRow() {
            const table = document.getElementById('stock-addition-table').getElementsByTagName('tbody')[0];
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="px-5 py-2 ">
                    <select name="products[${rowIndex}][id]" class="product-select w-full bg-white bg-opacity-0 p-1 text-main-dark rounded border-none  focus:border-none focus:outline-none focus:ring-0 focus:ring-main-light " required onchange="updateCurrentStock(this); updateDropdownOptions()">
                        <option value="">-- Select Product --</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" data-stock="{{ $product->stock_quantity }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="px-0 py-1 text-main-dark current-stock text-center">0</td>
                <td class="px-0 py-1 text-main-dark text-center">
                    <input type="text" name="products[${rowIndex}][quantity_added]" min="1" placeholder="0" required class="quantity-to-add w-1/3 bg-white bg-opacity-0 p-1 text-main-dark rounded border text-center border-none focus:border-none focus:outline-none focus:ring-0 focus:ring-main-light" oninput="updateFinalStock(this)">

                </td>
                <td class="px-0 py-1 text-main-dark final-stock text-center">0</td>
                <td class="px-0 py-1 text-main-dark text-center">
                    <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700">Remove</button>
                </td>
            `;
            table.appendChild(newRow);
            rowIndex++;

            updateDropdownOptions();
        }

        function removeRow(button) {
            button.closest('tr').remove();
            updateDropdownOptions();
        }

        function updateCurrentStock(selectElement) {
            const currentStock = selectElement.options[selectElement.selectedIndex].dataset.stock;
            const row = selectElement.closest('tr');
            row.querySelector('.current-stock').innerText = currentStock;
            updateFinalStock(row.querySelector('.quantity-to-add'));
        }

        function updateFinalStock(inputElement) {
            const row = inputElement.closest('tr');
            const currentStock = parseInt(row.querySelector('.current-stock').innerText) || 0;
            const quantityToAdd = parseInt(inputElement.value) || 0;
            const finalStock = currentStock + quantityToAdd;
            row.querySelector('.final-stock').innerText = finalStock;
        }

        function updateDropdownOptions() {
            const selectedProducts = Array.from(document.querySelectorAll('.product-select'))
                .map(select => select.value)
                .filter(value => value);

            document.querySelectorAll('.product-select').forEach(select => {
                Array.from(select.options).forEach(option => {
                    if (selectedProducts.includes(option.value) && option.value !== select.value) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            });
        }
    </script>
</x-app-layout>
