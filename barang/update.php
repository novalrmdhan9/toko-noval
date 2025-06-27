<?php
include '../db.php';

$id = $_POST['id_barang'] ?? '';
$nama = $_POST['nama_barang'] ?? '';
$harga = $_POST['harga'] ?? '';
$deskripsi = $_POST['deskripsi'] ?? '';
$id_kategori = $_POST['id_kategori'] ?? '';
$gambar_lama = $_POST['gambar_lama'] ?? '';

$gambar = $gambar_lama;

// Jika ada file gambar baru diupload
if (isset($_FILES['gambar'])) {
    $file_name = time() . '_' . $_FILES['gambar']['name'];
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $target_dir = '../uploads/' . $file_name;

    if (move_uploaded_file($file_tmp, $target_dir)) {
        $gambar = $file_name;

        // Hapus gambar lama jika ada dan berbeda
        if (!empty($gambar_lama) && file_exists('../uploads/' . $gambar_lama)) {
            unlink('../uploads/' . $gambar_lama);
        }
    }
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
