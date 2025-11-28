<?php
include "db.php";

$cart = [
    ["nama" => "Xerjoff Erbapura", "harga" => 5500000, "qty" => 1],
    ["nama" => "Xejoff Torino", "harga" => 6000000, "qty" => 2]
];

$total = 0;
foreach ($cart as $c) {
    $total += $c["harga"] * $c["qty"];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Parfum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

<h2>Checkout Parfum</h2>

<h3>Ringkasan Pesanan</h3>

<?php foreach ($cart as $item): ?>
<div class="cart-item">
    <div>
        <strong><?= $item["nama"] ?></strong><br>
        Harga: Rp <?= number_format($item["harga"], 0, ',', '.') ?><br>
        Qty: <?= $item["qty"] ?>
    </div>
    <div>
        Rp <?= number_format($item["harga"] * $item["qty"], 0, ',', '.') ?>
    </div>
</div>
<?php endforeach; ?>

<div class="total">Subtotal: Rp <?= number_format($total, 0, ',', '.') ?></div>

<form action="proses_checkout.php" method="POST">

<input type="hidden" name="total_barang" value="<?= $total ?>">

<label>Ongkir</label>
<select name="ongkir" required>
    <option value="">Pilih Kota</option>
    <option value="20000">Medan - Rp 20.000</option>
    <option value="25000">Jakarta - Rp 25.000</option>
    <option value="30000">Bandung - Rp 30.000</option>
</select>

<label>Voucher (opsional)</label>
<input type="text" name="voucher" placeholder="Masukkan kode voucher">

<h3>Data Pembeli</h3>

<label>Nama Lengkap</label>
<input type="text" name="nama" required>

<label>No. Telepon</label>
<input type="text" name="telepon" required>

<label>Alamat</label>
<textarea name="alamat" rows="3" required></textarea>

<label>Metode Pembayaran</label>
<select name="pembayaran" required>
    <option value="Transfer Bank">Transfer Bank</option>
    <option value="COD">COD (Bayar di Tempat)</option>
    <option value="E-Wallet">E-Wallet</option>
</select>

<button type="submit">Buat Pesanan</button>

</form>
</div>
</body>
</html>
