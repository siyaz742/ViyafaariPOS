<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Show all orders
    public function index(Request $request)
    {
        $sortField = $request->input('sort', 'invoice_date');
        $sortDirection = $request->input('direction', 'desc');
        $search = $request->input('search', '');

        if ($this->isAuthorized('O1')) {
            $orders = Order::with('customer', 'employee', 'orderItems.product')
                ->where(function ($query) use ($search) {
                    // Search by order ID
                    $query->where('id', 'like', "%$search%")
                        // Search by customer name
                        ->orWhereHas('customer', function ($subQuery) use ($search) {
                            $subQuery->where('name', 'like', "%$search%");
                        })
                        // Search by employee name
                        ->orWhereHas('employee', function ($subQuery) use ($search) {
                            $subQuery->where('name', 'like', "%$search%");
                        });

                    // Search by invoice_date if the search term is a valid date
                    if (strtotime($search)) {
                        $query->orWhere('invoice_date', $search);
                    }
                })
                ->orderBy($sortField, $sortDirection)
                ->get();

            return view('orders.index', compact('orders', 'sortField', 'sortDirection', 'search'));
        }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }



    // Show the form for creating a new order
    public function create()
    {
        if ($this->isAuthorized('O2')) {
            $customers = Customer::all();
            $employees = User::all();
            $products = Product::all();

            return view('orders.create', compact('customers', 'employees', 'products'));
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Store a new order
    public function store(Request $request)
    {
        if ($this->isAuthorized('O2')) {
            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'employee_id' => 'required|exists:users,id',
                'product_ids' => 'required|array',
                'product_ids.*' => 'required|exists:products,id',
                'quantities' => 'required|array',
                'quantities.*' => 'required|integer|min:1',
                'prices' => 'required|array',
                'prices.*' => 'required|numeric|min:0.01',
                'discounts' => 'required|array',
                'discounts.*' => 'required|numeric|min:0|max:100',
                'item_totals' => 'required|array',
                'item_totals.*' => 'required|numeric|min:0',
                'payment_method' => 'required|string',
            ]);

            // Check if quantities exceed stock
            foreach ($request->product_ids as $index => $productId) {
                $product = Product::find($productId);
                $quantity = $request->quantities[$index];

                if ($quantity > $product->stock_quantity) {
                    return back()->withErrors(['quantities' => 'The quantity for ' . $product->name . ' exceeds available stock.']);
                }
            }

            // Create the order
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'employee_id' => auth()->user()->id,
                'invoice_date' => now()->toDateString(),
                'invoice_time' => now()->toTimeString(),
                'payment_method' => $request->payment_method,
                'total' => 0,
            ]);

            // Create order items and calculate total
            $totalAmount = 0;

            foreach ($request->product_ids as $index => $productId) {
                $product = Product::find($productId);
                $quantity = $request->quantities[$index];
                $discount = $request->discounts[$index];
                $itemTotal = $request->item_totals[$index];
                $subtotal = $itemTotal;

                // Add to total
                $totalAmount += $subtotal;

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'item_sale_price' => $product->price,
                    'quantity' => $quantity,
                    'discount' => $discount,
                    'item_total' => $itemTotal,
                ]);

                // Update product stock
                $product->stock_quantity -= $quantity;
                $product->save();
            }

            // Update the total amount in the order
            $order->total = $totalAmount;
            $order->save();


            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Show a single order
    public function show(Order $order)
    {
        if ($this->isAuthorized('O3')) {
            $order->load('customer', 'employee', 'orderItems.product');
            return view('orders.show', compact('order'));
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }
}
