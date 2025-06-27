<?php
include '../db.php';

$id = $_POST['id_barang'] ?? '';

$query = "DELETE FROM barang WHERE id_barang = '$id'";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true, 'message' => 'Barang berhasil dihapus']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus barang']);
}
?>
