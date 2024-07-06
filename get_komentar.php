<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app_eliterasi";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data komentar
$sql = "SELECT * FROM ulasan";
$result = $conn->query($sql);

$comments = array();

if ($result->num_rows > 0) {
    // Output data setiap baris
    while($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
}

// Mengatur header untuk mengembalikan JSON
header('Content-Type: application/json');
echo json_encode($comments);

$conn->close();
?>
