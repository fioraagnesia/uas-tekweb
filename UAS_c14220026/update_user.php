<?php
    include "admin_authen.php";
    if(isset($_POST['upU']) && isset($_POST['upNm']) && isset($_POST['upPs'])){
        $sql = "UPDATE user SET nama = :upNm,password = PASSWORD(:upPs) WHERE username = :upU";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ":upU" => $_POST['upU'],
            ":upPs" => $_POST['upPs'],
            ":upNm" => $_POST['upNm']
        ));
        header("Location: admin.php");
        exit();
    }
?>