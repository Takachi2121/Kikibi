<aside class="sidebar d-flex flex-column p-4" id="sidebar">
    <!-- Logo -->
    <div class="text-center mb-5">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/img/Background/logo-form.png') }}" class="object-fit-contain" width="100" height="100" alt="Logo">
        </a>
    </div>

    <!-- Navigation -->
    <nav class="nav flex-column gap-2 flex-grow-1">
        <p class="text-uppercase text-black-50 small fw-bold mt-3 mb-1">Menu Utama</p>

        <a class="nav-link {{ $active == 'kategori' ? 'active' : '' }}" href="{{ route('admin-dashboard') }}"><i class="fa-solid fa-briefcase me-2"></i> Kategori</a>
        <a class="nav-link {{ $active == 'produk' ? 'active' : '' }}" href="{{ route('admin-produk') }}"><i class="fa-solid fa-box me-2"></i> Produk</a>

        <a class="nav-link {{ $active == 'pesanan' ? 'active' : '' }}" href="{{ route('admin-pesanan') }}"><i class="fa-solid fa-cart-shopping me-2"></i> Pesanan</a>

        <p class="text-uppercase text-black-50 small fw-bold mt-3 mb-1">Menu Tambahan</p>

        <a class="nav-link {{ $active == 'testimoni' ? 'active' : '' }}" href="{{ route('admin-testimoni') }}"><i class="fa-solid fa-lightbulb me-2"></i> Testimoni</a>

        <p class="text-uppercase text-black-50 small fw-bold mt-3 mb-1">Pengaturan</p>

        <a class="nav-link" href=""><i class="fa-solid fa-user me-2"></i> Ubah Profil</a>
        <a class="nav-link" href=""><i class="fa-solid fa-gear me-2"></i> Ubah Password</a>
    </nav>

    <!-- Logout -->
    <div class="mt-auto pt-4">
        <a href="{{ route('logout') }}" class="btn btn-danger w-100">
            <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
        </a>
    </div>
</aside>

<!-- Main Content -->
<main class="flex-grow-1 p-4" style="overflow-y: auto">
    <!-- Header Page -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="fw-bold mb-1">@yield('title')</h1>
            <p class="text-muted mb-0">@yield('subtitle')</p>
        </div>

        <!-- Hamburger (mobile only) -->
        <button class="btn btn-outline-light bg-dark d-md-none" id="menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- Konten halaman -->
    @yield('mainContent')
</main>

<!-- Overlay (untuk mobile) -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const toggleBtn = document.getElementById('menu-toggle');

    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });
</script>

