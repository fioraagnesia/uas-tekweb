<?php
session_set_cookie_params(0);
session_start();

include "koneksi.php";
header('Content-Type: application/json'); // Make sure response is in JSON format

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['username']) && isset($data['password'])) {
    $inputUsername = $data['username'];
    $inputPassword = $data['password'];

    $sql = "SELECT username, password FROM uas21_useradmin";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $isValid = false;

        while($row = $result->fetch_assoc()) {
            $username = $row['username'];
            $password = $row['password'];
            if ($inputUsername === $username && $inputPassword === $password) {
                $isValid = true;
                $_SESSION['username'] = $username;
                // header("Location: menuAdmin.php");
                break;
            }
        }

        if ($isValid) {
            echo json_encode(["status" => "success"]);
        }
        else {
            echo json_encode(["status" => "error"]);
        }

    }
}

$conn->close();
?>