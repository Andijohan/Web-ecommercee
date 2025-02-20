<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM produk WHERE id = $id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
} else {
    echo "ID produk tidak ditemukan!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_barang = $_POST['nama_barang'];
    $kategori_barang = $_POST['kategori_barang'];
    $harga = $_POST['harga'];
    $deskripsi_barang = $_POST['deskripsi_barang'];

    // Jika ada gambar baru yang diupload
    if ($_FILES['gambar']['name']) {
        $gambar = 'uploads/' . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar);
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $gambar = $row['gambar'];
    }

    // Query untuk update produk
    $query_update = "UPDATE produk SET nama_barang='$nama_barang', kategori_barang='$kategori_barang', harga='$harga',  deskripsi_barang='$deskripsi_barang', gambar='$gambar' WHERE id=$id";

    if ($conn->query($query_update) === TRUE) {
        echo "<script>alert('Produk berhasil diperbarui!'); window.location='list.php';</script>";
    } else {
        echo "Gagal memperbarui produk: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-96 m-10">
        <h2 class="text-2xl font-bold mb-4">Edit Produk</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Nama Barang -->
            <label class="block mb-2">Nama Barang</label>
            <input type="text" name="nama_barang" class="w-full border p-2 rounded" value="<?php echo $row['nama_barang']; ?>" required>

            <!-- Kategori Barang -->
            <label class="block mt-4 mb-2">Kategori</label>
            <select name="kategori_barang" class="w-full border p-2 rounded" required>
                <option value="Pakaian" <?php echo ($row['kategori_barang'] == 'Pakaian') ? 'selected' : ''; ?>>Pakaian</option>
                <option value="Sepatu" <?php echo ($row['kategori_barang'] == 'Sepatu') ? 'selected' : ''; ?>>Sepatu</option>
                <option value="Aksesoris" <?php echo ($row['kategori_barang'] == 'Aksesoris') ? 'selected' : ''; ?>>Aksesoris</option>
            </select>

            <!-- Harga -->
            <label class="block mt-4 mb-2">Harga</label>
            <input type="number" name="harga" class="w-full border p-2 rounded" value="<?php echo $row['harga']; ?>" required>

        

            <!-- Deskripsi Barang -->
            <label class="block mt-4 mb-2">Deskripsi Barang</label>
            <textarea name="deskripsi_barang" class="w-full border p-2 rounded" rows="4" required><?php echo $row['deskripsi_barang']; ?></textarea>

            <!-- Gambar Produk -->
            <label class="block mt-4 mb-2">Gambar Produk</label>
            <input type="file" name="gambar" class="w-full border p-2 rounded">
            <!-- Preview Gambar jika ada gambar yang diupload -->
            <?php if ($row['gambar']) : ?>
                <img src="<?php echo $row['gambar']; ?>" alt="Produk" class="w-32 mt-2">
            <?php endif; ?>

            <!-- Tombol Simpan -->
            <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>
