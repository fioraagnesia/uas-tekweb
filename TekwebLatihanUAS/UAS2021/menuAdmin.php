<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UAS 2021 - Menu Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
       .nav {
        background-color: black;
        color: white;
        display: flex;
        flex-wrap: nowrap;
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

       .entry-container {
        margin: 20px 30px 30px 30px;
       }

       .table-container {
        margin: 20px 30px 20px 30px;
       }
    </style>

  </head>
  <body>
    <!-- NavBar -->
    <nav class="nav">
        <h5>Halo, admin</h5>
        <a class="nav-link" href="menuAdmin.php">Data Resi Pengiriman</a>
        <a class="nav-link" href="userAdminPage.php">User Admin</a>
        <a class="nav-link" href="logout.php">Logout</a>
      </nav>

    <div class="entry-container">
        <h2>Entry Nomor Resi</h2>
        <form id="resi-form" style="width: 300px; align-items: center;">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal">
            </div>
            <div class="mb-4">
                <label for="noResi" class="form-label">Nomor Resi</label>
                <input type="text" class="form-control" id="noResi">
            </div>
            <button type="submit" class="btn btn-dark" style="width: 100%;">Entry</button>
        </form>
    </div>

    <!-- Table -->
     <div class="table-container">
      <table class="table table-bordered">
          <thead>
            <tr class="table-dark">
              <th scope="col">Tanggal</th>
              <th scope="col">Nomor Resi</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody id="table-entry">
      
          </tbody>
        </table>
      </div>

      <script>
        $(document).ready(function() {
          function loadData() {
            $.ajax({
              type: "POST",
              url: "entryNoResi.php",
              dataType: "json",
              contentType: "application/json",
              data: JSON.stringify({}),

              success:function(response) {
                if(response.status === "success") {
                  let rows = "";
                  response.data.forEach(item => {
                    rows += `<tr data-id="${item.id}">
                            <td>${item.tanggal}</td>
                            <td>${item.noResi}</td>
                            <td>
                              <button type="button" class="btn btn-primary btn-entry">Entry Log</button>
                              <button type="button" class="btn btn-danger btn-delete">Hapus</button>
                            </td>
                            </tr>`;
                  });
                  $("#table-entry").html(rows);
                }
              },
              error:function(xhr, status, error) {
                        console.error("Error: " + error);
                        console.log(xhr.responseText);  // Lihat respons yang dikirim server
                        alert("Gagal entry");
              }

            });
          }

          loadData();

          $("#resi-form").on("submit", function(e) {
            e.preventDefault();
            const tanggal = $("#tanggal").val();
            const noResi = $("#noResi").val();

            $.ajax({
              type: "POST",
              url: "entryNoResi.php",
              dataType: "json",
              contentType: "application/json",
              data: JSON.stringify({tanggal, noResi}),

              success:function(response) {
                if(response.status === "success") {
                  loadData();
                  $("#tanggal").val("");
                  $("#noResi").val("");
                }
              },
              error: function(xhr, status, error) {
                console.error("Error: " + error);
                console.log(xhr.responseText);
              }
            });

          });

          $(document).on("click",".btn-delete", function() {
            const row = $(this).closest("tr");
            const id = row.data("id");
            
            $.ajax({
              type: "POST",
              url: "deleteResi.php",
              dataType: "json",
              contentType: "application/json",
              data: JSON.stringify({id: id}),

              success:function(response) {
                console.log(response);
                if(response.status === "success") {
                  alert("Data berhasil dihapus");
                  row.remove();
                }
                else{
                  alert("Data gagal dihapus");
                }
                
              },

              error: function(xhr, status, error) {
                console.error("Error: " + error);
                console.log(xhr.responseText);
              }


            });

          });


          $(document).on("click",".btn-entry", function() {
            const row = $(this).closest("tr");
            const id = row.data("id");

            console.log("id:", id);
            
            if (id) {
              // Kirim ID ke server dan simpan di session PHP
              $.ajax({
                  type: 'POST',
                  url: 'saveSession.php',
                  data: { id: id },
                  success: function(response) {
                      window.location.href = 'entryLogPage.php'; // Arahkan ke halaman baru
                  }
              });
            }
          });



        });
      </script>
  </body>
</html>