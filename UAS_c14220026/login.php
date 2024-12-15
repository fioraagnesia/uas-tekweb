<?php
include "connection.php";
?>
<?php
if (isset($_POST['user']) && isset($_POST['pass'])) {
    $sql_cek = "SELECT COUNT(*) FROM uas21_useradmin WHERE username = :user and password = PASSWORD(:pass) and status = 1";
    $stmt_cek = $conn->prepare($sql_cek);
    $stmt_cek->execute(array(
        ":user" => $_POST['user'],
        ":pass" => $_POST['pass']
    ));
    $row = $stmt_cek->fetchColumn();
    if ($row == 1) {
        session_start();
        $_SESSION['user'] = $_POST['user'];
        $_SESSION['timeout'] = time();
    }
    echo $row;
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Pengiriman Resi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <!-- <link rel="stylesheet" href="sweetalert2.min.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .login-form {
            max-width: 500px;
            border: 1px solid #ddd;
            border-radius: 8px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
        }

        .login-form .title {
            padding: 15px 10px;
            text-align: center;
            font-size: 25px;
        }

        .login-form .content {
            padding: 15px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $("#signIn").on("click", function() {
                $.ajax({
                    type: "post",
                    data: {
                        user: $("#inputUsername").val(),
                        pass: $("#inputPassword").val()
                    },
                    success: function(e) {
                        console.log(e);
                        if (e == 1) {
                            swal.fire({
                                title: "Berhasil Login!",
                                icon: "success"
                            }).then(function() {
                                $(window).attr("location", "admin.php");
                            });
                        } else {
                            swal.fire({
                                title: "Gagal Login!",
                                icon: "error",
                                text: "Silahkan input ulang!"
                            });
                        }
                    }
                })
            });
        });
    </script>
</head>

<body>
    <div class="login-form">
        <div class="title bg-dark text-white">
            WELCOME!
        </div>
        <div class="content">
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <div class="container-fluid position-relative p-0">
                        <input type="text" class="form-control" id="inputUsername" aria-describedby="userHelp" name="user">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <div class="container-fluid position-relative p-0">
                        <input type="password" class="form-control" id="inputPassword" aria-describedby="passHelp" name="pass">
                    </div>
                </div>
                <div class="mb-3 text-center">
                    <div class="container-fluid position-relative p-0">
                        <button type="button" class="btn btn-dark" id="signIn" style="width:100%">Sign In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>