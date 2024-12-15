<!-- UNTUK SEND1 -->
<?php
// Pastikan file ini menerima data POST dan mengembalikannya dengan benar

// Memeriksa apakah data 'name' dan 'city' ada dalam POST
if (isset($_POST['name']) && isset($_POST['city'])) {
    $name = $_POST['name'];
    $city = $_POST['city'];

    // Mengirim respons dengan data yang diterima
    echo "Name: " . $name . "<br>City: " . $city;
} else {
    // Jika data tidak ada
    echo "Missing 'name' or 'city' data.";
}
?>
