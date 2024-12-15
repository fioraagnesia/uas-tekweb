<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koneksi ke MySQL</title>
</head>
<body>
<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=tekweb',  
'justin', '12345');
$stmt = $pdo->query("SELECT * FROM users");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//print_r($rows);
echo '<table border="1">'."\n";
foreach ( $rows as $row ) {
    echo "<tr><td>";
    echo $row["id"];
    echo "</td><td>";
    echo $row["name"];
    echo "</td><td>";
    echo $row["email"];
    echo "</td><td>";
    echo $row["created_at"];
    echo "</td></tr>\n";
}
echo "</table>";
?>
</body>
</html>