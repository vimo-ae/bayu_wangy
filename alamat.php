<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Ambil alamat dari DB
$query = $conn->prepare("SELECT * FROM alamat_pengiriman WHERE user_id = ? LIMIT 1");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$alamat = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alamat Pengiriman | Parfum Luxe</title>
    <link rel="stylesheet" href="css/global.css">
</head>
<body>
<div class="page-container address-page">
    <h1 class="title">Alamat Pengiriman</h1>

    <div class="address-box">

        <?php if ($alamat): ?>
            <div class="address-detail">
                <p><strong>Nama Penerima:</strong> <?= htmlspecialchars($alamat['nama_penerima']) ?></p>
                <p><strong>No. Telepon:</strong> <?= htmlspecialchars($alamat['telepon']) ?></p>
                <p><strong>Alamat Lengkap:</strong></p>

                <p>
                    <?= nl2br(htmlspecialchars($alamat['alamat'])) ?><br>

                    <?php if (!empty($alamat['kota'])): ?>
                        <?= htmlspecialchars($alamat['kota']) ?><br>
                    <?php endif; ?>

                    <?php if (!empty($alamat['provinsi'])): ?>
                        <?= htmlspecialchars($alamat['provinsi']) ?><br>
                    <?php endif; ?>

                    <?php if (!empty($alamat['kode_pos'])): ?>
                        <?= htmlspecialchars($alamat['kode_pos']) ?>
                    <?php endif; ?>
                </p>
            </div>
        <?php else: ?>
            <p style="text-align:center;">Belum ada alamat tersimpan.</p>
        <?php endif; ?>

        <a href="ubah-alamat.php" class="btn-ubah">Ubah Alamat</a>
    </div>

    <a href="akun.php" class="btn-kembali">Kembali</a>
</div>
</body>
</html>
