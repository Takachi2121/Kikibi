document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.form-delete-wishlist').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const url = this.dataset.url.replace('/0','/' + id);

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Wishlist ini akan dihapus dari daftar!',
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
                            text: res.data.message ?? 'Wishlist berhasil dihapus',
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

    const dropdownItems = document.querySelectorAll(".dropdown-item");
    const productContainer = document.querySelector(".row.mt-2"); // container wishlist items
    const filterLabel = document.getElementById("filter-etalase");

    dropdownItems.forEach(item => {
        item.addEventListener("click", function (e) {
            e.preventDefault();

            // Hapus active class
            dropdownItems.forEach(i => i.classList.remove("active"));
            this.classList.add("active");

            const sortType = this.getAttribute("data-sort");
            filterLabel.textContent = this.textContent;

            sortProducts(sortType);
        });
    });

    function sortProducts(type) {
        const products = Array.from(productContainer.querySelectorAll(".col-lg-12.mt-3.pt-4"));

        products.sort((a, b) => {
            // Ambil harga dari <p> di .col-12.col-md-7
            const hargaAString = a.querySelector(".col-12.col-md-7 p").textContent.replace(/[^\d]/g, '');
            const hargaBString = b.querySelector(".col-12.col-md-7 p").textContent.replace(/[^\d]/g, '');

            const hargaA = parseInt(hargaAString);
            const hargaB = parseInt(hargaBString);

            if (type === "harga_asc") return hargaA - hargaB;
            if (type === "harga_desc") return hargaB - hargaA;

            return 0; // default
        });

        products.forEach(product => productContainer.appendChild(product));
    }

});
