<?php
header("Content-Type: application/json");

echo json_encode([
    "success" => true,
    "message" => "API Toko Noval Berjalan",
    "endpoints" => [
        "/profile/read.php",
        "/profile/create.php",
        "/profile/update.php",
        "/profile/delete.php"
    ]
]);
?>
