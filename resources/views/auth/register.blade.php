<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kikibi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/icon-tab.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>

<body>

<!-- KEMBALI -->
<a href="{{ route('home') }}" class="back-btn">
    <i class="fa-solid fa-arrow-left"></i> Kembali
</a>

<div class="auth-wrapper">

    <div class="auth-card">

        <div class="text-center mb-3">
            <img src="{{ asset('assets/img/Background/logo-form.png') }}" width="78" height="73" alt="Logo">
        </div>

        <div class="auth-title fs-2 mb-1">Buat Akun Baru</div>
        <div class="auth-subtitle fs-6">Mulai mencari bingkisan sempurna</div>

        <form action="">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <label class="fw-normal" for="namaRegis">Nama Lengkap *</label>

                    <div class="position-relative mt-2">
                        <i class="fa-regular fa-user position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                        <input type="email" class="form-control input-field ps-5 rounded-4 border-2" placeholder="Nama Lengkap Anda" name="namaUser" id="namaRegis">
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="fw-normal" for="emailRegis">Email *</label>

                    <div class="position-relative mt-2">
                        <i class="fa-regular fa-envelope position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                        <input type="email" class="form-control input-field ps-5 rounded-4 border-2" placeholder="nama@email.com" name="emailUser" id="emailRegis">
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="fw-normal" for="telpRegis">Nomor Telepon *</label>

                    <div class="position-relative mt-2">
                        <i class="fa-solid fa-phone position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                        <input type="email" class="form-control input-field ps-5 rounded-4 border-2" placeholder="08123456789" name="telpUser" id="telpRegis">
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="fw-normal" for="passwordRegis">Password *</label>

                    <div class="position-relative mt-2">
                        <i class="fa-solid fa-lock position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                        <input type="password" class="form-control input-field ps-5 pe-5 rounded-4 border-2" placeholder="Minimal 8 Karakter" name="passwordUser" id="passwordRegis">

                        <i class="fa-regular fa-eye position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                        style="cursor:pointer"></i>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="fw-normal" for="confirmRegis">Konfirmasi Password *</label>

                    <div class="position-relative mt-2">
                        <i class="fa-solid fa-lock position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                        <input type="password" class="form-control input-field ps-5 pe-5 rounded-4 border-2" placeholder="Ketik Ulang Password" name="confirmUser" id="confirmRegis">

                        <i class="fa-regular fa-eye position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                        style="cursor:pointer"></i>
                    </div>
                </div>

                <div class="col-lg-12">
                    <button class="btn btn-danger w-100 py-3 mt-3 rounded-3">
                        <i class="fa-regular fa-circle-check"></i>&nbsp;&nbsp;Buat Akun
                    </button>
                </div>

                <div class="d-flex align-items-center my-3">
                    <hr class="flex-grow-1">
                    <span class="mx-3 text-muted fw-semibold">atau</span>
                    <hr class="flex-grow-1">
                </div>

                <p class="text-center">Belum Punya Akun?</p>

                <div class="col-lg-12">
                    <button class="btn btn-outline-danger w-100 py-3 rounded-3">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>&nbsp;&nbsp;Masuk
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

</body>
</html>
