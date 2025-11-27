<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About & Testimoni - Bayu Wangy</title>
    <link rel="stylesheet" href="css/about.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <section class="story">
        <div class="gold-line"></div>
        <p>
            Didirikan dengan semangat untuk menciptakan parfum yang bukan hanya wangi—tetapi juga pengalaman. Kami percaya bahwa setiap tetes parfum memiliki kekuatan untuk membangkitkan kenangan, meningkatkan percaya diri, dan menggambarkan kepribadian.
        </p>
        <p>
            Dengan bahan premium pilihan dan proses penyulingan yang penuh ketelitian, setiap parfum kami membawa kesan mewah, tahan lama, dan tak terlupakan.
        </p>
        <div class="signature">The Art of Fragrance</div>
    </section>

    <section class="timeline">
        <div class="t-card">
            <h3>Sejak 2020</h3>
            <p>Mengawali perjalanan kecil dari studio aroma eksklusif.</p>
        </div>
        <div class="t-card">
            <h3>Premium Collection</h3>
            <p>Meluncurkan seri parfum dengan karakter khas dan identitas kuat.</p>
        </div>
        <div class="t-card">
            <h3>Worldwide</h3>
            <p>Menjangkau pelanggan internasional yang mencari keunikan dan kemewahan.</p>
        </div>
    </section>

    <section class="testimoni-section">
    <h2 class="judul-section">TESTIMONI</h2>
    <p class="subjudul">Sentuhan kemewahan dalam setiap tetes parfum emas</p>

    <div class="main-review-section">
        <div class="review-list">
                <div class="review-item">
                    <div class="item-header">
                        <strong>Keyla B.</strong> <span class="rating">★★★★★</span>
                    </div>
                <p>Parfumnya bagus, wanginya mewah dan *packaging*-nya sangat niat!</p>
            </div>

            <div class="review-item">
                <div class="item-header">
                    <strong>Taufik H.</strong> <span class="rating">★★★<span class="partial">☆☆</span></span>
                </div>
                <p>Aromanya unik, tapi kurang tahan lama untuk aktivitas di luar ruangan.</p>
            </div>

            <div class="review-item">
                <div class="item-header">
                    <strong>Dina M.</strong> <span class="rating">★★★★★</span>
                </div>
                <p>Ini botol kedua saya, selalu suka dengan wanginya yang elegan dan berkelas!</p>
            </div>

            <div class="review-item">
                <div class="item-header">
                    <strong>Fahmi Z.</strong> <span class="rating">★★★★<span class="partial">☆</span></span>
                </div>
                <p>Sampai dengan aman. Wangi cocok untuk acara malam. Recommended!</p>
            </div>
            
            <div class="review-item">
                <div class="item-header">
                    <strong>Lisa W.</strong> <span class="rating">★★★★<span class="partial">☆</span></span>
                </div>
                <p>Sedikit manis di awal, tapi *drydown*-nya jadi mewah. Puas!</p>
            </div>
            
            <div class="review-item">
                <div class="item-header">
                    <strong>Rian P.</strong> <span class="rating">★★★★★</span>
                </div>
                <p>Pelayanan cepat, barang original. Tidak ada keluhan sama sekali.</p>
            </div>
            
            <div class="review-item">
                <div class="item-header">
                    <strong>Bima K.</strong> <span class="rating">★★★★<span class="partial">☆</span></span>
                </div>
                <p>Botolnya cantik, aromanya maskulin. Istri saya suka sekali.</p>
            </div>
            
            <div class="review-item">
                <div class="item-header">
                    <strong>Sari D.</strong> <span class="rating">★★★★★</span>
                </div>
                <p>The best parfum! Wangi mahal dengan harga terjangkau. Bintang 5!</p>
            </div>
        </div>
    </div>
    
    <div class="form-container">
    <form class="comment-form">
        <h2>Tulis Komentar</h2>

        <div class="star-rating">
            <input type="radio" id="star5" name="rating" value="5">
            <label for="star5">&#9733;</label>
            <input type="radio" id="star4" name="rating" value="4">
            <label for="star4">&#9733;</label>
            <input type="radio" id="star3" name="rating" value="3">
            <label for="star3">&#9733;</label>
            <input type="radio" id="star2" name="rating" value="2">
            <label for="star2">&#9733;</label>
            <input type="radio" id="star1" name="rating" value="1">
            <label for="star1">&#9733;</label>
        </div>

        <div class="input-group">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" placeholder="Masukkan nama Anda">
        </div>

        <div class="input-group">
            <label for="comment">Komentar</label>
            <textarea id="comment" name="comment" rows="4" placeholder="Tulis komentar Anda..."></textarea>
        </div>

        <button type="submit" class="submit-btn">Kirim</button>
    </form>
</div>
    </section>

    <script src="script/about.js"></script>
</body>
</html>