<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styleee.css">
    <title>Bayu Wangy - Perfume Shop</title>

    <!-- Font External -->
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Section About Us -->
    <section id="about" class="dark-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 py-5 text-center text-md-start">
                    <h1 class="text-light fw-bold mb-4">Selamat Datang di<br><span class="brand">Bayu Wangy</span></h1>
                    <p class="about-text mb-4">
                        Kami adalah toko parfum yang menyediakan berbagai jenis aroma premium,
                        mulai dari parfum elegan, fresh, hingga aroma bold yang tahan lama.
                        Visi kami adalah memberikan pengalaman wangi terbaik dengan harga terjangkau,
                        serta menghadirkan koleksi parfum yang cocok untuk semua gaya dan kepribadian.
                    </p>              
                    <a href="about.php" class="btn-custom1 mt-2">Pelajari Selengkapnya</a>
                </div>
                <div class="col-md-6">
                    <img src="images/home_about.png" class="img-fluid about-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Section Katalog -->
    <section id="katalog" class="py-5">
        <div class="container">
            <h2 class="text-dark mb-0 text-center subtitle">Katalog</h2>
            <div class="row g-5 mt-0 mb-4"> 
                <div class="col-12 col-md-4">
                    <div class="card dark-section shadow-sm">
                        <img src="images/home_eau_de_toilette.png" class="img-fluid align-self-center catalog-img" alt="Eau de Toilette">
                        <div class="card-body text-center text-light mb-2">
                            <h5 class="card-title catalog-title">Eau de Toilette</h5>
                            <p class="card-text catalog-text">Wangi ringan dan menyegarkan yang sempurna untuk menemani aktivitas harian Anda.</p>
                            <a href="katalog.php" class="btn-custom2 mt-2">Lihat Lainnya ..</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card dark-section shadow-sm">
                        <img src="images/home_eau_de_parfum.png" class="img-fluid align-self-center catalog-img" alt="Eau de Parfum">
                        <div class="card-body text-center text-light mb-2">
                            <h5 class="card-title catalog-title">Eau de Parfum</h5>
                            <p class="card-text catalog-text">Aroma lebih kaya dan tahan lama yang memberikan keharuman elegan sepanjang hari.</p>
                            <a href="katalog.php" class="btn-custom2 mt-2">Lihat Lainnya ..</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card dark-section shadow-sm">
                        <img src="images/home_extrait_de_parfum.png" class="img-fluid align-self-center catalog-img" alt="Extrait de Parfum">
                        <div class="card-body text-center text-light mb-2">
                            <h5 class="card-title catalog-title">Extrait de Parfum</h5>
                            <p class="card-text catalog-text">Aroma sangat pekat dengan kesan mewah dan elegan, serta ketahanan yang luar biasa lama.</p>
                            <a href="katalog.php" class="btn-custom2 mt-2">Lihat Lainnya ..</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Produk Kami -->
    <section id="produk" class="py-5 dark-section">
        <div class="container">
            <h2 class="mb-5 text-center text-light subtitle">Produk Kami</h2>
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
                <h6 class="catalog-text">Atau jelajahi seluruh koleksi parfum kami..</h6>
                <a href="katalog.php" class="btn-custom1 mt-2">Lihat Semua Produk</a>
            </div>
        </div>
    </section>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script src="bootstrap/js/bootstrap.js"></script>
</body>
</html>