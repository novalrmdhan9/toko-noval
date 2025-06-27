<?php
include '../db.php';
header('Content-Type: application/json');

$id = $_POST['id_banner'] ?? '';

$query = "DELETE FROM banner WHERE id_banner = '$id'";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true, 'message' => 'Banner berhasil dihapus']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus banner']);
}
?>
