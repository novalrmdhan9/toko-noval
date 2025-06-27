<?php
include '../db.php';
header('Content-Type: application/json');

if (!isset($_GET['email'])) {
    echo json_encode(["success" => false, "message" => "Email tidak ditemukan"]);
    exit;
}

$email = $_GET['email'];

$query = mysqli_query($conn, "SELECT * FROM profile_users WHERE email='$email'");

if (mysqli_num_rows($query) > 0) {
    $result = mysqli_fetch_assoc($query);

    echo json_encode([
        "success" => true,
        "data" => [
            "alamat" => $result['alamat'],
            "no_hp" => $result['no_hp'],
            "avatar" => $result['avatar'] ?? ''
        ]
    ]);
} else {
    echo json_encode([
        "success" => true,
        "data" => null
    ]);
}
?>
