<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koneksi ke MySQL</title>
</head>
<body>
<?php
include "koneksi.php";
$name = $_POST["name"];
$email = $_POST["email"];
$sql = "INSERT INTO users (name, email) 
              VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $email);
if($stmt->execute()) {
    echo "Data berhasil ditambahkan";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
?>
<p>Insert successful, go to <a href="dbconn.php">table</a></p>
</body>
</html>