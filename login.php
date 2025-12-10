<?php
session_start();
require 'conn.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $error = "Email tidak terdaftar!";
    } else {
        $user = $result->fetch_assoc();
        if (!password_verify($password, $user['password'])) {
            $error = "Password salah!";
        } else {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'] ?? 'user';

            if ($_SESSION['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: akun.php");
            }
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Parfum Luxe</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/akun.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/styleee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="login-container">

        <h1 class="title">Bayu Wangy</h1>
        
        <form id="loginForm" class="login-card" method="POST" action="">

            <h2>Masuk ke Akun</h2>

            <?php if ($error !== ""): ?>
                <div class="error-messages">
                    <p><?= $error; ?></p>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" placeholder="Masukkan email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                <span id="togglePassword">
                    <i class="fa-regular fa-eye-slash"></i>
                </span>
            </div>

            <button type="submit" class="btn-login">Login</button>

            <p class="register-text">
                Belum punya akun?
                <a href="register.php" class="link-gold">Daftar</a>
            </p>
        </form>

    </div>

    <?php include 'footer.php'; ?>

<script src="script/login.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>