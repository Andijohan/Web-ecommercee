<?php
session_start();
include 'koneksi.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_produk = (int)$_GET['id'];

    // Cek apakah produk ada di dalam keranjang
    if (isset($_SESSION['keranjang'][$id_produk])) {
        // Menghapus produk dari keranjang
        unset($_SESSION['keranjang'][$id_produk]);

        // Jika produk berhasil dihapus, beri pemberitahuan
        echo "<script>alert('Produk berhasil dihapus dari keranjang!'); window.location='keranjang.php';</script>";
    } else {
        // Jika produk tidak ditemukan di keranjang
        echo "<script>alert('Produk tidak ditemukan di keranjang!'); window.location='keranjang.php';</script>";
    }
} else {
    // Jika ID produk tidak valid
    echo "<script>alert('ID produk tidak ditemukan!'); window.location='keranjang.php';</script>";
}

$conn->close();
?>
