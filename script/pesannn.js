async function tambahKeKeranjang() {
    const idProduk = document.getElementById('id_produk_input').value;
    const quantity = parseInt(document.getElementById('qty').textContent);
    const idUser = document.getElementById('id_user_input').value;

    if (!idProduk || quantity < 1) {
        alert("ID Produk atau Jumlah tidak valid.");
        return;
    }
    
    if (!idUser) {
        alert("Anda harus login untuk menambahkan item ke keranjang.");
        window.location.href = 'login.php'; 
        return;
    }

    const endpoint = `keranjang.php?action=add`;

    try {
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id_produk: idProduk,
                qty: quantity,
                id_user: idUser
            })
        });

        const result = await response.json();

        if (result.success) {
            alert(`Produk berhasil ditambahkan ke keranjang sebanyak ${quantity} item!`);
            window.location.href = 'keranjang.php'; 
            } else {
            const errorMessage = result.error || '';
            
            if (errorMessage.includes('login') || errorMessage.includes('Akses ditolak')) {
                alert(`Gagal menambah ke keranjang: ${errorMessage}\nAnda akan diarahkan ke halaman login.`);
                window.location.href = 'login.php';
                return;
            }
            alert(`Gagal menambah ke keranjang: ${result.error || 'Terjadi kesalahan.'}\nDetail: ${result.message || 'Tidak ada detail error.'}`);
        }
    } catch (e) {
        console.error("Error:", e);
        alert("Terjadi kesalahan koneksi saat menambah ke keranjang.");
    }
}

function changeQty(value) {
    let qty = document.getElementById("qty");
    let current = parseInt(qty.textContent);

    let newQty = current + value;
    if (newQty < 1) newQty = 1;

    qty.textContent = newQty;
}


function toggleAcc(element) {
    const content = element.querySelector(".acc-content");
    const plus = element.querySelector(".plus");

    if (content.style.display === "block") {
        content.style.display = "none";
        plus.textContent = "+";
    } else {
        content.style.display = "block";
        plus.textContent = "−";
    }
}
