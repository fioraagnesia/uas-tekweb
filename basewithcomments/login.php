<?php
    include "connection.php"; // TODO: Pastikan file koneksi aman dan tidak dapat diakses secara langsung
?>
<?php
    if(isset($_POST['user']) && isset($_POST['pass'])){
        // TODO: Pertimbangkan untuk menggunakan prepared statements dengan penanganan error yang lebih baik
        $sql_cek = "SELECT COUNT(*) FROM user WHERE username = :user and password = PASSWORD(:pass) and status = 1";
        $stmt_cek = $conn->prepare($sql_cek);
        $stmt_cek->execute(array(
            ":user" => $_POST['user'],
            ":pass" => $_POST['pass']
        ));
        $row = $stmt_cek->fetchColumn();
        if($row == 1){
            session_start();
            $_SESSION['user'] = $_POST['user'];
            $_SESSION['timeout']=time();
            // TODO: Pertimbangkan untuk menyimpan informasi tambahan dalam session jika diperlukan
        }
        echo $row;
        exit();
        //username : admin
        //password : admin
        //username : hello
        //password : hello
        //username : hai
        //password : hai
        // TODO: Hapus atau amankan komentar yang berisi informasi sensitif seperti username dan password
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <!-- <link rel="stylesheet" href="sweetalert2.min.css"> -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <script>
            $(document).ready(function(){
                $("#signIn").on("click",function(){
                    $.ajax({
                        type : "post",
                        data : {
                            user : $("#inputUsername").val(),
                            pass : $("#inputPassword").val()
                        },
                        success : function(e){
                            console.log(e);
                            if(e == 1){
                                swal.fire({
                                    title : "success!",
                                    icon : "success"
                                }).then(function(){
                                    $(window).attr("location","input.php"); // TODO: Pastikan redirect sesuai dengan rute yang benar
                                });
                            }else{
                                swal.fire({
                                    title : "failed!",
                                    icon : "error",
                                    text : "silahkan input ulang!"
                                });
                                // TODO: Tambahkan penanganan error yang lebih informatif jika diperlukan
                            }
                        },
                        error: function(xhr, status, error) {
                            // TODO: Tambahkan penanganan error AJAX untuk meningkatkan debugging dan UX
                            console.error("AJAX Error: ", status, error);
                        }
                    })
                });
            });
        </script>
    </head>
    <body>
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark">  
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Halo,Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="login.php">Login Admin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row" style="width: 100%; margin-top:100pt">
                <div class="col-lg-4 col-md-3 col-sm-2 col-1"></div>
                <div class="col-lg-4 col-md-6 col-sm-8 col-10 box">
                    <div class="row bg-dark mb-4">
                        <h1 class="text-center text-light">WELCOME!</h1>
                        <!-- <h4 class="subtitle-login text-center" style="border-bottom:1px solid black;line-height:0.1em;"></h4> -->
                    </div>
                    <form action="login.php" method="post"> <!-- TODO: Pertimbangkan untuk menggunakan metode POST secara konsisten dan amankan endpoint -->
                        <div class="mb-3">
                            <div class="container-fluid position-relative p-0">
                                <input type="text" class="form-control text-center" id="inputUsername" aria-describedby="userHelp" name="user" placeholder="Username" required> <!-- TODO: Tambahkan validasi input frontend jika diperlukan -->
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="container-fluid position-relative p-0">
                                <input type="password" class="form-control text-center" id="inputPassword" aria-describedby="passHelp" name="pass" placeholder="Password" required> <!-- TODO: Pertimbangkan untuk menambahkan fitur show/hide password -->
                            </div>
                        </div>
                        <div class="mb-3 text-center">
                            <div class="container-fluid position-relative p-0">
                                <button type="button" class="btn btn-dark" id="signIn" style="width:100%">Login</button> <!-- TODO: Gunakan atribut type="submit" dan tangani submit form dengan AJAX jika diperlukan -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
