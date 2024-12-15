<?php
include "koneksi.php";

header("Content-Type: application/json");
ini_set('display_errors', 1);
error_reporting(E_ALL);


$data = json_decode(file_get_contents("php://input"), true);
$response = [];


if (isset($data["tanggal"]) && isset($data["noResi"]) &&!empty($data["tanggal"]) && !empty($data["noResi"])) {
    $tanggal = $data["tanggal"];
    $noResi = $data["noResi"];

    // INSERT no resi baru
    $sql = "INSERT INTO uas21_transaksiresi(tanggal_resi, no_resi) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $tanggal, $noResi);
    
    // setelah insert, ditampilkan
    if ($stmt->execute()) {
        $sql = "SELECT id_transaksi, tanggal_resi, no_resi FROM uas21_transaksiresi";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $id = $row["id_transaksi"];
            $tanggal = $row["tanggal_resi"];
            $noResi = $row["no_resi"];

            $response[] = [
                "id" => $id,
                "tanggal" => $tanggal,
                "noResi" => $noResi,
            ];
        }
        echo json_encode([
            "status" => "success",
            "data" => $response,
        ]);
        exit();
    }
    else {
        echo json_encode([
            "status" => "error",
        ]);
        exit();
    }

    $stmt->close();
}

else {
    $sql = "SELECT id_transaksi, tanggal_resi, no_resi FROM uas21_transaksiresi
            ORDER BY id_transaksi";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row["id_transaksi"];
            $tanggal = $row["tanggal_resi"];
            $noResi = $row["no_resi"];

            $response[] = [
                "id" => $id,
                "tanggal" => $tanggal,
                "noResi" => $noResi,
            ];
        }
        echo json_encode([
            "status" => "success",
            "data" => $response,
        ]);
        exit();
    }
    else {
        echo json_encode([
            "status" => "error",
        ]);
        exit();
    }
}



$conn->close();
?>