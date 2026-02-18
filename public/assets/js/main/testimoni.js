document.addEventListener('DOMContentLoaded', function () {

    /* =======================
     * DATATABLE
     * ======================= */
    $('#TestimonisTable').DataTable({
        responsive: true,
        scrollY: '600px',
        scrollCollapse: true,
        pageLength: -1,
        dom: 'Bfrt',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                className: 'btn btn-success',
                title: 'Data Testimoni',
                exportOptions: {
                    columns: [0, 1, 2, 3],
                    format: {
                        body: function (data) {
                            const div = document.createElement('div');
                            div.innerHTML = data;
                            return div.textContent || div.innerText || '';
                        }
                    }
                }
            }
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: { next: "Next", previous: "Prev" }
        },
    });



    /* =======================
     * MODAL EDIT
     * ======================= */
    const editModalEl = document.getElementById('editTestimoniModal');
    const editModal = new bootstrap.Modal(editModalEl);
    const editForm = document.getElementById('editTestimoniForm');
    const editBtn = document.getElementById('btnTestimoniEdit');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('idEdit').value = this.dataset.id;
            document.getElementById('namaTestimoniEdit').value = this.dataset.nama;
            document.getElementById('ratingEdit').value = this.dataset.rating;
            document.getElementById('komentarEdit').value = this.dataset.komentar;

            const foto = this.dataset.foto;

            const previewFotoEdit = document.getElementById('previewFotoEdit');
            if (foto) {
                previewFotoEdit.src = '/assets/img/Testimoni/' + foto;
                previewFotoEdit.classList.remove('d-none');
            } else {
                previewFotoEdit.classList.add('d-none');
            }

            document.getElementById('fotoEdit').value = '';

            editModal.show();
        });
    });

    editForm.addEventListener('submit', function (e) {
        e.preventDefault();

        editBtn.disabled = true;
        editBtn.querySelector('.btn-text').classList.add('d-none');
        editBtn.querySelector('.btn-loading').classList.remove('d-none');

        const id = document.getElementById('idEdit').value;
        const url = editForm.dataset.url.replace('/0','/' + id);

        const formData = new FormData();
        formData.append('nama', document.getElementById('namaTestimoniEdit').value);
        formData.append('rating', document.getElementById('ratingEdit').value.toString());
        formData.append('komentar', document.getElementById('komentarEdit').value);

        const fileInput = document.getElementById('fotoEdit');
        if (fileInput.files.length > 0) {
            formData.append('foto', fileInput.files[0]);
        }

        formData.append('_method', 'PUT');

        axios.post(url, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })
        .then(res => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.data.message ?? 'Data Testimoni berhasil diperbarui',
                timer: 1500,
                showConfirmButton: false
            }).then(() => location.reload());
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: err.response?.data?.message ?? 'Terjadi kesalahan'
            });
        })
        .finally(() => {
            editBtn.disabled = false;
            editBtn.querySelector('.btn-text').classList.remove('d-none');
            editBtn.querySelector('.btn-loading').classList.add('d-none');
        });
    });


    /* =======================
     * TAMBAH Testimoni
     * ======================= */
    const tambahForm = document.getElementById('addTestimoniForm');
    const tambahBtn = document.getElementById('btnTambahTestimoni');

    tambahForm.addEventListener('submit', function (e) {
        e.preventDefault();

        tambahBtn.disabled = true;
        tambahBtn.querySelector('.btn-text').classList.add('d-none');
        tambahBtn.querySelector('.btn-loading').classList.remove('d-none');

        const formData = new FormData(tambahForm);
        const url = tambahForm.dataset.url;

        axios.post(url, formData)
        .then(res => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.data.message ?? 'Testimoni berhasil ditambahkan',
                timer: 1500,
                showConfirmButton: false
            }).then(() => location.reload());
        })
        .catch(err => {
            let msg = 'Terjadi kesalahan';
            if (err.response?.status === 422) {
                msg = Object.values(err.response.data.errors)[0][0];
            }
            Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
        })
        .finally(() => {
            tambahBtn.disabled = false;
            tambahBtn.querySelector('.btn-text').classList.remove('d-none');
            tambahBtn.querySelector('.btn-loading').classList.add('d-none');
        });
    });


    /* =======================
     * HAPUS Testimoni
     * ======================= */
    document.querySelectorAll('.form-delete-testimoni').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const id = this.dataset.id;
            const url = this.dataset.url.replace('/0','/' + id);

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data Testimoni akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus'
            }).then(result => {
                if (result.isConfirmed) {
                    axios.delete(url)
                    .then(res => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.data.message ?? 'Testimoni berhasil dihapus',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Data gagal dihapus'
                        });
                    });
                }
            });
        });
    });
});
