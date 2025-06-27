<?php
include '../db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$gambar = $data['gambar'] ?? '';

if ($gambar === '') {
    echo json_encode(['success' => false, 'message' => 'URL gambar tidak ditemukan']);
    exit;
}

$query = "INSERT INTO banner (gambar) VALUES ('$gambar')";
if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true, 'message' => 'Banner berhasil ditambahkan']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menambahkan banner']);
}
?>
