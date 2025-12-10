 
    const API_URL = 'keranjang.php'; 
    const ONGKIR = 20000; 

    function formatRupiah(angka) {
        return 'Rp' + (Math.round(angka)).toLocaleString('id-ID');
    }

    
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

   
    async function loadSummary() {
        const summaryDiv = document.querySelector('.order-summary');
        const btnBayar = document.getElementById('btn-bayar');
        summaryDiv.innerHTML = '<p style="text-align: center;">Memuat ringkasan...</p>';

        try {
            const res = await apiCall('get_cart');
            const items = res.items || [];
            
            summaryDiv.innerHTML = ''; 

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
                
               
                summaryDiv.innerHTML += `
                    <div>
                        <span>${item.name} (${qty}x)</span>
                        <span>${formatRupiah(itemTotal)}</span>
                    </div>
                `;
            });

            const totalAkhir = subtotalProduk + ONGKIR;

            
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
            console.error("Gagal memuat ringkasan:", e);
            summaryDiv.innerHTML = '<p class="error-text">Gagal memuat ringkasan. Silakan cek konsol browser.</p>';
            btnBayar.disabled = true;
            }

    }

    
    function collectFormData() {
        return {
            nama_lengkap: document.getElementById('nama_lengkap').value,
            email: document.getElementById('email').value,
            no_telepon: document.getElementById('no_telepon').value,
          
            alamat_detail: document.getElementById('alamat_detail').value
        };
    }
    

function isNumeric(value) {
    
    const numericRegex = /^\d+$/; 
    return numericRegex.test(value);
}


    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validateForm() {
        const requiredIds = ['nama_lengkap', 'email', 'no_telepon', 'alamat_detail'];
        let isValid = true;
        let firstInvalidInput = null; 

        
        requiredIds.forEach(id => {
            const input = document.getElementById(id);
            const errorMessage = document.getElementById('error-' + id);
            
            if (input) input.classList.remove('is-invalid');
            if (errorMessage) errorMessage.style.display = 'none';
        });

        
        requiredIds.forEach(id => {
            const input = document.getElementById(id);
            const value = input ? input.value.trim() : '';
            const errorMessageElement = document.getElementById('error-' + id);
            let errorMessageText = ''; 
            
            if (input) {
                
                const labelName = input.previousElementSibling.textContent.replace(':', '').trim();

              
                if (value === '') {
                    errorMessageText = `${labelName} tidak boleh kosong.`;
                } 
                
                else if (id === 'email' && !isValidEmail(value)) {
                    errorMessageText = 'Format email tidak valid (contoh: user@domain.com).';
                }
              
                else if (id === 'no_telepon' && !isNumeric(value)) {
                    errorMessageText = `${labelName} harus berupa angka (0-9) tanpa spasi atau tanda lain.`;
                }
                
                if (errorMessageText !== '') {
                   
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

       
        if (firstInvalidInput) {
            firstInvalidInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstInvalidInput.focus(); 
        }

        return isValid;
    }


async function handleCheckout(event) {
        event.preventDefault(); 
        const btnBayar = document.getElementById('btn-bayar');

        
        if (!validateForm()) {
            return; 
        }
        
        
        validateForm(); 

       
        setTimeout(async () => {
            
          
            if (!confirm('Pastikan data sudah benar sebelum memproses pembayaran.')) {
                return;
            }

           
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
        }, 0); 
}

document.addEventListener('DOMContentLoaded', function() {
        loadSummary();
        document.getElementById('btn-bayar').addEventListener('click', handleCheckout);
});