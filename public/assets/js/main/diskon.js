document.addEventListener("DOMContentLoaded", function () {
    /* =======================
     * DATATABLE
     * ======================= */
    $("#DiskonsTable").DataTable({
        responsive: true,
        scrollY: "600px",
        scrollCollapse: true,
        pageLength: -1,
        dom: "Bfrt",
        buttons: [
            {
                extend: "excelHtml5",
                text: "Export Excel",
                className: "btn btn-success",
                title: "Data Diskon",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5], // No, Nama Produk, Nama Pengirim, No Telp, Jumlah, Total, Status
                    format: {
                        body: function (data) {
                            const div = document.createElement("div");
                            div.innerHTML = data;
                            return div.textContent || div.innerText || "";
                        },
                    },
                },
            },
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: { next: "Next", previous: "Prev" },
        },
    });

    /* =======================
     * MODAL EDIT
     * ======================= */
    const editModalEl = document.getElementById("editDiskonModal");
    const editModal = new bootstrap.Modal(editModalEl);
    const editForm = document.getElementById("editDiskonForm");
    const editBtn = document.getElementById("btnDiskonEdit");

    // tombol edit di tabel Pesanan
    document.querySelectorAll("#DiskonsTable .btn-warning").forEach((btn) => {
        btn.addEventListener("click", function () {
            document.getElementById("idEdit").value = this.dataset.id;
            document.getElementById("produkEdit").value = this.dataset.produk;
            document.getElementById("diskonEdit").value = this.dataset.diskon;
            document.getElementById("tanggalEdit").value =
                this.dataset.tanggalSelesai;

            editModal.show();
        });
    });

    editForm.addEventListener("submit", function (e) {
        e.preventDefault();

        editBtn.disabled = true;
        editBtn.querySelector(".btn-text").classList.add("d-none");
        editBtn.querySelector(".btn-loading").classList.remove("d-none");

        const id = document.getElementById("idEdit").value;
        const url = editForm.dataset.url.replace("/0", "/" + id);

        axios
            .put(url, {
                produk_id: document.getElementById("produkEdit").value,
                diskon: document.getElementById("diskonEdit").value,
                tanggal_selesai: document.getElementById("tanggalEdit").value,
            })
            .then((res) => {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.data.message ?? "Data Diskon berhasil diperbarui",
                    timer: 1500,
                    showConfirmButton: false,
                }).then(() => location.reload());
            })
            .catch((err) => {
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: err.response?.data?.message ?? "Terjadi kesalahan",
                });
                console.log(err.response);
            })
            .finally(() => {
                editBtn.disabled = false;
                editBtn.querySelector(".btn-text").classList.remove("d-none");
                editBtn.querySelector(".btn-loading").classList.add("d-none");
            });
    });

    /* =======================
     * TAMBAH PESANAN
     * ======================= */
    const tambahForm = document.getElementById("addDiskonForm");
    const tambahBtn = document.getElementById("btnTambahDiskon");

    tambahForm.addEventListener("submit", function (e) {
        e.preventDefault();

        tambahBtn.disabled = true;
        tambahBtn.querySelector(".btn-text").classList.add("d-none");
        tambahBtn.querySelector(".btn-loading").classList.remove("d-none");

        const formData = new FormData(tambahForm);
        const url = tambahForm.dataset.url;

        for (feri of formData.entries()) {
            console.log(feri);
        }

        axios
            .post(url, formData)
            .then((res) => {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.data.message ?? "Pesanan berhasil ditambahkan",
                    timer: 1500,
                    showConfirmButton: false,
                }).then(() => location.reload());
            })
            .catch((err) => {
                let msg = "Terjadi kesalahan";
                if (err.response?.status === 422) {
                    msg = Object.values(err.response.data.errors)[0][0];
                }
                Swal.fire({ icon: "error", title: "Gagal", text: msg });
                console.log(err.response);
            })
            .finally(() => {
                tambahBtn.disabled = false;
                tambahBtn.querySelector(".btn-text").classList.remove("d-none");
                tambahBtn.querySelector(".btn-loading").classList.add("d-none");
            });
    });

    document.addEventListener("submit", function (e) {
        const form = e.target.closest(".form-delete-diskon");
        if (!form) return;

        e.preventDefault();
        const url = form.dataset.url;

        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data diskon akan dihapus permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, hapus",
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .delete(url)
                    .then((res) => {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: res.data.message ?? "Diskon berhasil dihapus",
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(() => location.reload());
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: "Data gagal dihapus",
                        });
                    });
            }
        });
    });
});
