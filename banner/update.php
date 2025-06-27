<?php
include '../db.php';
header('Content-Type: application/json');

// Terima JSON
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id_banner'] ?? '';
$gambar = $data['gambar'] ?? '';

if (empty($id) || empty($gambar)) {
    echo json_encode(['success' => false, 'message' => 'ID atau URL gambar tidak ditemukan']);
    exit;
}

// Update ke database
$query = "UPDATE banner SET gambar = '$gambar' WHERE id_banner = '$id'";
if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true, 'message' => 'Banner berhasil diperbarui']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui banner']);
}
?>
