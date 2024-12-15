<pre>
<?php
if (strlen($_POST["account"]) == 0) {
    echo "Account belum diisi!!!";
}
var_dump($_POST);

$a=$_POST["code"];
var_dump($a);
echo "</pre>";
echo $_POST["account"];
?>


