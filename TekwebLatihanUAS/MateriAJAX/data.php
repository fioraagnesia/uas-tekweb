<?php
header("Content-type: application/json");
$arraydata = array();
$arraydata[] = array("id" => "1", "first_name" => "Justin", "last_name" => "Andy", "email" => "justin@petra.ac.id", "gender" => "M");
$arraydata[] = array( "id" => "2", "first_name" => "Mary", "last_name" => "Anne", "email" => "mary@petra.ac.id", "gender" => "F" );
$arraydata[] = array( "id" => "3", "first_name" => "Dino", "last_name" => "How", "email" => "dino@petra.ac.id", "gender" => "M" );
print_r(json_encode($arraydata, JSON_PRETTY_PRINT));
?>