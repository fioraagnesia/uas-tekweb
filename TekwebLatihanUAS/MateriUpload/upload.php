<?php
// Set folder tujuan untuk upload file
$upload_dir = 'uploads/';

// Tentukan jenis file yang diizinkan
$allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
$max_size = 2 * 1024 * 1024; // 2MB

// Periksa apakah ada file yang diupload
if (isset($_FILES['file'])) {
    // Ambil informasi file yang diupload
    $file_name = $_FILES['file']['name'];
    $file_tmp_name = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];

    // Periksa apakah jenis file diizinkan
    if (!in_array($file_type, $allowed_types)) {
        die('File type is not allowed.');
    }

    // Periksa ukuran file
    if ($file_size > $max_size) {
        die('File is too large.');
    }

    // Periksa ekstensi file
    $file_info = pathinfo($file_name);
    $file_extension = strtolower($file_info['extension']);
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

    if (!in_array($file_extension, $allowed_extensions)) {
        die('Invalid file extension.');
    }

    // Cek apakah file adalah gambar (untuk gambar)
    if (getimagesize($file_tmp_name) === false && in_array($file_type, ['image/jpeg', 'image/png', 'image/gif'])) {
        die('Uploaded file is not a valid image.');
    }

    // Menghasilkan nama file yang unik
    $random_name = uniqid('upload_') . '.' . $file_extension;
    $target_file = $upload_dir . $random_name;

    // Cek apakah direktori upload ada, jika tidak buat
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Pindahkan file yang diupload ke folder yang telah ditentukan
    if (move_uploaded_file($file_tmp_name, $target_file)) {
        echo 'File uploaded successfully: ' . $random_name;
    } else {
        echo 'Failed to upload file.';
    }
} else {
    echo 'No file uploaded.';
}
?>
