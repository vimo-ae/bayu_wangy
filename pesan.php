<?php
require 'conn.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_produk_url = $_GET['id'];
$query = "SELECT id_produk, nama_produk, merk, harga FROM produk WHERE id_produk = '$id_produk_url'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) !== 1) {
    header("Location: index.php");
    exit();
}

$data_produk = mysqli_fetch_assoc($result);

$id_produk = $data_produk['id_produk'];
$nama_produk = $data_produk['nama_produk'];
$merk = $data_produk['merk'];
$harga = $data_produk['harga'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan - <?php echo $data_produk['nama_produk']; ?> | Bayu Wangy</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/pesannn.css"> 
    <link rel="stylesheet" href="css/styleee.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

    <?php include 'navbar.php'; ?>
    
    <div class="button-bar">
        <button class="back-btn" onclick="history.back(-1)">← Kembali ke Katalog</button>
        <a href="detail.php?id=<?php echo $id_produk_url; ?>">
            <button class="detail-btn">Cek Detail Parfum</button>
        </a>
    </div>

    <section class="product-container">
        
        <div class="image-area">
            
            <div class="main-image-wrapper">
                 <img src="images/image00012.webp" class="main-img" alt="Xerjoff Erba Pura">
            </div>
            <div class="image-grid">
                <img src="images/erba pura 1.jpeg" alt="Erba Pura 1">
                <img src="images/xer.webp" alt="Xerjoff Botol">
            </div>
            
        </div>

        <div class="right-info">
            
            <h1 class="product-title"><?php echo $data_produk['nama_produk']; ?></h1>
            <p class="product-type brand-label">BRAND: <?php echo $data_produk['merk']; ?></p>
            <h2 class="price">Rp <?php echo number_format($data_produk['harga'], 0, ',', '.'); ?></h2>
            
            <div class="description-text">
                 <p>Erba Pura adalah ekstrak parfum buah-buahan dan amber yang lembut, modern, dan sangat kuat. Aroma dibuka dengan jeruk Sisilia yang cerah, dipadukan dengan amber, musk, dan vanila yang menghangatkan.</p>
            </div>


            <div class="quantity-box">
                <button class="qty-btn" onclick="changeQty(-1)">-</button>
                <span id="qty">1</span>
                <button class="qty-btn" onclick="changeQty(1)">+</button>
                <input type="hidden" id="id_produk_input" value="<?php echo $id_produk; ?>">
            </div>

            <button class="buy-btn" onclick="tambahKeKeranjang()">Tambah ke Keranjang</button>
            <button class="cart-btn-secondary" onclick="window.location.href='keranjang.php'">Cek Keranjang Anda</button>

            <div class="accordion-info">

                <div class="acc-item" onclick="toggleAcc(this)">
                    <h3>Detail Aroma</h3><span class="plus">+</span>
                    <div class="acc-content">
                        <p><b>Top Notes:</b> Jeruk Sisilia (Sicilian Orange), Lemon Sisilia, Bergamot Calabria</p>
                        <p><b>Middle Notes:</b> Keranjang buah-buahan segar Mediterania</p>
                        <p><b>Base Notes:</b> Amber, Musk putih, Vanila Madagaskar</p>
                    </div>
                </div>

                <div class="acc-item" onclick="toggleAcc(this)">
                    <h3>Product Performance</h3><span class="plus">+</span>
                    <p class="acc-content">Erba Pura punya longevity sangat tinggi, banyak review menyebut bisa bertahan 10+ jam di kulit dan bahkan lebih lama di kain.</p>
                </div>

                <div class="acc-item" onclick="toggleAcc(this)">
                    <h3>Shipping Information</h3><span class="plus">+</span>
                    <p class="acc-content">Pengiriman 1-2 hari kerja (Pulau Jawa) dan 3-5 hari kerja (Luar Jawa). Kami menjamin produk dikemas dengan sangat aman.</p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="script/pesannn.js"></script> 
</body>
</html>