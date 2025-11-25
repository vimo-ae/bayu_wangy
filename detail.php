<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Erba Pura Full Page</title>
     <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/detail.css">
</head>

<body>
    
     <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">

        <!-- LEFT IMAGE -->
        <div class="image">
            <img src="images/alexandria2.jpg" alt="Alexandria II Perfume">
        </div>

        <!-- RIGHT DETAILS -->
        <div class="details">

            <h1>ALEXANDRIA II</h1>

            <p class="label">BRAND</p>
            <p class="value">Xerjoff - Oud Stars Collection</p>

            <p class="label">TYPE</p>
            <p class="value">Unisex Eau de Parfum</p>

            <p class="label">SIZE</p>
            <p class="value">100 ml</p>

            <div class="description">
                Alexandria II adalah parfum oriental woody yang sangat mewah, elegan, dan berkarakter.
                Aromanya menggabungkan lavender lembut, kayu-kayuan eksotis, oud berkualitas tinggi,
                dan sentuhan amber-vanilla yang hangat.
                Parfum ini terkenal memiliki aura royal dan sangat berkesan, cocok untuk malam hari,
                acara formal, dan suasana yang membutuhkan kesan powerful & classy.
            </div>
  
                <h3 class="label">NOTES</h3>
                <p><b>Top Notes:</b> Lavender, Cinnamon, Apple</p>
                <p><b>Heart Notes:</b> Rosewood, Cedarwood, Lily of the Valley</p>
                <p><b>Base Notes:</b> Oud, Amber, Sandalwood, Vanilla, Musk</p>

        </div>

    </div>
    <button class="back-btn" onclick="history.back(-1)">← Kembali</button>
    <button class="cart-btn" onclick="window.location.href='keranjang.php'">Masukkan Keranjang</button>

    <!-- footer -->
    <?php include 'footer.php'; ?>

</body>

</html>