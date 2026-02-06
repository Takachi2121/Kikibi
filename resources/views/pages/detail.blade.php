@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/detail.css') }}">

<div class="container mt-5 mb-5">

    <!-- Back -->
    <a href="{{ route('etalase') }}" class="text-decoration-none font-arial fw-semibold text-muted">
        <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke List Hadiah
    </a>

    <div class="row mt-1 g-5">

        <!-- LEFT : IMAGE -->
        <div class="col-lg-6 mt-4">
            <div class="position-relative">
                <img src="{{ asset('assets/img/Produk/' . $data->foto_1) }}"
                     class="img-fluid w-100 rounded-4">

                <!-- Favorit -->
                <span class="badge  font-arial position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill" style="background-color: #00C950">
                    <i class="fa-solid fa-medal me-1"></i> UMKM Terverifikasi
                </span>
            </div>

            <!-- Thumbnails -->
            <div class="d-flex gap-2 mt-3 overflow-hidden w-100">
                @for ($i = 1; $i < 6; $i++)
                    <img src="{{ asset('assets/img/Produk/' . $data->{'foto_' . $i}) }}"
                         class="img-thumbnail rounded-3 thumb-img" width="115" height="115">
                @endfor
            </div>
        </div>

        <!-- RIGHT : DETAIL -->
        <div class="col-lg-6 mt-4">

            <span class="badge bg-light font-arial text-danger rounded-pill px-3 py-2">
                {{ $data->kategori->nama_kategori }}
            </span>

            <h2 class="mt-3 fw-semibold font-arial">{{ $data->nama_produk }}</h2>

            <!-- Rating -->
            <div class="d-flex align-items-center mb-3">
                <div class="text-warning me-2">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <small class="text-muted font-arial">(4.0 / 5.0)</small>
            </div>

            <!-- Harga -->
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">
                    <small class="text-muted font-arial">Harga</small>
                    <h3 class="text-danger mt-1 font-arial">Rp {{ number_format($data->harga, 0, ',', '.') }}</h3>
                </div>
            </div>

            <!-- Deskripsi -->
            <h6 class="fw-semibold font-arial">Deskripsi Singkat</h6>
            <p class="text-muted font-arial">
                {{ $data->deskripsi }}
            </p>

            <!-- Makna -->
            <div class="p-4 rounded-4 mb-3 shadow-sm" style="background:#D9E1F1">
                <h6 class="fw-semibold font-arial">
                    <i class="fa-regular fa-heart me-2 text-danger"></i>Makna Hadiah Ini
                </h6>
                <p class="mb-0 text-muted font-arial">
                    {{ $data->kategori->makna_hadiah }}
                </p>
            </div>

            <!-- Momen -->
            <h6 class="fw-semibold mb-2">Cocok untuk Momen</h6>
            <div class="d-flex flex-wrap gap-2 mt-3 mb-4">
                @foreach (explode(',', $data->untuk_momen) as $momen)
                    <span class="badge bg-danger text-white px-4 py-3 rounded-pill font-arial">{{ $momen }}</span>
                @endforeach
            </div>

            <!-- Estimasi -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-4 h-100">
                        <i class="fa-solid fa-truck-fast text-primary me-2"></i>
                        <small class="font-arial">Estimasi Pengiriman<br><b>2-3 hari kerja</b></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-success-subtle rounded-4 h-100">
                        <i class="fa-solid fa-shield text-success me-2"></i>
                        <small class="font-arial">Jaminan Kualitas<br><b>100% Original</b></small>
                    </div>
                </div>
            </div>

            <!-- Qty -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <span class="fw-medium font-arial">Jumlah</span>

                <div class="qty-wrapper">
                    <button class="qty-btn minus font-arial">−</button>
                    <span class="qty-number font-arial">1</span>
                    <button class="qty-btn plus font-arial">+</button>
                </div>
            </div>

            <!-- Action -->
            <a href="https://wa.me/6285233899868?text={{ urlencode('Permisi kak, saya ingin membeli ' . $data->nama_produk . ' untuk memberikan kejutan di momen spesial. Mohon informasinya, ya!') }}" target="_blank" class="btn btn-danger w-100 rounded-4 py-3 mb-3 fw-semibold d-flex justify-content-center align-items-center gap-2 font-arial">
                <i class="fa-brands fa-whatsapp fs-5"></i>
                Pesan via WhatsApp
            </a>

            {{-- <button class="btn btn-outline-dark w-100 rounded-4 py-3 fw-semibold d-flex justify-content-center align-items-center gap-2 font-arial">
                <i class="fa-regular fa-heart"></i>
                Simpan ke Wishlist
            </button> --}}

            <!-- Note WhatsApp -->
            <div class="alert alert-danger-subtle mt-3 p-3 rounded-4" style="background-color: #FFE5EC">
                <div class="d-flex gap-2">
                    <i class="fa-regular fa-comment-dots mt-1" style="color: #6B0702"></i>
                    <small class="font-arial">
                        <b style="color:#6B0702">Pemesanan via WhatsApp:</b><br>
                        Klik tombol di atas untuk langsung chat dengan vendor.
                        Diskusikan detail produk, ketersediaan, dan metode pembayaran secara langsung.
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
