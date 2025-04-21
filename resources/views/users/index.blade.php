<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <!-- Page Title -->
                <h1 class="text-5xl font-extrabold text-main-dark italic mb-1">Users</h1>

                <!-- Search Icon and Bar -->
                <div class="px-2 relative">
                    <button
                        id="toggle-search-icon"
                        class="text-main-dark hover:text-main-light transition text-2xl"
                    >
                        <i class="fas fa-search"></i>
                    </button>

                    <form id="search-bar" action="{{ route('users.index') }}" method="GET"
                          class="hidden flex items-center space-x-4">
                        <button
                            type="button"
                            id="close-search-bar"
                            class="text-main-dark hover:text-main-light transition text-2xl"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search users..."
                            class="px-4 py-2 mt-1 border border-main-dark rounded-full text-main-dark focus:ring-2 focus:ring-main-light transition"
                        >
                        <button
                            type="submit"
                            class="bg-main-dark text-white px-4 py-2 mt-1 rounded-full shadow-sm hover:bg-main-light transition"
                        >
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <!-- Add New User Button -->
            <a href="{{ route('register') }}"
               class="bg-main-light text-white px-6 py-2 rounded-full shadow-sm hover:bg-main-dark transition duration-300 ease-in-out">
                Create New User
            </a>
        </div>

        <!-- Search Results Message -->
        @if(request('search'))
            <div class="mt-4 ml-1 flex items-center space-x-2">
                <p class="text-main-dark">
                    Showing results for: <strong>{{ request('search') }}</strong>
                </p>
                <a href="{{ route('users.index') }}"
                   class="text-accent-dark hover:text-accent-light underline transition duration-200">
                    Clear Search
                </a>
            </div>
        @endif

        <!-- Table -->
        <div class="mt-8 overflow-hidden rounded-lg shadow-lg">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden bg-opacity-75">
                <!-- Table Header -->
                <thead class="bg-gradient-to-l from-main-light to-main-dark text-white text-sm uppercase">
                <tr>
                    @foreach ([
                        'id' => 'ID',
                        'name' => 'Name',
                        'email' => 'Email',
                        'role' => 'Role'
                    ] as $field => $label)
                        <th class="px-6 py-3 text-left">
                            <a href="{{ route('users.index', array_merge(request()->all(), ['sort' => $field, 'direction' => ($sortField === $field && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}"
                               class="hover:underline
                                          {{ $sortField === $field ? 'text-accent-light85' : 'text-white' }}
                                          transition duration-200">
                                {{ $label }}
                                @if ($sortField === $field)
                                    @if ($sortDirection === 'asc') ↑ @else ↓ @endif
                                @endif
                            </a>
                        </th>
                    @endforeach
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
                </thead>
                <!-- Table Body -->
                <tbody class="text-main-dark">
                @forelse ($users as $user)
                    @php
                        $trashedClass = $user->trashed() ? 'text-gray-400 bg-gray-100 bg-opacity-0' : '';
                    @endphp
                    <tr class="hover:bg-accent-superlight transition {{ $trashedClass }}">
                        <td class="px-6 py-4 {{ $trashedClass }}">{{ $user->id }}</td>
                        <td class="px-6 py-4 {{ $trashedClass }}">{{ $user->name }}</td>
                        <td class="px-6 py-4 {{ $trashedClass }}">{{ $user->email }}</td>
                        <td class="px-6 py-4 {{ $trashedClass }}">{{ $user->role }}</td>
                        <td class="px-6 py-4 flex space-x-4 justify-center items-center {{ $trashedClass }}">
                            <a href="{{ route('users.edit', $user) }}"
                               class="text-main-light hover:text-main-dark transition duration-200 {{ $trashedClass }}">
                                Edit
                            </a>
                            <form action="{{ $user->trashed() ? route('users.restore', $user->id) : route('users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @if ($user->trashed())
                                    <button type="submit"
                                            class="text-green-600 hover:text-green-800 transition duration-200 {{ $trashedClass }}">
                                        Restore
                                    </button>
                                @else
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-800 transition duration-200 {{ $trashedClass }}">
                                        Delete
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-main-dark">
                            No users found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('toggle-search-icon').addEventListener('click', function () {
            document.getElementById('toggle-search-icon').classList.add('hidden');
            document.getElementById('search-bar').classList.remove('hidden');
        });

        document.getElementById('close-search-bar').addEventListener('click', function () {
            document.getElementById('search-bar').classList.add('hidden');
            document.getElementById('toggle-search-icon').classList.remove('hidden');
        });
    </script>
</x-app-layout>
