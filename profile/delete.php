<?php
include '../db.php';

header('Content-Type: application/json');

$id = $_POST['id'];

$query = "DELETE FROM profile_users WHERE id='$id'";

if (mysqli_query($conn, $query)) {
    echo json_encode(["success" => true, "message" => "Data berhasil dihapus"]);
} else {
    echo json_encode(["success" => false, "message" => "Gagal hapus data"]);
}
?>
