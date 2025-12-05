<?php
session_start();
require 'conn.php';

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['id_pesanan']) || !isset($_POST['status_baru'])) {
    $_SESSION['error_message'] = "Data pesanan atau status baru tidak valid.";
    header("Location: admin-tab-pesanan.php");
    exit();
}

$id_pesanan = (int)$_POST['id_pesanan'];
$status_baru = $conn->real_escape_string($_POST['status_baru']); // Amankan string

$valid_statuses = ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
if (!in_array($status_baru, $valid_statuses)) {
    $_SESSION['error_message'] = "Status pesanan tidak valid.";
    header("Location: admin-tab-pesanan.php");
    exit();
}

$sql = "UPDATE pesanan SET status_pesanan = ? WHERE id_pesanan = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    $_SESSION['error_message'] = "Error saat menyiapkan query: " . $conn->error;
    header("Location: admin-tab-pesanan.php");
    exit();
}

$stmt->bind_param("si", $status_baru, $id_pesanan);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Status pesanan ID $id_pesanan berhasil diubah menjadi '$status_baru'.";
} else {
    $_SESSION['error_message'] = "Gagal mengubah status pesanan: " . $stmt->error;
}

$stmt->close();

header("Location: admin-tab-pesanan.php");
exit();
?>