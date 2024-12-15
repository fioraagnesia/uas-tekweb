<?php
include "admin_authen.php";
?>
<?php
if (isset($_POST['resi'])) {
    $sql = "SELECT COUNT(*) FROM pengiriman WHERE no_resi = :resi";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ":resi" => $_POST['resi']
    ));
    $row = $stmt->fetchColumn();
    echo $row;
    exit();
}
?>
<?php
if (isset($_POST['no_res'])) {
    $_SESSION['resi'] = $_POST['no_res'];
    exit();
}
?>
<?php
if (isset($_POST['res_del'])) {
    $sql = "DELETE FROM pengiriman WHERE no_resi = :res";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ":res" => $_POST['res_del']
    ));
    exit();
}
?>
<?php
if (isset($_POST['ajax'])) {
    $sql = "SELECT * FROM pengiriman";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetchAll();
    foreach ($row as $r) {
        echo "<tr><td class='tgl-resi'>" . $r['tanggal_resi'] . "</td>";
        echo "<td class='no-resi'>" . $r['no_resi'] . "</td>";
        echo "<td><button class='btn btn-primary me-lg-3' id='btn-edit' data-bs-toggle='modal' data-bs-target='#exampleModal'>Entry Log <i class='fa-solid fa-pen-to-square'></i></button><button class='btn btn-danger' id='btn-del'>Delete <i class='fa-solid fa-trash'></i></button></td>";
    }
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
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .content-web {
            border: 1px solid #ccc;
            padding: 25px;
            border-radius: 8px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $("#inNo").on("keyup", function() {
                $.ajax({
                    type: "post",
                    data: {
                        resi: $("#inNo").val()
                    },
                    success: function(e) {
                        console.log(e);
                        if (e == 1) {
                            $("#stat").html('<div class="alert alert-danger" role="alert">A simple danger alert—check it out!</div>');
                            $("#submit").attr("disabled", true);
                        } else {
                            $("#stat").html('');
                            $("#submit").removeAttr("disabled");
                        }
                    }
                })
            });
            $(document.body).on("click", "#btn-edit", function() {
                $.ajax({
                    type: "post",
                    data: {
                        no_res: $(this).parent().parent().find(".no-resi").text()
                    },
                    success: function() {
                        $(window).attr("location", "entry_log.php");
                    }
                })
            });
            $(document.body).on("click", "#btn-del", function() {
                $.ajax({
                    type: "post",
                    data: {
                        res_del: $(this).parent().parent().find(".no-resi").text()
                    },
                    success: function(e) {
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
                        <a class="nav-link active" aria-current="page" href="#">Data Resi Pengiriman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">User Admin</a>
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
                    <form action="upload.php" method="post">
                        <h2>Entry Nomor Resi</h2>
                        <div class="mb-3">
                            <label for="inTgl" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="inTgl" name="inTgl" required>

                        </div>
                        <div class="mb-3">
                            <label for="inNo" class="form-label">Nomor Resi</label>
                            <input type="text" class="form-control" id="inNo" name="inNo" required>
                        </div>
                        <div class="mb-3" id="stat">
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
                            <th>Tanggal Resi</th>
                            <th>Nomor Resi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-light" id="view">
                        <?php
                        $sql = "SELECT * FROM pengiriman";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $row = $stmt->fetchAll();
                        foreach ($row as $r) {
                            $tanggal = date('d/m/Y', strtotime($r['tanggal_resi']));
                            echo "<tr><td class='tgl-resi'>" . $tanggal . "</td>";
                            echo "<td class='no-resi'>" . $r['no_resi'] . "</td>";
                            echo "<td><button class='btn btn-primary me-lg-3' id='btn-edit'>Entry Log <i class='fa-solid fa-pen-to-square'></i></button><button class='btn btn-danger' id='btn-del'>Delete <i class='fa-solid fa-trash'></i></button></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>