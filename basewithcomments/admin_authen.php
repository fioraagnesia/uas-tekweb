<?php
// TODO: Pastikan file 'connection.php' mengandung pengaturan koneksi database yang benar dan aman.
// File ini harus berada di lokasi yang tidak dapat diakses langsung melalui web untuk meningkatkan keamanan.
include "connection.php";

session_start(); // Memulai sesi untuk mengelola data pengguna yang sedang login.

// TODO: Verifikasi bahwa sesi sudah diinisialisasi dengan benar setelah login.
// Cek apakah pengguna sudah login dengan memeriksa apakah variabel sesi 'user' ada.
if(isset($_SESSION['user']) == false){
    // Jika belum ada sesi 'user', destruksi sesi yang ada (jika ada) dan arahkan pengguna ke halaman login.
    session_destroy(); // Menghancurkan semua data sesi.
    sleep(2); // Memberikan jeda waktu 2 detik sebelum redirect, bisa diubah atau dihapus sesuai kebutuhan.
    header("Location: login.php"); // Redirect ke halaman login.
    exit(); // Menghentikan eksekusi skrip setelah redirect.
} else {
    // Jika pengguna sudah login, periksa apakah sesi telah kedaluwarsa.
    $inactive = 1800; // Waktu inaktivitas dalam detik (1800 detik = 30 menit).
    $session_life = time() - $_SESSION['timeout']; // Menghitung berapa lama sesi sudah aktif.

    // TODO: Sesuaikan nilai $inactive sesuai dengan kebijakan keamanan proyek Anda.
    if($session_life > $inactive) {
        // Jika sesi sudah lebih lama dari waktu inaktivitas yang ditentukan, arahkan pengguna ke logout.
        header("Location: logout.php"); // Redirect ke halaman logout.
        exit(); // Menghentikan eksekusi skrip setelah redirect.
    }

    // Jika sesi masih aktif, perbarui waktu timeout untuk memperpanjang sesi.
    $_SESSION['timeout'] = time();
    // TODO: Pertimbangkan untuk menyimpan informasi tambahan dalam sesi jika diperlukan, seperti hak akses atau preferensi pengguna.
}
?>
