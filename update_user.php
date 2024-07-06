<?php
require 'koneksi2.php';

header('Access-Control-Allow-Origin: *');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil data yang dikirim dari formulir
        $userID = $_POST['id'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];

        // Query untuk memperbarui data pengguna
        $query = "UPDATE Pengguna SET Nama = :nama, Email = :email WHERE User_ID = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(["success" => true]);
    } else {
        throw new Exception("Invalid request method.");
    }
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
