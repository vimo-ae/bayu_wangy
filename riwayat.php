<?php
session_start();
include "conn.php";

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
    <title>Riwayat Checkout | Parfum Luxe</title>
    <link rel="stylesheet" href="css/global.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="page-container history-page">
        <h1 class="title">Riwayat Pesanan</h1>

        <div class="history-container">

            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="history-card">
                        <h3><?= htmlspecialchars($row["nama_produk"]) ?></h3>
                        <p>Tanggal: <?= date("d M Y", strtotime($row["tanggal"])) ?></p>
                        <p>Harga: Rp <?= number_format($row["harga"], 0, ",", ".") ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align:center; margin-top:20px;">Belum ada riwayat pesanan.</p>
            <?php endif; ?>

        </div>

        <a href="akun.php" class="btn-kembali">Kembali</a>

    </div>

</body>
</html>
