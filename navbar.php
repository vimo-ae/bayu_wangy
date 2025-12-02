
<link rel="stylesheet" href="css/navbar.css">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm text-dark py-3">
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
                    <a class="nav-link <?= ($activePage == 'about') ? 'active' : '' ?>" href="about.php">Tentang</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($activePage == 'katalog') ? 'active' : '' ?>" href="katalog.php">Katalog</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($activePage == 'keranjang') ? 'active' : '' ?>" href="keranjang.php">Keranjang</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($activePage == 'akun') ? 'active' : '' ?>" href="akun.php">Akun Saya</a>
                </li>

            </ul>
        </div>

    </div>
</nav>
