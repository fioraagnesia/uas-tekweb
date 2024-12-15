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
$name = $_POST["name"];
$email = $_POST["email"];
$sql = "INSERT INTO users (name, email) 
              VALUES (:name, :email)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
        ':name' => $name,
        ':email' => $email));
?>
<p>Insert successful, go to <a href="dbconn.php">table</a></p>
</body>
</html>