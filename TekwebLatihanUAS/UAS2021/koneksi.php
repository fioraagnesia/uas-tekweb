<?php
    $conn = new mysqli("localhost", "root", "", "tekweb_latihan");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    };
?>