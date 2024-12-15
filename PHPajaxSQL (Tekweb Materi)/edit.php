<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
</head>
<body>
<?php
include "koneksi.php";
$id = $_GET["id"];
if(isset($_GET["name"])) {
    $sql = "UPDATE users SET name=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $_GET["name"], $_GET["email"], $id);
    if($stmt->execute()) {
        echo "Data berhasil diupdate";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
$sql = "SELECT * FROM users WHERE id='$id'";
$stmt = $conn->query($sql);
$rows = $stmt->fetch_assoc();

$name = $rows["name"];
$email = $rows["email"];

$stmt->close();
?>
<form action="#" method="get">
    <input type="text" name="name" value="<?= $name ?>"><br>
    <input type="text" name="email" value="<?= $email ?>"><br>
    <input type="hidden" name="id" value="<?= $id ?>"><br>
    <input type="submit">
</form>
<?php
}
?>
<p>Go to <a href="dbconn.php">table</a></p>
</body>
</html>