<?php
require 'koneksi.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $telepon  = trim($_POST['telepon']);

    // Validasi server-side
    if (empty($nama) || empty($email) || empty($password)) {
        $error = "Semua field harus diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid!";
    } elseif (strlen($password) < 8) {
        $error = "Password minimal 8 karakter!";
    } elseif (!preg_match('/[a-zA-Z]/', $password)) {
        $error = "Password harus mengandung huruf!";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error = "Password harus mengandung angka!";
    } else {
        // Cek email unik
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            // Simpan user baru
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (nama, email, password, telepon) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama, $email, $hashPassword, $telepon);

            if ($stmt->execute()) {
                $success = "Registrasi berhasil! Silahkan login.";
            } else {
                $error = "Terjadi kesalahan, coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register | Parfum Luxe</title>
<link rel="stylesheet" href="css/global.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="login-container">
    <h1 class="title">Daftar Akun</h1>

    <form id="registerForm" class="login-card" method="POST" action="">
        <!-- PHP error/success -->
        <div id="error-container">
            <?php if ($error !== ""): ?>
                <p class="error"><?= $error; ?></p>
            <?php endif; ?>
            <?php if ($success !== ""): ?>
                <p class="success"><?= $success; ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Masukkan email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="text" name="password" placeholder="Masukkan password" required>
            <small>Password minimal 8 karakter, harus ada huruf dan angka</small>
        </div>

        <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="text" name="telepon" placeholder="Masukkan nomor telepon">
        </div>

        <button type="submit" class="btn-login">Daftar</button>

        <p class="register-text">
            Sudah punya akun? 
            <a href="login.php" class="link-gold">Login</a>
        </p>
    </form>
</div>

</body>
</html>
