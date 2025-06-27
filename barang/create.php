<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil data JSON dari body
$input = json_decode(file_get_contents('php://input'), true);

// Ambil field
$nama = $input['nama_barang'] ?? '';
$harga = $input['harga'] ?? '';
$deskripsi = $input['deskripsi'] ?? '';
$id_kategori = $input['id_kategori'] ?? '';
$gambar = $input['gambar'] ?? '';

// Validasi id_kategori
if (!in_array($id_kategori, ['1', '2', '3', '4', '5'])) {
    echo json_encode([
        'success' => false,
        'message' => 'id_kategori tidak valid',
    ]);
    exit;
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
