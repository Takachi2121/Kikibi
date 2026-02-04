<link rel="stylesheet" href="{{ asset('assets/css/produk.css') }}">

<section class="rekomendasi-section">
    <div class="container">

        {{-- Rekomendasi Kekasih --}}
        <div class="row mt-5">
            <div class="col-md-6">
                <p class="fw-semibold fs-4 mb-0">Rekomendasi untuk Kekasih</p>
            </div>
            <div class="col-md-6 text-end align-self-center">
                <a href="" class="text-decoration-none text-muted text-end">Lihat Semua...</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card product-card">
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
                            <span class="category-text">Bunga</span>
                            <span class="rating-text">
                                <i class="fa-solid fa-star text-warning"></i> 4.7
                            </span>
                        </div>

                        <p class="product-title">Keranjang Bunga Mawar</p>

                        <p class="product-price">Rp 250.000</p>

                        <a href="{{ route('detail') }}" class="btn btn-detail w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>

        </div>

        {{-- Rekomendasi Orang Tua --}}
        <div class="row mt-5">
            <div class="col-md-6">
                <p class="fw-semibold fs-4 mb-0">Rekomendasi untuk Orang Tua</p>
            </div>
            <div class="col-md-6 text-end align-self-center">
                <a href="" class="text-decoration-none text-muted text-end">Lihat Semua...</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card product-card">
                    <!-- Image -->
                    <div class="position-relative">
                        <img src="{{ asset('assets/img/Produk/Coklat.png') }}" class="card-img-top" alt="Hampers Coklat Premium">

                        <!-- Favorit badge -->
                        <span class="badge-favorit">
                            <i class="fa-solid fa-award"></i>&nbsp;&nbsp;Verified
                        </span>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="category-text">Makanan & Minuman</span>
                            <span class="rating-text">
                                <i class="fa-solid fa-star text-warning"></i> 4.9
                            </span>
                        </div>

                        <p class="product-title">Hampers Coklat Premium</p>

                        <p class="product-price">Rp 350.000</p>

                        <a href="{{ route('detail') }}" class="btn btn-detail w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
