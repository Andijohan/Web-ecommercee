<?php
session_start();
require_once './midtrans-php-master/Midtrans.php';

// Konfigurasi Midtrans
\Midtrans\Config::$serverKey = 'SB-Mid-server-Nt18jlDm4TKmwGD52Zjw94Lf';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

header('Content-Type: application/json');

// Ambil data dari request JSON
$data = json_decode(file_get_contents("php://input"), true);

$nama = $data['nama'] ?? null;
$email = $data['email'] ?? null;
$total_harga = $data['total_harga'] ?? 0;
$keranjang = $data['keranjang'] ?? [];

// Validasi input
if (empty($nama) || empty($email)) {
    echo json_encode(['error' => 'Nama dan email wajib diisi']);
    exit;
}

// Buat order_id unik
$order_id = uniqid('ORDER-');

// Detail transaksi untuk Midtrans
$transaction_details = [
    'order_id' => $order_id,
    'gross_amount' => $total_harga
];

// Data customer untuk Midtrans
$customer_details = [
    'first_name' => $nama,
    'email' => $email
];

// Konfigurasi transaksi
$transaction = [
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details
];

try {
    // Dapatkan snapToken
    $snapToken = \Midtrans\Snap::getSnapToken($transaction);

    // Simpan transaksi ke sesi (opsional, bisa juga ke database)
    $_SESSION['checkout'][$order_id] = [
        'nama' => $nama,
        'email' => $email,
        'total_harga' => $total_harga,
        'keranjang' => $keranjang,
        'snapToken' => $snapToken
    ];

    echo json_encode(['snapToken' => $snapToken]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
