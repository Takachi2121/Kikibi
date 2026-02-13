@extends('admin.main')

@section('title', 'Tambah Produk')
@section('subtitle', 'Tambah Produk di sini.')

@section('mainContent')
    <link rel="stylesheet" href="{{ asset('assets/css/main/produk.css')}}">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <p class="fw-semibold fs-4 mb-0">Tambah Data Produk</p>
                </div>
                <div class="col-md-6 text-end align-self-center">
                    <a href="{{ route('admin-produk') }}" class="btn btn-secondary mb-3">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <form method="POST" enctype="multipart/form-data" id="tambahProdukForm" data-url="{{ route('produk-action.store') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <label class="form-label fw-bold mt-md-3 mt-sm-3 mb-3">Data Produk</label>

                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
                            <textarea class="form-control" id="deskripsi_produk" style="min-height: 155px" name="deskripsi_produk"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="harga_produk" class="form-label">Harga Produk</label>
                            <input type="text"
                                class="form-control"
                                id="harga_produk"
                                name="harga_produk"
                                placeholder="Rp."
                                autocomplete="off"
                            >
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="umur_min" class="form-label">Umur Minimal</label>
                                <div class="input-group">
                                    <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2);" class="form-control" id="umur_min" name="umur_min" max="99" min="0">
                                    <span class="input-group-text">Tahun</span>
                                </div>
                            </div>

                            <div class="col-6">
                                <label for="umur_max" class="form-label">Umur Maksimal</label>
                                <div class="input-group">
                                    <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2);" class="form-control" id="umur_max" name="umur_max" max="99" min="0">
                                    <span class="input-group-text">Tahun</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Untuk Gender</label>

                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="gender" id="laki" value="Pria" autocomplete="off">
                                <label class="btn btn-outline-primary" for="laki">
                                    <i class="fa-solid fa-mars me-1"></i> Laki-laki
                                </label>

                                <input type="radio" class="btn-check" name="gender" id="perempuan" value="Wanita" autocomplete="off">
                                <label class="btn btn-outline-danger" for="perempuan">
                                    <i class="fa-solid fa-venus me-1"></i> Perempuan
                                </label>

                                <input type="radio" class="btn-check" name="gender" id="unisex" value="Unisex" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="unisex">
                                    <i class="fa-solid fa-venus me-1"></i> Unisex
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="untuk_momen" class="form-label">Untuk Momen (pisahkan dengan koma)</label>
                            <input type="text" class="form-control" id="untuk_momen" name="untuk_momen">
                        </div>
                        <div class="mb-3"></div>
                            <label for="estimasi" class="form-label">Estimasi</label>
                            <select name="estimasi" id="estimasi" class="form-control">
                                <option value="" disabled hidden selected>Pilih Estimasi</option>
                                <option value="1 - 2 Hari">1-2 Hari Pengiriman</option>
                                <option value="3 - 4 Hari">3-4 Hari Pengiriman</option>
                                <option value="5 - 7 Hari">5-7 Hari Pengiriman</option>
                                <option value="8 - 10 Hari">8-10 Hari Pengiriman</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label fw-bold mt-md-3 mt-sm-3 mb-3">Kategori Produk</label>
                            <div class="mb-3">
                                <label for="kategori_id" class="form-label">Pilih Kategori</label>
                                <select class="form-select" id="kategori_id" name="kategori_id">
                                    <option value="" selected disabled hidden>Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="form-label fw-bold mt-md-3 mt-sm-3 mb-3">Foto Produk</label>

                            <div class="row g-3">

                                @for($i = 1; $i <= 5; $i++)
                                <div class="col-6">
                                    <div class="card shadow-sm h-100 text-center p-2">

                                        <img id="preview_foto_{{ $i }}"
                                            src=""
                                            class="img-fluid rounded mb-2"
                                            style="height:120px; object-fit:cover;">

                                        <label for="foto_{{ $i }}" class="btn btn-sm btn-outline-primary w-100">
                                            <i class="fa-solid fa-upload me-1"></i> Upload Foto {{ $i }}
                                        </label>

                                        <input type="file"
                                            class="file-input"
                                            hidden
                                            id="foto_{{ $i }}"
                                            name="foto_{{ $i }}"
                                            accept="image/*"
                                            onchange="previewImage(this, {{ $i }})">
                                    </div>
                                </div>
                                @endfor
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-danger w-auto" id="btnTambahProduk">
                                    <span class="btn-text"><i class="fa-solid fa-save me-1"></i> Simpan Produk</span>
                                    <span class="btn-loading d-none">
                                        <span class="spinner-border spinner-border-sm"></span>
                                        Loading
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<script src="{{ asset('assets/js/main/produk.js') }}"></script>
@endsection
