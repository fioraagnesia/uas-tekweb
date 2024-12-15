<?php
include "koneksi.php";

header("Content-Type: application/json");
ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);
$response = [];

if (isset($data["id"]) && isset($data["username"]) && isset($data["password"]) && isset($data["nama_admin"]) &&
    !empty($data["id"]) && !empty($data["username"]) && !empty($data["password"]) && !empty($data["nama_admin"])) {
    
    $id = $data["id"];
    $username = $data["username"];
    $password = $data["password"];
    $nama_admin = $data["nama_admin"];
    
    // UPDATE
    $sql = "UPDATE uas21_useradmin SET username = ?, password = ?, nama_admin = ? WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $password, $nama_admin, $id);
    
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Data berhasil diupdate"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Data gagal diupdate"
        ]);
    }
    
    $stmt->close();
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak lengkap"
    ]);
}

$conn->close();
?>
