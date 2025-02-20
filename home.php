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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beranda</title>
  <link rel="stylesheet" href="/css/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>
  <style>
    [x-cloak] { display: none !important; }
  </style>
</head>
<body class="bg-gray-100">
<!-- Navbar -->
<nav class="w-full bg-blue-500 py-3 shadow-md px-6">
  <div class="gap-2 w-full flex items-center justify-between">
    <div>
      <a href="home.php"><img src="img/Logo2.png" alt="Logo" class="h-12"></a>
    </div>
    <div class="flex items-center space-x-4">
      <form action="" method="GET" class="hidden md:flex items-center rounded-md bg-white px-3 py-1 shadow">
        <input type="search" name="search" class="w-80 border-none bg-transparent text-gray-700 focus:outline-none" placeholder="Cari produk..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-500">
            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
          </svg>
        </button>
      </form>

      <a href="keranjang.php">
        <img class="w-8" src="img/Keranjang.png"> 
      </a>

      <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
          Akun
        </button>
        <div x-show="open" x-cloak @click.away="open = false" class="absolute right-0 mt-2 w-44 bg-white shadow-md rounded-md">
          <ul class="py-2 text-gray-700">
            <li><a href="logout.php" class="px-4 py-2 text-red-500 hover:bg-gray-100 justify-center flex">Log Out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>


<div class="flex flex-wrap justify-center mt-10 gap-6">
  <div>
    <div class="text-center">
      <h1 class="text-2xl font-bold">Daftar Produk</h1>
    </div>

    <div class="flex flex-row flex-wrap justify-center mt-10 gap-10">
      <?php
      include 'koneksi.php';
      
      $search = isset($_GET['search']) ? $_GET['search'] : '';
      $query = "SELECT * FROM produk";
      if (!empty($search)) {
          $query .= " WHERE nama_barang LIKE '%$search%' OR kategori_barang LIKE '%$search%'";
      }

      $result = $conn->query($query); 

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '
          <div class="w-80 md:w-72 bg-white rounded-lg shadow-md overflow-hidden">
            <a href="detail.php?id=' . $row['id'] . '">
              <div class="w-full h-64 bg-gray-200 flex justify-center items-center overflow-hidden">
                <img class="w-full h-full object-cover" src="' . $row['gambar'] . '" alt="' . $row['nama_barang'] . '">
              </div>
              <div class="p-6">
                <span class="text-sm font-medium text-gray-600 bg-gray-200 px-3 py-1 rounded-full">' . $row['kategori_barang'] . '</span>
                <h2 class="text-xl font-semibold text-gray-800 mt-2">' . $row['nama_barang'] . '</h2>
                <p class="text-gray-600 text-base mt-2">Rp ' . number_format($row['harga'], 0, ',', '.') . '</p>
            
              </div>
            </a>
          </div>';
        }
      } else {
        echo '<p class="text-gray-700 text-center mt-6">Produk tidak ditemukan.</p>';
      }

      $conn->close();
      ?>
    </div>
  </div>
</div>

</body>
</html>
