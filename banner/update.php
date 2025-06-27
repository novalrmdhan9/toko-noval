<?php
include '../db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id_banner'] ?? '';
$gambar = $data['gambar'] ?? '';

if ($id === '' || $gambar === '') {
    echo json_encode(['success' => false, 'message' => 'ID atau URL gambar tidak ditemukan']);
    exit;
}

$query = "UPDATE banner SET gambar = '$gambar' WHERE id_banner = '$id'";
$result = mysqli_query($conn, $query);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Banner berhasil diperbarui']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui banner']);
}
?>
