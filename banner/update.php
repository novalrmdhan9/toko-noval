<?php
include '../db.php';
header('Content-Type: application/json');

$id = $_POST['id_banner'] ?? '';
$gambar = '';

if (isset($_FILES['gambar'])) {
    $file_name = time() . '_' . $_FILES['gambar']['name'];
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $target_dir = '../uploads/' . $file_name;

    if (move_uploaded_file($file_tmp, $target_dir)) {
        $gambar = $file_name;
    }
}

if ($gambar != '') {
    $query = "UPDATE banner SET gambar = '$gambar' WHERE id_banner = '$id'";
    $result = mysqli_query($conn, $query);
} else {
    $result = false;
}

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Banner berhasil diperbarui']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui banner']);
}
?>
