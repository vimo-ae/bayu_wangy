<?php
session_start();
include "conn.php";

if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION["id_user"];

$query = $conn->prepare("SELECT * FROM alamat WHERE id_user = ? LIMIT 1");
$query->bind_param("i", $id_user);
$query->execute();
$result = $query->get_result();
$alamat = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = $_POST["nama_penerima"] ?? '';
    $telepon = $_POST["telepon"] ?? '';
    $alamat_lengkap = $_POST["alamat"] ?? '';
    $kota = $_POST["kota"] ?? '';
    $provinsi = $_POST["provinsi"] ?? '';
    $kode_pos = $_POST["kode_pos"] ?? '';

    if ($alamat == null) {
        $insert = $conn->prepare("INSERT INTO alamat (id_user, nama, telepon, alamat, kota, provinsi, kode_pos)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("issssss", $id_user, $nama, $telepon, $alamat_lengkap, $kota, $provinsi, $kode_pos);
        $insert->execute();
    } else {
        $update = $conn->prepare("UPDATE alamat SET nama=?, telepon=?, alamat=?, kota=?, provinsi=?, kode_pos=? 
            WHERE id_user=?");
        $update->bind_param("ssssssi", $nama, $telepon, $alamat_lengkap, $kota, $provinsi, $kode_pos, $id_user);
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
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/akun.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/styleee.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="page-container address-page">
    <h1 class="title">Ubah Alamat</h1>

    <form class="address-form" method="POST">

        <div class="form-row">
            <label>Nama Penerima:</label>
            <input type="text" name="nama_penerima" required
            value="<?= $alamat['nama'] ?? '' ?>">
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
<?php include 'footer.php'; ?>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>