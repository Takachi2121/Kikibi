function registerUser(){
    const form = document.getElementById('regis-form');
    const btn = document.getElementById('btnRegister');
    const btnText = btn.querySelector('.btn-text');
    const btnLoading = btn.querySelector('.btn-loading');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // 🔒 disable button + loading
        btn.disabled = true;
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');

        const formData = new FormData(form);

        axios.post('/auth/register', formData)
        .then(res => {
            Swal.fire({
                title: "Verifikasi OTP",
                text: "Kode OTP telah dikirimkan ke email Anda",
                input: "text",
                inputPlaceholder: "Masukkan Kode OTP Disini",
                showCancelButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "Verifikasi",
                cancelButtonText: "Batal",
                preConfirm: (otp) => {
                    formData.append('otp', otp);
                    return axios.post('/auth/verify', formData)
                    .then(res => {
                        if (res.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Registrasi Berhasil',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                text: 'Silahkan login untuk melanjutkan.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = res.data.redirect;
                            });
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Verifikasi Gagal',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            text: err.response.data.message,
                            confirmButtonText: 'OK'
                        });
                    });
                }
            })
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
            console.log(err.response);
        })
        .finally(() => {
            // 🔓 aktifkan kembali button
            btn.disabled = false;
            btnText.classList.remove('d-none');
            btnLoading.classList.add('d-none');
        });
    });
}


document.addEventListener('DOMContentLoaded', function() {
    registerUser();

    // Ambil semua icon mata
    const toggleIcons = document.querySelectorAll('.fa-eye');

    toggleIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            // Cari input di parent yang sama
            const input = this.parentElement.querySelector('input');

            if (input.type === 'password') {
                input.type = 'text'; // tampilkan password
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash'); // ganti icon
            } else {
                input.type = 'password'; // sembunyikan password
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye'); // ganti icon
            }
        });
    });
});
