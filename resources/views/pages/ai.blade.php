@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/ai.css') }}">

<div class="container my-5">
    <div class="p-4 bg-white shadow rounded" style="margin-top: 84px" >
        <h2 class="text-center mb-4 fw-semibold">Cari rekomendasi dengan AI Kikibi</h2>

        <form action="{{ route('ai-rekomendasi') }}" method="POST" id="form-AI">
            @csrf
            <div class="row g-3">

                <!-- Momen -->
                <div class="col-12">
                    <label class="form-label">Hadiah ini diberikan untuk momen apa?</label>
                    <select class="form-select form-control" name="momen">
                        <option value="" selected hidden>Pilih Momen</option>
                        @foreach ($momen as $data)
                            <option value="{{ $data }}">{{ $data }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Gender -->
                <div class="col-12">
                    <label class="form-label d-block">Jenis Kelamin penerima?</label>
                    <div class="d-flex gap-3 mt-2 flex-wrap">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input class="form-check-input mt-0" type="radio" name="gender" value="Pria" id="laki">
                            <label class="form-check-label mb-0" for="laki">Laki-laki</label>
                        </div>
                        <div class="form-check d-flex align-items-center gap-2">
                            <input class="form-check-input mt-0" type="radio" name="gender" value="Wanita" id="perempuan">
                            <label class="form-check-label mb-0" for="perempuan">Perempuan</label>
                        </div>
                        <div class="form-check d-flex align-items-center gap-2">
                            <input class="form-check-input mt-0" type="radio" name="gender" value="" id="unisex">
                            <label class="form-check-label mb-0" for="unisex">Unisex</label>
                        </div>
                    </div>
                </div>

                <!-- Usia -->
                <div class="col-12">
                    <label class="form-label">Perkiraan usia penerima?</label>
                    <select class="form-select form-control" name="usia">
                        <option value="" selected hidden>Pilih Usia</option>
                        <option value="< 18">&lt; 18 Tahun</option>
                        <option value="18 - 25">18 - 25 Tahun</option>
                        <option value="26 - 35">26 - 35 Tahun</option>
                        <option value="36 - 45">36 - 45 Tahun</option>
                        <option value="> 45">&gt; 45 Tahun</option>
                    </select>
                </div>

                <!-- Budget -->
                <div class="col-12">
                    <label class="form-label mb-3">
                        Rentang anggaran
                        <span class="fw-semibold text-danger ms-2" id="budgetValue">&lt; Rp100.000</span>
                    </label>
                    <input type="range" class="form-range form-control" min="0" max="6" step="1" value="0" name="budget" id="budgetRange">
                    <div class="d-flex justify-content-between small text-muted mt-2 flex-wrap">
                        <span>&lt; Rp 100rb</span>
                        <span>Rp 100rb</span>
                        <span>Rp 200rb</span>
                        <span>Rp 300rb</span>
                        <span>Rp 400rb</span>
                        <span>Rp 500rb</span>
                        <span>&gt; Rp 500rb</span>
                    </div>
                </div>

            </div>

            <!-- Buttons -->
            <div class="row mt-4">
                <div class="col-12 col-md-6 mb-3">
                    <a href="#" class="btn btn-danger h-100 w-100 px-5 py-2 shadow-lg"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Kembali</a>
                </div>
                <div class="col-12 col-md-6 mb-3">
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

    document.getElementById('btnAI').addEventListener('click', function (e) {
        e.preventDefault();
        this.disabled = true;
        this.querySelector('.btn-text').classList.add('d-none');
        this.querySelector('.btn-loading').classList.remove('d-none');
        document.getElementById('form-AI').submit();
    });
</script>
@endsection
