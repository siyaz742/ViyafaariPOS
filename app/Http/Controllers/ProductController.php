<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Batch;
use App\Models\StockAddition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Show all products
    public function index(Request $request)
    {
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'asc');
        $search = $request->input('search', '');

        if ($this->isAuthorized('P1')) {
            $products = $sortField === 'vendor_id'
                ? Product::join('vendors', 'products.vendor_id', '=', 'vendors.id')
                    ->withTrashed()
                    ->where(function ($query) use ($search) {
                        $query->where('products.name', 'like', "%$search%")
                            ->orWhere('products.description', 'like', "%$search%")
                            ->orWhere('products.price', 'like', "%$search%")
                            ->orWhere('products.stock_quantity', 'like', "%$search%")
                            ->orWhere('vendors.name', 'like', "%$search%");
                    })
                    ->orderBy('vendors.name', $sortDirection)
                    ->select('products.*')
                    ->get()
                : Product::withTrashed()
                    ->where(function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%")
                            ->orWhere('description', 'like', "%$search%")
                            ->orWhere('price', 'like', "%$search%")
                            ->orWhere('stock_quantity', 'like', "%$search%");
                    })
                    ->orderBy($sortField, $sortDirection)
                    ->get();

            return view('products.index', compact('products', 'sortField', 'sortDirection', 'search'));
        }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }



    // Show form to create a new product
    public function create()
    {
        if ($this->isAuthorized('P2')) {
            $vendors = Vendor::all();
            return view('products.create', compact('vendors'));
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Store a new product
    public function store(Request $request)
    {
        if ($this->isAuthorized('P2')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'vendor_id' => 'required|exists:vendors,id',
            ]);

            Product::create($validatedData);

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Show form to edit an existing product
    public function edit(Product $product)
    {
        if ($this->isAuthorized('P3')) {
            $vendors = Vendor::all();
            return view('products.edit', compact('product', 'vendors'));
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Update product details
    public function update(Request $request, Product $product)
    {
        if ($this->isAuthorized('P3')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'vendor_id' => 'required|exists:vendors,id', // Validate vendor_id
            ]);

            $product->update($validatedData);

            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Delete a product
    public function destroy(Product $product)
    {
        if ($this->isAuthorized('P4')) {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    public function restore($id)
    {
        if ($this->isAuthorized('P5')) {
            $product = Product::withTrashed()->findOrFail($id);
            $product->restore();

            return redirect()->route('products.index')->with('success', 'Product restored successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }



    public function batchAddStockForm()
    {
        if ($this->isAuthorized('P6')) {
            $products = Product::orderBy('name', 'asc')->get();
            return view('stock.add_batch', compact('products'));
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    public function storeBatchStockAddition(Request $request)
    {
        if ($this->isAuthorized('P6')) {
            $request->validate([
                'products.*.id' => 'required|exists:products,id',
                'products.*.quantity_added' => 'required|integer|min:1',
            ]);

            $lastBatchId = StockAddition::max('batch_id');
            $newBatchId = $lastBatchId ? $lastBatchId + 1 : 1;

            foreach ($request->input('products') as $productData) {
                $product = Product::findOrFail($productData['id']);
                $initialAmount = $product->stock_quantity; // Renamed variable
                $finalAmount = $initialAmount + $productData['quantity_added'];

                $product->increment('stock_quantity', $productData['quantity_added']);

                StockAddition::create([
                    'batch_id' => $newBatchId,
                    'product_id' => $product->id,
                    'initial_amount' => $initialAmount, // Renamed field
                    'quantity_added' => $productData['quantity_added'],
                    'final_amount' => $finalAmount,
                    'user_id' => Auth::id(),
                ]);
            }

            return redirect()->route('stock.history')->with('success', 'Stock added successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    public function stockAdditionHistory(Request $request)
    {
        if ($this->isAuthorized('P6')) {
            $search = $request->input('search', '');

            // Retrieve stock additions with the search filter
            $stockAdditionsQuery = StockAddition::with(['product', 'user'])
                ->orderBy('created_at', 'asc');

            // Apply search filter if a search query is provided
            if (!empty($search)) {
                $stockAdditionsQuery->where(function ($query) use ($search) {
                    // Search by product name
                    $query->whereHas('product', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })
                        // Search by user name
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        // Search by batch ID
                        ->orWhere('batch_id', 'like', "%$search%")
                        // Check if the search term is a valid date (in the format YYYY-MM-DD)
                        ->orWhereDate('created_at', '=', $search);
                });
            }

            // Get the stock additions grouped by batch_id
            $stockAdditions = $stockAdditionsQuery->get()->groupBy('batch_id');

            return view('stock.history', compact('stockAdditions', 'search'));
        }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }


}

