<?php
session_start();
if (isset($_POST['id'])) {
    $_SESSION['id_transaksi'] = $_POST['id'];
    echo 'ID Transaksi Disimpan';
}
?>
