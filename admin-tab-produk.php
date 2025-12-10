<?php 
session_start();
require 'conn.php';

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT id_produk, nama_produk, harga, gambar_produk FROM produk ORDER BY id_produk ASC";
$produk_query = $conn->query($sql);

if ($produk_query === false) {
    echo "<p class='alert alert-danger'>Error saat mengambil data produk: " . $conn->error . "</p>";    $produk_query = new stdClass(); // Membuat objek dummy
    $produk_query->num_rows = 0;    // Mensimulasikan tidak ada baris
    // Tambahkan logika penanganan error lebih lanjut jika perlu
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

    <div class="adminproduk-container">
        <h1 class="title">Admin</h1>

        <div class="account-dashboard">

            <aside class="sidebar">
                <nav class="account-nav">
                    <a href="admin.php" class="nnav-item ">
                        <i class="bi bi-person me-2"></i> Profil
                    </a>
                    <a href="admin-tab-produk.php" class="nnav-item active">
                        <i class="bi bi-box-seam me-2"></i> Kelola Produk
                    </a>
                    <a href="admin-tab-user.php" class="nnav-item">
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

                <h2 class="section-title">Kelola Produk</h2>
                        <a href="admin-tambahproduk.php" class="btn-ubah">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Produk Baru
                        </a>

                <div class="address-form" style="max-width: 1200px; margin: 30px auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            while ($produk = $produk_query->fetch_assoc()): 
                            ?>
                            <tr>
                                <td><?= $produk['id_produk']; ?></td>
                                <td><img src="<?= $produk['gambar_produk']; ?>" width="60" class="rounded"></td>
                                <td><?= htmlspecialchars($produk['nama_produk']); ?></td>
                                <td>Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <!-- <a href="admin-editproduk.php?id=<?= $produk['id_produk']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a> -->
                                    <a href="admin-hapusproduk.php?id=<?= $produk['id_produk']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus produk ini?');"><i class="bi bi-trash"></i></a>
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