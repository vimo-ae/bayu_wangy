<?php
session_start();
require 'conn.php';
echo "";

function get_json_input() {
    $raw = file_get_contents('php://input');
    if (!$raw) return [];
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

$action = $_GET['action'] ?? null;
if ($action) {
    header('Content-Type: application/json');
    // PERBAIKAN 1: Ganti id_sesi() yang tidak dikenal menjadi session_id()
    $id_sesi = session_id(); 

    try {
        if ($action === 'get_cart') {
            $sql = "SELECT c.id_keranjang AS id_keranjang, p.id_produk AS id_produk, p.nama_produk AS name, p.harga AS price, p.gambar_produk AS image, c.jumlah AS qty
                   FROM item_keranjang c
                   JOIN produk p ON c.id_produk = p.id_produk
                   WHERE c.id_sesi = ?
                   ORDER BY id_keranjang";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 's', $id_sesi);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $items = [];
            while ($row = mysqli_fetch_assoc($res)) $items[] = $row;
            echo json_encode(['items' => $items]);
            exit;
        }

        if ($action === 'add') {
            $input = get_json_input();
            // PERHATIKAN: Variabel yang dikirim dari JS adalah 'id_produk' dan 'qty'
            $id_produk = isset($input['id_produk']) ? (int)$input['id_produk'] : 0; 
            $jumlah_input = isset($input['qty']) ? (int)$input['qty'] : 1;
            
            // Periksa jika qty yang dimasukkan valid
            if ($jumlah_input <= 0) $jumlah_input = 1;

            if ($id_produk <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid id_produk']);
                exit;
            }

            // (Opsional tapi direkomendasikan: Pengecekan produk ada di DB)
            // ...

            $sql = "SELECT id_keranjang FROM item_keranjang WHERE id_sesi = ? AND id_produk = ? LIMIT 1";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'si', $id_sesi, $id_produk);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $existing = mysqli_fetch_assoc($res);

            if ($existing) {
                // PERBAIKAN 2: UPDATE jumlah berdasarkan $jumlah_input
                $sql2 = "UPDATE item_keranjang SET jumlah = jumlah + ? WHERE id_keranjang = ?";
                $stmt2 = mysqli_prepare($conn, $sql2);
                mysqli_stmt_bind_param($stmt2, 'ii', $jumlah_input, $existing['id_keranjang']);
                mysqli_stmt_execute($stmt2);
            } else {
                // PERBAIKAN 2: INSERT jumlah berdasarkan $jumlah_input
                $sql2 = "INSERT INTO item_keranjang (id_sesi, id_produk, jumlah) VALUES (?, ?, ?)";
                $stmt2 = mysqli_prepare($conn, $sql2);
                mysqli_stmt_bind_param($stmt2, 'sii', $id_sesi, $id_produk, $jumlah_input);
                mysqli_stmt_execute($stmt2);
            }

            echo json_encode(['success' => true]);
            exit;
        }
        
        // Action 'update_jumlah' sudah benar menggunakan 'jumlah'
        if ($action === 'update_jumlah') {
            $input = get_json_input();
            $cart_id = isset($input['cart_id']) ? (int)$input['cart_id'] : 0;
            $jumlah = isset($input['jumlah']) ? (int)$input['jumlah'] : 0;
            if ($cart_id <= 0 || $jumlah <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid input']);
                exit;
            }
            $sql = "UPDATE item_keranjang SET jumlah = ? WHERE id_keranjang = ? AND id_sesi = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'iis', $jumlah, $cart_id, $id_sesi);
            mysqli_stmt_execute($stmt);
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
            $sql = "DELETE FROM item_keranjang WHERE id_keranjang = ? AND id_sesi = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'is', $cart_id, $id_sesi);
            mysqli_stmt_execute($stmt);
            echo json_encode(['success' => true]);
            exit;
        }

if ($action === 'checkout') {
            $input = get_json_input();
            $id_sesi = session_id(); 
            
            // Ambil Data Form Checkout
            $nama_lengkap = $input['nama_lengkap'] ?? '';
            $email = $input['email'] ?? '';
            $no_telepon = $input['no_telepon'] ?? '';
            // Data ini tidak dikirim dari form, dan tidak ada di tabel pesanan, jadi diabaikan di sini.
            // $provinsi = $input['provinsi'] ?? '';
            // $kota = $input['kota'] ?? '';
            $alamat_detail = $input['alamat_detail'] ?? ''; 

            // 1. Ambil Item Keranjang & Hitung Total (Kode ini sudah benar)
            $sql = "SELECT p.id_produk, p.nama_produk, p.harga, c.jumlah 
                    FROM item_keranjang c
                    JOIN produk p ON c.id_produk = p.id_produk
                    WHERE c.id_sesi = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 's', $id_sesi);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $items = [];
            $total_produk = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $items[] = $row;
                $total_produk += ((float)$row['harga']) * ((int)$row['jumlah']);
            }

            if (empty($items)) {
                http_response_code(400);
                echo json_encode(['error' => 'Keranjang kosong.']);
                exit;
            }
            
            // Tetapkan Biaya Ongkir (Statis: Rp20.000)
            $biaya_ongkir = 20000.00;
            $total_akhir = $total_produk + $biaya_ongkir;

            // 2. Simpan ke Tabel Pesanan
            // KOREKSI SQL: Hapus kolom 'provinsi', 'kota', dan 'biaya_ongkir' 
            // agar sesuai dengan tabel `pesanan`
            $sql_order = "INSERT INTO pesanan 
                          (id_sesi, nama_lengkap, email, no_telepon, alamat_detail, total_produk, total_akhir) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
                          
            $stmt_order = mysqli_prepare($conn, $sql_order);
            
            // KOREKSI BINDING: Sesuaikan dengan 5 string dan 2 double (7 parameter)
            // 'sssssdd' : id_sesi, nama_lengkap, email, no_telepon, alamat_detail, total_produk, total_akhir
            mysqli_stmt_bind_param($stmt_order, 'sssssdd', 
                $id_sesi, $nama_lengkap, $email, $no_telepon, $alamat_detail, $total_produk, $total_akhir);
            mysqli_stmt_execute($stmt_order);
            
            // Pengecekan error SQL tambahan (opsional, tapi disarankan)
            if (mysqli_stmt_error($stmt_order)) {
                throw new Exception("SQL Error during order insertion: " . mysqli_stmt_error($stmt_order));
            }
            
            $id_pesanan = mysqli_insert_id($conn);

            // 3. Simpan ke Tabel DetailPesanan (Kode ini sudah benar)
            $sql_detail = "INSERT INTO detail_pesanan (id_pesanan, id_produk, nama_produk, harga_satuan, jumlah) 
                           VALUES (?, ?, ?, ?, ?)";
            $stmt_detail = mysqli_prepare($conn, $sql_detail);
            
            foreach ($items as $item) {
                $harga_satuan = (double)$item['harga'];
                // Binding menggunakan 'iidsi'
                mysqli_stmt_bind_param($stmt_detail, 'iidsi', 
                    $id_pesanan, $item['id_produk'], $item['nama_produk'], $harga_satuan, $item['jumlah']);
                mysqli_stmt_execute($stmt_detail);
            }
            
            // 4. Kosongkan Keranjang (Kode ini sudah benar)
            $del = mysqli_prepare($conn, "DELETE FROM item_keranjang WHERE id_sesi = ?");
            mysqli_stmt_bind_param($del, 's', $id_sesi);
            mysqli_stmt_execute($del);

            echo json_encode(['success' => true, 'order_id' => $id_pesanan, 'total' => $total_akhir]);
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
    <link rel="stylesheet" href="css/styleee.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .cart-item-img { width:60px; height:60px; object-fit:cover; }
        .cart-empty { min-height:200px; align-items:center; justify-content:center; display:flex; flex-direction:column; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section id="cart" class="cart-section py-4">
        <div class="container">

            <div id="cart-empty" class="cart-empty text-center" style="display:none;">
                <i class="bi bi-cart-x"></i>
                <h1 class="cart-title">Keranjang Anda</h1>
                <p class="cart-subtitle">Keranjang Anda saat ini kosong.</p>
                <a href="katalog.php" class="btn cart-continue-btn">Lanjut Belanja</a>
            </div>

            <div id="cart-has-items" class="row justify-content-center">
                <div class="col-12 col-lg-12">
                    <h1 class="cart-title mb-4 text-center text-md-start">Keranjang Anda</h1>

                    <div class="table-responsive">
                        <table class="table align-middle cart-table" id="cart-table">
                            <thead>
                                <tr>
                                    <th scope="col">Produk</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-center">Harga</th>
                                    <th scope="col" class="text-center">Subtotal</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cart-body">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-center">Total</th>
                                    <th class="text-center" id="cart-total">Rp0</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
                        <a href="katalog.php" class="btn cart-back-btn mb-3 mb-md-0">Lanjut Belanja</a>
                        <button id="btn-checkout" class="btn cart-continue-btn" type="button">Checkout</button>
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
     console.log("Produk:", item.name);
     console.log("Path Gambar Diterima:", item.image);

      const price = parseInt(item.price) || 0;
      const qty = parseInt(item.qty) || 0;
      const subtotal = price * qty;
      total += subtotal;

      const tr = document.createElement('tr');
      tr.className = 'cart-item';
      // PERHATIKAN: PHP mengembalikan id_keranjang, tapi JS menggunakan cart_id
      tr.dataset.cartId = item.id_keranjang; 

tr.innerHTML = `
        <td>
          <div class="d-flex align-items-center">
            <img src="${item.image ? escapeHtml(item.image) : 'images/home_parfum.png'}" class="cart-item-img me-3" alt="">
            <div><div class="fw-semibold">${escapeHtml(item.name)}</div></div>
          </div>
        </td>
        
        <td class="text-center">
          <input type="number" class="form-control form-control-sm text-center cart-qty" value="${qty}" min="1" style="width:70px; margin: 0 auto;">
        </td>
        
        <td class="text-center cart-price" data-price="${price}">${formatRupiah(price)}</td>
        
        <td class="text-center cart-subtotal">${formatRupiah(subtotal)}</td>
        
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
                    // PERBAIKAN 1 & 2: Ganti action ke 'update_jumlah' dan key ke 'jumlah'
          await apiCall('update_jumlah', 'POST', { cart_id: cartId, jumlah: val });
          await loadCart();
        } catch (e) {
          console.error(e);
          alert('Gagal update jumlah');
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

    // Logika untuk menampilkan alert setelah sukses checkout dari checkout.php
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'success') {
      
      // Tampilkan alert yang diminta
      alert('Pesanan Anda akan diproses, silahkan menunggu ^_^');
      
      // Opsional: Bersihkan parameter dari URL agar alert tidak muncul saat refresh
      if (window.history.replaceState) {
        const cleanUrl = window.location.href.split('?')[0];
        window.history.replaceState(null, null, cleanUrl);
      }
    }

    document.getElementById('btn-checkout').addEventListener('click', function () {
    // Alih-alih melakukan AJAX, tombol ini seharusnya hanya mengarahkan ke halaman Checkout
    window.location.href = 'checkout.php'; 
    });
  });

    // Tambahkan parameter qty agar fungsi ini lebih berguna
  async function addToCart(productId, quantity = 1) { 
    try {
            // Mengirim {id_produk: X, qty: Y}
      const res = await apiCall('add', 'POST', { id_produk: productId, qty: quantity });
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
