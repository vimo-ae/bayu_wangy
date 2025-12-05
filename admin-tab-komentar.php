<?php 
session_start();
require 'conn.php';

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "
    SELECT 
        id_komen, 
        nama_user, 
        komentar, 
        tanggal_dibuat
    FROM testimoni
    ORDER BY tanggal_dibuat DESC
";

$komentar_query = $conn->query($sql);

if ($komentar_query === false) {
    echo "<p class='alert alert-danger'>Error saat mengambil data komentar: " . $conn->error . "</p>";
    $komentar_query = new stdClass();
    $komentar_query->num_rows = 0;    
}

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
                    <a href="admin-tab-user.php" class="nnav-item ">
                        <i class="bi bi-people me-2"></i> Kelola User
                    </a>
                    <a href="admin-tab-pesanan.php" class="nnav-item">
                        <i class="bi bi-cart-check me-2"></i> Pesanan Masuk
                    </a>
                    <a href="admin-tab-komentar.php" class="nnav-item active">
                        <i class="bi bi-chat-dots me-2"></i> Kelola Komentar
                    </a>
                    <a href="logout.php" class="nnav-item logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </aside>

            <main class="content-area">

                <h2 class="section-title">Kelola Data User</h2>

                <div class="address-form" style="max-width: 1200px; margin: 30px auto;"> 
                    <h4 class="mb-4">Daftar Pengguna Aktif</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Komen</th>
                                <th>Nama User</th>
                                <th>Isi Komentar</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($komentar_query->num_rows > 0): ?>
                            <?php while ($komentar = $komentar_query->fetch_assoc()): ?>
                            <tr>
                                <td><?= $komentar['id_komen']; ?></td>
                                <td><?= htmlspecialchars($komentar['nama_user']); ?></td>
                                <td><?= htmlspecialchars(substr($komentar['komentar'], 0, 80)) . (strlen($komentar['komentar']) > 80 ? '...' : ''); ?></td>
                                <td><?= date('d M Y', strtotime($komentar['tanggal_dibuat'])); ?></td>
                                <td>
                                    <a href="admin-hapuskomentar.php?id=<?= $komentar['id_komen']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus komentar ini?');">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada komentar saat ini.</td>
                            </tr>
                            <?php endif; ?>
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