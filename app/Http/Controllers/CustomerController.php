<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // Show all customers
    public function index(Request $request)
    {
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'asc');
        $search = $request->input('search', '');

        if ($this->isAuthorized('C1')) {
            $customers = Customer::withTrashed()
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%")
                        ->orWhere('address', 'like', "%$search%")
                        ->orWhere('tin', 'like', "%$search%");
                })
                ->orderBy($sortField, $sortDirection)
                ->get();

            return view('customers.index', compact('customers', 'sortField', 'sortDirection', 'search'));
        }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }


    // Show form to create a new customer
    public function create()
    {
        if ($this->isAuthorized('C2')) {
            return view('customers.create');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Store a new customer
    public function store(Request $request)
    {
        if ($this->isAuthorized('C2')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'tin' => 'nullable|string|max:20',
            ]);

            Customer::create($validatedData);

            return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Show form to edit an existing customer
    public function edit(Customer $customer)
    {
        if ($this->isAuthorized('C3')) {
            return view('customers.edit', compact('customer'));
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Update customer details
    public function update(Request $request, Customer $customer)
    {
        if ($this->isAuthorized('C3')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email,' . $customer->id,
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'tin' => 'nullable|string|max:20',
            ]);

            $customer->update($validatedData);

            return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Delete a customer
    public function destroy(Customer $customer)
    {
        if ($this->isAuthorized('C4')) {
            $customer->delete();
            return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    public function restore($id)
    {
        if ($this->isAuthorized('C5')) {
            $customer = Customer::withTrashed()->findOrFail($id);
            $customer->restore();

            return redirect()->route('customers.index')->with('success', 'Customer restored successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

}

