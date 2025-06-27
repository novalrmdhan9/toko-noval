<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil data dari request
$email   = $_POST['email'] ?? '';
$alamat  = $_POST['alamat'] ?? '';
$no_hp   = $_POST['no_hp'] ?? '';

// Cek kalo email kosong
if (empty($email)) {
    echo json_encode(["success" => false, "message" => "Email tidak boleh kosong"]);
    exit;
}

// Handle upload gambar
$target_dir = "../uploads/";
$imageName = '';

if (isset($_FILES["image"]) && $_FILES["image"]["name"] != '') {
    $imageName = time() . '_' . basename($_FILES["image"]["name"]); // Biar nama gambar gak bentrok
    $target_file = $target_dir . $imageName;

    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
}

// Cek apakah data sudah ada
$check = mysqli_query($conn, "SELECT * FROM profile_users WHERE email='$email'");

if (mysqli_num_rows($check) > 0) {
    // Update data
    $query = "UPDATE profile_users SET alamat='$alamat', no_hp='$no_hp'";
    if ($imageName != '') {
        $query .= ", avatar='$imageName'";
    }
    $query .= " WHERE email='$email'";
} else {
    // Insert data baru
    $query = "INSERT INTO profile_users (email, alamat, no_hp, avatar) VALUES ('$email', '$alamat', '$no_hp', '$imageName')";
}

// Eksekusi query
if (mysqli_query($conn, $query)) {
    echo json_encode(["success" => true, "message" => "Profile berhasil disimpan"]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Gagal menyimpan profile",
        "error" => mysqli_error($conn)
    ]);
}
?>
