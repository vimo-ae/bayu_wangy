<?php
session_start();
require 'conn.php';

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "ID Pesanan tidak ditemukan.";
    header("Location: admin-tab-pesanan.php");
    exit();
}

$id_pesanan = (int)$_GET['id'];

$sql_utama = "
    SELECT 
        p.*, 
        u.nama AS nama_user, 
        u.email AS email_user, 
        u.telepon AS telepon_user
    FROM pesanan p
    LEFT JOIN users u ON p.id_user = u.id_user 
    WHERE p.id_pesanan = ?
";

$stmt_utama = $conn->prepare($sql_utama);
$stmt_utama->bind_param("i", $id_pesanan);
$stmt_utama->execute();
$pesanan_utama_result = $stmt_utama->get_result();
$pesanan = $pesanan_utama_result->fetch_assoc();
$stmt_utama->close();

if (!$pesanan) {
    $_SESSION['error_message'] = "Pesanan dengan ID $id_pesanan tidak ditemukan.";
    header("Location: admin-tab-pesanan.php");
    exit();
}

$sql_detail = "
    SELECT 
        dp.jumlah, 
        dp.harga_satuan, 
        pr.nama_produk,
        pr.gambar_produk
    FROM detail_pesanan dp
    JOIN produk pr ON dp.id_produk = pr.id_produk
    WHERE dp.id_pesanan = ?
";

$stmt_detail = $conn->prepare($sql_detail);
$stmt_detail->bind_param("i", $id_pesanan);
$stmt_detail->execute();
$detail_produk_result = $stmt_detail->get_result();
$stmt_detail->close();

$statuses = ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Detail Pesanan #<?= $id_pesanan; ?></title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/akun.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/styleee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .detail-box {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .detail-box h5 {
            font-weight: 600;
            color: #D4AF37;
            border-bottom: 2px solid #D4AF37;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .product-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 15px;
        }
    </style>
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
                    <a href="logout.php" class="nnav-item logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </aside>

            <main class="content-area">

                <h2 class="section-title">Detail Pesanan #<?= $pesanan['id_pesanan']; ?></h2>

                <div class="mb-3">
                    <a href="admin-tab-pesanan.php" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan</a>
                </div>

                <div class="address-form" style="max-width: 1200px; margin: 30px auto;">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Status: 
                                <span class="badge 
                                    <?php 
                                    if ($pesanan['status_pesanan'] == 'Selesai') echo 'bg-success';
                                    elseif ($pesanan['status_pesanan'] == 'Dibatalkan') echo 'bg-danger';
                                    elseif ($pesanan['status_pesanan'] == 'Diproses') echo 'bg-warning text-dark';
                                    else echo 'bg-secondary';
                                    ?>
                                "><?= $pesanan['status_pesanan']; ?></span>
                            </h4>
                            <p>Tanggal Pesan: <strong><?= date('d M Y H:i', strtotime($pesanan['tanggal_pesan'])); ?></strong></p>
                        </div>
                        <div class="col-md-6 text-md-end">

                            <h3 class="mt-3">Total Bayar: <span class="text-success">Rp <?= number_format($pesanan['total_produk'], 0, ',', '.'); ?></span></h3>
                            
                            <form action="admin-ubahstatuspesanan.php" method="POST" class="d-inline mt-2">
                                <input type="hidden" name="id_pesanan" value="<?= $pesanan['id_pesanan']; ?>">
                                <select name="status_baru" onchange="this.form.submit()" class="form-select form-select-sm w-auto d-inline">
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?= $status; ?>" <?= ($pesanan['status_pesanan'] === $status) ? 'selected' : ''; ?>>
                                            Ubah ke: <?= $status; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-box">
                            <h5><i class="bi bi-person-fill"></i> Data Pelanggan</h5>
                            <p>Nama: <strong><?= htmlspecialchars($pesanan['nama_user']); ?></strong></p>
                            <p>Email: <strong><?= htmlspecialchars($pesanan['email']); ?></strong></p>
                            <p>Telepon: <strong><?= htmlspecialchars($pesanan['telepon_user']); ?></strong></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-box">
                            <h5><i class="bi bi-geo-alt-fill"></i> Alamat Pengiriman</h5>
                            <p>Penerima: <strong><?= htmlspecialchars($pesanan['nama_lengkap']); ?></strong> (<?= htmlspecialchars($pesanan['no_telepon']); ?>)</p>
                            <p>Alamat: <strong><?= htmlspecialchars($pesanan['alamat_detail']); ?></strong></p>
                        </div>
                    </div>
                </div>

                <div class="address-form p-4 mt-4"> 
                    <h4 class="mb-">Daftar Produk (<?= $detail_produk_result->num_rows; ?> Item)</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($detail = $detail_produk_result->fetch_assoc()): ?>
                            <tr class="product-item align-middle">
                                <td class="d-flex align-items-center">
                                    <img src="<?= htmlspecialchars($detail['gambar_produk']); ?>" alt="Gambar Produk" class="rounded">
                                    <strong><?= htmlspecialchars($detail['nama_produk']); ?></strong>
                                </td>
                                <td>Rp <?= number_format($detail['harga_satuan'], 0, ',', '.'); ?></td>
                                <td><?= $detail['jumlah']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end table-success"><strong>TOTAL AKHIR</strong></td>
                                <td class="table-success"><strong>Rp <?= number_format($pesanan['total_akhir'], 0, ',', '.'); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </main>
            </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>