<?php
require 'koneksi2.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['username']) && isset($_POST['nama']) && isset($_POST['email'])) {
            $username = $_POST['username'];
            $nama = $_POST['nama'];
            $email = $_POST['email'];

            $query = "INSERT INTO Pengguna (Username, Nama, Email) VALUES (:username, :nama, :email)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':nama', $nama);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["error" => "Failed to execute query."]);
            }
        } else {
            echo json_encode(["error" => "All fields are required."]);
        }
    } else {
        echo json_encode(["error" => "Invalid request method."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["error" => "General error: " . $e->getMessage()]);
}
?>
