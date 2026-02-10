<link rel="stylesheet" href="{{ asset('assets/css/produk.css') }}">

<section class="rekomendasi-section">
    <div class="container">

        {{-- Rekomendasi Kekasih --}}
        <div class="row mt-5">
            <div class="col-lg-6 col-sm-5">
                <p class="fw-semibold fs-4 mb-0">List Hadiah</p>
            </div>
            <div class="col-lg-6 col-sm-7 text-end align-self-center">
                <a href="{{ route('etalase') }}" class="text-decoration-none text-muted text-end">Lihat Semua...</a>
            </div>
        </div>
        <div class="row mt-3">
            @foreach ($produk as $data)
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card product-card">
                    <!-- Image -->
                    <div class="position-relative">
                        <img src="{{ asset('assets/img/Produk/'. $data->foto_1) }}" class="card-img-top" alt="Keranjang Bunga Mawar">

                        <!-- Favorit badge -->
                        <span class="badge-favorit">
                            <i class="fa-solid fa-award"></i>&nbsp;&nbsp;Verified
                        </span>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="category-text">{{ $data->kategori->nama_kategori }}</span>
                            <span class="rating-text">
                                <i class="fa-solid fa-star text-warning"></i> 4.7
                            </span>
                        </div>

                        <p class="product-title">{{ $data->nama_produk }}</p>

                        <p class="product-price">Rp {{ number_format($data->harga, 0, ',', '.') }}</p>

                        <a href="{{ route('detail', $data->id) }}" class="btn btn-detail w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
