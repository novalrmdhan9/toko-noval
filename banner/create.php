<?php
include '../db.php';
header('Content-Type: application/json');

$gambar = '';
if (isset($_FILES['gambar'])) {
    $file_name = time() . '_' . $_FILES['gambar']['name'];
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $target_dir = '../uploads/' . $file_name;

    if (move_uploaded_file($file_tmp, $target_dir)) {
        $gambar = $file_name;
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal upload gambar',
            'debug' => [
                'file' => $_FILES['gambar'],
                'target' => $target_dir
            ]
        ]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'File gambar tidak ditemukan']);
    exit;
}

$query = "INSERT INTO banner (gambar) VALUES ('$gambar')";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true, 'message' => 'Banner berhasil ditambahkan']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menambahkan banner']);
}
?>
