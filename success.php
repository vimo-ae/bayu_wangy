<?php
$nama = $_GET["nama"];
$total = $_GET["total"];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pesanan Berhasil</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>🎉 Pesanan Berhasil!</h2>
    <p>Terima kasih, <strong><?= $nama ?></strong>!</p>
    <p>Total pembayaran Anda:</p>
    <h2>Rp <?= number_format($total, 0, ',', '.') ?></h2>
    <p>Pesanan Anda sedang diproses dan akan segera dikirim.</p>
</div>
</body>
</html>
