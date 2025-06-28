<?php
error_reporting(0);
ini_set('display_errors', 0);

include 'db.php';
header('Content-Type: application/json');

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Koneksi database gagal"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

// Validasi data utama
if (
    !$data ||
    !isset($data['email']) ||
    !isset($data['alamat']) ||
    !isset($data['total']) ||
    !isset($data['metode']) ||
    !isset($data['items']) // penting untuk transaksi_detail
) {
    echo json_encode(["success" => false, "message" => "Data tidak lengkap"]);
    exit;
}

$email = $data['email'];
$alamat = $data['alamat'];
$total = $data['total'];
$metode = $data['metode'];
$items = $data['items']; // ← dipakai hanya untuk transaksi_detail

// Insert ke transaksi utama
$query = "INSERT INTO transaksi (email, alamat, total, metode) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssis", $email, $alamat, $total, $metode);

if ($stmt->execute()) {
    $id_transaksi = $stmt->insert_id;

    // Masukkan detail barang ke transaksi_detail
    $itemQuery = "INSERT INTO transaksi_detail (id_transaksi, nama_barang, harga, gambar) VALUES (?, ?, ?, ?)";
    $itemStmt = $conn->prepare($itemQuery);

    foreach ($items as $item) {
        $nama = $item['nama_barang'];
        $harga = intval(str_replace('.', '', $item['harga']));
        $gambar = $item['gambar'];
        $itemStmt->bind_param("isis", $id_transaksi, $nama, $harga, $gambar);
        $itemStmt->execute();
    }

    echo json_encode(["success" => true, "message" => "Transaksi berhasil"]);
} else {
    echo json_encode(["success" => false, "message" => "Gagal menyimpan transaksi"]);
}
