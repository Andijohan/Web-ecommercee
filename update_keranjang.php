<?php
session_start();
include('koneksi.php'); // Pastikan koneksi ke database sudah benar

if (isset($_POST['id_produk']) && isset($_POST['jumlah'])) {
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    // Ambil harga produk dari database
    $query = "SELECT harga FROM produk WHERE id_produk = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $stmt->bind_result($harga);
    $stmt->fetch();
    $stmt->close();

    // Update jumlah produk di session
    if (isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk]['jumlah'] = $jumlah;
    }

    // Hitung total harga item dan total harga keranjang
    $total_harga_item = $harga * $jumlah;
    $total_harga_keranjang = 0;
    foreach ($_SESSION['keranjang'] as $item) {
        $total_harga_keranjang += $item['harga'] * $item['jumlah'];
    }

    // Kirimkan response dalam format JSON
    echo json_encode([
        'total_harga_item' => number_format($total_harga_item, 0, ',', '.'),
        'total_harga_keranjang' => number_format($total_harga_keranjang, 0, ',', '.')
    ]);
}
?>
