document.addEventListener("DOMContentLoaded", function () {
    const minusBtn = document.querySelector(".minus");
    const plusBtn = document.querySelector(".plus");
    const qtyNumber = document.querySelector(".qty-number");

    let quantity = 1;

    plusBtn.addEventListener("click", function () {
        quantity++;
        qtyNumber.textContent = quantity;
    });

    minusBtn.addEventListener("click", function () {
        if (quantity > 1) {
            quantity--;
            qtyNumber.textContent = quantity;
        }
    });

    // Init Swiper
    const swiper = new Swiper(".mySwiper", {
        slidesPerView: "auto",
        spaceBetween: 10,
        freeMode: true,
    });

    const mainImage = document.getElementById("mainImage");
    const thumbs = document.querySelectorAll(".thumb-img");

    // Set default active
    if (thumbs.length > 0) {
        thumbs[0].classList.add("active");
    }

    thumbs.forEach((img) => {
        img.addEventListener("click", function () {
            // Ganti gambar utama
            mainImage.src = this.dataset.img;

            // Hapus active lama
            thumbs.forEach((i) => i.classList.remove("active"));

            // Tambah active baru
            this.classList.add("active");
        });
    });

    const formTambahWishlist = document.getElementById("tambah-wishlist");

    if (formTambahWishlist) {
        formTambahWishlist.addEventListener("submit", function (e) {
            e.preventDefault();

            this.querySelector(".btn-text").classList.add("d-none");
            this.querySelector(".btn-loading").classList.remove("d-none");

            const produkId = formTambahWishlist.dataset.produkId;
            const userId = formTambahWishlist.dataset.userId;
            const url = this.dataset.url;

            axios
                .post(url, {
                    user_id: userId,
                    produk_id: produkId,
                    total: quantity,
                })
                .then((res) => {
                    if (res.data.status) {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text:
                                res.data.message ??
                                "Produk berhasil ditambahkan ke wishlist",
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(() => location.reload());
                    }
                })
                .catch((err) => {
                    let msg = "Terjadi kesalahan";
                    if (err.response?.status === 422) {
                        msg = Object.values(err.response.data.errors)[0][0];
                    }
                    Swal.fire({ icon: "error", title: "Gagal", text: msg });
                })
                .finally(() => {
                    this.querySelector(".btn-text").classList.remove("d-none");
                    this.querySelector(".btn-loading").classList.add("d-none");
                });
        });
    }

    const formHapusWishlist = document.getElementById("hapus-wishlist");

    if (formHapusWishlist) {
        formHapusWishlist.addEventListener("submit", function (e) {
            e.preventDefault();

            this.querySelector(".btn-text").classList.add("d-none");
            this.querySelector(".btn-loading").classList.remove("d-none");

            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Produk akan dihapus dari wishlist",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#B00000",
                confirmButtonText: "Ya, hapus",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    const wishlistId = this.dataset.wishlist;
                    const urlWishlist = this.dataset.url.replace(
                        "/0",
                        "/" + wishlistId,
                    );

                    axios
                        .delete(urlWishlist, {
                            data: {
                                id: wishlistId,
                            },
                        })
                        .then((res) => {
                            if (res.data.status) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil",
                                    text:
                                        res.data.message ??
                                        "Produk berhasil dihapus dari wishlist",
                                    timer: 1500,
                                    showConfirmButton: false,
                                }).then(() => location.reload());
                            }
                        })
                        .catch((err) => {
                            let msg = "Terjadi kesalahan";
                            if (err.response?.status === 422) {
                                msg = Object.values(
                                    err.response.data.errors,
                                )[0][0];
                            }
                            Swal.fire({
                                icon: "error",
                                title: "Gagal",
                                text: msg,
                            });
                        })
                        .finally(() => {
                            this.querySelector(".btn-text").classList.remove(
                                "d-none",
                            );
                            this.querySelector(".btn-loading").classList.add(
                                "d-none",
                            );
                        });
                }
            });
        });
    }

    const formCheckout = document.getElementById("penerima-form");

    if (!formCheckout) return;

    formCheckout.addEventListener("submit", function (e) {
        e.preventDefault();

        const btn = formCheckout.querySelector("#btnTambahPenerima");
        const btnText = btn.querySelector(".btn-text");
        const btnLoading = btn.querySelector(".btn-loading");

        // tampilkan loading
        btnText.classList.add("d-none");
        btnLoading.classList.remove("d-none");

        // ambil data form
        const produkId = formCheckout.dataset.produkId;
        const userId = formCheckout.dataset.userId;
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
