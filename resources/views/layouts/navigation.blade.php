<nav class="w-64 h-screen bg-white border-r border-gray-200 flex flex-col px-4 pl-7 sticky top-0 bg-cover bg-center" style="background-image: url({{ asset('storage/images/93.png') }})">

<!-- Logo -->
    <div class="shrink-0 flex items-center px-2 pt-8 pb-4">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex flex-col mt-2" >

        <x-nav-link2 :href="route('orders.create')" :active="request()->routeIs('orders.create')" class="font-semibold px-0 mt-2 mb-1 italic text-xl text-accent-dark">
            {{ __('Make a Sale!') }}
        </x-nav-link2>
{{--        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">--}}
{{--            {{ __('Dashboard') }}--}}
{{--        </x-nav-link>--}}
        <h3 class="font-semibold mt-4 text-accent-dark">Customers</h3>
        <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.index')" class="pl-4">
            {{ __('Customers List') }}
        </x-nav-link>
        <x-nav-link :href="route('customers.create')" :active="request()->routeIs('customers.create')" class="pl-4">
            {{ __('Add New Customer') }}
        </x-nav-link>

        <h3 class="font-semibold mt-4 text-accent-dark">Vendors</h3>
        <x-nav-link :href="route('vendors.index')" :active="request()->routeIs('vendors.index')" class="pl-4">
            {{ __('Vendors List') }}
        </x-nav-link>
        <x-nav-link :href="route('vendors.create')" :active="request()->routeIs('vendors.create')" class="pl-4">
            {{ __('Add New Vendor') }}
        </x-nav-link>

        <h3 class="font-semibold mt-4 text-accent-dark">Products</h3>
        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" class="pl-4">
            {{ __('Products List') }}
        </x-nav-link>
        <x-nav-link :href="route('products.create')" :active="request()->routeIs('products.create')" class="pl-4">
            {{ __('Add New Product') }}
        </x-nav-link>
        <x-nav-link :href="route('stock.batchAddStockForm')" :active="request()->routeIs('stock.batchAddStockForm')" class="pl-4">
            {{ __('Add Stock') }}
        </x-nav-link>
        <x-nav-link :href="route('stock.history')" :active="request()->routeIs('stock.history')" class="pl-4">
            {{ __('Stock History') }}
        </x-nav-link>

        <h3 class="font-semibold mt-4 text-accent-dark">Orders</h3>
        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')" class="pl-4">
            {{ __('Orders List') }}
        </x-nav-link>
        <x-nav-link :href="route('orders.create')" :active="request()->routeIs('orders.create')" class="pl-4">
            {{ __('Create New Order') }}
        </x-nav-link>

        <h3 class="font-semibold mt-4 text-accent-dark">Reports</h3>
        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" class="pl-4">
            {{ __('Reports') }}
        </x-nav-link>

        <h3 class="font-semibold mt-4 text-accent-dark">User Management</h3>
        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="pl-4">
            {{ __('Users List') }}
        </x-nav-link>
        <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="pl-4">
            {{ __('Create New User') }}
        </x-nav-link>

    </div>

{{--    <div class="flex flex-col space-y-2 mt-4">--}}
{{--        --}}{{--        @if(Auth::check() && (Auth::user()->role === 'Admin' || Auth::user()->role === 'Manager'))--}}
{{--        --}}{{--            <x-nav-link :href="url('/manage-inventory')" :active="request()->is('manage-inventory')">--}}
{{--        --}}{{--                Manage Inventory--}}
{{--        --}}{{--            </x-nav-link>--}}
{{--        --}}{{--            <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')">--}}
{{--        --}}{{--                {{ __('Reports') }}--}}
{{--        --}}{{--            </x-nav-link>--}}
{{--        --}}{{--        @endif--}}

{{--        --}}{{--        @if(Auth::check() && Auth::user()->role === 'Admin')--}}
{{--        --}}{{--            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">--}}
{{--        --}}{{--                {{ __('User Management') }}--}}
{{--        --}}{{--            </x-nav-link>--}}
{{--        --}}{{--        @endif--}}
{{--    </div>--}}

    <!-- Profile Section -->
    <div x-data="{ open: false }" class="flex flex-col mt-auto mb-4 relative">
        <!-- Button to toggle the dropdown -->
        <button @click="open = !open" class="flex items-center space-x-2 px-2 py-2 text-accent-dark hover:text-accent-light focus:outline-none transition">
            <div class="text-accent-dark font-semibold">{{ Auth::user()->name }}</div>
            <svg :class="{ 'rotate-180': !open }" class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Hidden content that appears above the button when toggled -->
        <div x-show="open" x-transition class="bg-white bg-opacity-70 rounded-lg absolute bottom-full left-1 px-3 pb-3 pt-2 w-28">
            <a href="{{ route('profile.edit') }}" class="text-sm text-accent-dark hover:text-accent-light">
                {{ __('Profile') }}
            </a>
            <form method="POST" action="{{ route('logout') }}" class="text-sm">
                @csrf
                <button type="submit" class="text-accent-dark hover:text-accent-light mt-2">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>



</nav>
