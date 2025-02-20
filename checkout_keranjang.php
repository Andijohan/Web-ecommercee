<?php
session_start();

// Ambil data keranjang dari session
$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
$total_harga = 0;

// Cek apakah keranjang kosong
if (count($keranjang) == 0) {
    echo "<script>alert('Keranjang belanja Anda kosong!'); window.location='keranjang.php';</script>";
    exit;
}

// Hitung total harga dari semua produk di keranjang
foreach ($keranjang as $id_produk => $item) {
    $total_harga += $item['harga'] * $item['jumlah'];
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Keranjang</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md m-10">
        <h2 class="text-2xl font-bold text-center mb-4">Checkout Keranjang</h2>

        <!-- Input Nama & Email -->
        <div class="mb-4">
            <label class="block text-gray-700">Nama Lengkap</label>
            <input type="text" id="nama" class="w-full p-2 border rounded-md" placeholder="Masukkan nama" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" id="email" class="w-full p-2 border rounded-md" placeholder="Masukkan email" required>
        </div>

        <!-- Daftar Produk -->
        <div class="mb-4">
            <?php foreach ($keranjang as $id_produk => $item): ?>
                <div class="flex items-center border-b pb-4 mb-4">
                    <img src="<?= htmlspecialchars($item['gambar']); ?>" class="w-16 h-16 rounded-md shadow-md mr-4">
                    <div>
                        <h3 class="text-lg font-semibold"><?= htmlspecialchars($item['nama_barang']); ?></h3>
                        <p class="text-lg font-bold text-red-500">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Tampilkan Total Harga -->
        <div class="text-lg font-semibold mb-4">
            <label>Total harga</label>
            <p class="text-red-500">Rp <?= number_format($total_harga, 0, ',', '.'); ?></p>
        </div>

        <div class="flex justify-between">
            <a href="keranjang.php" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                Batal
            </a>
            <button id="checkout-button" class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 transition">
                Checkout
            </button>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-IDWh-XbQoyyGvtmT"></script>
    <script>
        document.getElementById("checkout-button").addEventListener("click", async function(event) {
            event.preventDefault();

            // Ambil nama dan email
            const nama = document.getElementById("nama").value.trim();
            const email = document.getElementById("email").value.trim();

            // Validasi input
            if (nama === "" || email === "") {
                alert("Silakan isi Nama dan Email sebelum checkout.");
                return;
            }

            try {
                // Kirim permintaan POST ke order.php
                const response = await fetch("php/order.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        nama: nama,
                        email: email,
                        total_harga: <?= $total_harga; ?>,
                        keranjang: <?= json_encode($keranjang); ?>
                    })
                });

                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();
                console.log(json);

                if (json.snapToken) {
                    window.snap.pay(json.snapToken, {
                        onSuccess: function(result) {
                            alert("Pembayaran sukses!");
                            window.location.href = "home.php";
                        },
                        onPending: function(result) {
                            alert("Pembayaran tertunda. Silakan cek kembali nanti.");
                        },
                        onError: function(result) {
                            alert("Pembayaran gagal. Silakan coba lagi.");
                        },
                        onClose: function() {
                            alert("Anda menutup pembayaran sebelum selesai.");
                        }
                    });
                } else {
                    alert("Gagal mendapatkan token pembayaran.");
                }
            } catch (error) {
                console.error(error.message);
                alert("Terjadi kesalahan saat memproses checkout.");
            }
        });
    </script>

</body>
</html>
