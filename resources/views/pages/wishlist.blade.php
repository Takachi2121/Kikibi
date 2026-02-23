@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/etalase.css') }}">
    <div class="container my-4">
        <a href="{{ route( 'home') }}" class="text-decoration-none text-black fs-5 gap-3">
            <i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Kembali
        </a>
        <div class="row align-items-center mt-4">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <h1 class="mb-0">Wishlist</h1>
                <p class="mb-0 text-muted">
                    Menampilkan {{ $data->count() }} produk yang kamu masukkan kedalam wishlist
                </p>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-end">
                <div class="dropdown">
                    <button
                    class="btn bg-white border rounded-pill px-3 py-2 dropdown-toggle"
                    type="button"
                    id="dropdownMenuButton"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa-solid fa-sliders"></i>&nbsp;&nbsp; <span id="filter-etalase">Urutkan Berdasarkan</span>
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#" data-sort="harga_desc">Harga Tertinggi</a></li>
                        <li><a class="dropdown-item" href="#" data-sort="harga_asc">Harga Terendah</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-2" style="min-height: 48.7dvh">
            @forelse ($data as $item)
            <div class="col-lg-12 col-md-12 col-sm-12 mt-3 pt-4 border-top">
                <div class="row align-items-center">

                    <!-- FOTO -->
                    <div class="col-12 col-md-2 text-center text-md-start mb-3 mb-md-0">
                        <img src="{{ asset('assets/img/Produk/' . $item->produk->foto_1) }}"
                            class="img-fluid"
                            style="max-height:120px; object-fit:cover;"
                            alt="...">
                    </div>

                    <!-- DETAIL PRODUK -->
                    <div class="col-12 col-md-7">
                        <h5 class="fs-6 text-danger">
                            {{ $item->produk->kategori->nama_kategori }}
                        </h5>

                        <h5 class="fs-4 fs-lg-3 mb-2 mt-2">
                            {{ $item->produk->nama_produk }}
                        </h5>

                        <p class="fs-5 fs-lg-4 mb-3">
                            Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                        </p>

                        <!-- JUMLAH -->
                        <div class="d-flex align-items-center justify-content-between mb-lg-2 mb-sm-4" style="max-width:250px;">
                            <span class="fw-medium font-arial">Jumlah</span>

                            <div class="qty-wrapper d-flex align-items-center gap-2"
                                data-id="{{ $item->id }}">
                                <button type="button" class="qty-btn minus btn btn-sm btn-outline-secondary">−</button>
                                <span class="qty-number">{{ $item->total }}</span>
                                <button type="button" class="qty-btn plus btn btn-sm btn-outline-secondary">+</button>
                            </div>
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <div class="col-12 col-md-3">
                        <a href="#"
                        data-name="{{ $item->produk->nama_produk }}"
                        class="btn btn-wa shadow-sm text-white w-100 mb-2 py-2"
                        style="background-color: #B0170F">
                            Check Out Whatsapp
                        </a>

                        <form method="POST"
                            data-id="{{ $item->id }}"
                            data-url="{{ route('wishlist-action.destroy', 0) }}"
                            class="d-inline form-delete-wishlist">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn shadow-sm text-white w-100 py-2"
                                    style="background-color: #1E2939">
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>
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
<script src="{{ asset('assets/js/main/wishlist.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    axios.defaults.headers.common['X-CSRF-TOKEN'] =
        document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.qty-wrapper').forEach(wrapper => {
        const minusBtn = wrapper.querySelector('.minus');
        const plusBtn = wrapper.querySelector('.plus');
        const qtyNumber = wrapper.querySelector('.qty-number');

        const wishlistId = wrapper.dataset.id;
        let quantity = parseInt(qtyNumber.textContent);

        function sendUpdate(newQty) {
            axios.patch(`/wishlist-action/${wishlistId}`, { total: newQty })
            .catch(err => {
                console.error(err.response || err);
                // optional: rollback UI kalau error
                qtyNumber.textContent = quantity;
            });
        }

        plusBtn.addEventListener('click', () => {
            quantity++;                  // update UI dulu
            qtyNumber.textContent = quantity;
            sendUpdate(quantity);        // kirim ke server
        });

        minusBtn.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;              // update UI dulu
                qtyNumber.textContent = quantity;
                sendUpdate(quantity);    // kirim ke server
            }
        });

        const waButton = wrapper.closest('.row.align-items-center').querySelector('.btn-wa');
        waButton.addEventListener('click', e => {
            e.preventDefault();
            const productName = e.target.dataset.name;
            const text = `Permisi kak, saya ingin membeli ${productName} sebanyak ${qtyNumber.textContent} buah untuk memberikan kejutan di momen spesial. Mohon informasinya, ya!.`;
            const waLink = `https://wa.me/6287731122287?text=${encodeURIComponent(text)}`;
            window.open(waLink, '_blank');
        });
    });

});
</script>
@endsection
