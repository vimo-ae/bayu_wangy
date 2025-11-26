<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <title>Keranjang</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&display=swap');
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <section id="cart" class="cart-section">
        <div class="container">

            <!-- Keranjang Kosong -->
            <div id="cart-empty" class="cart-empty text-center" style="display:none;">
                <h1 class="cart-title">Keranjang Anda</h1>
                <p class="cart-subtitle">Keranjang Anda saat ini kosong.</p>
                <a href="produk.php" class="btn btn-dark cart-continue-btn">
                    LANJUT BELANJA
                </a>
            </div>

            <!-- Keranjang ada barang -->
            <div id="cart-has-items" class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <h1 class="cart-title mb-4 text-center text-md-start">Keranjang Anda</h1>

                    <div class="table-responsive">
                        <table class="table align-middle cart-table" id="cart-table">
                            <thead>
                                <tr>
                                    <th scope="col">Produk</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-end">Harga</th>
                                    <th scope="col" class="text-end">Subtotal</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="cart-item">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="images/home_parfum.png"
                                                 class="cart-item-img me-3" alt="">
                                            <div>
                                                <div class="fw-semibold">Aroma Elegance</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <input type="number" class="form-control form-control-sm text-center cart-qty"
                                               value="1" min="1" style="width:70px;">
                                    </td>
                                    <td class="text-end cart-price" data-price="120000">
                                        Rp120.000
                                    </td>
                                    <td class="text-end cart-subtotal">
                                        Rp120.000
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-danger btn-delete-item">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>

                                <tr class="cart-item">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="images/home_parfum.png"
                                                 class="cart-item-img me-3" alt="">
                                            <div>
                                                <div class="fw-semibold">Fresh Breeze</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <input type="number" class="form-control form-control-sm text-center cart-qty"
                                               value="2" min="1" style="width:70px;">
                                    </td>
                                    <td class="text-end cart-price" data-price="110000">
                                        Rp110.000
                                    </td>
                                    <td class="text-end cart-subtotal">
                                        Rp220.000
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-danger btn-delete-item">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <th class="text-end" id="cart-total">Rp340.000</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
                        <a href="produk.php" class="btn btn-outline-dark mb-3 mb-md-0">
                            Lanjut Belanja
                        </a>
                        <button class="btn btn-dark" type="button">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="bootstrap/js/bootstrap.js"></script>

    <script>
        function formatRupiah(angka) {
            return 'Rp' + angka.toLocaleString('id-ID');
        }

        function hitungTotal() {
            let total = 0;
            const rows = document.querySelectorAll('.cart-item');
            rows.forEach(row => {
                const priceEl = row.querySelector('.cart-price');
                const qtyEl   = row.querySelector('.cart-qty');
                const subEl   = row.querySelector('.cart-subtotal');

                const price = parseInt(priceEl.getAttribute('data-price')) || 0;
                const qty   = parseInt(qtyEl.value) || 0;
                const subtotal = price * qty;

                subEl.textContent = formatRupiah(subtotal);
                total += subtotal;
            });

            document.getElementById('cart-total').textContent = formatRupiah(total);

            // kalau tidak ada item, tampilkan "keranjang kosong"
            const cartHasItems = document.getElementById('cart-has-items');
            const cartEmpty    = document.getElementById('cart-empty');
            if (rows.length === 0) {
                cartHasItems.style.display = 'none';
                cartEmpty.style.display = 'flex';
            } else {
                cartHasItems.style.display = 'block';
                cartEmpty.style.display = 'none';
            }
        }

        // event: ubah qty
        document.querySelectorAll('.cart-qty').forEach(input => {
            input.addEventListener('change', function () {
                if (this.value <= 0) this.value = 1;
                hitungTotal();
            });
        });

        // event: hapus item
        document.querySelectorAll('.btn-delete-item').forEach(btn => {
            btn.addEventListener('click', function () {
                const row = this.closest('.cart-item');
                row.parentNode.removeChild(row);
                hitungTotal();
            });
        });

        // hitung total di awal
        hitungTotal();
    </script>
</body>
</html>
