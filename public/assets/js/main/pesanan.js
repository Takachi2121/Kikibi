document.addEventListener('DOMContentLoaded', function () {
    /* =======================
     * DATATABLE
     * ======================= */
    $('#PesanansTable').DataTable({
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
                title: 'Data Kategori',
                exportOptions: {
                    columns: [0, 1, 2], // No, Nama, Makna
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
    const editModalEl = document.getElementById('editKategoriModal');
    const editModal = new bootstrap.Modal(editModalEl);
    const editForm = document.getElementById('editKategoriForm');
    const editBtn = document.getElementById('btnKategoriEdit');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('idEdit').value = this.dataset.id;
            document.getElementById('namaKategoriEdit').value = this.dataset.nama;
            document.getElementById('maknaHadiahEdit').value = this.dataset.maknaHadiah;

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

        axios.put(url, {
            nama_kategori: document.getElementById('namaKategoriEdit').value,
            makna_hadiah: document.getElementById('maknaHadiahEdit').value,
        })
        .then(res => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.data.message ?? 'Data kategori berhasil diperbarui',
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
     * TAMBAH KATEGORI
     * ======================= */
    const tambahForm = document.getElementById('addKategoriForm');
    const tambahBtn = document.getElementById('btnTambahKategori');

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
                text: res.data.message ?? 'Kategori berhasil ditambahkan',
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
     * HAPUS KATEGORI
     * ======================= */
    document.querySelectorAll('.form-delete-kategori').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const id = this.dataset.id;
            const url = this.dataset.url.replace('/0','/' + id);

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data kategori akan dihapus permanen!',
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
                            text: res.data.message ?? 'Kategori berhasil dihapus',
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
