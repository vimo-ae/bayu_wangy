<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Bayu Wangy - Perfume Shop</title>
    <style> 
        @import url('https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&display=swap');
    </style>


</head>
<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Section About Us -->
    <section id="about" class="dark-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 py-5 text-center text-md-start">
                    <h1 class="text-light fw-bold mb-4">Selamat Datang di<br>Bayu Wangy</h1>
                    <p class="about-text mb-5">
                        Kami adalah toko parfum yang menyediakan berbagai jenis aroma premium,
                        mulai dari parfum elegan, fresh, hingga aroma bold yang tahan lama.
                        Visi kami adalah memberikan pengalaman wangi terbaik dengan harga terjangkau,
                        serta menghadirkan koleksi parfum yang cocok untuk semua gaya dan kepribadian.
                    </p>              
                    <a href="about.php" class="btn btn-light">Pelajari Selengkapnya</a>
                </div>
                <div class="col-md-6 ">
                    <img src="images/home_about.png" class="img-fluid about-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Section Katalog -->
    <section id="katalog" class="py-5">
        <div class="container">
            <h2 class="text-dark mb-4 text-center">Katalog</h2>
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm">
                        <img src="images/home_parfum.png" class="img-fluid align-self-center catalog-img" alt="Kategori 1">
                        <div class="card-body text-center">
                            <h5 class="card-title">Eau de Toilette</h5>
                            <p class="card-text">Wangi ringan dan menyegarkan yang sempurna untuk menemani aktivitas harian Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm">
                        <img src="images/home_parfum.png" class="img-fluid align-self-center catalog-img" alt="Kategori 1">
                        <div class="card-body text-center">
                            <h5 class="card-title">Eau de Parfum</h5>
                            <p class="card-text">Aroma lebih kaya dan tahan lama yang memberikan keharuman elegan sepanjang hari.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm">
                        <img src="images/home_parfum.png" class="img-fluid align-self-center catalog-img" alt="Kategori 1">
                        <div class="card-body text-center">
                            <h5 class="card-title">Extrait de Parfum</h5>
                            <p class="card-text">Aroma paling pekat dengan kesan mewah dan sangat tahan lama.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="katalog.php" class="btn btn-dark">Lihat Semua Kategori</a>
            </div>
        </div>
    </section>

    <!-- Section Produk Kami -->
    <section id="produk" class="py-5 dark-section">
        <div class="container">
            <h2 class="mb-5 text-center text-light">Produk Kami</h2>
            <div class="row g-4">

                <!-- Item 1 -->
                <div class="col-6 col-md-3">
                    <div class="card h-100 shadow-sm">
                        <img src="images/home_parfum.png" class="img-fluid align-self-center catalog-img" alt="Kategori 1">
                        <div class="card-body">
                            <h5 class="card-title">Aroma Elegance</h5>
                            <p class="card-text small">Parfum floral elegan dengan wangi tahan lama.</p>
                            <p class="fw-bold">Rp120.000</p>
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="col-6 col-md-3">
                    <div class="card h-100 shadow-sm">
                        <img src="images/home_parfum.png" class="img-fluid align-self-center catalog-img" alt="Kategori 1">
                        <div class="card-body">
                            <h5 class="card-title">Fresh Breeze</h5>
                            <p class="card-text small">Aroma fresh yang menyegarkan sepanjang hari.</p>
                            <p class="fw-bold">Rp110.000</p>
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="col-6 col-md-3">
                    <div class="card h-100 shadow-sm">
                        <img src="images/home_parfum.png" class="img-fluid align-self-center catalog-img" alt="Kategori 1">
                        <div class="card-body">
                            <h5 class="card-title">Woody Intense</h5>
                            <p class="card-text small">Wangi woody maskulin yang kuat dan hangat.</p>
                            <p class="fw-bold">Rp130.000</p>
                        </div>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="col-6 col-md-3">
                    <div class="card h-100 shadow-sm">
                        <img src="images/home_parfum.png" class="img-fluid align-self-center catalog-img" alt="Kategori 1">
                        <div class="card-body">
                            <h5 class="card-title">Citrus Light</h5>
                            <p class="card-text small">Aroma citrus cerah cocok untuk suasana santai.</p>
                            <p class="fw-bold">Rp115.000</p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="text-center mt-5">
                <a href="produk.php" class="btn btn-light">Lihat Semua Produk</a>
            </div>
        </div>
    </section>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script src="bootstrap/js/bootstrap.js"></script>
</body>
</html>

<!-- style="font-family: 'Bodoni';"  -->