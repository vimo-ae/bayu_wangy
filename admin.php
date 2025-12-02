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
/* Menyesuaikan Admin Panel agar setema dengan Akun Saya (global.css) */
    body {
        /* Latar Belakang Gelap dan Font Poppins */
        background: #0D0D0D; 
        color: #E8E8E8;
        font-family: 'Poppins', sans-serif; 
    }
    
    /* Ganti warna teks header/judul utama ke emas */
    h2, h4 {
        color: #D4AF37;
    }
    
    /* --- SIDEBAR (Meniru global.css) --- */
    .sidebar {
        min-height: 100vh;
        background: #1c1c1c; /* Latar belakang sidebar gelap dari global.css */
        padding-top: 30px;
        border-right: 1px solid #333;
    }
    .sidebar a {
        display: flex; /* Menggunakan flex untuk ikon dan teks */
        align-items: center;
        padding: 15px 20px;
        color: #f2e9d8; /* Warna teks nav dari global.css */
        text-decoration: none;
        font-size: 15px;
        transition: 0.2s;
    }
    .sidebar a i {
        color: #D4AF37; /* Warna ikon emas */
        margin-right: 15px; 
        font-size: 1.2em; /* Ukuran ikon lebih besar */
    }
    .sidebar a:hover {
        background: #333333; /* Background hover dari global.css */
    }
    /* Style untuk tautan aktif */
    .sidebar .active {
        background: #2c2c2c; /* Background aktif */
        color: #D4AF37; /* Teks aktif emas */
        border-left: 5px solid #D4AF37; /* Aksen emas seperti di akun.php */
        padding-left: 15px; /* Mengkompensasi border */
        font-weight: 600;
    }
    /* Style untuk Logout */
    .sidebar .text-danger {
        color: #ff5050 !important; /* Warna logout dari global.css */
    }
    .sidebar .text-danger i {
        color: #ff5050 !important;
    }


    /* --- MAIN CONTENT & CARD --- */
    .card {
        background: #ffffff; 
        color: #000;
        border-radius: 12px;
        /* Menambahkan efek border dan shadow emas seperti login-card di global.css */
        border: 1.5px solid rgba(212, 175, 55, 0.6);
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
    }
    /* Styling untuk input form */
    .form-control {
        border-radius: 8px;
        border: 1px solid #ccc;
        transition: 0.3s;
    }
    .form-control:focus {
        border-color: #D4AF37;
        box-shadow: 0 0 8px rgba(212, 175, 55, 0.5);
        outline: none;
    }

    /* --- BUTTON GOLD (Primary) --- */
    .btn-gold {
        /* Menggunakan gradient emas seperti tombol login/edit di global.css */
        background: linear-gradient(135deg, #D4AF37, #b58d1a); 
        color: #0D0D0D; /* Teks gelap */
        font-weight: 600;
        border: none;
        transition: 0.3s;
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.4);
    }
    .btn-gold:hover {
        background: linear-gradient(135deg, #E5C361, #D4AF37);
        color: #0D0D0D;
        transform: translateY(-2px);
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.6);
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
            <a href="#"><i class="bi bi-cart-check me-2"></i>Pesanan Masuk</a>
            <a href="#"><i class="bi bi-people me-2"></i>Kelola User</a>
            <a href="#"><i class="bi bi-chat-square-text"></i>Kelola Komentar</a>
            <a href="#" class="mt-3 text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-10 p-4">

            <h2 class="mb-4" style="color:#D4AF37;">Kelola Produk</h2>

            <!-- FORM TAMBAH PRODUK -->
            <div class="card p-4 mb-4">
    <h4 class="mb-4">Tambah Produk Baru</h4>
    
    <form action="tambah_produk_proses.php" method="POST" enctype="multipart/form-data">
        
        <div class="row">
            <div class="col-md-5 mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="merk" class="form-label">Merk Utama</label>
                <input type="text" class="form-control" id="merk" name="merk" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="merk_detail" class="form-label">Detail Merk (untuk DB)</label>
                <input type="text" class="form-control" id="merk_detail" name="merk_detail" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="tipe_parfum" class="form-label">Tipe Parfum</label>
                <input type="text" class="form-control" id="tipe_parfum" name="tipe_parfum" placeholder="EDP/EDT/Extrait" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="ukuran" class="form-label">Ukuran (ml/oz)</label>
                <input type="text" class="form-control" id="ukuran" name="ukuran" placeholder="Contoh: 100ml" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" class="form-control" id="harga" name="harga" required min="0">
            </div>
        </div>

        <div class="mb-3">
            <label for="gambar_produk" class="form-label">Gambar Produk</label>
            <input type="file" class="form-control" id="gambar_produk" name="gambar_produk" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Produk</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
        </div>

        <h5 class="mt-4 mb-3" style="color: #D4AF37;">Detail Aroma (Notes)</h5>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="top_notes" class="form-label">Top Notes</label>
                <textarea class="form-control" id="top_notes" name="top_notes" rows="2" required></textarea>
            </div>
            <div class="col-md-4 mb-3">
                <label for="heart_notes" class="form-label">Heart Notes</label>
                <textarea class="form-control" id="heart_notes" name="heart_notes" rows="2" required></textarea>
            </div>
            <div class="col-md-4 mb-3">
                <label for="base_notes" class="form-label">Base Notes</label>
                <textarea class="form-control" id="base_notes" name="base_notes" rows="2" required></textarea>
            </div>
        </div>
        
        <button type="submit" class="btn btn-gold mt-4">Tambah Produk</button>
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