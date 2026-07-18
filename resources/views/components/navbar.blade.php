<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container">

        <!-- Brand kiri -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
        <img src="{{ asset('assets/img/logo.png') }}" width="56" />
        <div class="d-none d-md-block lh-1">
            <div class="fw-bold" style="font-size: 20px; font-family: Arial !important;">Kikibi.id</div>
            <small class="text-muted" style="font-size: 12px; font-family: Arial !important;">Kirim Kirim Bingkisan</small>
        </div>
        </a>

            <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse w-100" id="navbarNav">

        <!-- MENU TENGAH -->
        <ul class="navbar-nav mx-auto gap-3 my-sm-4 text-end {{ Auth::check() ? 'pe-lg-5 pe-sm-0' : 'ps-lg-4 ps-sm-0' }}">
            <li class="nav-item">
                <a class="nav-link py-sm-0 fw-normal {{ $active === 'home' ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-sm-0 fw-normal {{ $active === 'ai' ? 'active' : '' }}" href="{{ route('ai-kikibi') }}">AI Rekomendasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-sm-0 fw-normal {{ $active === 'produk' ? 'active' : '' }}" href="{{ route('etalase') }}">Etalase Kikibi</a>
            </li>
        </ul>

        <!-- TOMBOL KANAN -->
        <div class="d-lg-flex mx-lg-0 mx-sm-auto text-sm-end gap-2">
            @auth

                @if(auth()->user()->role === 'user')
                <div class="align-self-center me-2">
                    <a href="{{ route('wishlist') }}" class="text-decoration-none">
                        <img src="{{ asset('assets/img/clover.png') }}" alt="Wishlist" class="img-fluid" width="100%" height="21.75px">
                    </a>
                </div>
                <div class="dropdown align-self-center pt-1 me-2">
                    <button
                        class="btn p-0 border-0 bg-transparent position-relative"
                        type="button"
                        id="notifDropdown"
                        data-bs-toggle="dropdown">

                        <i class="fa-regular fa-bell fs-4"></i>

                        <span id="notif-count"
                            class="position-absolute top-0 start-100 translate-middle
                                badge rounded-pill bg-danger d-none">
                        </span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end shadow"
                        style="width: 320px;"
                        id="notif-list">

                        <div class="notif-header text-center py-2 fw-semibold">
                            Notifikasi
                        </div>

                        <div id="notif-empty" class="text-center text-muted py-4 small border-top">
                            Tidak ada notifikasi
                        </div>

                    </div>
                </div>
                @endif

                {{-- USER DROPDOWN --}}
                <div class="dropdown">
                    <button class="fw-semibold btn-daftar rounded-5 border-0 dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown">
                        {{ Auth::user()->nama_lengkap }}
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="menuUser">
                        @if(Auth::user()->role == 'admin')
                        <li>
                            <!-- Tombol logout di dropdown -->
                            <a href="{{ route('admin-produk') }}" class="dropdown-item bg-transparent position-relative ps-5 bg-transparent text-black">
                                <i class="fa-solid fa-table-columns position-absolute top-50 translate-middle-y" style="left: 20px"></i>
                                Dashboard
                            </a>
                        </li>
                        <hr class="my-1">
                        @endif
                        @if (Auth::user()->role == 'user')
                        <li> <!-- Tombol logout di dropdown -->
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modalPengaturan" class="dropdown-item bg-transparent position-relative ps-5 bg-transparent text-black"> <i class="fa-solid fa-gear position-absolute top-50 translate-middle-y" style="left: 20px"></i>
                                Pengaturan Akun
                            </button>
                        </li>
                        <hr class="my-1">
                        @endif
                        <li>
                            <!-- Tombol logout di dropdown -->
                            <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item text-black bg-transparent position-relative ps-5">
                             <i class="fa-solid fa-arrow-right-from-bracket position-absolute top-50 translate-middle-y" style="left: 20px">
                                </i>Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf</form>
                        </li>
                    </ul>
                </div>
                @else
                    <a href="{{ route('login') }}" class="btn  btn-masuk rounded-pill px-4">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-daftar rounded-pill px-4">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@if(auth()->check() && auth()->user()->role === 'user')
<script>

document.addEventListener("DOMContentLoaded", function () {

    loadNotif();
    setInterval(loadNotif, 5000); // polling 5 detik

    // ⏳ 1 detik setelah dropdown benar-benar terbuka → mark as read
    const dropdownBtn = document.getElementById('notifDropdown');

    dropdownBtn.addEventListener('show.bs.dropdown', function () {
        setTimeout(() => {
            readAllNotif();
        }, 1000);
    });
});

function loadNotif() {
    fetch('/notifikasi')
        .then(res => res.json())
        .then(data => {

            const list = document.getElementById('notif-list');
            const badge = document.getElementById('notif-count');
            const empty = document.getElementById('notif-empty');

            if (!list || !badge || !empty) return;

            // Hapus notif lama (kecuali header & footer)
            list.querySelectorAll('.notif-item').forEach(e => e.remove());

            if (data.length > 0) {

                const unread = data.filter(n => n.is_read == '0').length;

                // update badge
                if (unread > 0) {
                    badge.innerText = unread;
                    badge.classList.remove('d-none');
                } else {
                    badge.classList.add('d-none');
                }

                empty.classList.add('d-none');

                data.forEach(item => {

                    const div = document.createElement('div');
                    div.className = 'notif-item d-flex align-items-start gap-2 px-3 py-2 border-bottom';

                    if (item.is_read == '0') {
                        div.style.background = '#f8f9ff';
                    }

                    div.innerHTML = `
                        <div class="notif-icon">
                            <i class="fa-solid ${notifIcon(item.jenis_notif)}"></i>
                        </div>

                        <div class="flex-grow-1">
                            <div class="${item.is_read == '0' ? 'fw-semibold text-danger' : 'text-muted'}">
                                ${notifTitle(item.jenis_notif)}
                            </div>

                            <div class="small text-muted">
                                ${item.pesan}
                            </div>

                            <div class="small text-secondary">
                                ${timeAgo(item.created_at)}
                            </div>
                        </div>
                    `;

                    // sisipkan sebelum footer
                    list.insertBefore(div, list.lastElementChild);
                });

            } else {
                badge.classList.add('d-none');
                empty.classList.remove('d-none');
            }
        });
}

function readAllNotif() {
    fetch('/notif-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(() => loadNotif());
}

function notifTitle(jenis) {
    switch(jenis) {
        case '1': return 'Pesanan Diproses';
        case '2': return 'Pesanan Dikirim';
        case '3': return 'Pesanan Selesai';
        default: return 'Notifikasi Baru';
    }
}

function notifIcon(jenis) {
    switch(jenis) {
        case '1': return 'fa-dolly';
        case '2': return 'fa-truck-fast';
        case '3': return 'fa-circle-check';
        default: return 'fa-bell';
    }
}

function timeAgo(datetime) {
    const seconds = Math.floor((new Date() - new Date(datetime)) / 1000);

    const intervals = {
        tahun: 31536000,
        bulan: 2592000,
        hari: 86400,
        jam: 3600,
        menit: 60
    };

    for (let key in intervals) {
        const interval = Math.floor(seconds / intervals[key]);
        if (interval >= 1) {
            return interval + ' ' + key + ' lalu';
        }
    }

    return 'Baru saja';
}

</script>
@endif

@if(Auth::check() && Auth::user()->role == 'user')
<div class="modal fade"
     id="modalPengaturan"
     tabindex="-1"
     data-bs-backdrop="static">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pengaturan Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form method="POST" data-url="{{ route('update-profile') }}" id="form-pengaturan">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text"
                               name="nama_lengkap"
                               class="form-control"
                               value="{{ Auth::user()->nama_lengkap }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text"
                               name="no_telp"
                               class="form-control"
                               value="{{ Auth::user()->no_telp }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ Auth::user()->email }}">
                    </div>

                    <div class="mb-3 position-relative">
                        <label class="form-label">Konfirmasi Password</label>

                        <input type="password"
                            name="password"
                            class="form-control pe-5"
                            id="passwordInput">

                        <span onclick="togglePasswordInput()"
                            class="position-absolute end-0 me-3"
                            style="cursor:pointer; top: 57.5%;">

                            <i class="fa-regular fa-eye text-muted" id="togglePassword"></i>
                        </span>
                    </div>

                    <script>
                        function togglePasswordInput() {
                            const passwordInput = document.getElementById("passwordInput");
                            const icon = document.getElementById("togglePassword");

                            if (passwordInput.type === "password") {
                                passwordInput.type = "text";
                                icon.classList.replace("fa-eye","fa-eye-slash");
                            } else {
                                passwordInput.type = "password";
                                icon.classList.replace("fa-eye-slash","fa-eye");
                            }
                        }
                    </script>

                    <button type="submit" class="btn btn-danger w-100" id="btn-pengaturan">
                        <span><span class="btn-loading d-none"><span class="spinner-border spinner-border-sm"></span> Loading...</span>
                        <span class="btn-text"><i class="fa-regular fa-floppy-disk"></i> Simpan</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@if(auth()->check() && auth()->user()->role === 'user')
<script>
const formPengaturan = document.getElementById('form-pengaturan');
const btnPengaturan = document.getElementById('btn-pengaturan');

formPengaturan.addEventListener('submit', function(e){
    e.preventDefault();

    btnPengaturan.disabled = true;
    formPengaturan.querySelector('.btn-loading').classList.remove('d-none');
    formPengaturan.querySelector('.btn-text').classList.add('d-none');

    const data = {
        nama_lengkap: formPengaturan.nama_lengkap.value,
        no_telp: formPengaturan.no_telp.value,
        email: formPengaturan.email.value,
        password: formPengaturan.password.value,
    };
    const url = formPengaturan.dataset.url;

    axios.put(url, data)
    .then(res => {

        if(res.data.success){
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.data.message ?? 'Profil berhasil diperbarui',
                timer: 1500,
                showConfirmButton: false
            }).then(() => location.reload());
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: res.data.message ?? 'Terjadi kesalahan'
            });
        }

    })
    .catch(err => {

        let msg = 'Terjadi kesalahan';

        if (err.response && err.response.status === 422) {
            msg = Object.values(err.response.data.errors)[0][0];
        }

        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: msg
        });

        console.log(err.response);

    })
    .finally(() => {

        btnPengaturan.disabled = false;
        formPengaturan.querySelector('.btn-loading').classList.add('d-none');
        formPengaturan.querySelector('.btn-text').classList.remove('d-none');

    });
});
</script>
@endif
