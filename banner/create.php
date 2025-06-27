<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil input JSON dari body request
$data = json_decode(file_get_contents("php://input"), true);

// Cek apakah ada URL gambar
if (!isset($data['gambar'])) {
    echo json_encode([
        'success' => false,
        'message' => 'URL gambar tidak ditemukan'
    ]);
    exit;
}

$gambar = $data['gambar'];

$query = "INSERT INTO banner (gambar) VALUES ('$gambar')";

if (mysqli_query($conn, $query)) {
    echo json_encode([
        'success' => true,
        'message' => 'Banner berhasil ditambahkan'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal menambahkan banner'
    ]);
}
?>
