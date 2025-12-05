<?php
session_start();
require 'conn.php';

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "ID user tidak ditemukan.";
    header("Location: admin-tab-user.php");
    exit();
}

$id_user = (int)$_GET['id'];

if ($id_user === 1) {
    $_SESSION['error_message'] = "Anda tidak diizinkan menghapus akun Admin Utama.";
    header("Location: admin-tab-user.php");
    exit();
}

$conn->begin_transaction();
$success = true;

try {
    $stmt_alamat = $conn->prepare("DELETE FROM alamat WHERE id_user = ?");
    $stmt_alamat->bind_param("i", $id_user);
    if (!$stmt_alamat->execute()) { $success = false; }
    $stmt_alamat->close();

    $stmt_keranjang = $conn->prepare("DELETE FROM item_keranjang WHERE id_user = ?");
    $stmt_keranjang->bind_param("i", $id_user);
    if (!$stmt_keranjang->execute()) { $success = false; }
    $stmt_keranjang->close();
    
    $stmt_pesanan = $conn->prepare("UPDATE pesanan SET id_user = NULL WHERE id_user = ?");
    $stmt_pesanan->bind_param("i", $id_user); 
    if (!$stmt_pesanan->execute()) { 
        $success = false;
    }
    $stmt_pesanan->close(); // Tutup statement setelah dieksekusi

    $stmt_user = $conn->prepare("DELETE FROM users WHERE id_user = ?");
    $stmt_user->bind_param("i", $id_user);
    
    if (!$stmt_user->execute()) {
        $success = false;
    }
    $stmt_user->close(); 

    if ($success) {
        $conn->commit();
        $_SESSION['success_message'] = "User dengan ID $id_user berhasil dihapus.";
    } else {
        $conn->rollback();
        $_SESSION['error_message'] = "Gagal menghapus user: Terjadi kesalahan database.";
    }

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['error_message'] = "Terjadi kesalahan saat menghapus user: " . $e->getMessage();
}

header("Location: admin-tab-user.php");
exit();
?>