<?php
include 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id_transaksi']) || !isset($data['alamat'])) {
    echo json_encode(["success" => false, "message" => "Data tidak lengkap"]);
    exit;
}

$id = intval($data['id_transaksi']);
$alamat = $data['alamat'];

$stmt = $conn->prepare("UPDATE transaksi SET alamat = ? WHERE id_transaksi = ?");
$stmt->bind_param("si", $alamat, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Gagal update alamat"]);
}
?>
