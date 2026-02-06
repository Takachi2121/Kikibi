<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
  <div class="container">

    <!-- Brand kiri -->
    <a class="navbar-brand d-flex align-items-center gap-2" href="#">
      <img src="{{ asset('assets/img/logo.png') }}" width="56" />
      <div class="d-none d-md-block lh-1">
        <div class="fw-bold" style="font-size: 20px; font-family: Arial !important;">Kikibi.id</div>
        <small class="text-muted" style="font-size: 12px; font-family: Arial !important;">Kirim Kirim Bingkisan</small>
      </div>
    </a>

    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- COLLAPSE -->
    <div class="collapse navbar-collapse w-100" id="navbarNav">

      <!-- MENU TENGAH -->
    <ul class="navbar-nav mx-auto gap-3 my-sm-4 text-end {{ Auth::check() ? 'pe-lg-5 pe-sm-0' : 'ps-lg-4 ps-sm-0' }}">
        <li class="nav-item"><a class="nav-link py-sm-0 fw-normal {{ $active === 'home' ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
        <li class="nav-item"><a class="nav-link py-sm-0 fw-normal {{ $active === 'ai' ? 'active' : '' }}" href="{{ route('ai-kikibi') }}">AI Rekomendasi</a></li>
        <li class="nav-item"><a class="nav-link py-sm-0 fw-normal {{ Auth::check() ? 'pe-lg-5 pe-sm-0' : '' }} {{ $active === 'produk' ? 'active' : '' }} pe-0" href="{{ route('etalase') }}">Etalase Kikibi</a></li>
    </ul>

      <!-- TOMBOL KANAN -->
      <div class="d-lg-flex mx-lg-0 mx-sm-auto text-sm-end gap-2">
        @auth
            <div class="dropdown">
                <button class="fw-semibold btn-daftar rounded-5 border-0 text-decoration-none dropdown-toggle"
                        type="button"
                        id="menuUser"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                    {{ Auth::user()->nama_lengkap }}
                </button>

                <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="menuUser">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item position-relative ps-5">
                                <i class="fa-solid fa-arrow-right-from-bracket position-absolute top-50 translate-middle-y"
                                style="left: 20px"></i>
                                Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-danger btn-masuk rounded-pill px-4">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-danger rounded-pill btn-daftar px-4">Daftar</a>
        @endauth
      </div>

    </div>
  </div>
</nav>
