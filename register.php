<?php
require 'conn.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $telepon = trim($_POST['telepon']);

    if (empty($nama) || empty($email) || empty($password)) {
        $error = "Semua field harus diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid!";
    } elseif (strlen($password) < 5) {
        $error = "Password minimal 5 karakter!";
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
</head>
<body>
    <div class="login-container">
        <h1 class="title">Daftar Akun</h1>

        <form id="registerForm" class="login-card" method="POST" action="">
            <?php if ($error !== ""): ?>
                <p style="color:red; text-align:center; margin-bottom:15px;"><?php echo $error; ?></p>
            <?php endif; ?>
            <?php if ($success !== ""): ?>
                <p style="color:green; text-align:center; margin-bottom:15px;"><?php echo $success; ?></p>
            <?php endif; ?>

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
                <input type="password" name="password" placeholder="Masukkan password" required>
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
