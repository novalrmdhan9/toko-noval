<?php
include '../db.php';

// Debug log (opsional)
file_put_contents('log_post.txt', print_r($_POST, true));
file_put_contents('log_files.txt', print_r($_FILES, true));

// Ambil data dari request
$nama = $_POST['nama_barang'] ?? '';
$harga = $_POST['harga'] ?? '';
$deskripsi = $_POST['deskripsi'] ?? '';
$id_kategori = $_POST['id_kategori'] ?? '';

// ✅ Validasi id_kategori
if (!in_array($id_kategori, ['1', '2', '3', '4', '5'])) {
    echo json_encode([
        'success' => false,
        'message' => 'id_kategori tidak valid',
        'debug' => $id_kategori
    ]);
    exit;
}

// Upload gambar
$gambar = '';
if (isset($_FILES['gambar'])) {
    $file_name = time() . '_' . $_FILES['gambar']['name'];
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $target_dir = '../uploads/' . $file_name;

    if (move_uploaded_file($file_tmp, $target_dir)) {
        $gambar = $file_name;
    }
}

// Query insert
$query = "INSERT INTO barang (nama_barang, harga, deskripsi, gambar, id_kategori) 
          VALUES ('$nama', '$harga', '$deskripsi', '$gambar', '$id_kategori')";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true, 'message' => 'Barang berhasil ditambahkan']);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal menambahkan barang',
        'error' => mysqli_error($conn)
    ]);
}
?>
