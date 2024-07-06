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

// Ambil Comment_ID dari URL
$commentID = $_GET['Comment_ID'];

// Query untuk mengambil data komentar
$sql = "SELECT * FROM ulasan WHERE Comment_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $commentID);
$stmt->execute();
$result = $stmt->get_result();
$comment = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Komentar</title>
    <!-- Tautan CSS Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Edit Komentar</h1>
        <form action="update_komentar.php" method="POST">
            <input type="hidden" name="Comment_ID" value="<?php echo $comment['Comment_ID']; ?>">
            <div class="form-group">
                <label for="Chapter_ID">Chapter ID:</label>
                <input type="text" class="form-control" id="Chapter_ID" name="Chapter_ID" value="<?php echo $comment['Chapter_ID']; ?>" required>
            </div>
            <div class="form-group">
                <label for="User_ID">User ID:</label>
                <input type="text" class="form-control" id="User_ID" name="User_ID" value="<?php echo $comment['User_ID']; ?>" required>
            </div>
            <div class="form-group">
                <label for="Isi_Komentar">Isi Komentar:</label>
                <textarea class="form-control" id="Isi_Komentar" name="Isi_Komentar" required><?php echo $comment['Isi_Komentar']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Komentar</button>
        </form>
    </div>

    <!-- Tautan JavaScript Bootstrap (Opsional, jika diperlukan) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
