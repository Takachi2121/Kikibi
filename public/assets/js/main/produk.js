// -------------------
// PREVIEW IMAGE
// -------------------
function previewImage(input, index) {
    const preview = document.getElementById('preview_foto_' + index);
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

document.addEventListener('DOMContentLoaded', function() {

    /* =======================
     * DATATABLE
     * ======================= */
    $('#ProduksTable').DataTable({
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
                title: 'Data Produk',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
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

    // -------------------
    // HARGA INPUT
    // -------------------
    const hargaInput = document.getElementById('harga_produk');
    if(hargaInput){
        hargaInput.addEventListener('input', function() {
            let angka = this.value.replace(/[^0-9]/g, '');
            let formatted = angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            this.value = angka ? 'Rp ' + formatted : '';
        });

        hargaInput.form.addEventListener('submit', function() {
            hargaInput.value = hargaInput.value.replace(/[^0-9]/g, '');
        });
    }

    // -------------------
    // FORM TAMBAH PRODUK
    // -------------------
    const tambahForm = document.getElementById('tambahProdukForm');
    const tambahBtn = document.getElementById('btnTambahProduk');
    if(tambahForm){
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
                    text: res.data.message ?? 'Produk berhasil ditambahkan',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if(res.data.redirect){
                        window.location.href = res.data.redirect;
                    } else {
                        location.reload();
                    }
                });
            })
            .catch(err => {
                let msg = 'Terjadi kesalahan';
                if (err.response?.status === 422) {
                    msg = Object.values(err.response.data.errors)[0][0];
                }
                Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                console.log(err.response);
            })
            .finally(() => {
                tambahBtn.disabled = false;
                tambahBtn.querySelector('.btn-text').classList.remove('d-none');
                tambahBtn.querySelector('.btn-loading').classList.add('d-none');
            });
        });
    }

    // -------------------
    // FORM EDIT PRODUK
    // -------------------
    const editForm = document.getElementById('editProdukForm');
    const editBtn = document.getElementById('btnEditProduk');

    if(editForm){
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            editBtn.disabled = true;
            editBtn.querySelector('.btn-text').classList.add('d-none');
            editBtn.querySelector('.btn-loading').classList.remove('d-none');

            const formData = new FormData(editForm);
            formData.append('_method', 'PUT');
            const url = editForm.dataset.url;

            axios.post(url, formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }) // pakai POST + override
            .then(res => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.data.message ?? 'Produk berhasil diubah',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if(res.data.redirect){
                        window.location.href = res.data.redirect;
                    } else {
                        location.reload();
                    }
                });
            })
            .catch(err => {
                let msg = 'Terjadi kesalahan';
                if (err.response?.status === 422) {
                    msg = Object.values(err.response.data.errors)[0][0];
                }
                Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                console.log(err.response);
            })
            .finally(() => {
                editBtn.disabled = false;
                editBtn.querySelector('.btn-text').classList.remove('d-none');
                editBtn.querySelector('.btn-loading').classList.add('d-none');
            });
        });
    }

    // -------------------
    // DELETE PRODUK
    // -------------------
    document.querySelectorAll('.form-delete-Produk').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const url = this.dataset.url.replace('/0','/' + id);

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data produk akan dihapus permanen!',
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
                            text: res.data.message ?? 'Produk berhasil dihapus',
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
