
<?php
include 'koneksi.php';

// Mengambil data dari form
$username = $_POST['username'];
$nama = $_POST['nama'];
$sandi = $_POST['sandi'];
$email = $_POST['email'];

// Mengambil username lama dari post data
$username_lama = $_POST['username_lama'];

$data = mysqli_query($conn, "UPDATE pengguna SET Username='$username', Nama='$nama', Sandi='$sandi', Email='$email' WHERE Username='$username_lama'");

if ($data){
    echo json_encode([
        'pesan'=>'Sukses Update'
    ]);
} else {
    echo json_encode([
        'pesan'=>'Gagal Update'
    ]);
}
?>
