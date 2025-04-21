<x-app-layout>
    <div class="container mx-auto px-6 py-8">

        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <h1 class="text-4xl font-extrabold text-main-dark italic mb-1">Edit User</h1>
            </div>
            <a href="{{ route('users.index') }}"
               class="bg-main-light text-white px-6 py-2 rounded-full shadow-sm hover:bg-main-dark75 transition duration-300 ease-in-out">
                Back to Users
            </a>
        </div>

        <!-- Edit Form -->
        <div class="mt-8 py-6 rounded-lg">
            <form action="{{ route('users.update', $user) }}" method="POST" >
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">Name</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light" value="{{ old('name', $user->name) }}" required>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light" value="{{ old('email', $user->email) }}" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label for="role" class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">Role</label>
                    <select id="role" name="role" class="w-full px-4 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark border-gray-300 rounded-b-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light" required>
                        <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Owner" {{ old('role', $user->role) == 'Owner' ? 'selected' : '' }}>Owner</option>
                        <option value="Manager" {{ old('role', $user->role) == 'Manager' ? 'selected' : '' }}>Manager</option>
                        <option value="Cashier" {{ old('role', $user->role) == 'Cashier' ? 'selected' : '' }}>Cashier</option>
                        <option value="Staff" {{ old('role', $user->role) == 'Staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>


                <!-- Permissions -->
                @php
                    $permissionCategories = [
                        'Customers' => [
                            'C1' => 'View customer list',
                            'C2' => 'Add new customers',
                            'C3' => 'Edit customer details',
                            'C4' => 'Delete customer',
                            'C5' => 'Restore deleted customer',
                        ],
                        'Orders' => [
                            'O1' => 'View order list',
                            'O2' => 'Create new order',
                            'O3' => 'View order details',
                        ],
                        'Products' => [
                            'P1' => 'View product list',
                            'P2' => 'Add new products',
                            'P3' => 'Edit product details',
                            'P4' => 'Delete product',
                            'P5' => 'Restore deleted product',
                            'P6' => 'Stock management',
                        ],
                        'Reports' => [
                            'R1' => 'View reports',
                        ],
                        'Users' => [
                            'U1' => 'View user list',
                            'U2' => 'Add new users',
                            'U3' => 'Edit user details',
                            'U4' => 'Delete user',
                            'U5' => 'Restore deleted user',
                        ],
                        'Vendors' => [
                            'V1' => 'View vendor list',
                            'V2' => 'Add new vendors',
                            'V3' => 'Edit vendor details',
                            'V4' => 'Delete vendor',
                            'V5' => 'Restore deleted vendor',
                        ],
                    ];
                @endphp

                <div class="mb-6">
                    <label class="block bg-gradient-to-l from-main-light75 to-main-dark75 text-white pl-3 py-1 rounded-t-lg font-semibold">Permissions</label>
                    <div class="bg-white bg-opacity-70 rounded-b-lg px-2 py-2">
                        <div class="grid grid-cols-6 gap-1">
                            @foreach ($permissionCategories as $category => $permissions)
                                <div class="p-2 rounded-lg">
                                    <h3 class="text-md font-bold text-main-dark mb-2">{{ $category }}</h3>
                                    <div class="space-y-1">
                                        @foreach ($permissions as $code => $description)
                                            <div class="flex items-start">
                                                <input type="checkbox" id="permission_{{ $code }}" name="permissions[]" value="{{ $code }}" {{ in_array($code, old('permissions', $user->permissions ?? [])) ? 'checked' : '' }} class="mt-1  border-2 border-gray-300 rounded-xl bg-white hover:border-x-main-dark75  hover:checked:bg-main-dark75 checked:bg-accent-dark85 checked:border-accent-dark85 focus:ring-2 focus:ring-accent-dark85 focus:ring-offset-2">
                                                <label for="permission_{{ $code }}" class="ml-2 text-sm text-main-dark">
                                                    <span class="font-semibold">{{ $code }}</span> - {{ $description }}
                                                </label>
                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-main-light text-white px-6 py-2 rounded-full shadow-md hover:bg-main-dark75 transition duration-300 ease-in-out mt-5">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
