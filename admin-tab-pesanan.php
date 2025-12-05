<?php 
session_start();
require 'conn.php';

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "
    SELECT 
        p.id_pesanan, 
        u.nama, 
        p.tanggal_pesan, 
        p.total_akhir, 
        p.status_pesanan 
    FROM pesanan p
    JOIN users u ON p.id_user = u.id_user
    ORDER BY p.tanggal_pesan DESC
";

$pesanan_query = $conn->query($sql);

if ($pesanan_query === false) {
    echo "<p class='alert alert-danger'>Error saat mengambil data pesanan: " . $conn->error . "</p>";
    $pesanan_query = new stdClass(); 
    $pesanan_query->num_rows = 0;    
}

$statuses = ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Bayu Wangy</title>
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
        <h1 class="title">Admin</h1>

        <div class="account-dashboard">

            <aside class="sidebar">
                <nav class="account-nav">
                    <a href="admin.php" class="nnav-item">
                        <i class="bi bi-person me-2"></i> Profil
                    </a>
                    <a href="admin-tab-produk.php" class="nnav-item">
                        <i class="bi bi-box-seam me-2"></i> Kelola Produk
                    </a>
                    <a href="admin-tab-user.php" class="nnav-item">
                        <i class="bi bi-people me-2"></i> Kelola User
                    </a>
                    <a href="admin-tab-pesanan.php" class="nnav-item active">
                        <i class="bi bi-cart-check me-2"></i> Pesanan Masuk
                    </a>
                    <a href="admin-tab-komentar.php" class="nnav-item">
                        <i class="bi bi-chat-dots me-2"></i> Kelola Komentar
                    </a>
                    <a href="logout.php" class="nnav-item logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </aside>

            <main class="content-area">

                <h2 class="section-title">Daftar Pesanan Masuk</h2>

                <div class="address-form" style="max-width: 1200px; margin: 30px auto;">
                    <h4 class="mb-4">Riwayat Pesanan Pelanggan</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Cek apakah query berhasil dieksekusi dan memiliki baris data
                            if ($pesanan_query->num_rows > 0) {
                                while ($pesanan = $pesanan_query->fetch_assoc()): 
                            ?>
                            <tr>
                                <td><?= $pesanan['id_pesanan']; ?></td>
                                <td><?= htmlspecialchars($pesanan['nama']); ?></td>
                                <td><?= date('d M Y', strtotime($pesanan['tanggal_pesan'])); ?></td>
                                <td>Rp <?= number_format($pesanan['total_akhir'], 0, ',', '.'); ?></td>
                                <td>
                                    <form action="admin-ubahstatuspesanan.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id_pesanan" value="<?= $pesanan['id_pesanan']; ?>">
                                        <select name="status_baru" onchange="this.form.submit()" class="form-select form-select-sm">
                                            <?php foreach ($statuses as $status): ?>
                                                <option value="<?= $status; ?>" <?= ($pesanan['status_pesanan'] === $status) ? 'selected' : ''; ?>>
                                                    <?= $status; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href="admin-detailpesanan.php?id=<?= $pesanan['id_pesanan']; ?>" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i> Detail</a>
                                </td>
                            </tr>
                            <?php 
                                endwhile; 
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada pesanan masuk saat ini.</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </main>
            </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>