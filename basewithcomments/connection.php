<?php
    $conn = new PDO('mysql:host=localhost;port=3306;dbname=uas22_coba','root','');
    if ($conn === false){
        echo "Failed to connect!";
    }
?>  