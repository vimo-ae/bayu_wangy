<?php 
session_start();
require 'conn.php';

$user_query = $conn->query("SELECT id_user, nama, email, telepon, tanggal_daftar FROM users WHERE role != 'admin'");

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
                    <a href="admin-tab-user.php" class="nnav-item active">
                        <i class="bi bi-people me-2"></i> Kelola User
                    </a>
                    <a href="admin-tab-pesanan.php" class="nnav-item">
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

                <h2 class="section-title">Kelola Data User</h2>

                <div class="address-form" style="max-width: 1200px; margin: 30px auto;">
                    <h4 class="mb-4">Daftar Pengguna Aktif</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Tgl Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($user = $user_query->fetch_assoc()): ?>
                            <tr>
                                <td><?= $user['id_user']; ?></td>
                                <td><?= htmlspecialchars($user['nama']); ?></td>
                                <td><?= htmlspecialchars($user['email']); ?></td>
                                <td><?= htmlspecialchars($user['telepon'] ?? '-'); ?></td>
                                <td><?= date('d M Y', strtotime($user['tanggal_daftar'])); ?></td>
                                <td>
                                    <a href="admin-hapususer.php?id=<?= $user['id_user']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user ini?');"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
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