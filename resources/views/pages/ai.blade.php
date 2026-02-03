@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/ai.css') }}">
<div class="container my-5">
    <h2 class="text-center mb-4 fw-semibold">Cari rekomendasi dengan AI Kikibi</h2>

    <form>
        <!-- Nama Penerima -->
        <div class="mb-4">
            <label class="form-label">Nama Penerima</label>
            <input type="text" class="form-control py-2" placeholder="Masukkan nama penerima">
        </div>

        <!-- Row 1 -->
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Hadiah untuk siapa?</label>
                <select class="form-select">
                    <option selected hidden>Pilih Penerima</option>
                    <option>Pasangan</option>
                    <option>Orang Tua</option>
                    <option>Teman</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Perkiraan usia penerima?</label>
                <select class="form-select">
                    <option selected hidden>Pilih Usia</option>
                    <option>&lt; 18</option>
                    <option>18 - 25</option>
                    <option>26 - 35</option>
                    <option>36+</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label d-block">Jenis Kelamin penerima?</label>
                <div class="d-flex gap-4 mt-2">
                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input mt-0" type="radio" value="Laki-Laki" name="gender" id="laki">
                        <label class="form-check-label mb-0" for="laki">Laki-laki</label>
                    </div>

                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input mt-0" type="radio" value="Perempuan" name="gender" id="perempuan">
                        <label class="form-check-label mb-0" for="perempuan">Perempuan</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Hadiah ini diberikan untuk momen apa?</label>
                <select class="form-select py-2">
                    <option selected hidden>Pilih Momen</option>
                    <option>Ulang Tahun</option>
                    <option>Pernikahan</option>
                    <option>Wisuda</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Seberapa penting momen ini bagi Anda?</label>
                <select class="form-select py-2">
                    <option selected hidden>Pilih Level Kepentingan Momen</option>
                    <option>Biasa</option>
                    <option>Penting</option>
                    <option>Sangat Penting</option>
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
                id="budgetRange"
            >

            <div class="d-flex justify-content-between small text-muted mt-2">
                <span>&lt; Rp 100.000</span>
                <span>Rp 100.000</span>
                <span>Rp 200.000</span>
                <span>Rp 300.000</span>
                <span>Rp 400.000</span>
                <span>Rp 500.000</span>
                <span>&gt; Rp 500.000</span>
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
                <select class="form-select py-2">
                    <option selected hidden>Pilih Prioritas</option>
                    <option>Harga</option>
                    <option>Kualitas</option>
                    <option>Keunikan</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Minat utama penerima hadiah</label>
                <select class="form-select py-2">
                    <option selected hidden>Pilih Minat</option>
                    <option>Teknologi</option>
                    <option>Fashion</option>
                    <option>Hobi</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Gaya hadiah seperti apa yang paling cocok?</label>
                <select class="form-select py-2">
                    <option selected hidden>Pilih Gaya Hadiah</option>
                    <option>Simple</option>
                    <option>Elegan</option>
                    <option>Lucu</option>
                </select>
            </div>
        </div>

        <!-- Buttons -->
        <div class="row">
            <div class="col-md-6 mb-sm-3">
                <a href="#" class="btn btn-danger h-100 w-100 px-5 py-2 shadow-lg"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Kembali</a>
            </div>
            <div class="col-md-6 mb-sm-3">
                <button type="submit" class="btn btn-dark h-100 w-100 px-5 py-2 shadow-lg">Cari Sekarang&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </form>
</div>
@endsection
