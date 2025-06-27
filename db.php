<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");



$host = "mainline.proxy.rlwy.net";
$port = 31689;
$user = "root";
$pass = "JokmUrOVupffSlhsGgywSxexpBiCPCuG";
$db   = "railway";

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
