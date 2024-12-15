<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    $('.delbutton').on('click', function() {
      $.ajax({
        type: "get",
        url: "delete.php",
        data: $(this).attr('id'),
        success: function(response)
          {
	    $("#hasil").html(response);
          }
        });
      });
    $('#testform').submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "post",
        url: "insert.php",
        data: $(this).serialize(),
        success: function(response)
          {
	    $("#hasil").html(response);
          }
        });
      });
  });
</script>
</head>
<body>
    <form id="testform" method="get">
    <input type="text" name="name" placeholder="NAME"><br>
    <input type="text" name="email" placeholder="EMAIL"><br>
    <input type="submit">
    </form>
    <p id="hasil"></p>
</body>
</html>