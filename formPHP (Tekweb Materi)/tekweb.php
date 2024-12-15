<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
var_dump($_REQUEST);
$a = $_REQUEST["pertama"];
$b = $_REQUEST["kedua"];
$c = $a+$b;
$terbesar = ($a > $b) ? $a : $b;
echo "<h1>$a + $b = $c</h1>";
?>
<h2>Sub menu 2</h2>
<h3>Sub menu 3</h3>
<?php
for ($i = 0; $i < 10; $i++) {
    print("<h6>$i</h6>");
}
?>
</body>
</html>
