<?php
include 'db.php';
header('Content-Type: application/json');

if (!isset($_GET['email'])) {
    echo json_encode(["success" => false, "message" => "Email tidak ditemukan"]);
    exit;
}

$email = $_GET['email'];

// Ambil histori transaksi
$sql = "SELECT * FROM transaksi WHERE email = ? ORDER BY id_transaksi DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$histori = [];

while ($row = $result->fetch_assoc()) {
    $id_transaksi = $row['id_transaksi'];

    // Ambil item berdasarkan transaksi
    $itemSql = "SELECT nama_barang, harga, gambar FROM transaksi_detail WHERE id_transaksi = ?";
    $itemStmt = $conn->prepare($itemSql);
    $itemStmt->bind_param("i", $id_transaksi);
    $itemStmt->execute();
    $itemResult = $itemStmt->get_result();

    $items = [];
    while ($item = $itemResult->fetch_assoc()) {
        $items[] = $item;
    }

    $histori[] = [
        "id_transaksi" => $row["id_transaksi"],
        "alamat" => $row["alamat"],
        "total" => $row["total"],
        "metode" => $row["metode"],
        "tanggal" => $row["tanggal"] ?? '',
        "items" => $items
    ];
}

echo json_encode(["success" => true, "histori" => $histori]);
?>
