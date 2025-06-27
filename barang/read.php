<?php
include '../db.php';
header('Content-Type: application/json');

$query = mysqli_query($conn, "
  SELECT barang.*, kategori.nama_kategori 
  FROM barang 
  LEFT JOIN kategori ON barang.id_kategori = kategori.id_kategori
");

$result = [];
while($row = mysqli_fetch_assoc($query)) {
    $result[] = $row;
}

echo json_encode([
    'success' => true,
    'data' => $result
]);
?>
