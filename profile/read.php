<?php
include '../db.php';
header('Content-Type: application/json');

if (!isset($_GET['email'])) {
    echo json_encode(["success" => false, "message" => "Email tidak ditemukan"]);
    exit;
}

$email = $_GET['email'];

// Cloudinary config
$cloudinary_base = "https://res.cloudinary.com/do29rrjxg/image/upload/";

$query = mysqli_query($conn, "SELECT * FROM profile_users WHERE email='$email'");

if (mysqli_num_rows($query) > 0) {
    $result = mysqli_fetch_assoc($query);

    // Pastikan hanya tampilkan URL Cloudinary jika field avatar tidak kosong
    $avatarUrl = !empty($result['avatar'])
        ? $cloudinary_base . $result['avatar']
        : '';

    echo json_encode([
        "success" => true,
        "data" => [
            "alamat" => $result['alamat'],
            "no_hp" => $result['no_hp'],
            "avatar" => $avatarUrl
        ]
    ]);
} else {
    echo json_encode([
        "success" => true,
        "data" => null
    ]);
}
?>
