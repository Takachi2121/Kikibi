@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/etalase.css') }}">
    <div class="container mt-4">
        <a href="{{ route($isAI ? 'ai-kikibi' : 'home') }}" class="text-decoration-none text-black fs-5 gap-3">
            <i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Kembali
        </a>
        <div class="row align-items-center mt-4">
            @if (
                $isAI &&
                !empty($responseAI) &&
                isset($responseAI['gaya']) &&
                is_array($responseAI['gaya']) &&
                count($responseAI['gaya']) > 0
            )
                <div class="col-12">
                    <h1 class="mb-1">Rekomendasi AI</h1>

                    @if (!empty($responseAI['alasan']))
                        <small class="text-muted d-block mb-1">Alasan rekomendasi:</small>
                        <span>{{ $responseAI['alasan'] }}</span>
                    @endif
                </div>
            @else
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <h1 class="mb-0">Etalase Kikibi</h1>
                    <p class="mb-0 text-muted">
                        {{ $data->count() }} Bingkisan tersedia dari UMKM Terpercaya
                    </p>
                </div>
            @endif


            @if (!$isAI)
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
            @endif
        </div>

        <div class="row mt-3" style="min-height: 48.7dvh">
            @forelse ($data as $produk)
            <div class="col-lg-3 col-md-6 my-3">
                <a href="{{ route('detail', $produk->id) }}" class="text-decoration-none">
                    <div class="card product-card"
                        data-harga="{{ $produk->harga }}">
                        <!-- Image -->
                        <div class="position-relative">
                            <img src="{{ asset('assets/img/Produk/'. $produk->foto_1) }}" class="card-img-top" alt="Keranjang Bunga Mawar">

                            <!-- Favorit badge -->
                            <span class="badge-favorit">
                                <i class="fa-solid fa-award"></i>&nbsp;&nbsp;Verified
                            </span>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="category-text fw-semibold" style="font-family: Arial !important">{{ $produk->kategori->nama_kategori }}</span>
                                <span class="rating-text">
                                    <i class="fa-solid fa-star text-warning"></i> 4.7
                                </span>
                            </div>

                            <p class="product-title fw-medium" style="font-family: Arial !important">{{ $produk->nama_produk }}</p>
                            <p class="product-price fw-medium mb-0" style="font-family: Arial !important">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="text-center mb-0">Produk Belum Tersedia</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
<script src="{{ asset('assets/js/hadiah.js') }}"></script>
@endsection
