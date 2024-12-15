<?php
    $conn = new mysqli("localhost", "root", "", "uas22_coba");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    };
?>