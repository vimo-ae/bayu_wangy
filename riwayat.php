<?php
session_start();
include "conn.php";

if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION["id_user"];

$query = $conn->prepare("
    SELECT 
        p.id_pesanan,
        p.total_akhir,
        p.status_pesanan,
        p.tanggal_pesan, 
        dp.nama_produk, 
        dp.harga_satuan, 
        dp.jumlah
    FROM pesanan p
    JOIN detail_pesanan dp ON p.id_pesanan = dp.id_pesanan
    WHERE p.id_user = ? 
    ORDER BY p.tanggal_pesan DESC
");

$query->bind_param("i", $id_user);
$query->execute();
$result = $query->get_result();

$pesanan_grouped = []; 

while ($row = $result->fetch_assoc()) {
    $id_pesanan = $row['id_pesanan'];
    
    if (!isset($pesanan_grouped[$id_pesanan])) {
        $pesanan_grouped[$id_pesanan] = [
            'id_pesanan' => $id_pesanan,
            'total_akhir' => $row['total_akhir'],
            'status_pesanan' => $row['status_pesanan'],
            'tanggal_pesan' => $row['tanggal_pesan'],
            'items' => [] // Array untuk menyimpan detail produk
        ];
    }
    
    $pesanan_grouped[$id_pesanan]['items'][] = [
        'nama_produk' => $row['nama_produk'],
        'harga_satuan' => $row['harga_satuan'],
        'jumlah' => $row['jumlah']
    ];
}

function formatRupiah($angka) {
    return 'Rp' . number_format($angka, 0, ',', '.');
}

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
        <h1 class="title">Riwayat Pesanan</h1>

        <div class="account-dashboard">

            <aside class="sidebar">
                <nav class="account-nav">
                    <a href="akun.php" class="nnav-item">
                        <i class="fas fa-user"></i> Profil
                    </a>
                    <a href="riwayat.php" class="nnav-item active">
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
                    <h2 class="section-title">Detail Riwayat Pesanan</h2>

<?php if (empty($pesanan_grouped)): ?>
                        <p style="padding: 10px; font-size: 15px; color: #555;">
                            Belum ada riwayat pesanan!
                        </p>
                    <?php else: ?>
                        
                        <?php 
                        // Loop untuk setiap pesanan (dikelompokkan berdasarkan id_pesanan)
                        foreach ($pesanan_grouped as $pesanan): 
                        ?>
                            <div class="card p-3 mb-4 shadow-sm">
                                <h4 style="border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px;">
                                    Pesanan <span style="color: #D4AF37">#<?= htmlspecialchars($pesanan['id_pesanan']); ?></span>
                                </h4>
                                
                                <div class="info-group">
                                    <span class="info-label">Tanggal:</span>
                                    <span class="info-value">
                                        <?= date('d F Y H:i', strtotime($pesanan['tanggal_pesan'])); ?>
                                    </span>
                                </div>
                                
                                <div class="info-group">
                                    <span class="info-label">Status Pesanan:</span>
                                    <span class="info-value font-weight-bold">
                                        <?= htmlspecialchars($pesanan['status_pesanan']); ?>
                                    </span>
                                </div>

                                <div class="info-group">
                                    <span class="info-label">Nama Produk:</span>
                                    <span class="info-value" style="display: block; padding-left: 20px;">
                                        <?php 
                                        // Loop untuk setiap item di dalam pesanan ini
                                        foreach ($pesanan['items'] as $item): 
                                        ?>
                                            <div style="margin-bottom: 5px;">
                                                <?= htmlspecialchars($item['nama_produk']) . ' (' . htmlspecialchars($item['jumlah']) . 'x)'; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </span>
                                </div>
                                
                                <div class="info-group" style="border-top: 1px dashed #eee; padding-top: 10px; margin-top: 10px;">
                                    <span class="info-label font-weight-bold">Total Akhir:</span>
                                    <span class="info-value font-weight-bold" style="font-size: 1.1em;">
                                        <?= formatRupiah($pesanan['total_akhir']); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    <?php endif; ?>

                </section>
            </main>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>