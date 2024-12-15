<?php
include "koneksi.php";
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["id"])) {
    $id = $data["id"];

    error_log("ID yang diterima: " . $id);

    $sql = "DELETE FROM uas21_transaksiresi WHERE id_transaksi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "No rows affected"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error executing query"]);
    }

    $stmt->close();
}
else {
    echo json_encode([
        "status" => "error"
    ]);
}

$conn->close();
?>