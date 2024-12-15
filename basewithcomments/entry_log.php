<?php
    include "admin_authen.php"; // TODO: Pastikan file ini aman dan gunakan metode autentikasi terbaru
?>
<?php
    if(isset($_SESSION['resi']) == false){
        // TODO: Pertimbangkan untuk mengubah logika ini jika ada metode validasi sesi yang lebih baik
        // Jika belum ada isi no resi, maka tidak boleh masuk ke entry_log.php karena belum jelas mau entry dari no resi berapa
        header("Location: input.php");
        exit();
    }
?>
<?php
    if(isset($_POST['del'])){
        // TODO: Pertimbangkan untuk menambahkan validasi atau token CSRF untuk operasi ini
        unset($_POST['resi']);
        exit();
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <style>
            body {
                margin: 0;
                padding: 0;
            }
            .box{
                padding: 45px;
                background-color:rgba(255,255,255,.95);
                box-shadow: 1px 0px 17px -5px rgba(0,0,0,0.75);
                border-radius:10px;
            }
            /* TODO: Pertimbangkan untuk menambahkan responsivitas atau penyesuaian gaya lainnya */
        </style>
        <script>
            $(document).ready(function(){
                $("#back").on("click",function(){
                    $.ajax({
                        type : "post",
                        data : {
                            del : 1 // TODO: Pastikan bahwa penghapusan ini aman dan terverifikasi
                        },
                        success : function(){
                            $(window).attr("location","input.php"); // TODO: Pastikan redirect sesuai dengan rute yang benar
                        },
                        error: function(xhr, status, error) {
                            // TODO: Tambahkan penanganan error AJAX untuk meningkatkan debugging dan UX
                            console.error("AJAX Error: ", status, error);
                            Swal.fire({
                                title: "Error!",
                                text: "Gagal kembali ke halaman input.",
                                icon: "error"
                            });
                        }
                    })
                })
                // TODO: Pertimbangkan untuk menambahkan fungsi lain jika diperlukan
            })
        </script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Halo, Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Data Resi Pengiriman</a> <!-- TODO: Pastikan link ini mengarah ke halaman yang benar atau tambahkan fitur navigasi yang lebih baik -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">User Admin</a> <!-- TODO: Tambahkan link yang sesuai jika ada halaman khusus untuk User Admin -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Logout</a> <!-- TODO: Pastikan fungsi logout bekerja dengan benar dan aman -->
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid my-2 p-3">
            <div class="row mb-2">
                <div class="col-4">
                    <form action="upload_log.php" method="post"> <!-- TODO: Pastikan 'upload_log.php' aman dan menangani input dengan benar -->
                        <div class="mb-3">
                            <label for="inTgl" class="form-label">Tanggal : </label>
                            <input type="date" class="form-control" id="inTgl" name="inTgl" required> <!-- TODO: Tambahkan validasi frontend jika diperlukan -->
                        </div>
                        <div class="mb-3">
                            <label for="inKo" class="form-label">Kota : </label>
                            <input type="text" class="form-control" id="inKo" name="inKo" required> <!-- TODO: Pertimbangkan untuk menggunakan dropdown atau autocomplete untuk input kota -->
                        </div>
                        <div class="mb-3">
                            <label for="inKet" class="form-label">Keterangan : </label>
                            <textarea class="form-control" placeholder="Keterangan..." id="inKet" name="inKet" required></textarea> <!-- TODO: Pertimbangkan untuk menambahkan karakter maksimal atau validasi lain -->
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                            <button type="button" class="btn btn-danger" id="back">Back</button> <!-- TODO: Pastikan tombol 'Back' berfungsi sesuai yang diinginkan -->
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kota</th>
                            <th>Keterangan</th>
                            <!-- TODO: Tambahkan kolom lain jika diperlukan, seperti aksi (edit/delete) -->
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <?php
                            $sql = "SELECT * FROM pengiriman_detail WHERE no_resi = :resi"; // TODO: Pertimbangkan untuk memilih kolom spesifik daripada *
                            $stmt = $conn->prepare($sql);
                            $stmt->execute(array(
                                ":resi" => $_SESSION['resi'] // TODO: Pastikan 'resi' selalu ter-set dan valid
                            ));
                            $row = $stmt->fetchAll();
                            foreach($row as $r){
                                echo "<tr><td class='tgl'>".$r['tanggal']."</td>";
                                echo "<td class='kota'>".$r['kota']."</td>";
                                echo "<td class='keterangan'>".$r['keterangan']."</td></tr>";
                                // TODO: Tambahkan aksi edit/delete jika diperlukan
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
