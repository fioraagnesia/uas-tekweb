<?php
    include "connection.php"; // TODO: Pastikan file koneksi aman dan gunakan metode koneksi terbaru
?>
<?php
    if(isset($_POST['filter'])){
        // TODO: Pertimbangkan untuk memilih kolom spesifik daripada menggunakan *
        $sql = "SELECT * FROM pengiriman_detail WHERE no_resi = :nr";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ":nr" => $_POST['filter'] // TODO: Validasi input 'filter' untuk mencegah serangan seperti SQL Injection
        ));
        $row = $stmt->fetchAll();
        if($row){
            foreach($row as $r){
                echo "<tr><td class='tgl'>".$r['tanggal']."</td>";
                echo "<td class='kota'>".$r['kota']."</td>";
                echo "<td class='keterangan'>".$r['keterangan']."</td></tr>";
                // TODO: Pertimbangkan untuk menambahkan aksi seperti edit atau delete pada setiap baris data
            }
        }else{
            echo "<tr><td colspan='3'class='text-center text-danger'><strong>Tidak ada Data detail pengriman dengan No Resi ".$_POST['filter']."</strong></td></tr>";
            // TODO: Pertimbangkan untuk menambahkan opsi untuk memasukkan No Resi baru atau mencari lagi
        }
        exit();
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <!-- <link rel="stylesheet" href="sweetalert2.min.css"> -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function(){
                $("#search").on("click",function(){
                    // TODO: Tambahkan validasi input sebelum melakukan AJAX request
                    $.ajax({
                        type : "post",
                        data : {
                            filter : $("#inNp").val() // TODO: Pastikan input 'inNp' telah divalidasi dan disanitasi
                        },
                        success : function(e){
                            $("#view").html(e);
                            // TODO: Pertimbangkan untuk menambahkan notifikasi sukses atau informasi lainnya setelah pencarian
                        },
                        error: function(xhr, status, error) {
                            // TODO: Tambahkan penanganan error AJAX untuk meningkatkan debugging dan UX
                            console.error("AJAX Error: ", status, error);
                            Swal.fire({
                                title: "Error!",
                                text: "Gagal melakukan pencarian. Silakan coba lagi.",
                                icon: "error"
                            });
                        }
                    })
                })
                // TODO: Pertimbangkan untuk menambahkan event listener lain jika diperlukan
            })
        </script>
        <style>
            body {
                margin: 0;
                padding: 0;
                /* TODO: Tambahkan gaya tambahan atau responsivitas jika diperlukan */
            }
        </style>
    </head>
<body>
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark">  
        <div class="container-fluid">
            <a class="navbar-brand" href="#">WELCOME!</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="login.php">Login Admin</a> <!-- TODO: Pastikan link ini mengarah ke halaman login yang benar -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid p-4">
        <h1>Cek Pengiriman</h1>
        <div class="row my-4">
            <div class="mb-3 col-3">
                <input type="text" class="form-control" id="inNp" name="inNp" placeholder="Nomor Pengiriman" required> <!-- TODO: Tambahkan validasi frontend untuk memastikan input sesuai format No Resi -->
            </div>
            <div class="col-2">
                <button class="btn btn-dark" id="search">Lihat</button> <!-- TODO: Pertimbangkan untuk mengganti button dengan type="button" atau type="submit" sesuai kebutuhan -->
            </div>
        </div>
        <div class="row p-2">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kota</th>
                        <th>Keterangan</th>
                        <!-- TODO: Tambahkan kolom lain jika diperlukan, seperti aksi (edit/delete) -->
                    </tr>
                </thead>
                <tbody class="table-light" id="view">
                    <tr>
                        <td colspan="3" class="text-center text-primary">
                            <strong>Masukkan Nomor Resi untuk menampilkan detail pengiriman!!</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
