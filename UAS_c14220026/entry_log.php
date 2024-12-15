<?php
include "admin_authen.php";
?>
<?php
if (isset($_SESSION['resi']) == false) {
    //jika belum ada isi no resinya maka tdk bole masuk ke entry_log.php karena blom jls mau entry dari no resi brp
    header("Location: input.php");
    exit();
}
?>
<?php
if (isset($_POST['del'])) {
    unset($_POST['resi']);
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
            $("#back").on("click", function() {
                $.ajax({
                    type: "post",
                    data: {
                        del: 1
                    },
                    success: function() {
                        $(window).attr("location", "input.php");
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
                        <a class="nav-link" href="#">User Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid my-2 p-3">
        <div class="content-web">
            <div class="row mb-2">
                <div class="col-4">
                    <form action="upload_log.php" method="post">
                        <h2>Entry Log</h2>

                        <div class="mb-3">
                            <label for="inTgl" class="form-label">Tanggal : </label>
                            <input type="date" class="form-control" id="inTgl" name="inTgl" required>
                        </div>
                        <div class="mb-3">
                            <label for="inNo" class="form-label">Kota : </label>
                            <input type="text" class="form-control" id="inKo" name="inKo" required>
                        </div>
                        <div class="mb-3">
                            <label for="inNo" class="form-label">Keterangan : </label>
                            <textarea class="form-control" placeholder="Keterangan..." id="inKet" name="inKet" required></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                            <button type="button" class="btn btn-secondary" id="back">Back</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <table class="table table-dark table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kota</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <?php
                        $sql = "SELECT * FROM pengiriman_detail WHERE no_resi = :resi";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(array(
                            ":resi" => $_SESSION['resi']
                        ));
                        $row = $stmt->fetchAll();
                        foreach ($row as $r) {
                            echo "<tr><td class='tgl'>" . $r['tanggal'] . "</td>";
                            echo "<td class='kota'>" . $r['kota'] . "</td>";
                            echo "<td class='keterangan'>" . $r['keterangan'] . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>