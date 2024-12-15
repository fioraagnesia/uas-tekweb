<?php
    // Menyertakan file autentikasi admin untuk memastikan pengguna sudah login sebagai admin
    include "admin_authen.php";
?>
<?php
    // Mengecek apakah 'inTgl' (tanggal), 'inKo' (kota), 'inKet' (keterangan), dan 'resi' ada dalam permintaan POST dan session
    if(isset($_POST['inTgl']) && isset($_POST['inKo']) && isset($_POST['inKet']) && isset($_SESSION['resi'])){
        // Query SQL untuk memasukkan data detail pengiriman ke dalam tabel 'pengiriman_detail'
        $sql = "INSERT INTO pengiriman_detail VALUES(:inNo,:inTgl,:inKo,:inKet)";
        
        // Menyiapkan statement SQL untuk dieksekusi
        $stmt = $conn->prepare($sql);
        
        // Menjalankan query dengan nilai yang diberikan untuk 'inNo' (nomor resi dari session), 'inTgl' (tanggal), 'inKo' (kota), dan 'inKet' (keterangan)
        $stmt->execute(array(
            ":inNo" => $_SESSION['resi'],  // Mengambil nomor resi yang disimpan dalam session
            ":inTgl" => $_POST['inTgl'],   // Memasukkan tanggal pengiriman
            ":inKo" => $_POST['inKo'],     // Memasukkan nama kota pengiriman
            ":inKet" => $_POST['inKet']    // Memasukkan keterangan tentang pengiriman
        ));
        
        // Setelah data berhasil dimasukkan, pengguna akan diarahkan kembali ke halaman 'entry_log.php'
        header("Location: entry_log.php");
    }
?>
