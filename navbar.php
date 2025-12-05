<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            Bayu Wangy
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Tentang</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="katalog.php">Katalog</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="keranjang.php">Keranjang</a>
                </li>

                <li class="nav-item">
<?php
    if (isset($_SESSION['id_user'])) {
        if (($_SESSION['role'] ?? 'user') === 'admin') {
            $akun_link = 'admin.php';
        } else {
            $akun_link = 'akun.php';
        }
    } else {
        $akun_link = 'login.php';
    }
?>
                    <a class="nav-link" href="<?= $akun_link; ?>">Akun Saya</a>
                </li>

            </ul>
        </div>

    </div>
</nav>