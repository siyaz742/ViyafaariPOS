<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'asc');
        $search = $request->input('search', '');

        if ($this->isAuthorized('U1')) {
            $users = User::withTrashed()
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('role', 'like', "%$search%");
                })
                ->orderBy($sortField, $sortDirection)
                ->get();

            return view('users.index', compact('users', 'sortField', 'sortDirection', 'search'));
        }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }


    public function edit(User $user)
    {
        if ($this->isAuthorized('U3')) {
            return view('users.edit', compact('user'));
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    public function update(Request $request, User $user)
    {
        if ($this->isAuthorized('U3')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'role' => 'required|string',
                'permissions' => 'array', // Validate permissions as an array
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'permissions' => $request->permissions, // Save permissions array
            ]);

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
//            return redirect()->route('users.edit', ['user' => 3])->with('success', 'User updated successfully.');

        }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }


    public function destroy(User $user)
    {
        if ($this->isAuthorized('U4')) {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    public function restore($id)
    {
        if ($this->isAuthorized('U5')) {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore();

            return redirect()->route('users.index')->with('success', 'User restored successfully.');
        }
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

}



