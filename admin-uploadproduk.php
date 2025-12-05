<?php
session_start();
require 'conn.php';

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nama_produk = trim(htmlspecialchars($_POST['nama_produk']));
    $harga = (int)$_POST['harga']; // Konversi ke integer
    $deskripsi = trim(htmlspecialchars($_POST['deskripsi']));

    if (empty($nama_produk) || empty($harga) || empty($deskripsi) || $harga <= 0) {
        $_SESSION['error_message'] = "Semua kolom harus diisi dengan benar.";
        header("Location: admin-tambahproduk.php"); 
        exit();
    }

    $path_gambar_db = NULL; 


    if (is_null($path_gambar_db)) {
        $sql = "INSERT INTO produk (nama_produk, harga, deskripsi) VALUES (?, ?, ?)";
        $types = "sis"; // string, integer, string
        $params = [$nama_produk, $harga, $deskripsi];
    } else {
        $sql = "INSERT INTO produk (nama_produk, harga, deskripsi, gambar_produk) VALUES (?, ?, ?, ?)";
        $types = "siss"; // string, integer, string, string
        $params = [$nama_produk, $harga, $deskripsi, $path_gambar_db];
    }
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param($types, ...$params); 
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Produk '{$nama_produk}' berhasil ditambahkan! 🎉";
            header("Location: admin-tab-produk.php"); 
        } else {
            $_SESSION['error_message'] = "Gagal menambahkan produk ke database: " . $stmt->error;
            header("Location: admin-tambahproduk.php");
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Kesalahan database: " . $conn->error;
        header("Location: admin-tambahproduk.php");
    }

    $conn->close();

} else {
    header("Location: admin-tab-produk.php");
    exit();
}
?>