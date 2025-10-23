<aside class="sidebar">
    <a href="{{ route('dashboard') }}" class="brand">Mofu Cafe</a>

    <nav class="sidebar-nav">
        <div class="nav-title">Menu</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home-alt"></i> Dashboard
        </a>
        <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i> Transaksi
        </a>
        
        <div class="nav-title">Management</div>
        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="fas fa-mug-hot"></i> Products
        </a>
        <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            <i class="fas fa-truck-fast"></i> Supplier
        </a>
        <a href="{{ route('category.index') }}" class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i> Category
        </a>
    </nav>
    
    <div class="sidebar-footer">
        {{-- Nanti bisa ditambahkan menu logout, dll. --}}
    </div>
</aside>