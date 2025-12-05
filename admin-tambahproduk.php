<?php
session_start();
require 'conn.php';

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit();
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
<body>
    <?php include 'navbar.php'; ?>
    <div class="page-container">
        <h2 class="title" style="margin-bottom: 30px;">Tambah Produk Baru</h2>
     
        <div class="address-form" style="max-width: 700px; margin: 0 auto;">
            <form action="admin-uploadproduk.php" method="POST" enctype="multipart/form-data">
                <h4 class="mb-4">Input Data Produk</h4>
                
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
                </div>

                <button type="submit" class="btn btn-gold mt-4">Simpan Produk</button>
                <a href="admin.php?tab=produk" class="btn btn-secondary mt-4 ms-2">Kembali</a>
            </form>
        </div>
    </div>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
</html>