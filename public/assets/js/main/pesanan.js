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
                title: 'Data Pesanan',
                exportOptions: {
                    columns: [0, 1, 3, 4, 5, 6, 7], // No, Nama Produk, Nama Pengirim, No Telp, Jumlah, Total, Status
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
    const editModalEl = document.getElementById('editPesananModal');
    const editModal = new bootstrap.Modal(editModalEl);
    const editForm = document.getElementById('editPesananForm');
    const editBtn = document.getElementById('btnPesananEdit');

    // tombol edit di tabel Pesanan
    document.querySelectorAll('#PesanansTable .btn-warning').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('idEdit').value = this.dataset.id;
            document.getElementById('produkIdEdit').value = this.dataset.produkId;
            document.getElementById('pengirimIdEdit').value = this.dataset.pengirimId;
            document.getElementById('namaPenerimaEdit').value = this.dataset.namaPenerima;
            document.getElementById('alamatPenerimaEdit').value = this.dataset.alamatPenerima;
            document.getElementById('jumlahEdit').value = this.dataset.jumlah;
            document.getElementById('statusEdit').value = this.dataset.status;

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
            produk_id: document.getElementById('produkIdEdit').value,
            user_id: document.getElementById('pengirimIdEdit').value,
            nama_penerima: document.getElementById('namaPenerimaEdit').value,
            alamat_penerima: document.getElementById('alamatPenerimaEdit').value,
            jumlah: document.getElementById('jumlahEdit').value,
            status: document.getElementById('statusEdit').value,
        })
        .then(res => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.data.message ?? 'Data pesanan berhasil diperbarui',
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
     * TAMBAH PESANAN
     * ======================= */
    const tambahForm = document.getElementById('tambahPesananForm');
    const tambahBtn = document.getElementById('btnTambahPesanan');

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
                text: res.data.message ?? 'Pesanan berhasil ditambahkan',
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
     * HAPUS PESANAN
     * ======================= */
    document.querySelectorAll('.form-delete-pesanan').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const url = this.dataset.url;

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data pesanan akan dihapus permanen!',
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
                            text: res.data.message ?? 'Pesanan berhasil dihapus',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    })
                    .catch((err) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Data gagal dihapus'
                        });
                        console.log(err.response);
                    });
                }
            });
        });
    });
});
