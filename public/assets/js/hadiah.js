document.addEventListener('DOMContentLoaded', function () {
    const filterText = document.getElementById('filter-etalase');
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    const productList = document.getElementById('product-list');

    dropdownItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();

            // Update label
            filterText.textContent = this.textContent.trim();

            // Active state
            dropdownItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            const sortType = this.dataset.sort;
            sortProducts(sortType);
        });
    });

    function sortProducts(type) {
        const products = Array.from(
            productList.querySelectorAll('.product-item')
        );

        products.sort((a, b) => {
            const cardA = a.querySelector('.product-card');
            const cardB = b.querySelector('.product-card');

            const hargaA = parseInt(cardA.dataset.harga);
            const hargaB = parseInt(cardB.dataset.harga);

            const ratingA = parseFloat(cardA.dataset.rating);
            const ratingB = parseFloat(cardB.dataset.rating);

            switch (type) {
                case 'harga_asc':
                    return hargaA - hargaB;

                case 'harga_desc':
                    return hargaB - hargaA;

                case 'populer':
                    return ratingB - ratingA;

                default:
                    return 0; // relevansi (urutan awal)
            }
        });

        // Re-append ke DOM (tanpa reload)
        products.forEach(product => {
            productList.appendChild(product);
        });
    }
});
