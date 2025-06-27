<?php
include '../db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$email   = $data['email'] ?? '';
$alamat  = $data['alamat'] ?? '';
$no_hp   = $data['no_hp'] ?? '';
$image   = $data['image'] ?? '';

// Validasi
if (empty($email)) {
    echo json_encode(["success" => false, "message" => "Email tidak boleh kosong"]);
    exit;
}

// Cek apakah data sudah ada
$check = mysqli_query($conn, "SELECT * FROM profile_users WHERE email='$email'");
if (mysqli_num_rows($check) > 0) {
    // Update
    $query = "UPDATE profile_users SET alamat='$alamat', no_hp='$no_hp'";
    if (!empty($image)) {
        $query .= ", avatar='$image'";
    }
    $query .= " WHERE email='$email'";
} else {
    // Insert
    $query = "INSERT INTO profile_users (email, alamat, no_hp, avatar) 
              VALUES ('$email', '$alamat', '$no_hp', '$image')";
}

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
