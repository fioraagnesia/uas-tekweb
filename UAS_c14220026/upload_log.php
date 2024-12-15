<?php
    include "admin_authen.php";
?>
<?php
    if(isset($_POST['inTgl']) && isset($_POST['inKo']) && isset($_POST['inKet']) && isset($_SESSION['resi'])){
        $sql = "INSERT INTO pengiriman_detail VALUES(:inNo,:inTgl,:inKo,:inKet)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ":inNo" => $_SESSION['resi'],
            ":inTgl" => $_POST['inTgl'],
            ":inKo" => $_POST['inKo'],
            ":inKet" => $_POST['inKet']
        ));
        header("Location: entry_log.php");
    }
?>