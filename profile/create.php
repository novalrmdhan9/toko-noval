<?php
include '../db.php';

header('Content-Type: application/json');

$id = $_POST['id'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$avatar = $_POST['avatar'];

$query = "INSERT INTO profile_users (id, address, phone, avatar) 
          VALUES ('$id', '$address', '$phone', '$avatar')";

if (mysqli_query($conn, $query)) {
    echo json_encode(["success" => true, "message" => "Data berhasil ditambahkan"]);
} else {
    echo json_encode(["success" => false, "message" => "Gagal menambahkan data"]);
}
?>
