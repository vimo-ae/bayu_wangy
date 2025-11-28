<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimoni & Review Produk Parfum</title>
    <style>
        /* CSS Dasar untuk Body */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000; /* Latar belakang hitam */
            color: #fff; /* Teks putih */
        }

        /* Header Utama */
        header {
            text-align: center;
            padding: 50px 20px 30px;
        }
        h1.title {
            color: #FFD700; /* Emas */
            font-size: 3em;
            margin-bottom: 5px;
            letter-spacing: 5px;
        }
        .subtitle {
            color: #e6e6e6;
            font-size: 1.1em;
            margin-top: 0;
        }

        /* Container Testimoni Highlight */
        .testimonials-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            flex-wrap: wrap; 
        }
        .card {
            background-color: #fff;
            color: #000;
            padding: 20px;
            border-radius: 12px;
            width: 280px;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);
            text-align: left;
        }
        .card h3 {
            margin-top: 0;
            margin-bottom: 5px;
            color: #333; /* Mengubah warna agar kontras dengan card putih */
        }
        .rating {
            color: gold;
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .rating .partial {
            color: #ccc; 
        }
        
        /* --- CSS BARU UNTUK LIST REVIEW JUMLAH BANYAK --- */
        
        .main-review-section {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }
        .main-review-section h2 {
            color: #FFD700;
            text-align: center;
            margin-bottom: 30px;
        }
        .review-list {
            /* Menggunakan Grid 2 kolom agar lebih ringkas */
            display: grid;
            grid-template-columns: repeat(2, 1fr); 
            gap: 20px;
            padding-bottom: 20px;
        }
        .review-item {
            background-color: #222; /* Kontras gelap */
            padding: 15px;
            border-radius: 8px;
            border-left: 5px solid #FFD700; /* Aksen warna emas */
        }
        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
            font-size: 0.9em;
        }
        .review-item strong {
            color: #fff;
            font-size: 1.1em;
        }
        .review-item .rating {
            font-size: 1.2em;
            margin-bottom: 0;
        }
        .review-item p {
            margin-top: 5px;
            font-size: 0.95em;
            line-height: 1.4;
        }
        
        .load-more-container {
            text-align: center;
            margin-top: 30px;
        }
        
        /* --- END CSS BARU --- */

        /* Container Form */
        .form-container {
            display: flex;
            justify-content: center;
            padding: 50px 20px;
        }
        .comment-form {
            background-color: #FFD700; 
            padding: 30px;
            border-radius: 12px;
            width: 450px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            color: #333; 
            text-align: center;
        }
        .comment-form h2 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #333;
        }

        /* Input Group */
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .input-group input,
        .input-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1em;
        }
        .submit-btn {
            background-color: #333;
            color: #FFD700;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .submit-btn:hover {
            background-color: #555;
        }

        /* Star Rating Widget */
        .star-rating {
            display: flex;
            flex-direction: row-reverse; 
            justify-content: center;
            margin-bottom: 20px;
            font-size: 2em;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            cursor: pointer;
            color: #ccc; 
            transition: color 0.2s;
            padding: 0 3px;
        }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #FFD700; 
        }

        /* Media Queries untuk Responsif */
        @media (max-width: 900px) {
            .testimonials-container {
                flex-direction: column;
                align-items: center;
            }
            .card {
                width: 80%; 
            }
            .review-list {
                grid-template-columns: 1fr; /* Jadi 1 kolom di HP */
            }
        }
    </style>
</head>

<body>
    <header>
        <h1 class="title">TESTIMONI</h1>
        <p class="subtitle">Sentuhan kemewahan dalam setiap tetes parfum emas</p>
    </header>

    <div class="testimonials-container">
        <div class="card">
            <h3>Amelia Putri</h3>
            <div class="rating">★★★★★</div>
            <p>Harumnya lembut, tahan lama, dan mewah banget!</p>
        </div>

        <div class="card">
            <h3>Rudi Anggara</h3>
            <div class="rating">★★★★<span class="partial">☆</span></div>
            <p>Wangi elegan, cocok untuk acara formal dan hadiah.</p>
        </div>

        <div class="card">
            <h3>Alya Anantiyas</h3>
            <div class="rating">★★★★★</div>
            <p>Wangi, cocok untuk acara formal dan hadiah.</p>
        </div>
    </div>

    <div class="main-review-section">
        <h2>Semua Komentar Pengguna</h2>
        
        <div class="review-list">
            <div class="review-item">
                <div class="item-header">
                    <strong>Azka</strong> <span class="rating">★★★★★</span>
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
        
        <!-- <div class="load-more-container">
            <button class="submit-btn" id="loadMoreBtn">Lihat Komentar Lainnya (Tersisa 130)</button>
        </div> -->
    </div>
    <div class="form-container">
        <form class="comment-form" action="#" method="POST">
            <h2>Beri Komentar Anda</h2>
            
            <div class="input-group">
                <label for="nama">Nama Anda</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda" required>
            </div>

            <label style="text-align: center; display: block; margin-bottom: 10px;">Rating (Wajib)</label>
            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5" required>
                <label for="star5" title="5 bintang">★</label>
                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4" title="4 bintang">★</label>
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3" title="3 bintang">★</label>
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2" title="2 bintang">★</label>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1" title="1 bintang">★</label>
            </div>

            <div class="input-group">
                <label for="komentar">Tulis Komentar Anda</label>
                <textarea id="komentar" name="komentar" rows="4" placeholder="Tulis komentar dan pengalaman Anda di sini..." required></textarea>
            </div>

            <button type="submit" class="submit-btn">Kirim</button>
        </form>
    </div>

</body>
</html>