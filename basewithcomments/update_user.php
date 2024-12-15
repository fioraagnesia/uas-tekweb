<?php
    include "admin_authen.php"; // TODO: Pastikan file ini aman dan menggunakan metode autentikasi terbaru untuk melindungi akses admin.

    // Mengecek apakah semua data yang diperlukan untuk update telah dikirim melalui POST
    if(isset($_POST['upU']) && isset($_POST['upNm']) && isset($_POST['upPs'])){
        // TODO: Pertimbangkan untuk memilih kolom spesifik daripada menggunakan nama kolom langsung untuk menghindari kesalahan.
        // Misalnya, jika struktur tabel berubah, Anda perlu memperbarui query ini.
        $sql = "UPDATE user SET nama = :upNm, password = PASSWORD(:upPs) WHERE username = :upU";
        
        // Menyiapkan statement SQL untuk dieksekusi
        $stmt = $conn->prepare($sql);
        
        // TODO: Validasi dan sanitasi input pengguna sebelum eksekusi query untuk mencegah SQL Injection dan memastikan data yang konsisten.
        // Misalnya, periksa apakah 'upU' adalah format username yang valid, 'upNm' sesuai dengan kriteria nama, dan 'upPs' memenuhi kebijakan password.
        $stmt->execute(array(
            ":upU" => $_POST['upU'],   // TODO: Pastikan 'upU' berasal dari sumber yang terpercaya dan valid.
            ":upPs" => $_POST['upPs'], // TODO: Pertimbangkan untuk menggunakan metode hashing password yang lebih aman seperti password_hash() di PHP daripada fungsi PASSWORD() di MySQL.
            ":upNm" => $_POST['upNm']   // TODO: Validasi nama pengguna untuk memastikan tidak mengandung karakter ilegal atau script.
        ));
        
        // Setelah berhasil memperbarui data, arahkan kembali ke halaman admin
        header("Location: admin.php"); // TODO: Pastikan halaman 'admin.php' menangani data dengan benar dan aman setelah redirect.
        exit(); // Menghentikan eksekusi skrip setelah redirect untuk mencegah kode tambahan dieksekusi.
    }
?>
