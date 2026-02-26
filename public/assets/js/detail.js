document.addEventListener("DOMContentLoaded", function () {

    const minusBtn = document.querySelector(".minus");
    const plusBtn = document.querySelector(".plus");
    const qtyNumber = document.querySelector(".qty-number");
    const waButton = document.getElementById("waButton");

    const productName = document.querySelector(".product-detail").dataset.nama;
    const phoneNumber = "6287731122287";

    let quantity = 1;

    function updateWhatsAppLink() {
        const message = `Permisi kak, saya ingin membeli ${productName} sebanyak ${quantity} buah untuk memberikan kejutan di momen spesial. Mohon informasinya, ya!`;
        const encodedMessage = encodeURIComponent(message);
        waButton.href = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
    }

    plusBtn.addEventListener("click", function () {
        quantity++;
        qtyNumber.textContent = quantity;
        updateWhatsAppLink();
    });

    minusBtn.addEventListener("click", function () {
        if (quantity > 1) {
            quantity--;
            qtyNumber.textContent = quantity;
            updateWhatsAppLink();
        }
    });

    // Set default link saat pertama load
    updateWhatsAppLink();

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

    thumbs.forEach(img => {
        img.addEventListener("click", function () {

            // Ganti gambar utama
            mainImage.src = this.dataset.img;

            // Hapus active lama
            thumbs.forEach(i => i.classList.remove("active"));

            // Tambah active baru
            this.classList.add("active");
        });
    });

    const formTambahWishlist = document.getElementById("tambah-wishlist");

    if(formTambahWishlist){
        formTambahWishlist.addEventListener("submit", function(e){
            e.preventDefault();

            this.querySelector('.btn-text').classList.add('d-none');
            this.querySelector('.btn-loading').classList.remove('d-none');

            const produkId = formTambahWishlist.dataset.produkId;
            const userId = formTambahWishlist.dataset.userId;
            const url = this.dataset.url;

            axios.post(url, {
                user_id: userId,
                produk_id: produkId,
                total: quantity
            }).then(res => {
                if(res.data.status){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.data.message ?? 'Produk berhasil ditambahkan ke wishlist',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                }
            }).catch(err => {
                let msg = 'Terjadi kesalahan';
                if (err.response?.status === 422) {
                    msg = Object.values(err.response.data.errors)[0][0];
                }
                Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
            }).finally(() => {
                this.querySelector('.btn-text').classList.remove('d-none');
                this.querySelector('.btn-loading').classList.add('d-none');
            })
        });
    }

    const formHapusWishlist = document.getElementById('hapus-wishlist');

    if(formHapusWishlist){
        formHapusWishlist.addEventListener('submit', function (e) {
            e.preventDefault();

            this.querySelector('.btn-text').classList.add('d-none');
            this.querySelector('.btn-loading').classList.remove('d-none');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Produk akan dihapus dari wishlist',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#B00000',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(result => {
                if(result.isConfirmed){
                    const wishlistId = this.dataset.wishlist;
                    const urlWishlist = this.dataset.url.replace('/0', '/' + wishlistId);

                    axios.delete(urlWishlist,{ data: {
                        id: wishlistId
                    }
                    }).then(res => {
                        if(res.data.status){
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.data.message ?? 'Produk berhasil dihapus dari wishlist',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        }
                    }).catch(err => {
                        let msg = 'Terjadi kesalahan';
                        if (err.response?.status === 422) {
                            msg = Object.values(err.response.data.errors)[0][0];
                        }
                        Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                    }).finally(() => {
                        this.querySelector('.btn-text').classList.remove('d-none');
                        this.querySelector('.btn-loading').classList.add('d-none');
                    })
                }
            })
        });
    }
});
