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

// Ambil Comment_ID dari parameter GET
$commentID = $_GET['Comment_ID'];

// Query untuk menghapus data
$sql = "DELETE FROM ulasan WHERE Comment_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $commentID);

if ($stmt->execute()) {
    echo "Komentar berhasil dihapus.";
} else {
    echo "Gagal menghapus komentar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
