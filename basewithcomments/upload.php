<?php
    // Menyertakan file autentikasi admin untuk memastikan bahwa pengguna sudah login sebagai admin
    include "admin_authen.php";
?>
<?php
    // Mengecek apakah 'inTgl' (tanggal) dan 'inNo' (nomor resi) ada dalam permintaan POST
    if(isset($_POST['inTgl']) && isset($_POST['inNo'])){
        // Query SQL untuk memasukkan data pengiriman baru ke dalam tabel 'pengiriman'
        // Nilai 'Default' disetel untuk kolom ketiga (mungkin sebagai status default atau placeholder)
        $sql = "INSERT INTO pengiriman VALUES(:inNo,:inTgl,'Default')";
        
        // Menyiapkan statement SQL untuk dieksekusi
        $stmt = $conn->prepare($sql);
        
        // Menjalankan query dengan nilai yang diberikan untuk 'inNo' dan 'inTgl'
        $stmt->execute(array(
            ":inNo" => $_POST['inNo'], // Memasukkan nomor resi
            ":inTgl" => $_POST['inTgl'] // Memasukkan tanggal
        ));
        
        // Setelah data berhasil dimasukkan, pengguna akan diarahkan kembali ke halaman input
        header("Location: input.php");
    }
?>
