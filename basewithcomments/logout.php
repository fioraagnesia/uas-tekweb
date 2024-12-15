<?php
    include "connection.php"; // TODO: Pastikan file 'connection.php' mengandung pengaturan koneksi database yang benar dan aman. File ini harus dilindungi agar tidak dapat diakses langsung melalui web.

    session_start(); // Memulai sesi PHP untuk mengelola data pengguna yang sedang login.

    session_destroy(); // Menghancurkan semua data sesi yang ada untuk melakukan logout pengguna.

    header("Location: index.php"); // TODO: Pastikan 'index.php' adalah halaman yang tepat untuk diarahkan setelah logout. Pertimbangkan untuk menambahkan pesan konfirmasi logout jika diperlukan.
    // TODO: Tambahkan 'exit();' setelah header redirection untuk memastikan bahwa skrip berhenti dieksekusi setelah pengalihan.
?>
