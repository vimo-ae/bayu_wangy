<?php
session_start();
require 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    header('Content-Type: application/json'); 
    
    $nama = htmlspecialchars(trim($_POST['name'] ?? '')); 
    $rating = (int)($_POST['rating'] ?? 0);
    $komentar = htmlspecialchars(trim($_POST['comment'] ?? ''));
    $tanggal = date('Y-m-d H:i:s'); 
    
    if (empty($nama) || empty($komentar) || $rating < 1 || $rating > 5) {
        echo json_encode(['success' => false, 'message' => 'Data input tidak lengkap atau tidak valid.']);
        exit();
    }
    
    $sql = "INSERT INTO testimoni (nama_user, rating, komentar, tanggal_dibuat) 
            VALUES (?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $nama, $rating, $komentar, $tanggal);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Terima kasih, testimoni Anda berhasil dipublikasikan!']);
    } else {
        echo json_encode(['success' => false, 'message' => "Gagal menyimpan testimoni: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit(); 
}

$testimoni_list = [];
$sql_select = "SELECT nama_user, rating, komentar FROM testimoni ORDER BY id_komen DESC"; 
$result = $conn->query($sql_select);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $testimoni_list[] = $row;
    }
}
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About & Testimoni - Bayu Wangy</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/styleee.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="story">
        <div class="signature">The Art of Fragrance</div>
        <p>
            Didirikan dengan semangat untuk menciptakan parfum yang bukan hanya wangi—tetapi juga pengalaman. Kami percaya bahwa setiap tetes parfum memiliki kekuatan untuk membangkitkan kenangan, meningkatkan percaya diri, dan menggambarkan kepribadian.
        </p>
        <p>
            Dengan bahan premium pilihan dan proses penyulingan yang penuh ketelitian, setiap parfum kami membawa kesan mewah, tahan lama, dan tak terlupakan.
        </p>
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

    <div class="gold-line"></div>

    <section class="testimoni-section">
    <h2 class="judul-section">TESTIMONI</h2>
    <p class="subjudul">Sentuhan kemewahan dalam setiap tetes parfum emas</p>

    <div class="main-review-section">
        <div class="review-list">
    <?php
            if (count($testimoni_list) > 0) {
                foreach ($testimoni_list as $testimoni) {
                    $rating = $testimoni['rating'];
                    $stars_filled = str_repeat('★', $rating);
                    $stars_empty = str_repeat('☆', 5 - $rating);
                    
                    echo '<div class="review-item">';
                    echo '    <div class="item-header">';
                    echo '        <strong>' . htmlspecialchars($testimoni['nama_user']) . '</strong> ';
                    echo '        <span class="rating">' . $stars_filled . $stars_empty . '</span>';
                    echo '    </div>';
                    echo '    <p>' . nl2br(htmlspecialchars($testimoni['komentar'])) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>Belum ada testimoni. Jadilah yang pertama!</p>';
            }
            ?>
        </div>
    </div>
    
    <div class="form-container">
    <form class="comment-form" method="POST" action="about.php">
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

        <button type="submit" name="submit_comment" class="submit-btn">Kirim</button>
    </form>
</div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="script/aboutt.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>