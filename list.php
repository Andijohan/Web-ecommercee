<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
   
    <div class="w-64 bg-sky-300 shadow-md">
        <div class="flex items-center justify-center h-20 shadow-md">
        <a href="admin.php"><img src="img\Logo2.png" alt="Logo" class="h-16 mb-4 mt-4"> </a> 
        </div>
        <ul class="py-4">
            <li>
                <a href="tambah.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-sky-400 transition">
                    <span class="text-lg text-gray-600 mr-3">➕</span>
                    <span class="font-medium">Tambah Produk</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-sky-400 transition">
                    <span class="text-lg text-gray-600 mr-3">✏️</span>
                    <span class="font-medium">List Produk</span>
                </a>
            </li>
            <li>
                <a href="Masuk.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-sky-400 transition">
                    <span class="text-lg text-gray-600 mr-3">🚪</span>
                    <span class="font-medium">Logout</span>
                </a>
            </li>
        </ul>
    </div>

  
    <div class="flex-1 p-10">
        <h1 class="text-2xl font-semibold text-gray-800">Kelola Produk</h1>
        <p class="text-gray-600 mt-2">Edit atau hapus produk sesuai kebutuhan.</p>

        <table class="w-full mt-6 bg-white shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                <th class="py-3 px-4 text-left">Gambar</th>
                    <th class="py-3 px-4 text-left">Nama Produk</th>
                    <th class="py-3 px-4 text-left">Kategori</th>
                    <th class="py-3 px-4 text-left">Harga</th>
                    <th class="py-3 px-4 text-left">Deskripsi</th>
             
                    
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM produk";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='border-b'>";
                    echo "<td class='py-3 px-4'><img src='" . $row['gambar'] . "' class='w-16 h-16 rounded-lg'></td>";
                    echo "<td class='py-3 px-4'>" . $row['nama_barang'] . "</td>";
                    echo "<td class='py-3 px-4'>" . $row['kategori_barang'] . "</td>";
                    echo "<td class='py-3 px-4'>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                    echo "<td class='py-3 px-4'>" . $row['deskripsi_barang'] . "</td>";
           
                    
                    echo "<td class='py-3 px-4 text-center'>";
                    echo "<a href='edit.php?id=" . $row['id'] . "' class='text-blue-500 hover:underline'>Edit</a> | ";
                    echo "<a href='hapus.php?id=" . $row['id'] . "' class='text-red-500 hover:underline' onclick='return confirm(\"Apakah Anda yakin ingin menghapus produk ini?\");'>Hapus</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
