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
    //echo "Data berhasil dihapus";
    $result = $conn->query("SELECT * FROM users");
$rows = $result->fetch_assoc();
echo '<table border="1">'."\n";
echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Created at</th></tr>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id =$row["id"];
        echo "<tr><td>".
        $id. "</td><td>".
        $row["name"]. "</td><td>".
        $row["email"]. "</td><td>".
        $row["created_at"]. "</td><td>".
        "<button id='$id' class='delbutton'>DEL</button></td><td>".
        "<button>EDIT</button></td></tr>\n";
    }
} else {
    echo "0 results";
}
$conn->close();
echo "</table>";

} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
?>
</body>
</html>