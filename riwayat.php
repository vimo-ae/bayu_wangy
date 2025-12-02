<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Ambil ID user dari session
$user_id = $_SESSION["user_id"];

// Ambil riwayat dari database
$query = $conn->prepare("SELECT * FROM riwayat_pesanan WHERE user_id = ? ORDER BY tanggal DESC");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
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
        <h1 class="title">Riwayat Pesanan</h1>

        <div class="account-dashboard">

            <aside class="sidebar">
                <nav class="account-nav">
                    <a href="akun.php" class="nav-item">
                        <i class="fas fa-user"></i> Profil
                    </a>
                    <a href="riwayat.php" class="nav-item active">
                        <i class="fas fa-shopping-bag"></i> Riwayat Pesanan
                    </a>
                    <a href="alamat.php" class="nav-item">
                        <i class="fas fa-map-marker-alt"></i> Alamat Pengiriman
                    </a>
                    <a href="logout.php" class="nav-item logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </aside>

            <main class="content-area">
                <section class="profile-section">
                    <h2 class="section-title">Detail Riwayat Pesanan</h2>

                    <?php if ($result->num_rows == 0): ?>
                        <p style="padding: 10px; font-size: 15px; color: #555;">
                            Belum ada riwayat pesanan!
                        </p>
                    <?php else: ?>
                        
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="info-group">
                                <span class="info-label">Nama Produk:</span>
                                <span class="info-value"><?= htmlspecialchars($row['nama_produk']); ?></span>
                            </div>

                            <div class="info-group">
                                <span class="info-label">Harga:</span>
                                <span class="info-value"><?= htmlspecialchars($row['harga']); ?></span>
                            </div>
                            <div class="info-group">
                                <span class="info-label">Tanggal:</span>
                                <span class="info-value"><?= date('d F Y', strtotime($row['tanggal'])); ?></span>
                            </div>
                            
                            <!-- Tambahkan data lain di sini -->

                        <?php endwhile; ?>

                    <?php endif; ?>

                </section>
            </main>
        </div>
    </div>
</body>
</html>
