<?php
session_start();
require 'conn.php';


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="global.css">  -->
    <link rel="stylesheet" href="css/styleee.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <title>Checkout - Toko Parfum</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .checkout-container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .checkout-section {
            margin-bottom: 25px;
        }

        .checkout-section h3 {
            margin-bottom: 10px;
            border-bottom: 2px solid #eee;
            padding-bottom: 8px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 12px;
        }

        .input-group label {
            font-size: 14px;
            margin-bottom: 4px;
        }

        .input-group input, .input-group select, textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .order-summary {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            background: #fafafa;
        }

        .order-summary div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .btn-checkout {
            width: 100%;
            padding: 14px;
            background: #3b82f6;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-checkout:hover {
            background: #2563eb;
        }

        .error-message {
            color: #e3342f; /* Warna merah */
                font-size: 12px;
                margin-top: 4px;
            display: none; /* Sembunyikan secara default */
        }

            /* CSS untuk input yang invalid */
        .input-group input.is-invalid, 
        .input-group textarea.is-invalid {
            border-color: #e3342f; 
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="checkout-container">
        <h2>Checkout</h2>

        <!-- Informasi Pembeli -->
        <div class="checkout-section">
        <h3>Informasi Pembeli</h3>
        <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" id="nama_lengkap" placeholder="Masukkan nama anda">
                <p class="error-message" id="error-nama_lengkap">Nama lengkap tidak boleh kosong.</p> 
        </div>
        <div class="input-group"> 
                <label>Email</label>
                <input type="email" id="email" placeholder="contoh@email.com">
                <p class="error-message" id="error-email">Email tidak boleh kosong.</p>
        </div>
        <div class="input-group">
                <label>No Telepon</label>
                <input type="text" id="no_telepon" placeholder="08xxxxxxxxxx">
                <p class="error-message" id="error-no_telepon">Nomor telepon tidak boleh kosong.</p>
        </div>
        <div class="input-group">
                <label>Alamat Lengkap</label>
                <textarea rows="3" id="alamat_detail" placeholder="Nama jalan, kecamatan, RT/RW"></textarea>
                <p class="error-message" id="error-alamat_detail">Alamat pengiriman tidak boleh kosong.</p>
        </div>
</div>

        <!-- Ringkasan Pesanan -->
        <div class="checkout-section">
            <h3>Ringkasan Pesanan</h3>
            <div class="order-summary">
                <p>Memuat ringkasan...</p>
            </div>
        </div>

        <button class="btn-checkout" id="btn-bayar">Bayar Sekarang</button>

    </div>
    <?php include 'footer.php'; ?>

<script>
    // URL API yang mengarah ke keranjang.php
    const API_URL = 'keranjang.php'; 
    const ONGKIR = 20000; // Biaya Ongkir Statis

    function formatRupiah(angka) {
        return 'Rp' + (Math.round(angka)).toLocaleString('id-ID');
    }

    // Fungsi utilitas untuk melakukan panggilan API
    async function apiCall(action, method = 'GET', body = null) {
        const url = API_URL + '?action=' + encodeURIComponent(action);
        const res = await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: body ? JSON.stringify(body) : null
        });
        if (!res.ok) {
            let errorText = await res.text();
            throw new Error(`Error: ${res.status} ${res.statusText} - ${errorText}`);
        }
        return res.json();
    }

    // Mengambil data keranjang dan mengisi ringkasan pesanan
    async function loadSummary() {
        const summaryDiv = document.querySelector('.order-summary');
        const btnBayar = document.getElementById('btn-bayar');
        summaryDiv.innerHTML = '<p style="text-align: center;">Memuat ringkasan...</p>';

        try {
            const res = await apiCall('get_cart');
            const items = res.items || [];
            
            summaryDiv.innerHTML = ''; // Kosongkan konten

            let subtotalProduk = 0;

            if (items.length === 0) {
                summaryDiv.innerHTML = '<p style="text-align: center;">Keranjang kosong. Tidak dapat melanjutkan checkout.</p>';
                btnBayar.disabled = true;
                return;
            }
            
            items.forEach(item => {
                const price = parseFloat(item.price);
                const qty = parseInt(item.qty);
                const itemTotal = price * qty;
                subtotalProduk += itemTotal;
                
                // Tambahkan detail produk
                summaryDiv.innerHTML += `
                    <div>
                        <span>${item.name} (${qty}x)</span>
                        <span>${formatRupiah(itemTotal)}</span>
                    </div>
                `;
            });

            const totalAkhir = subtotalProduk + ONGKIR;

            // Tambahkan baris Ongkir dan Total
            summaryDiv.innerHTML += `
                <div>
                    <span>Ongkir</span>
                    <span>${formatRupiah(ONGKIR)}</span>
                </div>
                <hr>
                <div style="font-weight: bold;">
                    <span>Total</span>
                    <span>${formatRupiah(totalAkhir)}</span>
                </div>
            `;
            
            btnBayar.disabled = false;

        } catch (e) {
            console.error('Gagal memuat ringkasan keranjang:', e);
            summaryDiv.innerHTML = '<p style="color: red; text-align: center;">Gagal memuat data keranjang.</p>';
            btnBayar.disabled = true;
        }
    }

    // Mengambil semua data form yang saat ini ada di HTML
    function collectFormData() {
        return {
            nama_lengkap: document.getElementById('nama_lengkap').value,
            email: document.getElementById('email').value,
            no_telepon: document.getElementById('no_telepon').value,
            // ID 'provinsi' dan 'kota' dihapus karena tidak ada di HTML saat ini
            alamat_detail: document.getElementById('alamat_detail').value
        };
    }
    
// Fungsi pembantu untuk mengecek apakah nilai hanya terdiri dari angka
function isNumeric(value) {
    // Regex: hanya boleh mengandung 0-9 dan panjangnya minimal 5 (untuk nomor telepon)
    // Karakter + dan - tidak diperbolehkan, hanya angka.
    const numericRegex = /^\d+$/; 
    return numericRegex.test(value);
}

// Fungsi pembantu untuk mengecek format email yang valid
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validateForm() {
        const requiredIds = ['nama_lengkap', 'email', 'no_telepon', 'alamat_detail'];
        let isValid = true;
        let firstInvalidInput = null; 

        // 1. Reset semua status validasi
        requiredIds.forEach(id => {
            const input = document.getElementById(id);
            const errorMessage = document.getElementById('error-' + id);
            
            if (input) input.classList.remove('is-invalid');
            if (errorMessage) errorMessage.style.display = 'none';
        });

        // 2. Cek satu per satu dan tandai error
        requiredIds.forEach(id => {
            const input = document.getElementById(id);
            const value = input ? input.value.trim() : '';
            const errorMessageElement = document.getElementById('error-' + id);
            let errorMessageText = ''; 
            
            if (input) {
                // Mendapatkan nama label untuk pesan error
                const labelName = input.previousElementSibling.textContent.replace(':', '').trim();

                // A. Validasi KOSONG
                if (value === '') {
                    errorMessageText = `${labelName} tidak boleh kosong.`;
                } 
                // B. Validasi FORMAT EMAIL
                else if (id === 'email' && !isValidEmail(value)) {
                    errorMessageText = 'Format email tidak valid (contoh: user@domain.com).';
                }
                // C. Validasi HANYA ANGKA (Nomor Telepon)
                else if (id === 'no_telepon' && !isNumeric(value)) {
                    errorMessageText = `${labelName} harus berupa angka (0-9) tanpa spasi atau tanda lain.`;
                }
                
                if (errorMessageText !== '') {
                    // Ada Error
                    input.classList.add('is-invalid'); 
                    if (errorMessageElement) {
                        errorMessageElement.textContent = errorMessageText;
                        errorMessageElement.style.display = 'block';
                    }
                    isValid = false;
                    
                    if (!firstInvalidInput) {
                        firstInvalidInput = input;
                    }
                }
            }
        });

        // 3. Scroll ke input error pertama
        if (firstInvalidInput) {
            firstInvalidInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstInvalidInput.focus(); 
        }

        return isValid;
    }

// Fungsi yang akan menjalankan proses checkout
async function handleCheckout(event) {
        event.preventDefault(); 
        const btnBayar = document.getElementById('btn-bayar');

        // 1. Validasi. Jika gagal, stop dan tampilkan error merah.
        if (!validateForm()) {
            return; 
        }
        
        // 2. Reset Tampilan. Panggil validateForm() untuk menghilangkan garis merah.
        // Tampilan masih belum terupdate di layar.
        validateForm(); 

        // 3. Tunda eksekusi (setTimeout)
        // Ini memberikan waktu bagi browser untuk merender ulang tampilan (menghilangkan merah)
        setTimeout(async () => {
            
            // 4. Konfirmasi (Tampilan input sekarang sudah bersih)
            if (!confirm('Pastikan data sudah benar sebelum memproses pembayaran.')) {
                return;
            }

            // 5. Ambil data dan Lanjutkan AJAX
            const formData = collectFormData(); 
            
            try {
                btnBayar.disabled = true;
                btnBayar.textContent = 'Memproses...';
                
                const res = await apiCall('checkout', 'POST', formData);
                
                if (res.success) {
                    console.log(`Pesanan Berhasil! ID: #${res.order_id}`);
                    window.location.href = 'keranjang.php?status=success'; 
                } else {
                    console.error('Checkout gagal:', res.error);
                    alert('Checkout gagal: Terjadi kesalahan saat menyimpan pesanan.');
                }
            } catch (e) {
                console.error('Error saat proses checkout:', e);
                alert('Terjadi kesalahan koneksi/server. Silakan coba lagi.');
            } finally {
                if (btnBayar.disabled) {
                    btnBayar.disabled = false;
                    btnBayar.textContent = 'Bayar Sekarang';
                }
            }
        }, 0); // Delay nol (0) untuk memaksa pembaruan DOM
}

document.addEventListener('DOMContentLoaded', function() {
        loadSummary();
        document.getElementById('btn-bayar').addEventListener('click', handleCheckout);
});

</script>

</body>
</html>
