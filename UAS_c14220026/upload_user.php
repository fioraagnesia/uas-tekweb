<?php
    include "admin_authen.php";
    if(isset($_POST['inU']) && isset($_POST['inNm']) && isset($_POST['inPs'])){
        $sql = "INSERT INTO user VALUES (:inU,PASSWORD(:inPs),:inNm,1)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ":inU" => $_POST['inU'],
            ":inPs" => $_POST['inPs'],
            ":inNm" => $_POST['inNm']
        ));
        header("Location: admin.php");
        exit();
    }
?>