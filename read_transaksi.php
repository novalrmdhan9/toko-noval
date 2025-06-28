<?php
include '../db.php';
header('Content-Type: application/json');

$query = "SELECT * FROM transaksi ORDER BY id_transaksi DESC";
$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id_transaksi'];
    $detail = [];

    $detailResult = mysqli_query($conn, "SELECT * FROM transaksi_detail WHERE id_transaksi = $id");
    while ($d = mysqli_fetch_assoc($detailResult)) {
        $detail[] = $d;
    }

    $row['items'] = $detail;
    $data[] = $row;
}

echo json_encode([
  "success" => true,
  "data" => $data
]);
?>
