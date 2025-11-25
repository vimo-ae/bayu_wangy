<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAYU WANGY</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/pesan.css">
</head>
<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>
    
    <section class="product-container">
        
        <div class="middle-images">
            <img src="images/image00012.webp" class="main-img">
            <div class="image-grid">
                 <img src="images/erba pura 1.jpeg">
                <img src="images/xer.webp">
            </div>
        </div>

        <div class="right-info">
            <h1 class="product-title">Xerjoff</h1>
            <p class="product-type">Erba Pura</p>
            <h2 class="price">Rp 4.000.000</h2>

            <div class="quantity-box">
                <button class="qty-btn" onclick="changeQty(-1)">−</button>
                <span id="qty">1</span>
                <button class="qty-btn" onclick="changeQty(1)">+</button>
            </div>

            <button class="buy-btn">BUY NOW</button>

            <div class="accordion">
                <div class="acc-item" onclick="toggleAcc(this)">
                    <h3>Story Behind</h3><span class="plus">+</span>
                    <p class="acc-content">botol kaca berat dipadukan dengan tutup emas, dan pada beberapa versi disertai syal sutra buatan Como sebagai bagian dari ekspresi identitas “vibe”</p>
                </div>

                <div class="acc-item" onclick="toggleAcc(this)">
                    <h3>Notes Description</h3><span class="plus">+</span>
                    <p class="acc-content">Jeruk Sisilia (Sicilian Orange), Lemon Sisilia, Bergamot Calabria</p>
                </div>

                <div class="acc-item" onclick="toggleAcc(this)">
                    <h3>Product Performance</h3><span class="plus">+</span>
                    <p class="acc-content">Erba Pura punya longevity sangat tinggi, banyak review menyebut bisa bertahan 10+ jam di kulit dan bahkan lebih lama di kain.Setelah beberapa jam, aroma menurun menjadi vanila lembut, amber hangat, dan musk yang bersih.</p>
                </div>

                <div class="acc-item" onclick="toggleAcc(this)">
                    <h3>What Do They Say</h3><span class="plus">+</span>
                    <p class="acc-content">
                      “Performs great … 1-2 sprays max … sangat fruity dan manis … benar-benar room filler”</p>
                       <p class="acc-content">“It's so fruity and sweet, almost like shampoo … for me, not worth the high price.”
                    </p>
                </div>

                <div class="acc-item" onclick="toggleAcc(this)">
                    <h3>Shipping Information</h3><span class="plus">+</span>
                    <p class="acc-content">Pengiriman 1–2 hari kerja...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>
