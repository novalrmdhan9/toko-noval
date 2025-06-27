<?php
include '../db.php';
header('Content-Type: application/json');

// Terima JSON
$data = json_decode(file_get_contents("php://input"), true);

$gambar = $data['gambar'] ?? '';

if (empty($gambar)) {
    echo json_encode(['success' => false, 'message' => 'URL gambar tidak ditemukan']);
    exit;
}

// Simpan ke database
$query = "INSERT INTO banner (gambar) VALUES ('$gambar')";
if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true, 'message' => 'Banner berhasil ditambahkan']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menambahkan banner']);
}
?>
