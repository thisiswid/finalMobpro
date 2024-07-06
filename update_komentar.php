<?php
// Tampilkan semua error untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Ambil data dari form
$commentID = $_POST['Comment_ID'];
$chapterID = $_POST['Chapter_ID'];
$userID = $_POST['User_ID'];
$isiKomentar = $_POST['Isi_Komentar'];
$tanggalKomentar = date('Y-m-d H:i:s');

// Query untuk mengupdate data
$sql = "UPDATE ulasan SET Chapter_ID = ?, User_ID = ?, Isi_Komentar = ?, Tanggal_Komentar = ? WHERE Comment_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissi", $chapterID, $userID, $isiKomentar, $tanggalKomentar, $commentID);

if ($stmt->execute()) {
    // Redirect ke halaman utama setelah update berhasil
    header("Location: index_komentar.html");
    exit(); // Pastikan untuk menghentikan eksekusi script setelah redirect
} else {
    echo "Gagal memperbarui komentar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
