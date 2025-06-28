<?php
include 'db.php';
header('Content-Type: application/json');

// Ambil semua transaksi
$query = "SELECT * FROM transaksi ORDER BY id_transaksi DESC";
$result = mysqli_query($conn, $query);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id_transaksi'];

    // Ambil detail barang untuk transaksi ini
    $detailQuery = "SELECT nama_barang, harga, gambar FROM transaksi_detail WHERE id_transaksi = ?";
    $detailStmt = $conn->prepare($detailQuery);
    $detailStmt->bind_param("i", $id);
    $detailStmt->execute();
    $detailResult = $detailStmt->get_result();

    $items = [];
    while ($d = $detailResult->fetch_assoc()) {
        $items[] = $d;
    }

    $row['items'] = $items;
    $data[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $data
]);
