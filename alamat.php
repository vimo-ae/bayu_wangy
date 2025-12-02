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
    <title>Akun Saya | Bayu Wangy</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="account-page">
    <div class="container">
        <h1 class="title">Alamat Pengiriman</h1>

        <div class="account-dashboard">

            <aside class="sidebar">
                <nav class="account-nav">
                    <a href="akun.php" class="nav-item">
                        <i class="fas fa-user"></i> Profil
                    </a>
                    <a href="riwayat.php" class="nav-item">
                        <i class="fas fa-shopping-bag"></i> Riwayat Pesanan
                    </a>
                    <a href="alamat.php" class="nav-item active">
                        <i class="fas fa-map-marker-alt"></i> Alamat Pengiriman
                    </a>
                    <a href="logout.php" class="nav-item logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </aside>

            <main class="content-area">
                <section class="profile-section">
                    <h2 class="section-title">Detail Alamat Pengiriman</h2>

                    <div class="profile-info-card">
                        <div class="info-group">
                            <span class="info-label">Nama Penerima:</span>
                            <span class="info-value"><?= htmlspecialchars($alamat['nama_penerima']); ?></span>
                        </div>
                        <div class="info-group">
                            <span class="info-label">Nomor Telepon:</span>
                            <span class="info-value"><?= htmlspecialchars($alamat['telepon']); ?></span>
                        </div>
                        <div class="info-group alamat-group">
                            <span class="info-label">Alamat Lengkap:</span>
                            <div class="alamat-value">
                                <?= nl2br(htmlspecialchars($alamat['alamat'])) ?><br>
                                <?= htmlspecialchars($alamat['kota']) ?><br>
                                <?= htmlspecialchars($alamat['provinsi']) ?><br>
                                <?= htmlspecialchars($alamat['kode_pos']) ?>
                            </div>
                        </div>

                        <a href="ubah-alamat.php" class="btn-ubah">Ubah Alamat</a>

                </section>
            </main>
        </div>
    </div>
</body>
</html>
