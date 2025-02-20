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

$row = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-gray-100 flex flex-col items-center min-h-screen">

    <!-- Navbar -->
    <nav class="w-full bg-blue-500 py-3 shadow-md px-6">
  <div class="gap-2 w-full flex items-center justify-between">
    <div>
      <a href="home.php"><img src="img/Logo2.png" alt="Logo" class="h-12"></a>
    </div>
    <div class="flex items-center space-x-4">
     

      <a href="keranjang.php">
        <img class="w-8" src="img/Keranjang.png"> 
      </a>

      <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
          Akun
        </button>
        <div x-show="open" x-cloak @click.away="open = false" class="absolute right-0 mt-2 w-44 bg-white shadow-md rounded-md">
          <ul class="py-2 text-gray-700">
            <li><a href="logout.php" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Log Out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>


    <div class="bg-white p-6 rounded-lg shadow-lg max-w-6xl w-full flex flex-col md:flex-row mt-6">
        <!-- Gambar Produk -->
        <div class="w-full md:w-1/2 flex justify-center">
            <img src="<?= htmlspecialchars($row['gambar']); ?>" 
                 alt="<?= htmlspecialchars($row['nama_barang']); ?>" 
                 class="w-full max-w-lg rounded-md shadow-md">
        </div>

        <!-- Informasi Produk -->
        <div class="w-full md:w-1/2 p-6 text-gray-900 flex flex-col justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2"><?= htmlspecialchars($row['nama_barang']); ?></h2>
                <p class="text-lg text-gray-600 mb-4"><?= nl2br(htmlspecialchars($row['deskripsi_barang'])); ?></p>
                <p class="text-3xl font-semibold text-red-500">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                
            </div>

            <div class="mt-10 flex flex-row justify-between items-center space-x-4">
                <!-- Form Tambah ke Keranjang -->
                <form method="POST" action="proses_keranjang.php" class="flex-1">
                    <input type="hidden" name="id_produk" value="<?= $row['id']; ?>">
                    <input type="hidden" name="nama_barang" value="<?= $row['nama_barang']; ?>">
                    <input type="hidden" name="harga" value="<?= $row['harga']; ?>">
                    <input type="hidden" name="gambar" value="<?= $row['gambar']; ?>">

                    

                    <div class="flex flex-row gap-5">
                        <button type="submit" class="border bg-red-500 text-white px-6 py-3 text-base font-semibold rounded-md hover:bg-red-600 flex-1 flex items-center justify-center space-x-2 transition">
                            <img class="w-8 h-8" src="img/Keranjang.png" alt="Keranjang">
                            <span>Masukkan Keranjang</span>
                        </button>

                        <a href="checkout_detail.php?id=<?= $row['id']; ?>" 
                           class="bg-green-500 px-6 py-3 text-white text-lg font-semibold rounded-md hover:bg-green-600 flex-1 text-center">
                            Beli
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
