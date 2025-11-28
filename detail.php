<?php
require 'conn.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_produk_url = $_GET['id'];
$query = "SELECT * FROM produk WHERE id_produk = $id_produk_url";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) !== 1) {
    header("Location: index.php");
    exit();
}

?>

<?php $data = mysqli_fetch_assoc($result); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail - <?php echo $data['nama_produk']; ?></title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/detaill.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>
    
     <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="button-bar">
        <a href="katalog.php">
            <button class="back-btn">← Kembali ke Katalog</button>
        </a>
        <a href="pesan.php?id=<?php echo $id_produk_url; ?>">
            <button class="cart-btn">Masukkan Keranjang</button>
        </a>
    </div>

    <div class="detail-container">

        <!-- LEFT IMAGE -->
        <div class="image">
            <img src="<?php echo $data['gambar_produk']; ?>" alt="<?php echo $data['nama_produk']; ?>">
        </div>

        <!-- RIGHT DETAILS -->
        <div class="details">

            <h1><?php echo $data['nama_produk']; ?></h1>

            <p class="label">BRAND</p>
            <p class="value"><?php echo $data['merk_detail']; ?></p>

            <p class="label">TYPE</p>
            <p class="value"><?php echo $data['tipe_parfum']; ?></p>

            <p class="label">SIZE</p>
            <p class="value"><?php echo $data['ukuran']; ?></p>

            <div class="description">
                <?php echo $data['deskripsi']; ?>
            </div>
  
                <h3 class="label">NOTES</h3>
                <p><b>Top Notes:</b> <?php echo $data['top_notes']; ?></p>
                <p><b>Heart Notes:</b> <?php echo $data['heart_notes']; ?></p>
                <p><b>Base Notes:</b> <?php echo $data['base_notes']; ?></p>

        </div>

    </div>


    <!-- footer -->
    <?php include 'footer.php'; ?>

</body>

</html>