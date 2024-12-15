<?php
include "koneksi.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["noPengiriman"]) && !empty($data["noPengiriman"])) {
    $noResi = $data["noPengiriman"];

    $sql = "SELECT d.tanggal, d.kota, d.keterangan
            FROM uas21_detaillog d
            JOIN uas21_transaksiresi t ON d.id_transaksi = t.id_transaksi
            WHERE t.no_resi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $noResi);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response = [];     // utk menampung datanya

        while($row = $result->fetch_assoc()) {
            $tanggal = $row["tanggal"];
            $kota = $row["kota"];
            $keterangan = $row["keterangan"];

            $response[] = [
                "tanggal" => $tanggal,
                "kota" => $kota,
                "keterangan" => $keterangan
            ];
        }
        echo json_encode([
            "status" => "success",
            "data" => $response
        ]);
    }
    else {
        echo json_encode([
            "status" => "success",
            "data" => []
        ]);
    }

}
// // Kalau di klik "lihat" tanpa input akan memunculkan semua datanya
// else {
//     $sql = "SELECT tanggal, kota, keterangan
//             FROM uas21_detaillog";
//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         $response = [];     // utk menampung datanya

//         while($row = $result->fetch_assoc()) {
//             $tanggal = $row["tanggal"];
//             $kota = $row["kota"];
//             $keterangan = $row["keterangan"];

//             $response[] = [
//                 "tanggal" => $tanggal,
//                 "kota" => $kota,
//                 "keterangan" => $keterangan
//             ];
//         }
//         echo json_encode([
//             "status" => "success",
//             "data" => $response
//         ]);
//     }
//     else {
//         echo json_encode([
//             "status" => "success",
//             "data" => []
//         ]);
//     }


//     // echo json_encode(["status" => "error"]);
// }


$conn->close();
?>