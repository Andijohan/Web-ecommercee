<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $query = $conn->prepare("SELECT gambar FROM produk WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $data = $result->fetch_assoc();

    if ($data && file_exists($data['gambar'])) {
        unlink($data['gambar']); 
    }

  
    $stmt = $conn->prepare("DELETE FROM produk WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Produk berhasil dihapus!'); window.location.href='list.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk!'); window.history.back();</script>";
    }

    $stmt->close();
    $query->close();
} else {
    echo "<script>alert('ID produk tidak ditemukan!'); window.history.back();</script>";
}

$conn->close();
?>
