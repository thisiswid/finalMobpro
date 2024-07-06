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
    $user_id = $input['user_id'];

    // Query untuk mengambil jadwal berdasarkan ID pengguna
    $cek = "SELECT * FROM pengguna WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $cek);

    if (mysqli_num_rows($result) > 0) {
        $profil = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $profil[] = $row;
        }
        $response['value'] = 1;
        $response['profil'] = $profil;
    } else {
        $response['value'] = 0;
        $response['message'] = "Tidak ada data untuk pengguna ini";
    }

    echo json_encode($response);
}
?>