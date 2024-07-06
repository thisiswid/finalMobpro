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

// Ambil data dari form
$chapterID = $_POST['Chapter_ID'];
$userID = $_POST['User_ID'];
$isiKomentar = $_POST['Isi_Komentar'];
$tanggalKomentar = date('Y-m-d H:i:s');

// Validasi Chapter_ID dan User_ID
$valid = true;

// Periksa Chapter_ID
$chapterCheck = $conn->prepare("SELECT COUNT(*) FROM chapter WHERE Chapter_ID = ?");
$chapterCheck->bind_param("i", $chapterID);
$chapterCheck->execute();
$chapterCheck->bind_result($chapterCount);
$chapterCheck->fetch();
$chapterCheck->close();

if ($chapterCount == 0) {
    $valid = false;
    echo "Chapter_ID tidak valid.<br>";
}

// Periksa User_ID
$userCheck = $conn->prepare("SELECT COUNT(*) FROM pengguna WHERE User_ID = ?");
$userCheck->bind_param("i", $userID);
$userCheck->execute();
$userCheck->bind_result($userCount);
$userCheck->fetch();
$userCheck->close();

if ($userCount == 0) {
    $valid = false;
    echo "User_ID tidak valid.<br>";
}

if ($valid) {
    // Query untuk menyimpan data
    $sql = "INSERT INTO ulasan (Chapter_ID, User_ID, Isi_Komentar, Tanggal_Komentar) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $chapterID, $userID, $isiKomentar, $tanggalKomentar);

    if ($stmt->execute()) {
        echo "Komentar berhasil ditambahkan.";
        header("Location: index_komentar.html"); // Alihkan ke index.html setelah berhasil menambahkan komentar
        exit(); // Pastikan tidak ada kode lain yang dijalankan setelah pengalihan
    } else {
        echo "Gagal menambahkan komentar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
