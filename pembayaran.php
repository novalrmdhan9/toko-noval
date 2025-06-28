<?php
include 'db.php';
header('Content-Type: application/json');

// Ambil dan decode input
$data = json_decode(file_get_contents("php://input"), true);

// Validasi data
if (
    !$data ||
    !isset($data['email']) ||
    !isset($data['alamat']) ||
    !isset($data['total']) ||
    !isset($data['items']) ||
    !isset($data['metode'])
) {
    echo json_encode(["success" => false, "message" => "Data tidak lengkap"]);
    exit;
}

$email = $data['email'];
$alamat = $data['alamat'];
$total = $data['total'];
$metode = $data['metode'];
$items = $data['items'];

// Simpan ke tabel transaksi
$query = "INSERT INTO transaksi (email, alamat, total, metode) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssis", $email, $alamat, $total, $metode);

if ($stmt->execute()) {
    $id_transaksi = $stmt->insert_id;

    $itemQuery = "INSERT INTO transaksi_items (id_transaksi, nama_barang, harga, gambar) VALUES (?, ?, ?, ?)";
    $itemStmt = $conn->prepare($itemQuery);

    foreach ($items as $item) {
        $nama = $item['nama_barang'];
        $harga = intval(str_replace('.', '', $item['harga']));
        $gambar = $item['gambar'];
        $itemStmt->bind_param("isis", $id_transaksi, $nama, $harga, $gambar);
        $itemStmt->execute();
    }

    echo json_encode(["success" => true, "message" => "Transaksi berhasil"]);
    exit; // ⬅️ ini penting
} else {
    echo json_encode(["success" => false, "message" => "Gagal menyimpan transaksi"]);
    exit;
}
?>
