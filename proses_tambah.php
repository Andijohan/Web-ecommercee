<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $nama_barang = $_POST['nama_barang'];
    $kategori_barang = $_POST['kategori_barang'];
    $deskripsi_barang = $_POST['deskripsi_barang'];
    $harga = $_POST['harga'];

    // Validasi input harga
    if (!is_numeric($harga)) {
        echo "<script>alert('Harga harus berupa angka!'); window.history.back();</script>";
        exit();
    }

    // Cek apakah file gambar diunggah
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar_name = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $upload_dir = "uploads/";

        // Pastikan direktori uploads tersedia
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Rename file agar unik
        $gambar_ext = pathinfo($gambar_name, PATHINFO_EXTENSION);
        $gambar_name_new = time() . "_" . uniqid() . "." . $gambar_ext;
        $gambar_path = $upload_dir . $gambar_name_new;

        // Pindahkan file ke folder uploads
        if (!move_uploaded_file($gambar_tmp, $gambar_path)) {
            die("Gagal mengupload gambar! Periksa izin folder uploads.");
        }

        // Menyimpan data ke database menggunakan prepared statement
        $stmt = $conn->prepare("INSERT INTO produk (nama_barang, kategori_barang, harga, deskripsi_barang, gambar) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $nama_barang, $kategori_barang, $harga, $deskripsi_barang, $gambar_path);


        // Menjalankan query dan mengecek apakah berhasil
        if ($stmt->execute()) {
            echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href='list.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan produk!'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Gagal upload gambar!'); window.history.back();</script>";
    }
}

$conn->close();
?>
