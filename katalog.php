<?php
require 'conn.php';

// --- BASE QUERY ---
$query = "SELECT * FROM produk WHERE 1";

// =========================
//  FILTER HARGA
// =========================
$min = isset($_GET['min']) ? intval($_GET['min']) : 0;
$max = isset($_GET['max']) ? intval($_GET['max']) : 12500000;

$query .= " AND harga BETWEEN $min AND $max";

// =========================
//  FILTER BRAND
// =========================
if (!empty($_GET['brand'])) {
    // ubah array menjadi format 'Dior','Chanel','Zara'
    $filterBrand = array_map('mysqli_real_escape_string', 
                    array_fill(0, count($_GET['brand']), $conn),
                    $_GET['brand']);

    $brandList = "'" . implode("','", $_GET['brand']) . "'";
    $query .= " AND merk IN ($brandList)";
}

// =========================
//  FILTER JENIS PARFUM
//  contoh: EDP, EDT, Extrait, Cologne, Body Mist
// =========================
if (!empty($_GET['tipe_parfum'])) {
    $jenisList = "'" . implode("','", $_GET['tipe_parfum']) . "'";
    $query .= " AND tipe_parfum IN ($jenisList)";
}

// =========================
//  EKSEKUSI QUERY
// =========================
$result = mysqli_query($conn, $query);

// DETEKSI PAGE (opsional)
$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Katalog</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/katalogg.css">
    <link rel="stylesheet" href="css/styleee.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>
 
    <div class="katalog-wrapper">


    <!-- Sidebar Filter -->
     <form method="GET" action="katalog.php">
<div class="filter-box">

<h4>Jenis Parfum</h4>

<label>
    <input type="checkbox" name="tipe_parfum[]" value="Eau de Parfum"
    <?= isset($_GET['tipe_parfum']) && in_array("Eau de Parfum", $_GET['tipe_parfum']) ? "checked" : "" ?>>
    Eau de Parfum
</label>

<label>
    <input type="checkbox" name="tipe_parfum[]" value="Eau de Toilette"
    <?= isset($_GET['tipe_parfum']) && in_array("Eau de Toilette", $_GET['tipe_parfum']) ? "checked" : "" ?>>
    Eau de Toilette
</label>

<label>
    <input type="checkbox" name="tipe_parfum[]" value="Extrait de Parfum"
    <?= isset($_GET['tipe_parfum']) && in_array("Extrait de Parfum", $_GET['tipe_parfum']) ? "checked" : "" ?>>
    Extrait de Parfum
</label>

        <h4 class="joedoel">Harga</h4>

<div class="price-display">
    <span>Min: <strong id="minValue">Rp <?= number_format($min, 0, ',', '.') ?></strong></span><br>
    <span>Max: <strong id="maxValue">Rp <?= number_format($max, 0, ',', '.') ?></strong></span>
</div>

<input type="range" id="minRange" min="0" max="12500000" step="1000"
       name="min" value="<?= $min ?>">

<input type="range" id="maxRange" min="0" max="12500000" step="1000"
       name="max" value="<?= $max ?>" style="margin-top:10px;">


        <h4 class="joedoel">Brand</h4>
        <label><input type="checkbox" name="brand[]" value="Xerjoff"
            <?= (isset($_GET['brand']) && in_array("Xerjoff", $_GET['brand'])) ? "checked" : "" ?>>
            Xerjoff
        </label>

        <label><input type="checkbox" name="brand[]" value="Versace"
            <?= (isset($_GET['brand']) && in_array("Versace", $_GET['brand'])) ? "checked" : "" ?>>
            Versace
        </label>

        <label><input type="checkbox" name="brand[]" value="Maison Francis Kurkdjian"
            <?= (isset($_GET['brand']) && in_array("Maison Francis Kurkdjian", $_GET['brand'])) ? "checked" : "" ?>>
            Maison Francis Kurkdjian
        </label>

        <label><input type="checkbox" name="brand[]" value="Parfums de Marly"
            <?= (isset($_GET['brand']) && in_array("Parfums de Marly", $_GET['brand'])) ? "checked" : "" ?>>
            Parfums de Marly
        </label>

        <button type="submit" class="confirm-btn">Konfirmasi</button>

    </form>

</div>


    <!-- Grid Produk -->
    <div class="container-catalog">
        <?php while ($data = mysqli_fetch_assoc($result)) : ?>
        <?php $id_produk = $data['id_produk']; ?>
        <div class="card">
            <div class="img-wrapper">
                <img src="<?php echo $data['gambar_produk']; ?>" alt="">
            </div>

            <div class="title">
                <h3><?= $data['nama_produk'] ?></h3>
                <span class="harga">Rp <?= number_format($data['harga'], 0, ',', '.'); ?></span>
            </div>

            <span class="brand"><?= $data['merk']; ?></span>

            <div class="tombol">
                <a href="detail.php?id=<?= $id_produk; ?>"><button>Detail</button></a>
                <a href="pesan.php?id=<?= $id_produk; ?>"><button>Masukkan Keranjang</button></a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

</div>


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

    <script>
const minRange = document.getElementById("minRange");
const maxRange = document.getElementById("maxRange");

const minValue = document.getElementById("minValue");
const maxValue = document.getElementById("maxValue");

function formatRupiah(num) {
    return "Rp " + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

minRange.addEventListener("input", () => {
    minValue.textContent = formatRupiah(minRange.value);
});

maxRange.addEventListener("input", () => {
    maxValue.textContent = formatRupiah(maxRange.value);
});
</script>


</body>

</html>