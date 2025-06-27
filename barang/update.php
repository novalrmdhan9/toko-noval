<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil data JSON dari body
$input = json_decode(file_get_contents('php://input'), true);

// Ambil field
$id = $input['id_barang'] ?? '';
$nama = $input['nama_barang'] ?? '';
$harga = $input['harga'] ?? '';
$deskripsi = $input['deskripsi'] ?? '';
$id_kategori = $input['id_kategori'] ?? '';
$gambar = $input['gambar'] ?? '';

// Validasi id
if (empty($id)) {
    echo json_encode(['success' => false, 'message' => 'id_barang tidak boleh kosong']);
    exit;
}

$query = "UPDATE barang 
          SET nama_barang = '$nama',
              harga = '$harga',
              deskripsi = '$deskripsi',
              gambar = '$gambar',
              id_kategori = '$id_kategori'
          WHERE id_barang = '$id'";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true, 'message' => 'Barang berhasil diperbarui']);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal memperbarui barang',
        'error' => mysqli_error($conn)
    ]);
}
?>
