<?php
session_start();
require 'conn.php'; 

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}
    
$id_user = $_SESSION['id_user'];

// ambil data user (lengkap)
$sql = "SELECT nama, email, telepon, tanggal_daftar FROM users WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Saya | Bayu Wangy</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/akun.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/styleee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="account-page">

        <?php include 'navbar.php'; ?>

    <div class="akun-container">
        <h1 class="title">Akun Saya</h1>

        <div class="account-dashboard">

            <aside class="sidebar">
                <nav class="account-nav">
                    <a href="riwayat.php" class="nnav-item active">
                        <i class="fas fa-shopping-bag"></i> Profil
                    </a>
                    <a href="riwayat.php" class="nnav-item">
                        <i class="fas fa-shopping-bag"></i> Riwayat Pesanan
                    </a>
                    <a href="alamat.php" class="nnav-item">
                        <i class="fas fa-map-marker-alt"></i> Alamat Pengiriman
                    </a>
                    <a href="logout.php" class="nnav-item logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </aside>

            <main class="content-area">
                <section class="profile-section">
                    <h2 class="section-title">Detail Informasi Profil</h2>

                    <div class="profile-info-card">
                        <div class="info-group">
                            <span class="info-label">Nama Lengkap:</span>
                            <span class="info-value"><?= htmlspecialchars($user['nama']); ?></span>
                        </div>
                        <div class="info-group">
                            <span class="info-label">Email:</span>
                            <span class="info-value"><?= htmlspecialchars($user['email']); ?></span>
                        </div>
                        <div class="info-group">
                            <span class="info-label">Nomor Telepon:</span>
                            <span class="info-value"><?= htmlspecialchars($user['telepon']); ?></span>
                        </div>
                        <div class="info-group">
                            <span class="info-label">Tanggal Daftar:</span>
                            <span class="info-value"><?= date('d F Y', strtotime($user['tanggal_daftar'])); ?></span>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>