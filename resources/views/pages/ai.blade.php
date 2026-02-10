@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/ai.css') }}">
<div class="container my-5">
    <h2 class="text-center mb-4 fw-semibold">Cari rekomendasi dengan AI Kikibi</h2>

    <form action="{{ route('ai-rekomendasi') }}" method="POST" id="form-AI">
        @csrf
        <!-- Nama Penerima -->
        <div class="mb-4">
            <label class="form-label">Nama Penerima</label>
            <input type="text" class="form-control py-2" name="nama" placeholder="Masukkan nama penerima">
        </div>

        <!-- Row 1 -->
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Hadiah untuk siapa?</label>
                <select class="form-select" name="penerima">
                    <option value="" selected hidden>Pilih Penerima</option>
                    <option value="Pasangan">Pasangan</option>
                    <option value="Orang Tua">Orang Tua</option>
                    <option value="Teman">Teman</option>
                    <option value="Rekan Kerja">Rekan Kerja</option>
                    <option value="Atasan atau Klien">Atasan / Klien</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Perkiraan usia penerima?</label>
                <select class="form-select" name="usia">
                    <option value="" selected hidden>Pilih Usia</option>
                    <option value="< 18">&lt; 18</option>
                    <option value="18 - 25">18 - 25</option>
                    <option value="26 - 35">26 - 35</option>
                    <option value="36 - 45">36 - 45</option>
                    <option value="> 45">&gt; 45</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label d-block">Jenis Kelamin penerima?</label>
                <div class="d-flex gap-4 mt-2">
                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input mt-0" name="gender" type="radio" value="Pria" name="gender" id="laki">
                        <label class="form-check-label mb-0" for="laki">Laki-laki</label>
                    </div>

                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input mt-0" name="gender" type="radio" value="Wanita" name="gender" id="perempuan">
                        <label class="form-check-label mb-0" for="perempuan">Perempuan</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Hadiah ini diberikan untuk momen apa?</label>
                <select class="form-select py-2" name="momen">
                    <option value="" selected hidden>Pilih Momen</option>
                    @foreach ($momen as $data)
                        <option value="{{ $data }}">{{ $data }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Seberapa penting momen ini bagi Anda?</label>
                <select class="form-select py-2" name="level_kepentingan">
                    <option value="" selected hidden>Pilih Level Kepentingan Momen</option>
                    <option value="Biasa">Biasa</option>
                    <option value="Penting">Penting</option>
                    <option value="Sangat Penting atau Spesial">Sangat Penting</option>
                </select>
            </div>
        </div>

        <!-- Budget -->
        <div class="mb-4">
            <label class="form-label">
                Rentang anggaran yang Anda siapkan?
                <span class="fw-semibold text-danger ms-2" id="budgetValue">
                    &lt; Rp100.000
                </span>
            </label>

            <input
                type="range"
                class="form-range"
                min="0"
                max="6"
                step="1"
                value="0"
                name="budget"
                id="budgetRange"
            >

            <div class="d-flex justify-content-between small text-muted mt-2">
                <span>&lt; Rp 100rb</span>
                <span>Rp 100rb</span>
                <span>Rp 200rb</span>
                <span>Rp 300rb</span>
                <span>Rp 400rb</span>
                <span>Rp 500rb</span>
                <span>&gt; Rp 500rb</span>
            </div>
        </div>
        <script>
            const budgetRange = document.getElementById('budgetRange');
            const budgetValue = document.getElementById('budgetValue');

            const labels = [
                '< Rp100.000',
                'Rp100.000',
                'Rp200.000',
                'Rp300.000',
                'Rp400.000',
                'Rp500.000',
                '> Rp500.000'
            ];

            budgetRange.addEventListener('input', function () {
                budgetValue.textContent = labels[this.value];
            });
        </script>


        <!-- Row 3 -->
        <div class="row g-3 mb-5">
            <div class="col-md-4">
                <label class="form-label">Prioritas utama Anda dalam memilih hadiah?</label>
                <select class="form-select py-2" name="prioritas">
                    <option value="" selected hidden>Pilih Prioritas</option>
                    <option value="Harga">Harga Produk</option>
                    <option value="Kualitas">Kualitas Produk</option>
                    <option value="Tampilan">Tampilan / Estetika</option>
                    <option value="Makna">Makna Simbolik</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Minat utama penerima hadiah</label>
                <select class="form-select py-2" name="minat">
                    <option value="" selected hidden>Pilih Minat</option>
                    <option value="Teknologi atau Self Care">Teknologi & Self Care</option>
                    <option value="Dekorasi atau LifeStyle">Dekorasi & LifeStyle</option>
                    <option value="Produk Kreatif atau Handmade">Produk Kreatif / Handmade</option>
                    <option value="Religi atau Budaya">Religi & Budaya</option>
                    <option value="Makanan atau Minuman">Makanan & Minuman</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Gaya hadiah seperti apa yang paling cocok?</label>
                <select class="form-select py-2" name="gaya">
                    <option value="" selected hidden>Pilih Gaya Hadiah</option>
                    <option value="Simpel dan Minimalis">Simpel & Minimalis</option>
                    <option value="Elegan dan Premium">Elegan & Premium</option>
                    <option value="Unik dan Kreatif">Unik & Kreatif</option>
                    <option value="Lucu dan Playful">Lucu & Playful</option>
                    <option value="Fungsional">Fungsional</option>
                </select>
            </div>

        </div>

        <!-- Buttons -->
        <div class="row">
            <div class="col-md-6 mb-sm-3">
                <a href="#" class="btn btn-danger h-100 w-100 px-5 py-2 shadow-lg"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Kembali</a>
            </div>
            <div class="col-md-6 mb-sm-3">
                <button type="submit" class="btn btn-dark h-100 w-100 px-5 py-2 shadow-lg" id="btnAI">
                    <span class="text-center btn-text">
                        Cari Sekarang&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i>
                    </span>
                    <span class="btn-loading d-none">
                        <span class="spinner-border spinner-border-sm"></span>
                        Loading
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('btnAI').addEventListener('click', function (e) {
        // jangan submit otomatis dulu
        e.preventDefault();

        // disable tombol + tampilkan loading
        this.disabled = true;
        this.querySelector('.btn-text').classList.add('d-none');
        this.querySelector('.btn-loading').classList.remove('d-none');

        // submit form manual
        document.getElementById('form-AI').submit();
    });
</script>
@endsection
