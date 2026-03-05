<aside class="sidebar d-flex flex-column p-4" id="sidebar">
    <!-- Logo -->
    <div class="text-center mb-5">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/img/Background/logo-form.png') }}" class="object-fit-contain" width="100" height="100" alt="Logo">
        </a>
    </div>

    <!-- Navigation -->
    <nav class="nav flex-column gap-2 flex-grow-1">
        <p class="text-uppercase text-black-50 small fw-bold mt-3 mb-1">Menu Utama</p>

        <a class="nav-link {{ $active == 'kategori' ? 'active' : '' }}" href="{{ route('admin-dashboard') }}"><i class="fa-solid fa-briefcase me-2"></i> Kategori</a>
        <a class="nav-link {{ $active == 'produk' ? 'active' : '' }}" href="{{ route('admin-produk') }}"><i class="fa-solid fa-box me-2"></i> Produk</a>

        <a class="nav-link {{ $active == 'pesanan' ? 'active' : '' }}" href="{{ route('admin-pesanan') }}"><i class="fa-solid fa-cart-shopping me-2"></i> Pesanan</a>

        <p class="text-uppercase text-black-50 small fw-bold mt-3 mb-1">Menu Tambahan</p>

        <a class="nav-link {{ $active == 'testimoni' ? 'active' : '' }}" href="{{ route('admin-testimoni') }}"><i class="fa-solid fa-lightbulb me-2"></i> Testimoni</a>
        {{-- <a class="nav-link {{ $active == 'diskon' ? 'active' : '' }}" href="{{ route('admin-diskon') }}"><i class="fa-solid fa-lightbulb me-2"></i> Diskon</a> --}}

        <p class="text-uppercase text-black-50 small fw-bold mt-3 mb-1">Pengaturan</p>

        <a class="nav-link" data-bs-toggle="modal" data-bs-target="#modalProfil"><i class="fa-solid fa-user me-2"></i> Ubah Profil</a>
        <a class="nav-link" data-bs-toggle="modal" data-bs-target="#modalPass"><i class="fa-solid fa-gear me-2"></i> Ubah Password</a>
    </nav>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger w-100">
            <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
        </button>
    </form>
</aside>

<!-- Main Content -->
<main class="flex-grow-1 p-4" style="overflow-y: auto">
    <!-- Header Page -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="fw-bold mb-1">@yield('title')</h1>
            <p class="text-muted mb-0">@yield('subtitle')</p>
        </div>

        <!-- Hamburger (mobile only) -->
        <button class="btn btn-outline-light bg-dark d-md-none" id="menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- Konten halaman -->
    @yield('mainContent')
</main>

<!-- Overlay (untuk mobile) -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const toggleBtn = document.getElementById('menu-toggle');

    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });
</script>

<!-- Modal Profil -->
<div class="modal fade" id="modalProfil" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" data-url="{{ route('update-profile') }}" id="form-profil">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control"
                               value="{{ Auth::user()->nama_lengkap }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="no_telp" class="form-control"
                               value="{{ Auth::user()->no_telp }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ Auth::user()->email }}">
                    </div>

                    <div class="mb-3 position-relative">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password" class="form-control pe-5">
                        <span onclick="togglePasswordInput(this)"
                              class="position-absolute end-0 me-3"
                              style="cursor:pointer; top: 57.5%;">
                            <i class="fa-regular fa-eye text-muted"></i>
                        </span>
                    </div>

                    <button type="submit" class="btn btn-danger w-100" id="btn-profil">
                        <span><span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm"></span> Loading...
                        </span>
                        <span class="btn-text"><i class="fa-regular fa-floppy-disk"></i> Simpan</span></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubah Password -->
<div class="modal fade" id="modalPass" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" data-url="{{ route('update-pass') }}" id="form-pass">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 position-relative">
                        <label class="form-label">Password Lama</label>
                        <input type="password" name="current_password" class="form-control pe-5">
                        <span onclick="togglePasswordInput(this)"
                              class="position-absolute end-0 me-3"
                              style="cursor:pointer; top: 57.5%;">
                            <i class="fa-regular fa-eye text-muted"></i>
                        </span>
                    </div>

                    <div class="mb-3 position-relative">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password_new" class="form-control pe-5">
                        <span onclick="togglePasswordInput(this)"
                              class="position-absolute end-0 me-3"
                              style="cursor:pointer; top: 57.5%;">
                            <i class="fa-regular fa-eye text-muted"></i>
                        </span>
                    </div>

                    <div class="mb-3 position-relative">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_new_confirmation" class="form-control pe-5">
                        <span onclick="togglePasswordInput(this)"
                              class="position-absolute end-0 me-3"
                              style="cursor:pointer; top: 57.5%;">
                            <i class="fa-regular fa-eye text-muted"></i>
                        </span>
                    </div>

                    <button type="submit" class="btn btn-danger w-100" id="btn-pass">
                        <span><span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm"></span> Loading...
                        </span>
                        <span class="btn-text"><i class="fa-regular fa-floppy-disk"></i> Simpan</span></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordInput(span){
    const input = span.previousElementSibling; // input sebelum span
    const icon = span.querySelector('i');

    if(input.type === "password"){
        input.type = "text";
        icon.classList.replace("fa-eye","fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash","fa-eye");
    }
}
</script>

<script>
const formProfil = document.getElementById('form-profil');
const btnProfil = document.getElementById('btn-profil');

if(formProfil){
    formProfil.addEventListener('submit', function(e){
        e.preventDefault();

        btnProfil.disabled = true;
        formProfil.querySelector('.btn-loading').classList.remove('d-none');
        formProfil.querySelector('.btn-text').classList.add('d-none');

        const data = {
            nama_lengkap: formProfil.nama_lengkap.value,
            no_telp: formProfil.no_telp.value,
            email: formProfil.email.value,
            password: formProfil.password.value,
        };
        const url = formProfil.dataset.url;

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

            btnProfil.disabled = false;
            formProfil.querySelector('.btn-loading').classList.add('d-none');
            formProfil.querySelector('.btn-text').classList.remove('d-none');

        });
    });
}

const formPass = document.getElementById('form-pass');
const btnPass = document.getElementById('btn-pass');

if(formPass){
    formPass.addEventListener('submit', function(e){
        e.preventDefault();

        btnPass.disabled = true;
        formPass.querySelector('.btn-loading').classList.remove('d-none');
        formPass.querySelector('.btn-text').classList.add('d-none');

        const data = {
            current_password: formPass.current_password.value,
            password_new: formPass.password_new.value,
            password_new_confirmation: formPass.password_new_confirmation.value,
        };
        const url = formPass.dataset.url;

        axios.put(url, data)
        .then(res => {

            if(res.data.success){
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.data.message ?? 'Profil berhasil diperbarui',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if(res.data.redirect){
                        window.location.href = res.data.redirect;
                    }
                });
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

            btnPass.disabled = false;
            formPass.querySelector('.btn-loading').classList.add('d-none');
            formPass.querySelector('.btn-text').classList.remove('d-none');

        });
    });
}
</script>
