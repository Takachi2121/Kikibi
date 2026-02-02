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
      <ul class="navbar-nav mx-auto ps-4 gap-3">
        <li class="nav-item"><a class="nav-link fw-normal active" href="#">Beranda</a></li>
        <li class="nav-item"><a class="nav-link fw-normal" href="#">AI Rekomendasi</a></li>
        <li class="nav-item"><a class="nav-link fw-normal pe-0" href="#">Kontak Kami</a></li>
      </ul>

      <!-- TOMBOL KANAN -->
      <div class="d-flex gap-2">
        <a href="#" class="btn btn-outline-danger btn-masuk rounded-pill px-4">Masuk</a>
        <a href="#" class="btn btn-danger rounded-pill btn-daftar px-4">Daftar</a>
      </div>

    </div>
  </div>
</nav>
