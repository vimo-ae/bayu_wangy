<?php
// NANTI kamu bisa tambah pengecekan login admin di sini
// if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Admin Panel - Produk</title>

    <style>
        body {
            background: #0d0d0d;
            color: white;
        }
        .sidebar {
            min-height: 100vh;
            background: #1a1a1a;
            padding-top: 30px;
            border-right: 1px solid #333;
        }
        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #e4e4e4;
            text-decoration: none;
            font-size: 15px;
        }
        .sidebar a:hover,
        .sidebar .active {
            background: #2a2a2a;
            color: #D4AF37;
        }

        .btn-gold {
            background: #D4AF37;
            color: black;
            font-weight: 600;
        }
        .btn-gold:hover {
            background: #b5911b;
            color: black;
        }

        .card {
            background: #ffffff;
            color: #000;
            border-radius: 12px;
            border: 1px solid rgba(212,175,55,0.25);
        }

    </style>
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-2 sidebar">
            <h4 class="text-center mb-4" style="color:#D4AF37;">ADMIN</h4>

            <a href="admin.php" class="active"><i class="bi bi-box-seam me-2"></i>Kelola Produk</a>
            <a href="#"><i class="bi bi-people me-2"></i>Kelola User</a>
            <a href="#"><i class="bi bi-cart-check me-2"></i>Pesanan Masuk</a>
            <a href="#" class="mt-3 text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-10 p-4">

            <h2 class="mb-4" style="color:#D4AF37;">Kelola Produk</h2>

            <!-- FORM TAMBAH PRODUK -->
            <div class="card p-4 mb-4">
                <h4 class="mb-3">Tambah Produk Baru</h4>

                <form action="upload_produk.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar Produk</label>
                        <input type="file" name="gambar" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-gold mt-2">Tambah Produk</button>
                </form>
            </div>

            <!-- DAFTAR PRODUK (contoh statis) -->
            <div class="card p-4">
                <h4 class="mb-3">Daftar Produk</h4>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Contoh produk sementara -->
                        <tr>
                            <td><img src="img/contoh.jpg" width="60" class="rounded"></td>
                            <td>Parfum Contoh</td>
                            <td>Rp 150.000</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <!-- NANTI ganti dengan loop PHP dari database -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>