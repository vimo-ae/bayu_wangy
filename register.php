<?php
require 'conn.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $telepon  = trim($_POST['telepon']);

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
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (nama, email, password, telepon) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama, $email, $hashPassword, $telepon);

if ($result->num_rows > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (nama, email, password, telepon) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama, $email, $hashPassword, $telepon);

            if ($stmt->execute()) {
                
                
                $new_user_id = $conn->insert_id; 

                $stmt_alamat = $conn->prepare("INSERT INTO alamat (id_user, nama, telepon) VALUES (?, ?, ?)");
                
                $stmt_alamat->bind_param("iss", 
                    $new_user_id,  
                    $nama,         
                    $telepon       
                );
                
                if ($stmt_alamat->execute()) {
                    $success = "Registrasi berhasil! Silakan <a href='login.php' class='link-gold'>login</a>.";
                } else {
                    $conn->query("DELETE FROM users WHERE id_user = $new_user_id");
                    $error = "Registrasi gagal karena masalah database alamat. Silakan coba lagi.";
                }
                

            } else {
                $error = "Terjadi kesalahan, coba lagi.";
            }
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
<link rel="stylesheet" href="css/akun.css">
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/styleee.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet"></head>
<body>

<div class="login-container">
    <h1 class="title">Daftar Akun</h1>

    <form id="registerForm" class="login-card" method="POST" action="">
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
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
