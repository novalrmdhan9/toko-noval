<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil data dari Flutter
$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? null;
$alamat = $data['alamat'] ?? null;
$total = $data['total'] ?? 0;
$items = $data['items'] ?? [];

if (!$email || !$alamat || empty($items)) {
    echo json_encode([
        'success' => false,
        'message' => 'Data tidak lengkap'
    ]);
    exit;
}

// 1. Simpan ke tabel transaksi
$stmt = $conn->prepare("INSERT INTO transaksi (email, alamat, total) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $email, $alamat, $total);

if (!$stmt->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal menyimpan transaksi utama'
    ]);
    exit;
}

$id_transaksi = $stmt->insert_id;

// 2. Simpan isi detail barang ke transaksi_detail
foreach ($items as $item) {
    $nama = $item['nama_barang'];
    $harga = (int) str_replace('.', '', $item['harga']); // handle "5.000.000"
    $gambar = $item['gambar'];

    $stmt2 = $conn->prepare("INSERT INTO transaksi_detail (id_transaksi, nama_barang, harga, gambar) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("isis", $id_transaksi, $nama, $harga, $gambar);
    $stmt2->execute();
}

// 3. Sukses!
echo json_encode([
    'success' => true,
    'message' => 'Pembayaran berhasil disimpan'
]);
?>
