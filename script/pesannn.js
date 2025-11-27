async function tambahKeKeranjang() {
    // 1. Ambil ID Produk dan Jumlah
    const idProduk = document.getElementById('id_produk_input').value;
    const quantity = parseInt(document.getElementById('qty').textContent);

    if (!idProduk || quantity < 1) {
        alert("ID Produk atau Jumlah tidak valid.");
        return;
    }
    
    // 2. Tentukan Endpoint API Keranjang
    const endpoint = `keranjang.php?action=add`;

    // 3. Kirim Data menggunakan Fetch API (metode POST)
    try {
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id_produk: idProduk,
                qty: quantity
            })
        });

        const result = await response.json();

        if (result.success) {
            alert(`Produk berhasil ditambahkan ke keranjang sebanyak ${quantity} item!`);
            // Opsional: Langsung arahkan ke halaman keranjang
            window.location.href = 'keranjang.php'; 
        } else {
            alert(`Gagal menambah ke keranjang: ${result.error || 'Terjadi kesalahan.'}\nDetail: ${result.message || 'Tidak ada detail error.'}`);
            // alert(`Gagal menambah ke keranjang: ${result.error || 'Terjadi kesalahan.'}`);
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
