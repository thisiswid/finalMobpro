<?php
require 'koneksi2.php';


header('Access-Control-Allow-Origin: *');

try {
   
    $query = "SELECT User_ID, Username, Nama, Email FROM pengguna";  
    $stmt = $pdo->query($query);

    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $json = json_encode($result, JSON_PRETTY_PRINT);


    $file_path = __DIR__ . '/output.json'; 
    file_put_contents($file_path, $json); 

 
    header('Content-Type: application/json'); 

    echo $json;

} catch (PDOException $e) {
    
    echo json_encode(["error" => $e->getMessage()]);
}
?>
