<header class="content-header">
    {{-- Bagian Kiri: Judul Halaman --}}
    <h4 class="fw-bold mb-0">@yield('page-title', 'Dashboard')</h4>

    {{-- Bagian Kanan: Search, Notifikasi, Profil --}}
    <div class="d-flex align-items-center gap-3">
        <div class="input-group">
            <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control bg-light border-0" placeholder="Search...">
        </div>
        <a href="#" class="text-secondary fs-5"><i class="fas fa-bell"></i></a>
        
        <div class="user-profile">
            <img src="https://i.pravatar.cc/150?u=admin" alt="User Avatar" class="header-profile-image">
        </div>
    </div>
</header>