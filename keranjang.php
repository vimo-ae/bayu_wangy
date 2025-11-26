<!-- hitamkan di css -->
<!-- CREATE DATABASE bayu_wangy CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  price INT NOT NULL,
  image VARCHAR(255) DEFAULT NULL
);

CREATE TABLE cart_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  session_id VARCHAR(255) NOT NULL,
  product_id INT NOT NULL,
  qty INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id)
); -->

<?php
session_start();

$host = 'localhost';
$db   = 'nama_database';
$user = 'db_user';
$pass = 'db_pass';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (Exception $e) {
    if (isset($_GET['action']) || strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Database connection failed']);
        exit;
    } else {
        die('Database connection failed. Sesuaikan kredensial di file ini.');
    }
}

function get_json_input() {
    $raw = file_get_contents('php://input');
    if (!$raw) return [];
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

$action = $_GET['action'] ?? null;
if ($action) {
    header('Content-Type: application/json');
    $session_id = session_id();

    try {
        if ($action === 'get_cart') {
            $sql = "SELECT c.id as cart_id, p.id as product_id, p.name, p.price, p.image, c.qty
                    FROM cart_items c
                    JOIN products p ON c.product_id = p.id
                    WHERE c.session_id = :sid
                    ORDER BY c.id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['sid' => $session_id]);
            $items = $stmt->fetchAll();
            echo json_encode(['items' => $items]);
            exit;
        }

        if ($action === 'add') {
            $input = get_json_input();
            $product_id = isset($input['product_id']) ? (int)$input['product_id'] : 0;
            if ($product_id <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid product_id']);
                exit;
            }

            $stmt = $pdo->prepare("SELECT id FROM cart_items WHERE session_id = :sid AND product_id = :pid");
            $stmt->execute(['sid' => $session_id, 'pid' => $product_id]);
            $existing = $stmt->fetch();

            if ($existing) {
                $pdo->prepare("UPDATE cart_items SET qty = qty + 1 WHERE id = :id")
                    ->execute(['id' => $existing['id']]);
            } else {
                $pdo->prepare("INSERT INTO cart_items (session_id, product_id, qty) VALUES (:sid, :pid, 1)")
                    ->execute(['sid' => $session_id, 'pid' => $product_id]);
            }

            echo json_encode(['success' => true]);
            exit;
        }

        if ($action === 'update_qty') {
            $input = get_json_input();
            $cart_id = isset($input['cart_id']) ? (int)$input['cart_id'] : 0;
            $qty = isset($input['qty']) ? (int)$input['qty'] : 0;
            if ($cart_id <= 0 || $qty <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid input']);
                exit;
            }

            $stmt = $pdo->prepare("UPDATE cart_items SET qty = :qty WHERE id = :id AND session_id = :sid");
            $stmt->execute(['qty' => $qty, 'id' => $cart_id, 'sid' => $session_id]);
            echo json_encode(['success' => true]);
            exit;
        }

        if ($action === 'delete') {
            $input = get_json_input();
            $cart_id = isset($input['cart_id']) ? (int)$input['cart_id'] : 0;
            if ($cart_id <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid cart_id']);
                exit;
            }

            $stmt = $pdo->prepare("DELETE FROM cart_items WHERE id = :id AND session_id = :sid");
            $stmt->execute(['id' => $cart_id, 'sid' => $session_id]);
            echo json_encode(['success' => true]);
            exit;
        }

        if ($action === 'checkout') {
            $sql = "SELECT c.id as cart_id, p.id as product_id, p.price, c.qty
                    FROM cart_items c
                    JOIN products p ON c.product_id = p.id
                    WHERE c.session_id = :sid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['sid' => $session_id]);
            $items = $stmt->fetchAll();

            if (empty($items)) {
                http_response_code(400);
                echo json_encode(['error' => 'Cart kosong']);
                exit;
            }

            $total = 0;
            foreach ($items as $it) {
                $total += ((int)$it['price']) * ((int)$it['qty']);
            }

            $del = $pdo->prepare("DELETE FROM cart_items WHERE session_id = :sid");
            $del->execute(['sid' => $session_id]);

            echo json_encode(['success' => true, 'total' => $total]);
            exit;
        }

        http_response_code(400);
        echo json_encode(['error' => 'Unknown action']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Server error', 'message' => $e->getMessage()]);
    }
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&display=swap');
        .cart-item-img { width:60px; height:60px; object-fit:cover; }
        .cart-title { font-family: 'Bodoni Moda', serif; }
        .cart-empty { min-height:200px; align-items:center; justify-content:center; display:flex; flex-direction:column; }
    </style>
</head>
<body>

    <section id="cart" class="cart-section py-4">
        <div class="container">

            <div id="cart-empty" class="cart-empty text-center" style="display:none;">
                <h1 class="cart-title">Keranjang Anda</h1>
                <p class="cart-subtitle">Keranjang Anda saat ini kosong.</p>
                <a href="produk.php" class="btn btn-dark cart-continue-btn">LANJUT BELANJA</a>
            </div>

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
                            <tbody id="cart-body">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <th class="text-end" id="cart-total">Rp0</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
                        <a href="katalog.php" class="btn btn-outline-dark mb-3 mb-md-0">Lanjut Belanja</a>
                        <button id="btn-checkout" class="btn btn-dark" type="button">Checkout</button>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script src="bootstrap/js/bootstrap.js"></script>
    <script>
    function formatRupiah(angka) {
        return 'Rp' + angka.toLocaleString('id-ID');
    }

    async function apiCall(action, method = 'GET', body = null) {
        const url = '<?= basename($_SERVER['PHP_SELF']); ?>?action=' + encodeURIComponent(action);
        const opts = { method, headers: {} };
        if (body) {
            opts.headers['Content-Type'] = 'application/json';
            opts.body = JSON.stringify(body);
        }
        const res = await fetch(url, opts);
        if (!res.ok) {
            let txt = await res.text();
            throw new Error(txt || 'Network error');
        }
        return res.json();
    }

    function escapeHtml(text) {
        return String(text)
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;')
          .replace(/'/g, '&#039;');
    }

    function renderCart(items) {
        const tbody = document.getElementById('cart-body');
        tbody.innerHTML = '';
        if (!items.length) {
            document.getElementById('cart-has-items').style.display = 'none';
            document.getElementById('cart-empty').style.display = 'flex';
            document.getElementById('cart-total').textContent = formatRupiah(0);
            return;
        } else {
            document.getElementById('cart-has-items').style.display = 'block';
            document.getElementById('cart-empty').style.display = 'none';
        }

        let total = 0;
        items.forEach(item => {
            const price = parseInt(item.price) || 0;
            const qty = parseInt(item.qty) || 0;
            const subtotal = price * qty;
            total += subtotal;

            const tr = document.createElement('tr');
            tr.className = 'cart-item';
            tr.dataset.cartId = item.cart_id;

            tr.innerHTML = `
                <td>
                    <div class="d-flex align-items-center">
                        <img src="${item.image ? escapeHtml(item.image) : 'images/home_parfum.png'}" class="cart-item-img me-3" alt="">
                        <div><div class="fw-semibold">${escapeHtml(item.name)}</div></div>
                    </div>
                </td>
                <td class="text-center">
                    <input type="number" class="form-control form-control-sm text-center cart-qty" value="${qty}" min="1" style="width:70px;">
                </td>
                <td class="text-end cart-price" data-price="${price}">${formatRupiah(price)}</td>
                <td class="text-end cart-subtotal">${formatRupiah(subtotal)}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-danger btn-delete-item">Hapus</button>
                </td>
            `;

            tbody.appendChild(tr);
        });

        document.getElementById('cart-total').textContent = formatRupiah(total);

        document.querySelectorAll('.cart-qty').forEach(input => {
            input.addEventListener('change', async function () {
                let val = parseInt(this.value) || 1;
                if (val <= 0) val = 1;
                this.value = val;
                const row = this.closest('.cart-item');
                const cartId = row.dataset.cartId;
                try {
                    await apiCall('update_qty', 'POST', { cart_id: cartId, qty: val });
                    await loadCart();
                } catch (e) {
                    console.error(e);
                    alert('Gagal update qty');
                }
            });
        });

        document.querySelectorAll('.btn-delete-item').forEach(btn => {
            btn.addEventListener('click', async function () {
                if (!confirm('Hapus item ini dari keranjang?')) return;
                const row = this.closest('.cart-item');
                const cartId = row.dataset.cartId;
                try {
                    await apiCall('delete', 'POST', { cart_id: cartId });
                    await loadCart();
                } catch (e) {
                    console.error(e);
                    alert('Gagal hapus item');
                }
            });
        });
    }

    async function loadCart() {
        try {
            const res = await apiCall('get_cart');
            renderCart(res.items || []);
        } catch (e) {
            console.error('loadCart error', e);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        loadCart();

        document.getElementById('btn-checkout').addEventListener('click', async function () {
            if (!confirm('Lanjut ke checkout?')) return;
            try {
                const res = await apiCall('checkout', 'POST', {});
                if (res.success) {
                    alert('Checkout sukses. Total: ' + formatRupiah(res.total || 0));
                    loadCart();
                } else {
                    alert('Checkout gagal: ' + (res.error || 'Unknown'));
                }
            } catch (e) {
                console.error(e);
                alert('Checkout error');
            }
        });
    });

    async function addToCart(productId) {
        try {
            const res = await apiCall('add', 'POST', { product_id: productId });
            if (res.success) {
                alert('Produk ditambahkan ke keranjang');
                loadCart();
            } else {
                alert('Gagal menambah ke keranjang: ' + (res.error || 'Unknown'));
            }
        } catch (e) {
            console.error(e);
            alert('Error menambah ke keranjang');
        }
    }
    </script>
</body>
</html>
