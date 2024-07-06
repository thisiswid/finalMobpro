<?php
include 'koneksi.php';

$sql = "SELECT * FROM pengguna WHERE Username = 'Ryuki'";
$result = $conn->query($sql);
$books = $result->fetch_all(MYSQLI_ASSOC);

// Convert to JSON
$json_books = json_encode($books);
echo $json_books
?>