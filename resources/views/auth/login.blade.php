<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kikibi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/icon-tab.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>

<body>
@if (session('auth_error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "Informasi",
            text: "{{ session('auth_error') }}",
            icon: "question"
        });
    </script>
@endif

@if (session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "bottom-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "error",
            title: "{{ session('error') }}"
        });
    </script>
@endif

<!-- KEMBALI -->
<a href="{{ route('home') }}" class="back-btn">
    <i class="fa-solid fa-arrow-left"></i> Kembali
</a>

<div class="auth-wrapper">

    <div class="auth-card">

        <div class="text-center mb-3">
            <img src="{{ asset('assets/img/Background/logo-form.png') }}" width="78" height="73" alt="Logo">
        </div>

        <div class="auth-title fs-2 mb-1">Selamat Datang Kembali!</div>
        <div class="auth-subtitle fs-5">Masuk ke akun Kikibi Anda</div>

        <form action="{{ route('Verif-login') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <label class="fw-semibold" for="emailLogin">Email</label>

                    <div class="position-relative mt-2">
                        <i class="fa-regular fa-envelope position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                        <input type="email" class="form-control ps-5 input-field rounded-4 border-2" placeholder="nama@email.com" name="emailUser" id="emailLogin">
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="fw-semibold" for="passwordLogin">Password</label>

                    <div class="position-relative mt-2">
                        <i class="fa-solid fa-lock position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                        <input type="password" class="form-control ps-5 input-field pe-5 rounded-4 border-2" placeholder="Password" name="passwordUser" id="passwordLogin">

                        <i class="fa-regular fa-eye position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                        style="cursor:pointer"></i>
                    </div>
                </div>

                <a href="" class="text-decoration-none text-danger text-end fw-semibold">Lupa Password?</a>

                <div class="col-lg-12">
                    <button type="submit" class="btn btn-danger w-100 py-3 mt-3 rounded-3">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>&nbsp;&nbsp;Masuk
                    </button>
                </div>

                <div class="d-flex align-items-center my-3">
                    <hr class="flex-grow-1">
                    <span class="mx-3 text-muted fw-semibold">atau</span>
                    <hr class="flex-grow-1">
                </div>

                <p class="text-center">Belum Punya Akun?</p>

                <div class="col-lg-12">
                    <a href="{{ route('register') }}" class="btn btn-outline-danger w-100 py-3 rounded-3">
                        <i class="fa-solid fa-user-plus"></i>&nbsp;&nbsp;Daftar
                    </a>
                </div>
            </div>
        </form>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</body>
</html>
