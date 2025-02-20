<?php
session_start();

// Ambil data keranjang dari session
$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
$total_harga = 0;

// Hitung total belanjaan
foreach ($keranjang as $item) {
    $total_harga += $item['harga'] * $item['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center">

    <!-- Navbar -->
    <nav class="w-full bg-blue-500 py-3 shadow-md px-6">
        <div class="gap-2 flex items-center justify-between">
            <a href="home.php">
                <img src="img/Logo2.png" alt="Logo" class="h-12">
            </a>
            <a href="home.php" class="text-white font-semibold">Kembali ke Home</a>
        </div>
    </nav>

    <!-- Kontainer Keranjang -->
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full mt-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-900">Keranjang Belanja</h2>

        <!-- Cek apakah keranjang kosong -->
        <?php if (count($keranjang) > 0): ?>
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="border border-gray-200 px-4 py-2">Gambar</th>
                        <th class="border border-gray-200 px-4 py-2">Nama Produk</th>
                        <th class="border border-gray-200 px-4 py-2">Harga</th>
                        <th class="border border-gray-200 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keranjang as $id_produk => $item): ?>
                        <tr class="text-gray-900 text-center">
                            <td class="border border-gray-200 px-4 py-2">
                                <img src="<?= htmlspecialchars($item['gambar']); ?>" alt="Produk" class="w-20 h-20 object-cover rounded-md">
                            </td>
                            <td class="border border-gray-200 px-4 py-2"><?= htmlspecialchars($item['nama_barang']); ?></td>
                            <td class="border border-gray-200 px-4 py-2">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                            <td class="border border-gray-200 px-4 py-2">
                                <a href="hapus_keranjang.php?id=<?= $id_produk; ?>" class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600 transition">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Total Belanjaan -->
            <div class="mt-6 text-xl font-semibold text-gray-900 text-right">
                <p>Total Belanja: Rp <?= number_format($total_harga, 0, ',', '.'); ?></p>
            </div>

            <!-- Tombol Checkout -->
            <div class="mt-4 text-start">
                <a href="checkout_keranjang.php" 
                   class="bg-green-500 px-6 py-3 text-white text-lg font-semibold rounded-md hover:bg-green-600">
                    Beli
                </a>
            </div>

        <?php else: ?>
            <p class="text-gray-600 text-center">Keranjang belanja Anda kosong.</p>
        <?php endif; ?>
    </div>

</body>
</html>
