<?php
include "admin_authen.php";
?>
<?php
if (isset($_POST['ajax'])) {
    $sql = "SELECT * FROM user";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetchAll();
    foreach ($row as $r) {
        echo "<tr><td class='username'>" . $r['username'] . "</td>";
        echo "<td class='nama'>" . $r['nama'] . "</td>";
        echo "<td class='status'>" . $r['status'] . "</td>";
        if ($r['status'] == 1) {
            echo "<td><button class='btn btn-warning me-2' id='btn-edit' data-bs-toggle='modal' data-bs-target='#exampleModal'>Edit</button><button class='btn btn-danger' id='non-aktif'>Non-Akitfkan</button></td>";
        } else {
            echo "<td><button class='btn btn-warning me-2' id='btn-edit' data-bs-toggle='modal' data-bs-target='#exampleModal'>Edit</button><button class='btn btn-success' id='aktif'>Akitfkan</button></td>";
        }
        echo "</tr>";
    }
    exit();
}
?>
<?php
//php untuk mennonaktifkan user
if (isset($_POST['usr'])) {
    $sql = "UPDATE user SET status = 0 WHERE username = :usr";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ":usr" => $_POST['usr']
    ));
    exit();
}
?>
<?php
//php untuk mengaktifkan user
if (isset($_POST['user'])) {
    $sql = "UPDATE user SET status = 1 WHERE username = :usr";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <style>
        .content-web {
            border: 1px solid #ccc;
            padding: 25px;
            border-radius: 8px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $(document.body).on("click", "#non-aktif", function() {
                console.log($(this).parent().parent().find(".username").text());
                $.ajax({
                    type: "post",
                    data: {
                        usr: $(this).parent().parent().find(".username").text()
                    },
                    success: function() {
                        $.ajax({
                            type: "post",
                            data: {
                                ajax: 1
                            },
                            success: function(e) {
                                $("#view").html(e);
                            }
                        })
                    }
                })
            });
            $(document.body).on("click", "#aktif", function() {
                console.log($(this).parent().parent().find(".username").text());
                $.ajax({
                    type: "post",
                    data: {
                        user: $(this).parent().parent().find(".username").text()
                    },
                    success: function() {
                        $.ajax({
                            type: "post",
                            data: {
                                ajax: 1
                            },
                            success: function(e) {
                                $("#view").html(e);
                            }
                        })
                    }
                })
            });
            $(document.body).on("click", "#btn-edit", function() {
                $("#upU").val($(this).parent().parent().find('.username').text());
                $("#upNm").val($(this).parent().parent().find('.nama').text());
            })
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
        <div class="content-web">
            <div class="row mb-2">
                <div class="col-4">
                    <form action="upload_user.php" method="post">
                        <h2>Entry Admin</h2>
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
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-dark" id="submit">Entry</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <table class="table table-dark table-striped table-bordered">
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
                        $sql = "SELECT * FROM user";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $row = $stmt->fetchAll();
                        foreach ($row as $r) {
                            echo "<tr><td class='username'>" . $r['username'] . "</td>";
                            echo "<td class='nama'>" . $r['nama'] . "</td>";
                            echo "<td class='status'>" . $r['status'] . "</td>";
                            if ($r['status'] == 1) {
                                echo "<td><button class='btn btn-warning me-2' id='btn-edit' data-bs-toggle='modal' data-bs-target='#exampleModal'>Edit</button><button class='btn btn-danger' id='non-aktif'>Non-Akitfkan</button></td>";
                            } else {
                                echo "<td><button class='btn btn-warning me-2' id='btn-edit' data-bs-toggle='modal' data-bs-target='#exampleModal'>Edit</button><button class='btn btn-success' id='aktif'>Akitfkan</button></td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
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
                            <label for="inU" class="form-label">Username</label>
                            <input type="text" class="form-control" id="upU" name="upU" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="inU" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="upNm" name="upNm" required>
                        </div>
                        <div class="mb-3">
                            <label for="inU" class="form-label">Password</label>
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