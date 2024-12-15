<?php
    include "admin_authen.php"; // Pastikan file ini aman dan gunakan metode autentikasi terbaru
?>
<?php
if(isset($_POST['ajax'])){
    $sql = "SELECT * FROM user"; // TODO: Pertimbangkan untuk memilih kolom spesifik daripada *
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetchAll();
    foreach($row as $r){
        echo "<tr><td class='username'>".$r['username']."</td>";
        echo "<td class='nama'>".$r['nama']."</td>";
        echo "<td class='status'>".$r['status']."</td>";
        if($r['status'] == 1){
            echo "<td>
                    <button class='btn btn-warning me-2 btn-edit' data-bs-toggle='modal' data-bs-target='#exampleModal'>edit</button>
                    <button class='btn btn-danger non-aktif'>Non-Aktifkan</button>
                  </td>"; // Gunakan class
        }else{
            echo "<td>
                    <button class='btn btn-warning me-2 btn-edit' data-bs-toggle='modal' data-bs-target='#exampleModal'>edit</button>
                    <button class='btn btn-success aktif'>Aktifkan</button>
                  </td>"; // Gunakan class
        }
        echo "</tr>";
    }
    exit();
}
?>
<?php
// PHP untuk menonaktifkan user
if(isset($_POST['usr'])){
    $sql = "UPDATE user SET status = 0 WHERE username = :usr"; // Validasi input untuk mencegah SQL injection meski menggunakan prepared statements
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ":usr" => $_POST['usr']
    ));
    exit(); 
}
?>
<?php
// PHP untuk mengaktifkan user
if(isset($_POST['user'])){
    $sql = "UPDATE user SET status = 1 WHERE username = :usr"; // Validasi input untuk keamanan
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ":usr" => $_POST['user']
    ));
    exit(); 
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            // Menonaktifkan user
            $(document.body).on("click", ".non-aktif", function(){
                var username = $(this).closest("tr").find(".username").text();
                console.log("Menonaktifkan user:", username);
                $.ajax({
                    type: "post",
                    url: "admin.php", // Pastikan URL ini sesuai
                    data: {
                        usr: username
                    },
                    success: function(){
                        // Reload data setelah berhasil menonaktifkan
                        loadUserData();
                        Swal.fire({
                            title: "Sukses!",
                            text: "User berhasil dinonaktifkan.",
                            icon: "success"
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", status, error);
                        Swal.fire({
                            title: "Error!",
                            text: "Gagal menonaktifkan user.",
                            icon: "error"
                        });
                    }
                });
            });

            // Mengaktifkan user
            $(document.body).on("click", ".aktif", function(){
                var username = $(this).closest("tr").find(".username").text();
                console.log("Mengaktifkan user:", username);
                $.ajax({
                    type: "post",
                    url: "admin.php", // Pastikan URL ini sesuai
                    data: {
                        user: username
                    },
                    success: function(){
                        // Reload data setelah berhasil mengaktifkan
                        loadUserData();
                        Swal.fire({
                            title: "Sukses!",
                            text: "User berhasil diaktifkan.",
                            icon: "success"
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", status, error);
                        Swal.fire({
                            title: "Error!",
                            text: "Gagal mengaktifkan user.",
                            icon: "error"
                        });
                    }
                });
            });

            // Mengedit user
            $(document.body).on("click", ".btn-edit", function(){
                var username = $(this).closest("tr").find('.username').text();
                var nama = $(this).closest("tr").find('.nama').text();
                $("#upU").val(username);
                $("#upNm").val(nama);
            });

            // Fungsi untuk memuat data user
            function loadUserData(){
                $.ajax({
                    type: "post",
                    url: "admin.php", // Pastikan URL ini sesuai
                    data: {
                        ajax: 1
                    },
                    success: function(e){
                        $("#view").html(e);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", status, error);
                        Swal.fire({
                            title: "Error!",
                            text: "Gagal memuat data user.",
                            icon: "error"
                        });
                    }
                });
            }

            // Inisialisasi data user saat halaman dibuka
            loadUserData();
        });
    </script>
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Halo, Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="input.php">Data Resi Pengiriman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">User Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid my-2 p-3">
        <div class="row mb-2">
            <div class="col-4">
                <form action="upload_user.php" method="post">
                    <div class="mb-3">
                        <label for="inU" class="form-label">Username</label>
                        <input type="text" class="form-control" id="inU" name="inU" required>
                    </div>
                    <div class="mb-3">
                        <label for="inNm" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="inNm" name="inNm" required>
                    </div>
                    <div class="mb-3">
                        <label for="inPs" class="form-label">Password</label>
                        <input type="password" class="form-control" id="inPs" name="inPs" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-light" id="view">
                    <?php
                        $sql = "SELECT * FROM user"; // TODO: Pertimbangkan memilih kolom spesifik
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $row = $stmt->fetchAll();
                        foreach($row as $r){
                            echo "<tr><td class='username'>".$r['username']."</td>";
                            echo "<td class='nama'>".$r['nama']."</td>";
                            echo "<td class='status'>".$r['status']."</td>";
                            if($r['status'] == 1){
                                echo "<td>
                                        <button class='btn btn-warning me-2 btn-edit' data-bs-toggle='modal' data-bs-target='#exampleModal'>edit</button>
                                        <button class='btn btn-danger non-aktif'>Non-Aktifkan</button>
                                      </td>"; // Gunakan class
                            }else{
                                echo "<td>
                                        <button class='btn btn-warning me-2 btn-edit' data-bs-toggle='modal' data-bs-target='#exampleModal'>edit</button>
                                        <button class='btn btn-success aktif'>Aktifkan</button>
                                      </td>"; // Gunakan class
                            }
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="update_user.php" method="post">
                <div class="modal-body">
                        <div class="mb-3">
                            <label for="upU" class="form-label">Username</label>
                            <input type="text" class="form-control" id="upU" name="upU" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="upNm" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="upNm" name="upNm" required>
                        </div>
                        <div class="mb-3">
                            <label for="upPs" class="form-label">Password</label>
                            <input type="password" class="form-control" id="upPs" name="upPs" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>
