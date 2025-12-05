<?php
session_start();
require 'conn.php';

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "ID produk tidak ditemukan.";
    header("Location: admin-tab-produk.php");
    exit();
}

$id_produk = (int)$_GET['id']; 

$conn->begin_transaction();
$success = true;

try {
    $stmt_keranjang = $conn->prepare("DELETE FROM item_keranjang WHERE id_produk = ?");
    $stmt_keranjang->bind_param("i", $id_produk);
    if (!$stmt_keranjang->execute()) {
        throw new Exception("Gagal menghapus item keranjang: " . $stmt_keranjang->error);
    }

    $stmt_detail = $conn->prepare("DELETE FROM detail_pesanan WHERE id_produk = ?");
    $stmt_detail->bind_param("i", $id_produk);
    if (!$stmt_detail->execute()) {
        throw new Exception("Gagal menghapus detail pesanan: " . $stmt_detail->error);
    }
    
    $stmt_produk = $conn->prepare("DELETE FROM produk WHERE id_produk = ?");
    $stmt_produk->bind_param("i", $id_produk);
    
    if (!$stmt_produk->execute()) {
        throw new Exception("Gagal menghapus produk utama: " . $stmt_produk->error);
    }

    $conn->commit();
    $_SESSION['success_message'] = "Produk dengan ID **$id_produk** berhasil dihapus. ✅";

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['error_message'] = "Gagal menghapus produk. Detail: " . $e->getMessage();
}

$conn->close();
header("Location: admin-tab-produk.php");
exit();
?>