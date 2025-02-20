<?php
session_start();

// Cek apakah session 'email' ada
if (!isset($_SESSION['email'])) {
    // Jika tidak ada session 'email', tampilkan pesan dan arahkan ke Masuk.php
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            window.location.href = 'Masuk.php';
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
    <link rel="stylesheet" href="/css/style.css" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  </head>
  <body class="bg-gray-100">
    <div class="flex min-h-screen">
      <!-- Sidebar -->
      <div class="w-64 bg-sky-300 shadow-md">
        <div class="flex items-center justify-center h-20 shadow-md">
        <a href="admin.php"><img src="img\Logo2.png" alt="Logo" class="h-16 mb-4 mt-4"> </a>
        </div>  
        <ul class="py-4">
          <!-- Menu 1: Tambah Barang -->
          <li>
            <a
              href="Tambah.php"
              class="flex items-center px-4 py-3 text-gray-700 hover:bg-sky-400 transition"
            >
              <span class="text-lg text-gray-600 mr-3">➕</span>
              <span class="font-medium">Tambah Barang</span>
            </a>
          </li>

          <!-- Menu 2: List Barang -->
          <li>
            <a
              href="list.php"
              class="flex items-center px-4 py-3 text-gray-700 hover:bg-sky-400 transition"
            >
              <span class="text-lg text-gray-600 mr-3">✏️</span>
              <span class="font-medium">List Barang</span>
            </a>
          </li>

          <!-- Menu 3: Laporan Penjualan -->
        

          <!-- Menu 4: Logout -->
          <li>
            <a
              href="Masuk.php"
              class="flex items-center px-4 py-3 text-gray-700 hover:bg-sky-400 transition"
            >
              <span class="text-lg text-gray-600 mr-3">🚪</span>
              <span class="font-medium">Logout</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Content Area -->
      <div class="flex-1 p-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="mt-4 text-gray-600">
          Selamat datang di panel admin. Pilih menu di sidebar untuk mulai mengelola barang.
        </p>
      </div>
    </div>
  </body>
</html>
