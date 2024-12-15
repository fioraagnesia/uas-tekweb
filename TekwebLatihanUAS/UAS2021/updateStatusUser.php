<?php
include "koneksi.php";
header("Content-Type: application/json");
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ambil data dari request
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["id"]) && isset($data["status_aktif"])) {
    $id = $data["id"];
    $status_aktif = $data["status_aktif"];

    // Update status_aktif di database
    $sql = "UPDATE uas21_useradmin SET status_aktif = ? WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Query preparation failed: ' . $conn->error);
    }
    
    $stmt->bind_param("ii", $status_aktif, $id);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
        ]);
    } else {
        echo json_encode([
            "status" => "error",
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        "status" => "error",
    ]);
}

$conn->close();
?>
