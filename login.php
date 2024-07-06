<?php
include 'koneksi.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $response = array();

    // Mengambil input JSON dari request body
    $input = json_decode(file_get_contents("php://input"), true);
    $username = $input['Username'];
    $sandi = $input['Sandi']; // Ganti MD5 dengan password_hash dan password_verify

    // Query untuk memeriksa pengguna
    $cek = "SELECT * FROM pengguna WHERE Username='$username' AND Sandi='$sandi'";
    $result = mysqli_fetch_array(mysqli_query($conn, $cek));

    if (isset($result)) {
        $response['value'] = 1;
        $response['message'] = "Login Berhasil";
        $response['user'] = array(
            'User_ID' => $result['User_ID'],
            'Username' => $result['Username'],
            'Nama' => $result['Nama'], // Ambil nama dari tabel
            'Email' => $result['Email'],
            'Sandi' => $result['Sandi']
        );
    } else {
        $response['value'] = 0;
        $response['message'] = "Login Gagal";
    }

    echo json_encode($response);
}
?>
