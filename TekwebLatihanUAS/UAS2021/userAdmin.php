<?php
include "koneksi.php";

header("Content-Type: application/json");
ini_set('display_errors', 1);
error_reporting(E_ALL);


$data = json_decode(file_get_contents("php://input"), true);

$response = [];

if (isset($data["username"]) && isset($data["password"]) && isset($data["nama_admin"]) &&
    !empty($data["username"]) && !empty($data["password"]) && !empty($data["nama_admin"])) {

    $username = $data["username"];
    $password = $data["password"];
    $nama_admin = $data["nama_admin"];

    // Siapkan query untuk memasukkan data user baru
    $sql = "INSERT INTO uas21_useradmin (username, password, nama_admin) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Cek jika query gagal disiapkan
    if ($stmt === false) {
        die('Query preparation failed: ' . $conn->error);
    }

    // Bind parameter dan eksekusi
    $stmt->bind_param("sss", $username, $password, $nama_admin);
    
    // Eksekusi query
    if ($stmt->execute()) {
        // Jika berhasil insert, ambil data user yang baru ditambahkan
        $sql = "SELECT id_user, username, nama_admin, status_aktif FROM uas21_useradmin ORDER BY id_user DESC LIMIT 1";
        $result = $conn->query($sql);

        // Cek apakah ada data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $response[] = [
                    "id" => $row["id_user"],
                    "username" => $row["username"],
                    "nama_admin" => $row["nama_admin"],
                    "status_aktif" => $row["status_aktif"],
                ];
            }
        }

        echo json_encode([
            "status" => "success",
            "data" => $response,
        ]);
        exit();
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Gagal menambahkan user",
        ]);
        exit();
    }

    $stmt->close();

}

else {
    $sql = "SELECT id_user, username, nama_admin, status_aktif FROM uas21_useradmin
            ORDER BY id_user";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row["id_user"];
            $username = $row["username"];
            $nama_admin = $row["nama_admin"];
            $status_aktif = $row["status_aktif"];

            $response[] = [
                "id" => $id,
                "username" => $username,
                "nama_admin" => $nama_admin,
                "status_aktif" => $status_aktif,
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