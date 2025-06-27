<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");



$host = "sql12.freesqldatabase.com";
$user = "sql12787176";
$pass = "m7YXbd7mye";
$db   = "sql12787176";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
