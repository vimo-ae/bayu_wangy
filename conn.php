<?php
$conn = mysqli_connect("localhost", "root", "", "bayu_wangy");
if (!$conn) {
    echo "Koneksi Gagal: " . mysqli_connect_error();
}
?>