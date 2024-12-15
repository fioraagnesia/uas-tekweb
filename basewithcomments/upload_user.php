<?php
    // Menyertakan file autentikasi admin untuk memastikan pengguna sudah login sebagai admin
    include "admin_authen.php";
?>
<?php
    // Mengecek apakah data input 'inU' (username), 'inNm' (nama), dan 'inPs' (password) ada dalam permintaan POST
    if(isset($_POST['inU']) && isset($_POST['inNm']) && isset($_POST['inPs'])){
        // Query SQL untuk memasukkan data user baru ke dalam tabel 'user'
        // 'PASSWORD(:inPs)' digunakan untuk mengenkripsi password sebelum disimpan di database
        $sql = "INSERT INTO user VALUES (:inU,PASSWORD(:inPs),:inNm,1)";
        
        // Menyiapkan statement SQL untuk dieksekusi
        $stmt = $conn->prepare($sql);
        
        // Menjalankan query dengan nilai yang diberikan untuk 'inU' (username), 'inPs' (password), dan 'inNm' (nama)
        $stmt->execute(array(
            ":inU" => $_POST['inU'],  // Mengambil username dari form input
            ":inPs" => $_POST['inPs'], // Mengambil password dari form input
            ":inNm" => $_POST['inNm']  // Mengambil nama dari form input
        ));
        
        // Setelah data berhasil dimasukkan, pengguna akan diarahkan kembali ke halaman 'admin.php'
        header("Location: admin.php");
        exit();
    }
?>
