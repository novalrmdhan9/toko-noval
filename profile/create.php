<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil data JSON
$data = json_decode(file_get_contents("php://input"), true);

$id      = $data['id'] ?? '';
$address = $data['address'] ?? '';
$phone   = $data['phone'] ?? '';
$avatar  = $data['avatar'] ?? ''; // URL dari Cloudinary

// Validasi sederhana
if (empty($id) || empty($address) || empty($phone)) {
    echo json_encode([
        "success" => false,
        "message" => "Semua field harus diisi"
    ]);
    exit;
}

// Eksekusi query insert
$query = "INSERT INTO profile_users (id, address, phone, avatar) 
          VALUES ('$id', '$address', '$phone', '$avatar')";

if (mysqli_query($conn, $query)) {
    echo json_encode(["success" => true, "message" => "Data berhasil ditambahkan"]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Gagal menambahkan data",
        "error" => mysqli_error($conn)
    ]);
}
?>
