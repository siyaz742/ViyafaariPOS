<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    // Show all vendors
    public function index(Request $request)
    {
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'asc');
        $search = $request->input('search', '');

        if ($this->isAuthorized('V1')) {
            $vendors = Vendor::withTrashed()
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%")
                        ->orWhere('address', 'like', "%$search%");
                })
                ->orderBy($sortField, $sortDirection)
                ->get();

            return view('vendors.index', compact('vendors', 'sortField', 'sortDirection', 'search'));
        }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }



    // Show form to create a new vendor
    public function create()
    {
        if ($this->isAuthorized('V2')) {
            return view('vendors.create');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Store a new vendor
    public function store(Request $request)
    {
        if ($this->isAuthorized('V2')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:vendors',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
            ]);

            Vendor::create($validatedData);

            return redirect()->route('vendors.index')->with('success', 'Vendor created successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Show form to edit an existing vendor
    public function edit(Vendor $vendor)
    {
        if ($this->isAuthorized('V3')) {
            return view('vendors.edit', compact('vendor'));
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Update vendor details
    public function update(Request $request, Vendor $vendor)
    {
        if ($this->isAuthorized('V3')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:vendors,email,' . $vendor->id,
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
            ]);

            $vendor->update($validatedData);

            return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    // Delete a vendor
    public function destroy(Vendor $vendor)
    {
        if ($this->isAuthorized('V4')) {
            $vendor->delete();
            return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    public function restore($id)
    {
        if ($this->isAuthorized('V5')) {
            $vendor = Vendor::withTrashed()->findOrFail($id);
            $vendor->restore();

            return redirect()->route('vendors.index')->with('success', 'Vendor restored successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

}
