<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_produk'], $_POST['nama_barang'], $_POST['harga'], $_POST['gambar'])) {
        // Ambil data dari POST
        $id_produk = (int)$_POST['id_produk'];
        $nama_barang = $_POST['nama_barang'];
        $harga = (int)$_POST['harga'];
        $gambar = $_POST['gambar'];

        // Cek apakah produk sudah ada di dalam keranjang
        if (isset($_SESSION['keranjang'][$id_produk])) {
            // Jika produk sudah ada, update jumlah produk di keranjang
            $_SESSION['keranjang'][$id_produk]['jumlah'] += 1;
        } else {
            // Jika produk belum ada, tambahkan produk baru ke dalam keranjang
            $_SESSION['keranjang'][$id_produk] = [
                'nama_barang' => $nama_barang,
                'harga' => $harga,
                'gambar' => $gambar,
                'jumlah' => 1 // Menambahkan 1 ke jumlah produk dalam keranjang
            ];
        }

        echo "<script>alert('Produk berhasil ditambahkan ke keranjang!'); window.location='keranjang.php';</script>";
    } else {
        echo "<script>alert('Data yang diperlukan tidak lengkap!'); window.location='home.php';</script>";
    }
} else {
    echo "<script>alert('Aksi tidak diizinkan!'); window.location='home.php';</script>";
}

$conn->close();
?>
