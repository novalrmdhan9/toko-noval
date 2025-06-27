include '../db.php';
header('Content-Type: application/json');

$cloudinary_base_url = "https://res.cloudinary.com/do29rrjxg/image/upload/";

$query = mysqli_query($conn, "SELECT * FROM banner");

$result = [];
while($row = mysqli_fetch_assoc($query)) {
    $row['gambar'] = $cloudinary_base_url . $row['gambar'];
    $result[] = $row;
}

echo json_encode([
    'success' => true,
    'data' => $result
]);
