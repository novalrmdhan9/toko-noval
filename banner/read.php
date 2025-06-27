<?php
include '../db.php';
header('Content-Type: application/json');

$query = mysqli_query($conn, "SELECT * FROM banner");

$result = [];
while($row = mysqli_fetch_assoc($query)) {
    $row['gambar'] = trim($row['gambar']); // jaga-jaga spasi
    $result[] = $row;
}

echo json_encode([
    'success' => true,
    'data' => $result
]);    
?>
