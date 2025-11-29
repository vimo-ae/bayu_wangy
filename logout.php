<?php
session_start();

// Hapus semua session
session_unset();

// Hapus session dari server
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit();
?>
