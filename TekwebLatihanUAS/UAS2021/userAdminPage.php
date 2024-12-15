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

       .admin-container {
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

    <div class="admin-container">
        <h2>User Admin</h2>
        <form id="user-form" style="width: 300px; align-items: center;">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" id="password">
            </div>
            <div class="mb-3">
                <label for="nama_admin" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama_admin">
            </div>
            <button type="submit" class="btn btn-dark" style="width: 100%;">Submit</button>
        </form>
    </div>

    <!-- Table -->
     <div class="table-container">
      <table class="table table-bordered">
          <thead>
            <tr class="table-dark">
              <th scope="col">Username</th>
              <th scope="col">Nama</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody id="table-user">
      
          </tbody>
        </table>
      </div>

      <!-- Modal utk edit -->
       <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="editModalLabel">Edit User</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="edit-form">
                    <div class="mb-2">
                        <label for="edit-username" class="col-form-label">Username:</label>
                        <input type="text" class="form-control" id="edit-username">
                    </div>
                    <div class="mb-3">
                      <label for="edit-password" class="col-form-label">Password:</label>
                      <input type="password" class="form-control" id="edit-password">
                    </div>
                    <div class="mb-3">
                      <label for="edit-nama" class="col-form-label">Nama:</label>
                      <input type="text" class="form-control" id="edit-nama">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="confirm-btn">Save</button>
                </div>
                </form>
              </div>
            </div>
          </div>
    

      <script>
        $(document).ready(function() {
          function loadData() {
            $.ajax({
              type: "POST",
              url: "userAdmin.php",
              dataType: "json",
              contentType: "application/json",
              data: JSON.stringify({}),

              success:function(response) {
                if(response.status === "success") {
                  let rows = "";
                  response.data.forEach(item => {

                    // Tentukan status tombol berdasarkan status_aktif
                    let buttonText = item.status_aktif === 1 ? "Non-Aktifkan" : "Aktifkan";
                    let buttonClass = item.status_aktif === 1 ? "btn-danger" : "btn-success";  // Red = Non-Aktif, Green = Aktif
                    rows += `<tr data-id="${item.id}">
                            <td>${item.username}</td>
                            <td>${item.nama_admin}</td>
                            <td>${item.status_aktif}</td>
                            <td>
                              <button type="button" class="btn btn-warning btn-edit">Edit</button>
                              <button type="button" class="btn btn-danger btn-nonaktif" data-id="${item.id}" data-status="${item.status_aktif}">
                                ${item.status_aktif === 1 ? "Aktifkan" : "Non-Aktifkan"}
                              </button>
                            </td>
                            </tr>`;
                  });
                  $("#table-user").html(rows);
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

          $("#user-form").on("submit", function(e) {
              e.preventDefault(); // Prevent default form submission

              const username = $("#username").val();
              const password = $("#password").val();
              const nama_admin = $("#nama_admin").val();

              // Cek apakah data sudah diisi dengan benar
              console.log("Username:", username);
              console.log("Password:", password);
              console.log("Nama Admin:", nama_admin);

              if (!username || !password || !nama_admin) {
                  alert("Semua kolom harus diisi!");
                  return;
              }

              // Kirim data ke server menggunakan AJAX
              $.ajax({
                  type: "POST",
                  url: "userAdmin.php",  // URL ke PHP untuk insert
                  dataType: "json",
                  contentType: "application/json",
                  data: JSON.stringify({ username, password, nama_admin }),

                  success: function(response) {
                      if (response.status === "success") {
                          alert("User baru berhasil ditambahkan");
                          // Bersihkan form setelah insert
                          $("#username").val("");
                          $("#password").val("");
                          $("#nama_admin").val("");
                          loadData();  // Memuat ulang data tabel
                      } else {
                          alert("Gagal menambahkan user baru");
                      }
                  },
                  error: function(xhr, status, error) {
                      console.error("Error:", error);
                      alert("Terjadi kesalahan saat menambahkan user");
                  }
              });
          });

          $(document).on("click", ".btn-edit", function(e) {
            e.preventDefault();
            
            // Ambil data ID dari baris yang diklik
            const row = $(this).closest("tr");
            const id = row.data("id");
            
            // Mengambil data dari elemen <td> berdasarkan urutan kolom
            const username = row.children("td").eq(0).text();  // Mengambil kolom pertama (username)
            const nama_admin = row.children("td").eq(1).text(); // Mengambil kolom kedua (nama_admin)
            // Isi data ke dalam modal
            $("#edit-username").val(username);
            $("#edit-nama").val(nama_admin);
            
            // Simpan ID user yang sedang diedit
            $("#edit-form").data("id", id);
            
            // Tampilkan modal
            $("#editModal").modal("show");
          });


          // EDIT
          $("#edit-form").on("submit", function(e) {
              e.preventDefault();
              
              const id = $(this).data("id");
              const username = $("#edit-username").val();
              const password = $("#edit-password").val();  // Anda bisa mengganti ini dengan pengaturan password yang aman
              const nama_admin = $("#edit-nama").val();
              
              // Kirim data ke server untuk di-update
              $.ajax({
                type: "POST",
                url: "editUser.php",
                dataType: "json",
                contentType: "application/json",
                data: JSON.stringify({id: id, username: username, password: password, nama_admin: nama_admin}),
                success: function(response) {
                  console.log(response);
                  if (response.status === "success") {
                    alert("Data berhasil diedit");
                    // Reload data setelah edit berhasil
                    loadData();  // Misalnya fungsi loadData() untuk memuat ulang data dari server
                    $("#editModal").modal("hide");  // Tutup modal setelah edit berhasil
                  } else {
                    alert("Data gagal diedit");
                  }
                },
                error: function(xhr, status, error) {
                  console.error("Error: " + error);
                  console.log(xhr.responseText);
                }
              });
            });

            
            // NON-AKTIF
            $(document).on("click", ".btn-nonaktif", function(e) {
                e.preventDefault();
                
                const button = $(this);
                const row = $(this).closest("tr");
                const id = button.data("id");
                let currentStatus = button.data("status");

                // Toggle status: jika 1, jadi 0 (non-aktifkan), jika 0 jadi 1 (aktifkan)
                const newStatus = currentStatus === 1 ? 0 : 1;
                
                // Kirim data status baru ke backend
                $.ajax({
                  type: "POST",
                  url: "updateStatusUser.php",  // URL ke PHP untuk update status
                  dataType: "json",
                  contentType: "application/json",
                  data: JSON.stringify({ id: id, status_aktif: newStatus }),
                  
                  success: function(response) {
                    if (response.status === "success") {
                      // Update tombol sesuai status baru
                      if (newStatus === 1) {
                        button.text("Non-Aktifkan").removeClass("btn-success").addClass("btn-danger");
                      } else {
                        button.text("Aktifkan").removeClass("btn-danger").addClass("btn-success");
                      }
                      button.data("status", newStatus); // Update status di data atribut tombol
                      // Update status di tabel
                      const statusCell = row.find("td:nth-child(3)"); // Targetkan kolom status
                      statusCell.text(newStatus === 1 ? 1 : 0);

                    } else {
                      alert("Gagal mengupdate status");
                    }
                  },
                  
                  error: function(xhr, status, error) {
                    console.error("Error: " + error);
                    console.log(xhr.responseText);
                  }
                });
              });




        });
      </script>
  </body>
</html>