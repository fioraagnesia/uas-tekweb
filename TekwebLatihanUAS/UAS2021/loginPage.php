<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UAS 2021 - Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px; 
        }

        .login-header {
            background-color: black;
            color: white;
            text-align: center;
            padding: 20px;
        }
        #login-form {
            align-items: center;
            justify-content: center;
            padding: 30px 50px 30px 50px;
        }
    </style>

  </head>
  <body>
    <div class="login-container">
        <div class="login-header">
            <h1>WELCOME!</h1>
        </div>
        <form id="login-form">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn" style="width: 100%; background-color: black; color: white">Login</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $("#login-form").on("submit", function(e) {
                e.preventDefault();
                const username = $("#username").val();
                const password = $("#password").val();

                $.ajax({
                    type: "POST",
                    url: "login.php",
                    dataType: "json",
                    contentType: "application/json",
                    data: JSON.stringify({username, password}),
                    
                    success:function(response) {
                        console.log(response);
                        if (response.status === "success") {
                             window.location.href = "menuAdmin.php";
                        }
                        else {
                            alert("Username atau password salah");
                        }
                       
                    },
                    error:function(xhr, status, error) {
                        console.error("Error: " + error);
                        console.log(xhr.responseText);  // Lihat respons yang dikirim server
                        alert("Terjadi kesalahan saat melakukan login.");
                    }
                });

                $("#username").val("");
                $("#password").val("");



            });

        });
    </script>
  </body>
</html>