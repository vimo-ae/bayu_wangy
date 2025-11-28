<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Ambil data lama (kalau ada)
$query = $conn->prepare("SELECT * FROM alamat_pengiriman WHERE user_id = ? LIMIT 1");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$alamat = $result->fetch_assoc();

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama   = $_POST["nama_penerima"];
    $telepon = $_POST["telepon"];
    $alamat_lengkap = $_POST["alamat"];
    $kota = $_POST["kota"];
    $provinsi = $_POST["provinsi"];
    $kode_pos = $_POST["kode_pos"];

    // Jika user belum punya alamat → INSERT
    if ($alamat == null) {
        $insert = $conn->prepare("
            INSERT INTO alamat_pengiriman 
            (user_id, nama_penerima, telepon, alamat, kota, provinsi, kode_pos)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $insert->bind_param("issssss", $user_id, $nama, $telepon, $alamat_lengkap, $kota, $provinsi, $kode_pos);
        $insert->execute();

    } else {
        // Kalau sudah ada → UPDATE
        $update = $conn->prepare("
            UPDATE alamat_pengiriman
            SET nama_penerima=?, telepon=?, alamat=?, kota=?, provinsi=?, kode_pos=?
            WHERE user_id=?
        ");
        $update->bind_param("ssssssi", $nama, $telepon, $alamat_lengkap, $kota, $provinsi, $kode_pos, $user_id);
        $update->execute();
    }

    header("Location: alamat.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Alamat | Parfum Luxe</title>
    <link rel="stylesheet" href="css/global.css">
</head>
<body>

<div class="page-container address-page">
    <h1 class="title">Ubah Alamat</h1>

    <form class="address-form" method="POST">

        <div class="form-row">
            <label>Nama Penerima:</label>
            <input type="text" name="nama_penerima" required
                value="<?= $alamat['nama_penerima'] ?? '' ?>">
        </div>

        <div class="form-row">
            <label>Nomor Telepon:</label>
            <input type="text" name="telepon" required
                value="<?= $alamat['telepon'] ?? '' ?>">
        </div>

        <div class="form-row">
            <label>Alamat Lengkap:</label>
            <textarea name="alamat" required><?= $alamat['alamat'] ?? '' ?></textarea>
        </div>

        <div class="form-row">
            <label>Kota:</label>
            <input type="text" name="kota" required
                value="<?= $alamat['kota'] ?? '' ?>">
        </div>

        <div class="form-row">
            <label>Provinsi:</label>
            <input type="text" name="provinsi" required
                value="<?= $alamat['provinsi'] ?? '' ?>">
        </div>

        <div class="form-row">
            <label>Kode Pos:</label>
            <input type="text" name="kode_pos" required
                value="<?= $alamat['kode_pos'] ?? '' ?>">
        </div>

        <button class="btn-save" type="submit">Simpan Alamat</button>
    </form>

    <a href="alamat.php" class="btn-kembali">Kembali</a>
</div>

</body>
</html>
