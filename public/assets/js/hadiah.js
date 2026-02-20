document.addEventListener("DOMContentLoaded", function () {

    const dropdownItems = document.querySelectorAll(".dropdown-item");
    const productContainer = document.querySelector(".row.mt-3");
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
        const products = Array.from(productContainer.querySelectorAll(".col-lg-3"));

        products.sort((a, b) => {
            const hargaA = parseInt(a.querySelector(".product-card").dataset.harga);
            const hargaB = parseInt(b.querySelector(".product-card").dataset.harga);

            if (type === "harga_asc") {
                return hargaA - hargaB; // Termurah ke termahal
            }

            if (type === "harga_desc") {
                return hargaB - hargaA; // Termahal ke termurah
            }

            // Default = relevansi (urutan awal)
            return 0;
        });

        // Re-append ke container
        products.forEach(product => {
            productContainer.appendChild(product);
        });
    }

});
