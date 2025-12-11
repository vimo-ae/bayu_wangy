# BAYU WANGY: Platform E-Commerce Parfum Mewah

Proyek ini adalah Tugas Besar mata kuliah **Pemrograman Web** yang dibina oleh **Umaya Ramadhani Putri Nasution S.TI., M.Kom.**.

## Link Repository GitHub

**URL:** https://github.com/vimo-ae/bayu_wangy

---

## Anggota Kelompok

**Kelompok 3 - Kelas A**
Program Studi Teknologi Informasi, Fakultas Ilmu Komputer dan Teknologi Informasi, Universitas Sumatera Utara (USU), 2025.

| Nama | NIM |
| :--- | :--- |
| Azriyad Ramadhansyah Lubis | 251402062 |
| Charles | 251402081 |
| Felix Desselo Tambunan | 251402033 |
| Keizya Azalea Azka | 251402131 |
| Patricia Putri Josephine Situmeang | 251402119 |
| Raymond Ganda Parsaoran Simarmata | 25140278 |
| Vedder Timothy Simbolon | 251402072 |

---

## Deskripsi Proyek

**"BAYU WANGY"** adalah prototipe website *marketplace* yang dirancang khusus untuk transaksi jual beli parfum terkenal dan mewah secara daring. Platform ini bertujuan untuk menyediakan pengalaman berbelanja yang modern, aman, dan nyaman, serta mendukung perkembangan *brand* lokal di industri wewangian.

Website ini memberikan solusi terhadap permasalahan yang sering dihadapi pengguna dalam transaksi di media sosial, seperti kurangnya keamanan dan struktur.

### Fitur Utama

Website ini membedakan pengguna ke dalam tiga peran/role: **Guest**, **User**, dan **Administrator**.

| Role | Keterangan |
| :--- | :--- |
| **Guest** | Hanya dapat melihat barang di katalog dan melihat detail produk (akses terbatas). |
| **User** | Dapat mendaftar/login, memasukkan barang ke keranjang, memberi komentar/rating, dan mengakses *Dashboard* untuk mengatur akun/informasi. |
| **Administrator** | Memiliki kontrol penuh terhadap fitur dan akun pengguna, termasuk mengelola produk, user, pesanan masuk, dan komentar. |

**Daftar Fitur yang Tersedia:**
* Login dan registrasi.
* Masukkan keranjang.
* Pencarian dan Filter produk (berdasarkan *brand* atau *range* harga).
* Memberikan komentar dan rating.
* Menambahkan alamat pengiriman.
* Melihat pesanan.
* Fitur *Admin* untuk mengelola pesanan, komentar, produk, dan data pengguna.

---

## Teknologi yang Digunakan

Pengembangan website *BAYU WANGY* menggunakan beberapa teknologi pendukung berikut:

### Front-end
* HTML
* JavaScript
* CSS

### Back-end & Basis Data
* PHP
* XAMPP
* MySQL (digunakan sebagai sistem basis data)
* phpMyAdmin (digunakan sebagai panel *dashboard* basis data)

### Teknologi Pendukung
* Visual Studio Code
* Git

---

## Cara Menjalankan Proyek (Contoh)

Proyek ini dibangun menggunakan PHP dan sistem basis data MySQL (XAMPP).

1.  **Clone Repository:**
    ```bash
    git clone [https://github.com/vimo-ae/bayu_wangy.git](https://github.com/vimo-ae/bayu_wangy.git)
    ```
2.  **Siapkan Database:**
    * Pastikan **XAMPP** (atau lingkungan serupa) berjalan (Apache dan MySQL).
    * Buat database baru di **phpMyAdmin**.
    * Impor struktur tabel (contohnya: `users`, `alamat`, `produk`, `pesanan`, dll.) ke dalam database tersebut. Anda dapat mereferensi struktur tabel pada BAB III, Bagian 3.2 Laporan.
3.  **Konfigurasi Proyek:**
    * Pindahkan folder proyek ke direktori *web server* lokal Anda (misalnya: `htdocs` di XAMPP).
    * Sesuaikan konfigurasi koneksi database di kode program PHP Anda agar terhubung dengan database yang baru dibuat.
4.  **Akses Aplikasi:**
    * Akses aplikasi melalui *browser* Anda (misalnya: `http://localhost/bayu_wangy/`).
    * Lakukan registrasi sebagai *User* atau *Guest* untuk mulai mencoba fitur. Admin memiliki akses khusus untuk melihat laporan aktivitas dan mengelola pesanan.
