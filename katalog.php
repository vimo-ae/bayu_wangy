<?php
require 'conn.php';

$query = "SELECT * FROM produk";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Katalog</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/katalog.css">
    <link rel="stylesheet" href="css/styleee.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>
 
    
    <div class="container-catalog">
        <?php while ($data = mysqli_fetch_assoc($result)) : ?>
        <?php $id_produk = $data['id_produk']; ?>
        <div class="card">
            <div class="img-wrapper">
                <img src="<?php echo $data['gambar_produk']; ?>" alt="<?php echo $data['nama_produk']; ?>" />
            </div>
            <div class="title">
                <h3><?php echo $data['nama_produk']; ?></h3>
                <span class="harga">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></span>
            </div>
            <span class="brand"><?php echo $data['merk']; ?></span>
            <div class="tombol">
                <a href="detail.php?id=<?php echo $id_produk; ?>">
                    <button>Detail</button>
                </a>

                <a href="pesan.php?id=<?php echo $id_produk; ?>">
                    <button>Masukkan Keranjang</button>
                </a>
            </div>
        </div>
        <?php endwhile; ?>
        
        
    </div>
    
    <!-- footer -->
    <?php include 'footer.php'; ?>

</body>

</html>