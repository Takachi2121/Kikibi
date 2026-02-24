<div class="container pt-5">
    <div class="row gy-4">
        <div class="text-white col-md-4">
            <div class="row">
                <div class="col-md-2">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Kikibi" width="54" height="50">
                </div>
                <div class="col-md-7">
                    <strong class="fs-4">Kikibi.id</strong>
                    <p>Kirim Kirim Bingkisan</p>
                </div>
                <p class="text-white w-75">
                    Platform kurasi bingkisan yang menghubungkan Anda
                    dengan UMKM lokal terbaik.
                </p>
            </div>
        </div>

        <div class="text-white col-md-4">
            <h6>Jelajahi</h6>
            <ul class="list-unstyled mt-4">
                <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none text-white">Beranda</a></li>
                <li class="mb-2"><a href="{{ route('ai-kikibi') }}" class="text-decoration-none text-white">AI Rekomendasi</a></li>
                <li class="mb-2"><a href="{{ route('etalase') }}" class="text-decoration-none text-white">Etalase Kikibi</a></li>
            </ul>
        </div>

        <div class="text-white col-md-4">
            <h6>Kontak</h6>
            <ul class="list-unstyled mt-4">
                <li class="mb-2">
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=official.kikibi@gmail.com" class="text-decoration-none text-white" target="_blank">
                        Email: official.kikibi@gmail.com
                    </a>
                </li>
                <li class="mb-2">
                    <a href="https://wa.me/6287731122287" class="text-decoration-none text-white">
                        WA: +62 8773 1122 287
                    </a>
                </li>
                <li class="mb-2">Jakarta, Indonesia</li>
            </ul>
        </div>
    </div>
    <hr class="mb-0" style="border-color: white">
    <div class="text-white text-center py-4">
        © {{ date('Y') }} Kikibi.id Mendukung UMKM Indonesia
    </div>
</div>
