<?php
include 'db.php';
header('Content-Type: application/json');

// Ambil data JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validasi data
if (
    !isset($data['id_transaksi']) ||
    !isset($data['alamat']) ||
    !isset($data['metode'])
) {
    echo json_encode(["success" => false, "message" => "Data tidak lengkap"]);
    exit;
}

$id = intval($data['id_transaksi']);
$alamat = $data['alamat'];
$metode = $data['metode'];

// Update query
$stmt = $conn->prepare("UPDATE transaksi SET alamat = ?, metode = ? WHERE id_transaksi = ?");
$stmt->bind_param("ssi", $alamat, $metode, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Berhasil update transaksi"]);
} else {
    echo json_encode(["success" => false, "message" => "Gagal update transaksi"]);
}
?>
