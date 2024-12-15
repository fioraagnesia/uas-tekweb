<?php
    include "admin_authen.php";
?>
<?php
    if(isset($_POST['inTgl']) && isset($_POST['inNo'])){
        $sql = "INSERT INTO pengiriman VALUES(:inNo,:inTgl,'Default')";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ":inNo" => $_POST['inNo'],
            ":inTgl" => $_POST['inTgl']
        ));
        header("Location: input.php");
    }
?>