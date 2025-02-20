<?php
session_start();

// Hapus session checkout jika ada
if (isset($_SESSION['checkout'])) {
    unset($_SESSION['checkout']);
}

// Jika menggunakan sesi keranjang, hapus juga
if (isset($_SESSION['keranjang'])) {
    unset($_SESSION['keranjang']);
}

// Redirect ke halaman keranjang
header("Location: keranjang.php");
exit;
