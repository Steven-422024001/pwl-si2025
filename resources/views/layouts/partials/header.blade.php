<nav class="header-nav">
    <a class="navbar-brand" href="{{ route('dashboard') }}">Mofu Cafe</a>

    <div class="nav-links">
        {{-- Ganti onclick dengan href ke route yang benar --}}
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="fa-solid fa-mug-hot"></i> Products
        </a>
        <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            <i class="fa-solid fa-truck-fast"></i> Supplier
        </a>
        <a href="{{ route('category.index') }}" class="{{ request()->routeIs('category.*') ? 'active' : '' }}">
            <i class="fa-solid fa-tags"></i> Category
        </a>
        <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
            <i class="fa-solid fa-receipt"></i> Transaksi
        </a>
    </div>

    <div class="user-profile">
        <img src="https://i.pravatar.cc/150?u=admin" alt="User Avatar">
        <div>
            <span class="user-name">Admin Mofu</span>
            <i class="fa-solid fa-chevron-down ms-1"></i>
        </div>
    </div>
</nav>