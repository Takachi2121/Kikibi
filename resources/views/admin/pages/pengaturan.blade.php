@extends('admin.main')

@section('mainContent')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 93vh">
    <div class="row w-100 justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    <h4 class="fw-semibold mb-1">Pengaturan Akun</h4>
                    <p class="text-muted mb-4">Ubah data diri Anda</p>

                    <form class="edit-data-user">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="namaUser"
                                   >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="emailUser"
                                   >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Lama</label>
                            <input type="password" class="form-control" name="passUser">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="newPassUser">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Ulangi Password</label>
                            <input type="password" class="form-control" name="passUserRepeat">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger rounded-pill" id="btnUpdateUser">
                                <span class="btn-text">Simpan Perubahan</span>
                                <span class="btn-loading d-none">
                                    <span class="spinner-border spinner-border-sm"></span> Loading...
                                </span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const form = document.querySelector('.edit-data-user');
const btn = document.getElementById('btnUpdateUser');
const btnText = btn.querySelector('.btn-text');
const btnLoading = btn.querySelector('.btn-loading');

form.addEventListener('submit', function (e) {
    e.preventDefault();

    btn.disabled = true;
    btnText.classList.add('d-none');
    btnLoading.classList.remove('d-none');

    const formData = new FormData(form);

    axios.post('/update-user', formData)
        .then(() => {
            Swal.fire({
                title: "Verifikasi OTP",
                text: "Kode OTP telah dikirim ke email Anda",
                input: "text",
                showCancelButton: true,
                allowOutsideClick: false,
                preConfirm: (otp) => {
                    formData.append('otp', otp);
                    return axios.post('/verif-user', formData);
                }
            }).then(result => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Berhasil Diperbarui',
                        confirmButtonText: 'OK'
                    }).then(() => location.reload());
                }
            });
        })
        .catch(err => {
            let message = 'Terjadi kesalahan';

            if (err.response?.status === 422) {
                const errors = err.response.data.errors;
                message = Object.values(errors)[0][0];
            }

            Swal.fire({
                icon: 'error',
                title: 'Pendaftaran Gagal',
                text: message,
            });
        })
        .finally(() => {
            // 🔓 aktifkan kembali button
            btn.disabled = false;
            btnText.classList.remove('d-none');
            btnLoading.classList.add('d-none');
        });
});
</script>
@endsection
