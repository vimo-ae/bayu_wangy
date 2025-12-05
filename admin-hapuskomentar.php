<?php
session_start();
require 'conn.php';

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "ID komentar tidak ditemukan.";
    header("Location: admin-tab-komentar.php");
    exit();
}

$id_komen = (int)$_GET['id']; // Ambil dan konversi ID ke integer

$sql = "DELETE FROM testimoni WHERE id_komen = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $id_komen);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Komentar dengan ID **$id_komen** berhasil dihapus dari tabel testimoni. ✅";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus komentar dari database: " . $stmt->error;
    }
    $stmt->close();
} else {
    $_SESSION['error_message'] = "Kesalahan database: " . $conn->error;
}

$conn->close();

header("Location: admin-tab-komentar.php");
exit();
?>