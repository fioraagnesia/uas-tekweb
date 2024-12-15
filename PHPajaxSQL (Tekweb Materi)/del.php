<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>
<body>
<?php
include "koneksi.php";
$id = $_GET["id"];
$sql = "DELETE FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
if($stmt->execute()) {
    echo "Data berhasil dihapus";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
?>
<p>Insert successful, go to <a href="dbconn.php">table</a></p>
</body>
</html>