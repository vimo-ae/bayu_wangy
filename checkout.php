<?php
session_start();
require 'conn.php';

$id_user = $_SESSION['id_user'] ?? null;
$alamat_tersimpan = null;

if ($id_user) {
    $sql_user = "SELECT nama, email FROM users WHERE id_user = ?"; 
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $id_user);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $data_user = $result_user->fetch_assoc();

    $sql_alamat = "SELECT nama, telepon, alamat, kota, provinsi, kode_pos FROM alamat WHERE id_user = ? LIMIT 1"; 
    $stmt_alamat = $conn->prepare($sql_alamat);
    $stmt_alamat->bind_param("i", $id_user);
    $stmt_alamat->execute();
    $result_alamat = $stmt_alamat->get_result();
    $alamat_tersimpan = $result_alamat->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/checkout.css"> 
    <link rel="stylesheet" href="css/navbar.css"> 
    <link rel="stylesheet" href="css/styleee.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Checkout - Toko Parfum</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="checkout-container">
        <h2>Checkout</h2>

        <div class="checkout-section">
        <h3>Informasi Pembeli</h3>
        <div class="input-group">
                <label>Nama Lengkap</label>
                <input id="nama_lengkap" type="text" name="nama_lengkap" value="<?= htmlspecialchars($data_user['nama'] ?? '') ?>" required>
                <p class="error-message" id="error-nama_lengkap">Nama lengkap tidak boleh kosong.</p> 
        </div>
        <div class="input-group"> 
                <label>Email</label>
                <input id="email" type="email" name="email" value="<?= htmlspecialchars($data_user['email'] ?? '') ?>" required>
                <p class="error-message" id="error-email">Email tidak boleh kosong.</p>
        </div>
        <div class="input-group">
                <label>No Telepon</label>
                <input id="no_telepon" type="text" name="no_telepon" value="<?= htmlspecialchars($alamat_tersimpan['telepon'] ?? '') ?>" required>
                <p class="error-message" id="error-no_telepon">Nomor telepon tidak boleh kosong.</p>
        </div>
        <div class="input-group">
                <label>Alamat Lengkap</label>
                <textarea id="alamat_detail" name="alamat_detail" required><?= htmlspecialchars($alamat_tersimpan['alamat'] ?? '') ?></textarea>
                <p class="error-message" id="error-alamat_detail">Alamat pengiriman tidak boleh kosong.</p>
        </div>
</div>

        <div class="checkout-section">
            <h3>Ringkasan Pesanan</h3>
            <div class="order-summary">
                <p>Memuat ringkasan...</p>
            </div>
        </div>

        <button class="btn-checkout" id="btn-bayar">Bayar Sekarang</button>

    </div>
    <?php include 'footer.php'; ?>

    <script src="script/checkout.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
