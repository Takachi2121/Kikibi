document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".form-delete-wishlist").forEach((form) => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const url = this.dataset.url.replace("/0", "/" + id);

            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Wishlist ini akan dihapus dari daftar!",
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
                                text:
                                    res.data.message ??
                                    "Wishlist berhasil dihapus",
                                timer: 1500,
                                showConfirmButton: false,
                            }).then(() => location.reload());
                        })
                        .catch((err) => {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal",
                                text: "Data gagal dihapus",
                            });

                            console.log(err.response);
                        });
                }
            });
        });
    });

    const dropdownItems = document.querySelectorAll(".dropdown-item");
    const productContainer = document.querySelector(".row.mt-2"); // container wishlist items
    const filterLabel = document.getElementById("filter-etalase");

    dropdownItems.forEach((item) => {
        item.addEventListener("click", function (e) {
            e.preventDefault();

            // Hapus active class
            dropdownItems.forEach((i) => i.classList.remove("active"));
            this.classList.add("active");

            const sortType = this.getAttribute("data-sort");
            filterLabel.textContent = this.textContent;

            sortProducts(sortType);
        });
    });

    function sortProducts(type) {
        const products = Array.from(
            productContainer.querySelectorAll(".col-lg-12.mt-3.pt-4"),
        );

        products.sort((a, b) => {
            // Ambil harga dari <p> di .col-12.col-md-7
            const hargaAString = a
                .querySelector(".col-12.col-md-7 p")
                .textContent.replace(/[^\d]/g, "");
            const hargaBString = b
                .querySelector(".col-12.col-md-7 p")
                .textContent.replace(/[^\d]/g, "");

            const hargaA = parseInt(hargaAString);
            const hargaB = parseInt(hargaBString);

            if (type === "harga_asc") return hargaA - hargaB;
            if (type === "harga_desc") return hargaB - hargaA;

            return 0; // default
        });

        products.forEach((product) => productContainer.appendChild(product));
    }

    axios.defaults.headers.common["X-CSRF-TOKEN"] = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    document.querySelectorAll(".qty-wrapper").forEach((wrapper) => {
        const minusBtn = wrapper.querySelector(".minus");
        const plusBtn = wrapper.querySelector(".plus");
        const qtyNumber = wrapper.querySelector(".qty-number");

        const wishlistId = wrapper.dataset.id;
        let quantity = parseInt(qtyNumber.textContent);

        function sendUpdate(newQty) {
            axios
                .patch(`/wishlist-action/${wishlistId}`, { total: newQty })
                .catch((err) => {
                    console.error(err.response || err);
                    // optional: rollback UI kalau error
                    qtyNumber.textContent = quantity;
                });
        }

        plusBtn.addEventListener("click", () => {
            quantity++; // update UI dulu
            qtyNumber.textContent = quantity;
            sendUpdate(quantity); // kirim ke server
        });

        minusBtn.addEventListener("click", () => {
            if (quantity > 1) {
                quantity--; // update UI dulu
                qtyNumber.textContent = quantity;
                sendUpdate(quantity); // kirim ke server
            }
        });
    });

    const formCheckout = document.getElementById("penerima-form");

    if (!formCheckout) return;

    formCheckout.addEventListener("submit", function (e) {
        e.preventDefault();

        const quantity = formCheckout.dataset.quantity;

        const btn = formCheckout.querySelector("#btnTambahPenerima");
        const btnText = btn.querySelector(".btn-text");
        const btnLoading = btn.querySelector(".btn-loading");

        // tampilkan loading
        btnText.classList.add("d-none");
        btnLoading.classList.remove("d-none");

        // ambil data form
        const produkId = formCheckout.dataset.produkId;
        const userId = formCheckout.dataset.userId;
        const wishlistId = this.dataset.wishlist;
        const url = formCheckout.dataset.url;

        const payload = {
            produk_id: produkId,
            user_id: userId,
            nama_penerima: document.getElementById("namaPenerimaTambah").value,
            alamat_penerima: document.getElementById("alamatPenerimaTambah")
                .value,
            notelp_penerima: document.getElementById("noTelpPenerimaTambah")
                .value,
            catatan: document.getElementById("catatanPenerimaTambah").value,
            jumlah: quantity,
            status: "Pending",
            wishlist: wishlistId,
        };

        console.log(payload);

        axios
            .post(url, payload)
            .then((res) => {
                if (res.data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: res.data.message ?? "Pesanan berhasil dibuat",
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => {
                        location.reload();
                    });
                }
            })
            .catch((err) => {
                let msg = "Terjadi kesalahan";
                if (err.response?.status === 422) {
                    msg = Object.values(err.response.data.errors)[0];
                }
                console.log(err.response);
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: msg,
                });
            })
            .finally(() => {
                btnText.classList.remove("d-none");
                btnLoading.classList.add("d-none");
            });
    });
});
