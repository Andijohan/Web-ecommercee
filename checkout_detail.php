<?php
include 'koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID produk tidak ditemukan!'); window.location='home.php';</script>";
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Produk tidak ditemukan!'); window.location='home.php';</script>";
    exit;
}

$produk = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-4">Checkout</h2>

        <div class="flex items-center border-b pb-4 mb-4">
            <img src="<?= htmlspecialchars($produk['gambar']); ?>" class="w-16 h-16 rounded-md shadow-md mr-4">
            <div>
                <h3 class="text-lg font-semibold"><?= htmlspecialchars($produk['nama_barang']); ?></h3>
                <p class="text-lg font-bold text-red-500">Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></p>
            </div>
        </div>

        <form id="checkout-form">
            <input type="hidden" name="id_produk" value="<?= $produk['id']; ?>">
            <input type="hidden" name="harga" value="<?= $produk['harga']; ?>">
            <input type="hidden" name="nama_barang" value="<?= $produk['nama_barang']; ?>">

            <div class="mb-3">
                <label class="block text-gray-700">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required class="w-full p-2 border rounded-md">
            </div>

            <div class="mb-3">
                <label class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" required class="w-full p-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Total Harga</label>
                <p class="text-lg font-bold text-red-500">Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></p>
                <input type="hidden" name="total_harga" value="<?= $produk['harga']; ?>">
            </div>

            <div class="flex justify-between">
                <a href="detail.php?id=<?= $produk['id']; ?>" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                    Batal
                </a>
                <button type="submit" id="checkout-button" class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 transition">
                    Checkout
                </button>
            </div>
        </form>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-IDWh-XbQoyyGvtmT"></script>
    <script>
        document.getElementById("checkout-form").addEventListener("submit", async function(event) {
            event.preventDefault();

            const nama = document.getElementById("nama").value.trim();
            const email = document.getElementById("email").value.trim();
            const total_harga = document.querySelector('[name="total_harga"]').value;
            const id_produk = document.getElementsByName("id_produk")[0].value;
            const nama_barang = document.getElementsByName("nama_barang")[0].value;
            const harga = document.getElementsByName("harga")[0].value;

            if (nama === "" || email === "") {
                alert("Harap isi semua data dengan benar.");
                return;
            }

            try {
                const response = await fetch("php/order_detail.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        nama: nama,
                        email: email,
                        id_produk: id_produk,
                        nama_barang: nama_barang,
                        harga: harga,
                        total_harga: total_harga
                    })
                });

                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();
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
