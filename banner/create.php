<?php
include '../db.php';
header('Content-Type: application/json');

if (!isset($_FILES['gambar'])) {
    echo json_encode(['success' => false, 'message' => 'File gambar tidak ditemukan']);
    exit;
}

// Data Cloudinary
$cloud_name = 'do29rrjxg';
$upload_preset = 'noval_preset';
$file_tmp = $_FILES['gambar']['tmp_name'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/$cloud_name/image/upload");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'file' => new CURLFile($file_tmp),
    'upload_preset' => $upload_preset
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if (!isset($result['secure_url'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal upload ke Cloudinary',
        'debug' => $result
    ]);
    exit;
}

$gambar = $result['secure_url'];

// Simpan ke DB
$query = "INSERT INTO banner (gambar) VALUES ('$gambar')";
if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true, 'message' => 'Banner berhasil ditambahkan']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menambahkan banner']);
}
