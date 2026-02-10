<aside class="sidebar d-flex flex-column p-4" id="sidebar">
    <!-- Logo -->
    <div class="text-center mb-5">
        <a href="{{ route('rumahgue') }}">
            <img src="{{ asset('assets/img/logo-login.png') }}" class="object-fit-contain" width="200" alt="Logo">
        </a>
    </div>

    <!-- Navigation -->
    <nav class="nav flex-column gap-2 flex-grow-1">
        <p class="text-uppercase text-black-50 small fw-bold mt-3 mb-1">Menu Utama</p>

        @if (Auth::user()->is_mitra == 1)
            <a class="nav-link" href="{{ route('mitra-home') }}"><i class="fa-solid fa-pencil me-2"></i> Data Diri</a>
            <a class="nav-link" href="{{ route('mitra-portfolio') }}"><i class="fa-solid fa-briefcase me-2"></i> Portofolio</a>
        @elseif(Auth::user()->is_mitra == 2)
            <a class="nav-link" href="{{ route('admin-user') }}"><i class="fa-solid fa-pencil me-2"></i> Data User</a>
            <a class="nav-link" href="{{ route('admin-mitra') }}"><i class="fa-solid fa-briefcase me-2"></i> Data Mitra</a>
        @endif

        <p class="text-uppercase text-black-50 small fw-bold mt-3 mb-1">Pengaturan</p>

        <a class="nav-link" href="{{ route('mitra-settings') }}"><i class="fa-solid fa-gear me-2"></i> Ubah Password</a>
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

