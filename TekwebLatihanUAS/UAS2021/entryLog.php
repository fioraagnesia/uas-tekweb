<?php
session_start();
include "koneksi.php";

header("Content-Type: application/json");


$id_transaksi = $_SESSION['id_transaksi'] ?? null;
if (!$id_transaksi) {
    echo "ID transaksi tidak ditemukan!";
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$response = [];


if (isset($data["tanggal"]) && isset($data["kota"])  && isset($data["keterangan"])
        &&!empty($data["tanggal"]) && !empty($data["kota"]) && !empty($data["keterangan"])) {
    $tanggal = $data["tanggal"];
    $kota = $data["kota"];
    $keterangan = $data["keterangan"];

    $sql = "INSERT INTO uas21_detaillog(id_transaksi, tanggal, kota, keterangan) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $id_transaksi, $tanggal, $kota, $keterangan);
    
    if ($stmt->execute()) {
        $sql = "SELECT id_log, tanggal, kota, keterangan FROM uas21_detaillog
                WHERE id_transaksi = ? ORDER BY id_log";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_transaksi);
        $stmt->execute();
        $result = $stmt->get_result();

        while($row = $result->fetch_assoc()) {
            $id = $row["id_log"];
            $tanggal = $row["tanggal"];
            $kota = $row["kota"];
            $keterangan = $row["keterangan"];

            $response[] = [
                "id" => $id,
                "tanggal" => $tanggal,
                "kota" => $kota,
                "keterangan" => $keterangan
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
    }

    $stmt->close();
}

else {
    $sql = "SELECT id_log, tanggal, kota, keterangan FROM uas21_detaillog
            WHERE id_transaksi = ? ORDER BY id_log";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_transaksi);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row["id_log"];
            $tanggal = $row["tanggal"];
            $kota = $row["kota"];
            $keterangan = $row["keterangan"];

            $response[] = [
                "id" => $id,
                "tanggal" => $tanggal,
                "kota" => $kota,
                "keterangan" => $keterangan
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
    }
}



$conn->close();
?>