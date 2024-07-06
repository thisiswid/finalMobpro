<?php
require 'koneksi2.php';

header('Access-Control-Allow-Origin: *');

try {
    if (isset($_GET['id'])) {
        $userID = intval($_GET['id']);

   
        $checkQuery = "SELECT COUNT(*) FROM Pengguna WHERE User_ID = :id";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindParam(':id', $userID, PDO::PARAM_INT);
        $checkStmt->execute();
        $userExists = $checkStmt->fetchColumn();

        if ($userExists) {
            $query = "DELETE FROM Pengguna WHERE User_ID = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["error" => "Pengguna tidak dapat dihapus."]);
            }
        } else {
            echo json_encode(["error" => "ID pengguna tidak ditemukan."]);
        }
    } else {
        throw new Exception("ID pengguna tidak ditemukan.");
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
