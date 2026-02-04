@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/etalase.css') }}">
    <div class="container mt-4">
        <a href="{{ route('home') }}" class="text-decoration-none text-black fs-5 gap-3">
            <i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Kembali
        </a>
        <div class="row align-items-center mt-4">
            <div class="col-6">
                <h1 class="mb-0">Etalase Kikibi</h1>
                <p class="mb-0 text-muted">12 Bingkisan tersedia dari UMKM Terpercaya</p>
            </div>

            <div class="col-6 d-flex justify-content-end">
                <div class="dropdown">
                    <button
                        class="btn bg-white border rounded px-3 py-2 dropdown-toggle"
                        type="button"
                        id="dropdownMenuButton"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-sliders"></i>&nbsp;&nbsp;Urutkan: <span id="filter-etalase">Relevansi</span>
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item active" href="#" data-sort="relevansi">Relevansi</a></li>
                        <li><a class="dropdown-item" href="#" data-sort="harga_asc">Harga Terendah</a></li>
                        <li><a class="dropdown-item" href="#" data-sort="harga_desc">Harga Tertinggi</a></li>
                        <li><a class="dropdown-item" href="#" data-sort="populer">Populer</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            @for ($i = 0; $i < 12; $i++)
            <div class="col-md-3 my-3">
                <a href="{{ route('detail') }}" class="text-decoration-none">
                    <div class="card product-card"
                        data-harga="250000"
                        data-rating="4.7"
                        data-populer="1">
                        <!-- Image -->
                        <div class="position-relative">
                            <img src="{{ asset('assets/img/Produk/Bunga.png') }}" class="card-img-top" alt="Keranjang Bunga Mawar">

                            <!-- Favorit badge -->
                            <span class="badge-favorit">
                                <i class="fa-solid fa-award"></i>&nbsp;&nbsp;Verified
                            </span>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="category-text fw-semibold" style="font-family: Arial !important">Bunga</span>
                                <span class="rating-text">
                                    <i class="fa-solid fa-star text-warning"></i> 4.7
                                </span>
                            </div>

                            <p class="product-title fw-medium" style="font-family: Arial !important">Keranjang Bunga Mawar</p>
                            <p class="product-price fw-medium mb-0" style="font-family: Arial !important">Rp 250.000</p>
                        </div>
                    </div>
                </a>
            </div>
            @endfor
        </div>
    </div>
<script src="{{ asset('assets/js/hadiah.js') }}"></script>
@endsection
