<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UAS 2021 - Main Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        .nav {
        background-color: black;
        color: white;
        align-items: center;
       }

       .nav-link {
        color: white;
       }

       .nav-link:hover {
        color: lightgrey;
       }

       .nav h5 {
        align-items: center;
        justify-content: center;
        margin: 0px 0px 0px 10px;
       }

       .index-container {
        border-color: grey;
        border-radius: 2px;
        margin: 20px;
       }

       #form-cek {
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        
       }

       .table-container {
        margin: 20px 30px 20px 30px;
       }
    </style>

  </head>

  <body>
    <!-- NavBar -->
    <nav class="nav">
        <h5>WELCOME!</h5>
        <a class="nav-link" href="loginPage.php">Login admin</a>
      </nav>

    <div class="index-container">
        <h2>Cek Pengiriman</h2>
        <form id="form-cek">
            <div class="mb-2" style="display: flex;">
              <input type="text" class="form-control" id="noPengiriman" placeholder="Nomor Pengiriman" style="margin-right: 15px;">
              <button type="submit" class="btn btn-dark">Lihat</button>
            </div>
          </form>
    </div>

    <!-- Table -->
     <div class="table-container">
        <table class="table table-bordered">
            <thead>
            <tr class="table-dark">
                <th scope="col">Tanggal</th>
                <th scope="col">Kota</th>
                <th scope="col">Keterangan</th>
            </tr>
            </thead>
            <tbody id="table-body">
    
            </tbody>
        </table>
    </div>

    <script>
      $(document).ready(function() {
        $("#form-cek").on("submit", function(e) {
          e.preventDefault();
          const noPengiriman = $("#noPengiriman").val();

          $.ajax({
            type: "POST",
            url: "cekPengiriman.php",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify({noPengiriman}),

            success: function(response) {
              if (response.status === "success") {
                let rows = "";
                response.data.forEach(item => {
                  rows += `<tr>
                          <td>${item.tanggal}</td>
                          <td>${item.kota}</td>
                          <td>${item.keterangan}</td>
                          </tr>`;
                });
                $("#table-body").html(rows);
              }
              else {
                const noData = '<tr><td clospan="3" style="text-align: center">Tidak ada data</td></tr>';
                $("#table-body").html(noData);
              }
            },
            error: function() {
              alert("Gagal mengambil data");
            }

        });

        $("#noPengiriman").val("");

        });

      });
      </script>
  </body>
</html>